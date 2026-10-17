# Validation — 2026-09-07

| Check | Result |
| --- | --- |
| Laravel application suite | 61 passed; expanded About/Contact regression checks also passed |
| Registered controller-method audit | No missing actions |
| Blade compilation | Successful |
| Production Vite build after dependency updates | Successful, Vite 7.3.6 |
| PHP dependency audit after updates | No security vulnerability advisories found |
| npm dependency audit after updates | 0 vulnerabilities |
| Desktop/mobile storefront checks | No horizontal overflow in checked home/product pages |
| Mobile navigation and cart | Menu, drawer, Escape, add/remove passed |
| Browser JavaScript exceptions in checked flows | None |
| Duplicate application directory | Removed; private ZIP backup retained |
| Category responsive grid | Four columns at 768, 991, 1024 and 1440px; two at 390px; list mode one column |
| Listing query regression | Relationship queries remain batched with 18 seeded products |
| Customer account routes | Canonical and legacy account pages render; guest protection and logout pass |
| Add-to-cart notification | Visible SweetAlert success toast confirmed in browser |
| Login and account layout | Desktop/mobile screenshots generated with isolated demo data |
| Dynamic homepage slider | Active-only/mobile-image/fallback feature tests; arrows, dots, keyboard, pause, autoplay and swipe passed in browser |
| About and Contact | Desktop/mobile layouts without overflow; configured About sections and contact validation/persistence verified |

The performance update added and applied catalog indexes to the configured local database, scoped optional vendor assets, and removed unused category modal code. Apache cache/compression rules require verification on the deployment server. See `PERFORMANCE.md`.

The Shopify-inspired redesign was rechecked on 2026-09-08: 53 tests / 467 assertions passed, Blade compilation succeeded, the route audit returned no missing actions, and desktop/mobile browser checks passed. Screenshots were refreshed after correcting the mobile hero headline wrapping. Dependency audit and build results above refer to the preceding dependency update.

The original PHP dependency audit reported 40 advisories across 12 packages; the original npm audit reported 36 affected dependencies. Updates stayed within the project's declared dependency constraints. The original Composer lock is retained at `tools/composer.lock.before-update` for comparison, not deployment.

Tests use in-memory SQLite. The browser preview uses a separate SQLite demo database. Live MySQL race behavior, merchant callbacks, SMS delivery, courier operations, all staff-role combinations and full accessibility coverage are not established by these checks.

Frontend third-party CDN scripts and checked-in vendor assets are not covered by Composer/npm audit results. Deployment and additional work are documented in `SETUP.md` and `PROJECT_AUDIT.md`.
