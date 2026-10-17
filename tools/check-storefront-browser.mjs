import fs from 'node:fs';
const pages = await (await fetch('http://127.0.0.1:9225/json')).json();
const page = pages.find(page => page.type === 'page');
if (!page) throw new Error('No preview browser page found.');
const ws = new WebSocket(page.webSocketDebuggerUrl);
await new Promise(resolve => ws.addEventListener('open', resolve, {once:true}));
let id = 0;
const pending = new Map();
const errors = [];
ws.addEventListener('message', event => {
    const message = JSON.parse(event.data);
    if (message.method === 'Runtime.exceptionThrown') errors.push(message.params.exceptionDetails.text + ': ' + (message.params.exceptionDetails.exception?.description || ''));
    if (message.id && pending.has(message.id)) {
        const {resolve,reject} = pending.get(message.id);
        pending.delete(message.id);
        message.error ? reject(new Error(message.error.message)) : resolve(message.result);
    }
});
const call = (method, params = {}) => new Promise((resolve,reject) => { const key = ++id; pending.set(key,{resolve,reject}); ws.send(JSON.stringify({id:key,method,params})); });
const evaluate = async expression => (await call('Runtime.evaluate',{expression,returnByValue:true,awaitPromise:true})).result.value;
const waitFor = async expression => {
    for (let attempt = 0; attempt < 40; attempt++) {
        if (await evaluate(expression)) return;
        await new Promise(resolve => setTimeout(resolve,200));
    }
    throw new Error('Browser state did not settle: ' + expression);
};
await call('Page.enable');
await call('Runtime.enable');
await call('Network.clearBrowserCookies');
const directory = 'storage/app/private/preview';
await call('Emulation.setDeviceMetricsOverride',{width:1440,height:1100,deviceScaleFactor:1,mobile:false});
errors.length = 0;
await call('Page.navigate',{url:'http://127.0.0.1:8097'});
await new Promise(resolve => setTimeout(resolve,5000));
await evaluate('document.fonts.ready');
const slider = await evaluate('({count:document.querySelectorAll("[data-slide]").length})');
if (slider.count > 1) {
    await evaluate('document.querySelector("[data-slide-to=\\"0\\"]").click()');
    await evaluate('document.querySelector("[data-slide-next]").click()');
    slider.next = await evaluate('document.querySelectorAll("[data-slide]")[1].hidden === false');
    await evaluate('document.querySelector("[data-slide-prev]").click()');
    slider.previous = await evaluate('document.querySelectorAll("[data-slide]")[0].hidden === false');
    await evaluate('document.querySelector("[data-slide-to=\\"1\\"]").click()');
    slider.dot = await evaluate('document.querySelectorAll("[data-slide]")[1].hidden === false');
    await evaluate('document.querySelector("[data-slide-next]").focus()');
    await call('Input.dispatchKeyEvent',{type:'keyDown',key:'ArrowLeft',code:'ArrowLeft',windowsVirtualKeyCode:37});
    slider.keyboard = await evaluate('document.querySelectorAll("[data-slide]")[0].hidden === false');
    await evaluate('document.querySelector("[data-slide-pause]").click()');
    slider.paused = await evaluate('document.querySelector("[data-slide-pause]").getAttribute("aria-label")==="Play slideshow"');
    await evaluate('document.querySelector("[data-slide-pause]").click(); document.activeElement.blur()');
    await call('Input.dispatchMouseEvent',{type:'mouseMoved',x:700,y:350});
    await new Promise(resolve=>setTimeout(resolve,5400));
    slider.autoplay = await evaluate('document.querySelectorAll("[data-slide]")[1].hidden === false');
    await evaluate('document.querySelector("[data-slide-to=\\"0\\"]").click()');
    await evaluate('document.querySelector("[data-slide-pause]").click()');
}
await evaluate('Promise.all([...document.images].map(img => {img.loading="eager";return img.decode().catch(()=>{});} ))');
await new Promise(resolve => setTimeout(resolve,600));
const desktop = await evaluate('({title:document.title,cards:document.querySelectorAll(".ub-product-card").length,overflow:document.documentElement.scrollWidth>innerWidth})');
fs.writeFileSync(directory+'/desktop.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
const metrics = await call('Page.getLayoutMetrics');
fs.writeFileSync(directory+'/desktop-full.png',Buffer.from((await call('Page.captureScreenshot',{format:'png',captureBeyondViewport:true,clip:{x:0,y:0,width:1440,height:metrics.cssContentSize.height,scale:1}})).data,'base64'));
const collectionTop = await evaluate('document.getElementById("collections").getBoundingClientRect().top + scrollY');
fs.writeFileSync(directory+'/collections-desktop.png',Buffer.from((await call('Page.captureScreenshot',{format:'png',captureBeyondViewport:true,clip:{x:0,y:collectionTop,width:1440,height:440,scale:1}})).data,'base64'));
await call('Emulation.setDeviceMetricsOverride',{width:390,height:844,deviceScaleFactor:1,mobile:true});
if (slider.count > 1) {
    await call('Input.dispatchTouchEvent',{type:'touchStart',touchPoints:[{x:300,y:350}]});
    await call('Input.dispatchTouchEvent',{type:'touchMove',touchPoints:[{x:100,y:350}]});
    await call('Input.dispatchTouchEvent',{type:'touchEnd',touchPoints:[]});
    slider.swipe = await evaluate('document.querySelectorAll("[data-slide]")[1].hidden === false');
    await evaluate('document.querySelector("[data-slide-to=\\"0\\"]").click()');
}
await evaluate('window.scrollTo(0,0)');
await new Promise(resolve => setTimeout(resolve,700));
fs.writeFileSync(directory+'/mobile.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
const mobile = await evaluate('({overflow:document.documentElement.scrollWidth>innerWidth,width:innerWidth,content:document.documentElement.scrollWidth})');
await evaluate('document.querySelector(".ub-menu-toggle").click()');
mobile.menuOpens = await evaluate('document.querySelector(".ub-menu-toggle").getAttribute("aria-expanded")==="true" && getComputedStyle(document.getElementById("store-navigation")).display!=="none"');
await new Promise(resolve=>setTimeout(resolve,350));
mobile.menuFromLeft = await evaluate('Math.abs(document.getElementById("store-navigation").getBoundingClientRect().left)<1 && document.getElementById("store-navigation").getBoundingClientRect().width<=340 && document.activeElement.id==="menu-close"');
mobile.menuGeometry = await evaluate('({left:document.getElementById("store-navigation").getBoundingClientRect().left,width:document.getElementById("store-navigation").getBoundingClientRect().width,focus:document.activeElement.id})');
fs.writeFileSync(directory+'/mobile-menu.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
await evaluate('document.getElementById("menu-overlay").click()');
mobile.menuBackdropCloses = await evaluate('document.getElementById("store-navigation").inert && document.getElementById("menu-overlay").hidden && !document.body.classList.contains("ub-menu-open")');
await evaluate('document.querySelector(".ub-menu-toggle").click(); document.getElementById("menu-close").click()');
mobile.menuCloseButton = await evaluate('document.querySelector(".ub-menu-toggle").getAttribute("aria-expanded")==="false" && document.activeElement.classList.contains("ub-menu-toggle")');
await evaluate('document.querySelector(".ub-menu-toggle").click()');
await call('Input.dispatchKeyEvent',{type:'keyDown',key:'Escape',code:'Escape',windowsVirtualKeyCode:27});
mobile.menuEscape = await evaluate('document.getElementById("store-navigation").inert && document.getElementById("menu-overlay").hidden');
await evaluate('document.querySelector(".ub-menu-toggle").click()');
await call('Emulation.setDeviceMetricsOverride',{width:1024,height:1000,deviceScaleFactor:1,mobile:false});
await new Promise(resolve=>setTimeout(resolve,200));
mobile.menuDesktopReset = await evaluate('!document.getElementById("store-navigation").inert && !document.getElementById("store-navigation").hasAttribute("aria-hidden") && document.getElementById("menu-overlay").hidden');
await call('Emulation.setDeviceMetricsOverride',{width:390,height:844,deviceScaleFactor:1,mobile:true});
await new Promise(resolve=>setTimeout(resolve,200));
await evaluate('document.querySelector(".ub-menu-toggle").click()');
await evaluate('document.querySelector(".ub-menu-toggle").click();document.querySelector(".cart-toggle").click()');
mobile.cartOpens = await evaluate('document.getElementById("cart-drawer").getAttribute("aria-hidden")==="false" && document.activeElement.id==="cart-close"');
await call('Input.dispatchKeyEvent',{type:'keyDown',key:'Escape',code:'Escape',windowsVirtualKeyCode:27});
mobile.escapeCloses = await evaluate('document.getElementById("cart-drawer").getAttribute("aria-hidden")==="true"');
const productUrl = await evaluate('document.querySelector(".ub-product-card a").href');
const categoryUrl = await evaluate('document.querySelector(".ub-category-tile").href');
const homeAssets = await evaluate('({swiper:!!document.querySelector("script[src*=swiper]"),select2:!!document.querySelector("script[src*=select2]")})');
await call('Page.navigate',{url:productUrl});
await new Promise(resolve => setTimeout(resolve,2500));
fs.writeFileSync(directory+'/mobile-product.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
mobile.productOverflow = await evaluate('document.documentElement.scrollWidth>innerWidth');
await evaluate('document.getElementById("addToCartBtn").click()');
await waitFor('Number(document.getElementById("cart-count").textContent)>0 && document.getElementById("cart-drawer").getAttribute("aria-hidden")==="false"');
mobile.addToCart = await evaluate('Number(document.getElementById("cart-count").textContent)>0 && document.getElementById("cart-drawer").getAttribute("aria-hidden")==="false"');
mobile.addToast = await evaluate('!!document.querySelector(".swal2-toast .swal2-success") && document.querySelector(".swal2-toast").textContent.includes("All set")');
fs.writeFileSync(directory+'/mobile-cart.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
await evaluate('document.querySelector("#cart-section .remove-item").click()');
await waitFor('Number(document.getElementById("cart-count").textContent)===0');
mobile.removeFromCart = await evaluate('Number(document.getElementById("cart-count").textContent)===0');
await call('Page.navigate', {url:categoryUrl});
await new Promise(resolve => setTimeout(resolve,2500));
const category = [];
for (const width of [390,768,991,1024,1440]) {
    await call('Emulation.setDeviceMetricsOverride',{width,height:1000,deviceScaleFactor:1,mobile:width<768});
    await new Promise(resolve => setTimeout(resolve,150));
    category.push(await evaluate('({width:innerWidth,columns:getComputedStyle(document.querySelector("#nav-home .ub-product-grid")).gridTemplateColumns.split(" ").length,overflow:document.documentElement.scrollWidth>innerWidth})'));
}
fs.writeFileSync(directory+'/category-desktop.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
await evaluate('document.getElementById("nav-profile-tab").click()');
const listColumns = await evaluate('getComputedStyle(document.querySelector("#nav-profile .ub-product-grid")).gridTemplateColumns.split(" ").length');
await call('Page.navigate',{url:'http://127.0.0.1:8097/account/login'});
await new Promise(resolve=>setTimeout(resolve,1500));
await evaluate('document.getElementById("login-phone").focus()');
const inputFocus = await evaluate('({outline:getComputedStyle(document.getElementById("login-phone")).outlineStyle,shadow:getComputedStyle(document.getElementById("login-phone")).boxShadow})');
fs.writeFileSync(directory+'/login-desktop.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
await call('Emulation.setDeviceMetricsOverride',{width:390,height:1000,deviceScaleFactor:1,mobile:true});
const loginOverflow = await evaluate('document.documentElement.scrollWidth>innerWidth');
fs.writeFileSync(directory+'/login-mobile.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
await evaluate('document.querySelector("footer").scrollIntoView()');
await new Promise(resolve=>setTimeout(resolve,200));
fs.writeFileSync(directory+'/footer-mobile.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
await evaluate('window.scrollTo(0,0)');
let dashboardOverflow = false;
const infoPages = [];
for (const slug of ['about-us', 'contact-us']) {
    await call('Page.navigate',{url:'http://127.0.0.1:8097/'+slug});
    await new Promise(resolve=>setTimeout(resolve,2000));
    for (const width of [1440,390]) {
        await call('Emulation.setDeviceMetricsOverride',{width,height:1100,deviceScaleFactor:1,mobile:width<768});
        await new Promise(resolve=>setTimeout(resolve,200));
        const state = await evaluate('({title:document.title,overflow:document.documentElement.scrollWidth>innerWidth,heading:!!document.querySelector("h1")})');
        infoPages.push({slug,width,...state});
        fs.writeFileSync(directory+'/'+slug+'-'+(width===390?'mobile':'desktop')+'.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
    }
}
if (fs.existsSync(directory+'/dashboard.html')) {
    const frame = (await call('Page.getFrameTree')).frameTree.frame.id;
    await call('Page.setDocumentContent',{frameId:frame,html:fs.readFileSync(directory+'/dashboard.html','utf8')});
    await new Promise(resolve=>setTimeout(resolve,1200));
    dashboardOverflow = await evaluate('document.documentElement.scrollWidth>innerWidth');
    fs.writeFileSync(directory+'/dashboard-mobile.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
    await call('Emulation.setDeviceMetricsOverride',{width:1440,height:1100,deviceScaleFactor:1,mobile:false});
    fs.writeFileSync(directory+'/dashboard-desktop.png',Buffer.from((await call('Page.captureScreenshot',{format:'png'})).data,'base64'));
}
const result = {desktop,mobile,slider,homeAssets,category,listColumns,loginOverflow,dashboardOverflow,inputFocus,infoPages,errors};
fs.writeFileSync(directory+'/browser-check.json',JSON.stringify(result,null,2));
console.log(JSON.stringify(result,null,2));
ws.close();
if (desktop.cards < 1 || desktop.title === 'Server Error' || desktop.overflow || mobile.overflow || mobile.productOverflow || !mobile.menuOpens || !mobile.cartOpens || !mobile.escapeCloses || !mobile.addToCart || !mobile.removeFromCart || errors.length) process.exitCode = 1;
if (homeAssets.swiper || homeAssets.select2 || listColumns !== 1 || category.some(item => item.overflow || item.columns !== (item.width >= 768 ? 4 : 2))) process.exitCode = 1;
if (!mobile.addToast || loginOverflow || dashboardOverflow) process.exitCode = 1;
if (slider.count > 1 && Object.values(slider).some(value => value === false)) process.exitCode = 1;
if(inputFocus.outline !== 'none' || inputFocus.shadow !== 'none') process.exitCode = 1;
if(infoPages.some(page=>page.overflow || !page.heading || page.title==='Server Error')) process.exitCode=1;
if (!mobile.menuFromLeft || !mobile.menuBackdropCloses || !mobile.menuCloseButton || !mobile.menuEscape || !mobile.menuDesktopReset) process.exitCode=1;
