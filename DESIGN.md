# Unibox storefront design

The storefront uses a shared visual system: white, charcoal actions and warm stone accents, inspired by minimal Shopify storefronts. The homepage, navigation, product cards, footer, cart drawer and existing checkout/account forms share the palette.

| Token | Value | Purpose |
| --- | --- | --- |
| `--ub-paper` | `#FFFFFF` | Page background |
| `--ub-ink` | `#202020` | Text and dark sections |
| `--ub-teal` | `#202020` | Primary buttons, links and emphasis |
| `--ub-mint` | `#F5F3EF` | Quiet section backgrounds |
| `--ub-amber` | `#C7B49B` | Small highlights |

The homepage uses a dynamic photographic banner slider, a warm-background collection gallery with large numbered photo cards, borderless product grids and a centered custom-order story. All active categories appear in the collection browser, with arrows and a horizontal swipe rail. This is a Laravel storefront redesign, not a Shopify platform migration.

## Homepage banners

Manage banners at **Admin → Sliders** (`/admin/sliders`). Active records with a desktop image appear newest first. Each banner uses its title, short description, link and optional mobile image. Recommended artwork: 1600 × 800 desktop, 800 × 1000 mobile. Empty/unsafe links fall back to the shop. No active banners gives a static catalog-based hero; one banner hides carousel controls.

`public/frontend/assets/js/home.js` handles five-second autoplay, arrows, dots, keyboard navigation, swipe and pause/play without loading Swiper. Mouse hover no longer pauses automatic movement; manual navigation resets the timer. Keyboard focus, an offscreen/hidden page and reduced-motion preferences suspend automatic movement; the play control can explicitly resume it. Only the first image has eager/high-priority loading; later slides use lazy loading. `resources/views/frontend/home/partials/hero.blade.php` contains the shared banner markup.

Text inputs use a single focus border without an extra outline or shadow. Button/link keyboard focus indicators remain available. Browser checks verify the login field's computed focus styles and slider autoplay while the mouse is over the hero.

Below 768px, navigation opens as a sliding panel from the left. It closes using its close button, backdrop, Escape or a navigation link. The panel locks page scrolling, manages keyboard focus and restores desktop navigation on resize. The cart and navigation panels cannot stay open together.

`php tools/preview-sliders.php` adds two sample banners only to the isolated preview database. It does not add banners to the business database.

## Where to edit

- `public/frontend/assets/css/storefront.css`: tokens, shared components and responsive rules.
- `public/frontend/assets/css/info-pages.css`: shared About/Contact typography, story layout, team/service cards, customer quotes and contact form. About content continues to use the existing admin records. Contact details use Settings with the prior address/email/hours as fallback; the placeholder phone was removed. Directions open from the displayed address, avoiding an embedded map download. Contact form preserves submitted values and shows field errors and success feedback.
- `public/frontend/assets/css/pages/`: extracted page-specific styles; the obsolete category modal stylesheet has since been removed.
- `public/frontend/assets/js/storefront.js`: one cart update/removal implementation, debounced search, mobile navigation and accessible cart drawer.
- `public/frontend/assets/css/account.css` and `js/account.js`: customer login, account navigation, forms and OTP/location interactions. See `CUSTOMER_EXPERIENCE.md` for routes and behavior.
- `resources/views/frontend/components/product-card.blade.php`: product cards reused by homepage, search, categories and bestsellers.
- `resources/views/frontend/partials/header.blade.php` and `footer.blade.php`: shared navigation, search, account/cart entry, newsletter and support links.
- `resources/views/frontend/home/index.blade.php`: hero, categories, collections and custom-order section. Actual catalog records drive the content; the empty catalog has a deliberate fallback.

## Cleanup

- Removed the separate `ninetyspoint.com/` source tree. Its ZIP backup is private at `storage/app/private/backups/ninetyspoint-source-before-cleanup.zip` and is not part of the served frontend.
- Removed obsolete homepage CSS/JavaScript templates and the unused alternate product-detail template.
- Removed the old global template JavaScript that duplicated gallery initialization and raised a missing `niceSelect` exception.
- Removed unused global plugin loads, repeated cart handlers, repeated add/buy payload construction, commented-out markup and repeated cart-count IDs.
- Replaced homepage-wide unbounded product queries and unused content queries with bounded, eager-loaded catalog queries.
- Source hash scan found no byte-identical files larger than 200 bytes across `app`, `resources`, `routes`, `config` and `database`. This is not a claim that all similar logic in every module has been refactored.
- Hardcoded tracking accounts were removed. To enable your own tracking, configure `META_PIXEL_ID` / `GOOGLE_TAG_MANAGER_ID` in the environment. Existing ecommerce data-layer events remain.

## Preview and browser checks

The isolated demo uses the project's existing product images with sample catalog names/prices. It does not modify business data.

```text
php tools/preview-storefront.php seed
php -S 127.0.0.1:8097 -t public tools/preview-router.php
```

Open `http://127.0.0.1:8097`. Keep this preview bound to localhost. The real application uses your normal environment and product database.

Screenshots and browser-check output are under `storage/app/private/preview/`. Desktop (1440px) and mobile (390px) checks cover horizontal overflow, mobile menu, cart drawer, Escape/focus behavior, product add-to-cart and removal. No browser JavaScript exceptions were observed in those checked flows.

This update preserves the functioning catalog/checkout system. Payment gateway activation, real SMS/courier integration and the remaining production work are listed in `PROJECT_AUDIT.md`.
