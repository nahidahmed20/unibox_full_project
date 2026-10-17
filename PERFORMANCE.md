# Storefront performance changes — 2026-09-08

- Category grids show four products per row from 768px upward, two below 768px. List mode stays one column. Category pages contain up to 16 products.
- Search and bestseller pages eager-load the relationships used by cards, removing per-product stock/category queries. A regression test checks relationship queries with 18 products.
- Removed unused category/search filter-data queries and reused homepage category data in navigation.
- Added and applied indexes for product slugs, newest listings, category/subcategory listings, bestsellers, variant ownership and subcategory lookups in the configured local database. Deployments must also run the new migration.
- Swiper only loads on pages that use it; Select2 only loads on checkout. Homepage/category no longer download the 334,589-byte uncompressed Swiper script or its stylesheet, or Select2's script/stylesheet.
- Removed the unused remote Google font import in favor of the storefront's system font stack.
- Removed the category page's unreachable legacy quick-view modal, its JavaScript and its stylesheet; cards continue to open product details for option selection and adding to cart.
- Product-card images remain lazy-loaded with explicit dimensions and now decode asynchronously. The hero remains high priority.
- Added Apache text compression and bounded static-asset expiration rules. These need the corresponding Apache modules; PHP's local preview server does not process `.htaccess`. Personalized HTML/cart/checkout responses are not given public cache lifetimes.

## Verification and deployment

`php artisan test --compact` covers commerce and listing-query regressions. `node tools/check-storefront-browser.mjs` checks category columns at 390, 768, 991, 1024 and 1440px, list mode, unused homepage libraries, product/cart interactions and JavaScript errors.

Production should run migrations and `php artisan optimize` after configuring its environment (see `SETUP.md`). Enable OPcache and compression in the actual hosting environment. Do not cache personalized storefront HTML at a CDN.

These changes reduce queries and unnecessary downloads; they are not a measured live-site loading-time guarantee. Existing full-resolution uploads are preserved. Responsive image derivatives and live-device/network measurements remain useful follow-up work, particularly for the large photographic hero and multi-megabyte uploads.
