/* Accessible navigation and cart behavior shared by every storefront page. */
(() => {
    const config = JSON.parse(
        document.getElementById("unibox-config")?.textContent || "{}",
    );
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const notify = (message, error = false) => {
        if (window.Swal)
            window.Swal.fire({
                icon: error ? "error" : "success",
                title: error ? "Please check your order" : "All set",
                text: message,
                ...(error
                    ? {}
                    : {
                          toast: true,
                          position: "top-end",
                          timer: 3200,
                          timerProgressBar: true,
                          showConfirmButton: false,
                      }),
            });
        else window.alert(message);
    };
    window.Unibox = { notify };
    if (config.success || config.error)
        notify(config.error || config.success, Boolean(config.error));
    const repaintCart = (result) => {
        if (result.html !== undefined)
            document.getElementById("cart-section").innerHTML = result.html;
        if (
            result.table !== undefined &&
            document.getElementById("cart-table-wrapper")
        )
            document.getElementById("cart-table-wrapper").innerHTML =
                result.table;
        if (result.cart_count !== undefined)
            document
                .querySelectorAll(".cart-item-count-render")
                .forEach((el) => (el.textContent = result.cart_count));
        for (const [selector, value] of [
            [".subtotal-value", result.subtotal],
            [".shipping-value", result.shipping],
            [".total-value", result.cart_total],
        ]) {
            if (value !== undefined)
                document
                    .querySelectorAll(selector)
                    .forEach(
                        (el) =>
                            (el.textContent = "৳" + Number(value).toFixed(2)),
                    );
        }
    };
    document.addEventListener("click", async (event) => {
        const update = event.target.closest(".update-btn");
        const remove = event.target.closest(".remove-item");
        if (!update && !remove) return;
        event.preventDefault();
        const button = update || remove;
        if (button.dataset.busy) return;
        button.dataset.busy = "true";
        button.disabled = true;
        try {
            const quantities = {};
            if (update)
                document
                    .querySelectorAll(".qty-input")
                    .forEach(
                        (input) => (quantities[input.dataset.id] = input.value),
                    );
            const response = await fetch(
                update
                    ? config.cartUpdate
                    : config.cartRemove.replace(
                          "__id__",
                          encodeURIComponent(remove.dataset.id),
                      ),
                {
                    method: update ? "POST" : "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": csrf,
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: JSON.stringify(update ? { quantities } : {}),
                },
            );
            const result = await response.json();
            if (!response.ok)
                throw new Error(
                    result.message ||
                        "Unable to update your cart. Please try again.",
                );
            repaintCart(result);
            notify(
                update
                    ? "Your cart has been updated."
                    : "The item has been removed.",
            );
        } catch (error) {
            notify(error.message, true);
        } finally {
            delete button.dataset.busy;
            button.disabled = false;
        }
    });
    const searchInput = document.querySelector(".ub-search input");
    const suggestions = document.getElementById("searchSuggestion");
    let searchTimer, searchRequest;
    searchInput?.addEventListener("input", () => {
        clearTimeout(searchTimer);
        searchRequest?.abort();
        if (!searchInput.value.trim()) {
            suggestions.style.display = "none";
            return;
        }
        searchTimer = setTimeout(async () => {
            searchRequest = new AbortController();
            try {
                const url = new URL(config.search);
                url.searchParams.set("search", searchInput.value.trim());
                const response = await fetch(url, {
                    signal: searchRequest.signal,
                });
                if (!response.ok) return;
                suggestions.innerHTML = await response.text();
                suggestions.style.display = "block";
            } catch (_) {
                /* The next keystroke may cancel the preceding request. */
            }
        }, 250);
    });
    document.addEventListener("click", (event) => {
        if (!event.target.closest(".ub-search-wrap") && suggestions)
            suggestions.style.display = "none";
    });
    const drawer = document.getElementById("cart-drawer");
    const overlay = document.getElementById("cart-overlay");
    const nav = document.getElementById("store-navigation");
    const menu = document.querySelector(".ub-menu-toggle");
    const menuOverlay = document.getElementById("menu-overlay");
    const menuClose = document.getElementById("menu-close");
    const mobileNavigation = matchMedia("(max-width: 991px)");
    const closeMenu = (restoreFocus = true) => {
        const wasOpen = nav?.classList.contains("is-open");
        if (wasOpen && restoreFocus) menu?.focus();
        nav?.classList.remove("is-open");
        menu?.setAttribute("aria-expanded", "false");
        menu?.setAttribute("aria-label", "Open navigation");
        if (menuOverlay) menuOverlay.hidden = true;
        document.body.classList.remove("ub-menu-open");
        if (nav) {
            nav.inert = mobileNavigation.matches;
            if (mobileNavigation.matches)
                nav.setAttribute("aria-hidden", "true");
            else nav.removeAttribute("aria-hidden");
            nav.removeAttribute("aria-modal");
            nav.removeAttribute("role");
        }
    };
    closeMenu(false);
    mobileNavigation.addEventListener("change", () => closeMenu(false));
    let previousFocus;
    const closeCart = () => {
        drawer?.classList.remove("is-open");
        drawer?.setAttribute("aria-hidden", "true");
        if (drawer) drawer.inert = true;
        if (overlay) overlay.hidden = true;
        document.body.classList.remove("ub-overlay-open");
        document
            .querySelectorAll(".cart-toggle")
            .forEach((button) => button.setAttribute("aria-expanded", "false"));
        previousFocus?.focus();
    };
    document.addEventListener("click", (event) => {
        const toggle = event.target.closest(".cart-toggle");
        if (toggle && drawer) {
            event.preventDefault();
            closeMenu(false);
            previousFocus = toggle;
            drawer.inert = false;
            drawer.classList.add("is-open");
            drawer.setAttribute("aria-hidden", "false");
            overlay.hidden = false;
            document.body.classList.add("ub-overlay-open");
            toggle.setAttribute("aria-expanded", "true");
            document.getElementById("cart-close").focus();
        }
        if (event.target.closest("#cart-close") || event.target === overlay)
            closeCart();
        document
            .querySelectorAll(".ub-category-menu[open]")
            .forEach((details) => {
                if (!details.contains(event.target)) details.open = false;
            });
    });
    menu?.addEventListener("click", () => {
        if (!mobileNavigation.matches) return;
        if (nav.classList.contains("is-open")) {
            closeMenu();
            return;
        }
        if (drawer?.classList.contains("is-open")) closeCart();
        nav.inert = false;
        nav.classList.add("is-open");
        nav.setAttribute("aria-hidden", "false");
        nav.setAttribute("role", "dialog");
        nav.setAttribute("aria-modal", "true");
        menu.setAttribute("aria-expanded", "true");
        menu.setAttribute("aria-label", "Close navigation");
        menuOverlay.hidden = false;
        document.body.classList.add("ub-menu-open");
        requestAnimationFrame(() => {
            if (nav.classList.contains("is-open")) menuClose.focus();
        });
    });
    menuClose?.addEventListener("click", () => closeMenu());
    menuOverlay?.addEventListener("click", () => closeMenu());
    nav?.addEventListener("click", (event) => {
        if (mobileNavigation.matches && event.target.closest("a[href]"))
            closeMenu(false);
    });
    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            if (drawer?.classList.contains("is-open")) closeCart();
            closeMenu();
            document
                .querySelectorAll(".ub-category-menu[open]")
                .forEach((details) => (details.open = false));
        }
        const activePanel = nav?.classList.contains("is-open")
            ? nav
            : drawer?.classList.contains("is-open")
              ? drawer
              : null;
        if (event.key !== "Tab" || !activePanel) return;
        const focusable = [
            ...activePanel.querySelectorAll(
                "a[href], button:not([disabled]), input:not([disabled]), summary",
            ),
        ].filter((el) => el.getClientRects().length);
        const first = focusable[0],
            last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last?.focus();
        }
        if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first?.focus();
        }
    });
    document.addEventListener(
        "error",
        (event) => {
            const img = event.target;
            if (img.tagName === "IMG" && !img.dataset.fallbackApplied) {
                img.dataset.fallbackApplied = "true";
                img.src = "/frontend/assets/img/product-placeholder.svg";
            }
        },
        true,
    );
})();
