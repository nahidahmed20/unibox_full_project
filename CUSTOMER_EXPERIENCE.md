# Customer experience update

- Product add-to-cart now shows a SweetAlert success toast alongside the drawer. Update/remove and session notifications use the shared notifier. SweetAlert2 11.26.25 is served locally, preserving its MIT license header, so alerts no longer depend on a CDN request.
- Login and OTP screens use a shared responsive account design. OTP accepts exactly four digits, preserves leading zeroes in the input, shows expiry/resend state, and prevents double submission. Removed duplicate flash-message scripts and unsafe raw session interpolation.
- Account overview shows actual order counts and order numbers, with useful empty states. Profile and password forms now render complete pages, with shared navigation, visible validation errors and restored location selection. The previous AJAX loader and duplicate main-content IDs were removed.
- Footer uses the `footer_logo` uploaded under admin Settings, with a text fallback. Newsletter and footer were redesigned with larger text and clear links. First-party frontend declarations that specified `font-size: 13px` now use `16px`.
- The unused alternate user dashboard and retired account stylesheets were removed.

## Account routes

| URL | Laravel name |
| --- | --- |
| `/account/login` | `account.login` |
| `/account` | `account.dashboard` |
| `/account/orders` | `account.orders.index` |
| `/account/orders/{orderNumber}` | `account.orders.show` |
| `/account/profile` | `account.profile.edit` / `account.profile.update` |
| `/account/password` | `account.password.edit` / `account.password.update` |
| `/account/logout` (POST) | `account.logout` |
| `/account/otp/send` (POST) | `account.otp.send` |
| `/account/otp/verify` (POST) | `account.otp.verify` |

Existing user/customer URLs and old named routes remain available for compatibility. Internal links and redirects use the canonical account names. Existing OTP throttles and account authorization also apply to the canonical routes.

Browser artifacts in `storage/app/private/preview` include login, dashboard and footer screenshots. The account screenshot is rendered using an isolated demo account; authenticated route behavior is covered by feature tests. Real SMS and OAuth provider delivery are not established by local UI tests.
