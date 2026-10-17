# Ecommerce project audit — 2026-09-07

এই রিপোর্ট workspace root-এর Laravel application নিয়ে। আলাদা `ninetyspoint.com/` copy private ZIP backup করে সরানো হয়েছে। নতুন frontend design ও cleanup-এর বিবরণ `DESIGN.md`-এ আছে। Live server-এ পরিবর্তন deploy করা হয়নি। “সম্পূর্ণ production-ready” বলা যাচ্ছে না; নিচের যাচাই ও সীমাবদ্ধতা প্রযোজ্য।

## পাওয়া সমস্যা ও করা সংশোধন

| সমস্যা | সংশোধন |
| --- | --- |
| Public `/test-google` OAuth secret প্রকাশ করত | Route সরানো হয়েছে |
| Public `/clear-cache` application cache পরিবর্তন করত | Route সরানো হয়েছে; maintenance CLI দিয়ে হবে |
| Customer/inactive user admin-এ প্রবেশ করতে পারত | Staff middleware এবং admin login account-type/status check |
| Registration form বন্ধ থাকলেও POST দিয়ে web-guard account তৈরি হতো | Public staff registration routes সরানো |
| CRUD permission শুধু form-এ ছিল; store/update বাদ পড়ত | Existing permission middleware-এ mutation methods যোগ |
| Admin profile-এ arbitrary file upload সম্ভব ছিল | Image MIME/size validation, generated filename, unique email validation |
| User type mass assignment/default অমিল | Explicit model defaults ও type persistence |
| Checkout-এর দুই implementation-এর দাম/স্টক আচরণ আলাদা | Shared `CheckoutService` ও `CartPricing` |
| Browser থেকে subtotal/shipping/total পাঠিয়ে দাম কমানো যেত | Database product/variant/options ও shipping row থেকে হিসাব |
| Calculator browser-supplied sqft বিশ্বাস করত | Width/height থেকে server-side area calculation |
| Negative/fractional cart quantity গ্রহণ করত | Positive integer validation |
| Variant আংশিক নির্বাচন করলে অন্য variation-এর stock বদলাত | Exact color/size matching |
| Attribute আলাদা করে একই stock অতিরিক্ত cart-এ নেওয়া যেত | Product/variant aggregate quantity checks |
| Checkout-এ insufficient stock, concurrent sale ও rollback সমস্যা | Transaction, row locks, stock validation, stable lock order |
| Short order number collision ও receipt enumeration | ULID order number, customer/session receipt authorization |
| Guest phone দিয়ে অন্য account-এ order যুক্ত করা হতো | Only authenticated customer ownership |
| Checkout এমন columns লিখত যা migrations-এ নেই | Schema-compatible order/item fields |
| Cancel/reactivate/quantity edit-এ stock drift | Reservation difference reconciliation; repeated cancellation test |
| Unsupported online payment নেওয়া হতো | Implemented COD method-এ validation সীমিত |
| OTP unlimited attempts ও nonsecure random generator | Route throttles, `random_int`, failed-send cleanup |
| SMS `env()` config cache-এ সমস্যা এবং sensitive logs | Config-backed settings, sanitized logs |
| Tracking শুধু order number দিয়ে পাওয়া যেত | Checkout phone verification ও throttling |
| Default পরিচিত admin password, reseed-এ password reset | Environment-backed initial admin; existing account password overwrite নয় |
| ৩০টি route nonexistent controller method-এ যেত | Working aliases, supported resource actions; route audit added |
| Duplicate route names, missing cart/bestseller/auth views | Route cleanup, cart redirect, templates added |
| Cart removal GET request দিয়ে হতো | CSRF-protected DELETE ও active frontend handler updated |
| Review author browser থেকে পাঠানো যেত | Authenticated account identity |
| Coupon field ছিল কিন্তু backend ছিল না | Misleading nonfunctional control removed |
| Root Apache rewrite loop/source exposure | Rewrite cleanup, source/duplicate-directory deny rules, upload script deny rule |

## যাচাই

- Original test run: **10 failed, 15 passed**.
- Application tests use an isolated in-memory SQLite database; existing business data was not migrated/reset.
- Added security, price, variant, rollback, cancellation, order editing, cart, route and storefront tests.
- Populated catalog flow covers product detail, category, quick view, bestsellers, cart, checkout and receipt rendering.
- `php tools/audit-routes.php`: no missing registered controller methods.
- `npm run build`: production assets generated successfully.
- `php artisan view:cache`: templates compiled successfully.
- Final test/dependency audit results are recorded in `VALIDATION.md`.

## যা এখনও missing বা পুরো যাচাই হয়নি

1. **Online payment integration:** bKash/Nagad logos are not gateway integrations. Merchant/provider choice, sandbox credentials, verified callbacks/webhooks, duplicate callback protection and refund/reconciliation testing are needed.
2. **SMS/OAuth live operation:** provider credentials, sender approval, provider-specific success response handling and real delivery/callback testing are not verified. HTTP success alone may not mean SMS delivery.
3. **Delivery rules:** configured zones are used, but address-to-zone enforcement needs the actual business coverage rules. Division/district/upazila hierarchy validation and courier API booking/webhooks need further work.
4. **Full staff permission matrix:** existing permission omissions were patched, but controller-wide permissions, inconsistent permission labels, high-privilege role assignment and every auxiliary stock/report action still require a complete authorization review with intended staff roles.
5. **Inventory beyond ecommerce:** POS, purchases, bulk import, stock adjustment, order deletion, returns and reports need end-to-end reconciliation on a copy of actual business data. SQLite tests do not prove MySQL concurrency behavior.
6. **Promotions and retention:** coupons, wishlist, abandoned-cart workflow and loyalty features have no completed backend in the inspected flows. Business rules are required before implementing them.
7. **Notifications and after-sales:** order-confirmation jobs, customer return requests, refund ledger and reconciliation are not complete.
8. **SEO and scale:** generated XML sitemap, structured product data, large catalog pagination/query profiling and cache strategy need work. A Blade partial named sitemap is not an XML sitemap endpoint.
9. **Browser UX:** new homepage/product pages, mobile menu and cart add/remove were checked in desktop/mobile Edge with screenshots and no JavaScript exceptions. Every content page, assistive technology, third-party integration and device combination has not been verified.
10. **Production operations:** live MySQL/schema drift, HTTPS/session settings, backups and restore drill, queue worker, monitoring, log retention and server configuration remain deployment work. Apache changes were inspected but not exercised on a live Apache server.
11. **Archived project:** nested duplicate source was removed after private backup. Deploy only the root application's `public` document root; do not publish the archive under `storage/app/private/backups/`.
12. **Existing carts/data:** old sessions may lack calculator dimensions/attribute identifiers required by the new pricing process. Clear old carts at rollout and let customers add items again. Existing negative stock, duplicate variants/shipping zones and corrupt orders need a separate data audit before migration or cleanup.

## Live হওয়ার আগে জরুরি

- যদি আগের version public ছিল, Google OAuth secret এবং পরিচিত seed-admin password বদলান; code থেকে route সরানো পুরোনো credential exposure বাতিল করে না।
- `SETUP.md` অনুসারে local/staging চালান; database backup ছাড়া production data repair করবেন না।
- Payment/SMS provider ও তিন delivery-zone charge ঠিক করুন; secrets chat-এ নয়, server environment-এ দিন।
- Missing items and deployment checks above mean this audit is not a claim that every module is finished or vulnerability-free.
