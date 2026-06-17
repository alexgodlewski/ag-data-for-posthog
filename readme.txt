=== AG Data for PostHog ===
Contributors: agstudioai, levskipg
Tags: posthog, woocommerce, analytics, attribution, ecommerce
Requires at least: 5.8
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.5.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

PostHog Analytics for WooCommerce. Server-side event tracking, marketing attribution engine, identity stitching, and LTV enrichment.

== Description ==

AG Data for PostHog connects your WooCommerce store to [PostHog](https://posthog.com) — the open-source product analytics platform. Track the complete customer journey from first click to lifetime value, all within PostHog.

= Why AG Data? =

Most WooCommerce analytics plugins give you pageviews and basic events. AG Data gives you a **full marketing attribution engine** — first-touch/last-touch UTM tracking, ad click ID capture (Google, Meta, TikTok, Microsoft, LinkedIn), server-side first-party cookies that survive Safari ITP, and automatic LTV enrichment on every person profile.

= Key Features =

**Server-Side Event Tracking**

* Order Completed, Order Refunded, Order Status Changed
* Deduplication prevents double-counting
* Blocking API calls ensure delivery before marking as tracked
* Works with all payment gateways and checkout flows

**Frontend Event Tracking**

* Product Viewed, Product List Viewed, Products Searched
* Product Added / Removed (classic and block-based carts)
* Cart Viewed, Checkout Started
* Product Clicked, Coupon Applied / Removed, Payment Info Entered
* Works without jQuery — block themes fully supported

**Marketing Attribution Engine**

* Captures UTM parameters and ad click IDs (gclid, fbclid, ttclid, msclkid, li_fat_id)
* Server-side first-party cookies bypass Safari ITP 24-hour restriction
* First-touch and last-touch attribution persisted to every order
* Days-to-conversion and session count tracking
* Falls back to WooCommerce 8.5+ native attribution when cookies are unavailable
* Attribution data included in all PostHog order events

**Identity Stitching**

* Reads PostHog JS SDK cookie server-side for seamless funnel connection
* Browser `posthog.identify()` for logged-in users
* Server-side `$identify` with `$anon_distinct_id` merges anonymous and known profiles
* PostHog funnels work end-to-end: Landing Page → Checkout Started → Order Completed

**LTV Person Enrichment**

* `total_orders`, `lifetime_value`, `avg_order_value`, `last_order_date` updated on every purchase
* `first_order_date`, `acquisition_source`, `acquisition_medium`, `acquisition_campaign` set once via `$set_once`
* Build PostHog cohorts like "Customers with LTV > $500 acquired from Google Ads"

**GDPR / Consent Management**

* Optional consent mode: starts PostHog opted-out with memory-only persistence
* Exposes `aphaOptIn()` / `aphaOptOut()` JavaScript functions
* Built-in support for CookieYes and Complianz consent management platforms

**WooCommerce Compatibility**

* HPOS (High-Performance Order Storage) compatible
* Cart and Checkout Blocks compatible
* Classic and block checkout flows supported
* Reverse proxy support for first-party tracking domains

= Requirements =

* WordPress 5.8+
* WooCommerce 7.0+
* PHP 7.4+
* A PostHog account (free tier available at posthog.com)

== Installation ==

1. Upload the `ag-data-for-posthog` folder to `/wp-content/plugins/`
2. Activate the plugin through the Plugins menu in WordPress
3. Go to WooCommerce > Settings > AG Data
4. Enter your PostHog project API key (starts with `phc_`)
5. Select your PostHog region (US or EU)
6. Optionally configure a reverse proxy URL for first-party tracking
7. Done! Events will start flowing to PostHog immediately.

== Frequently Asked Questions ==

= Where do I find my PostHog API key? =

Log in to PostHog, go to Project Settings, and copy the Project API Key. It starts with `phc_`.

= Does AG Data work with PostHog Cloud and self-hosted? =

Yes. Select US or EU for PostHog Cloud, or enter your self-hosted URL in the Custom Proxy URL field.

= Will this slow down my site? =

No. Server-side events use non-blocking HTTP calls. The frontend tracker is a lightweight script (~5KB) with no jQuery dependency. Attribution cookies are set server-side with minimal overhead.

= Does AG Data work with Safari ITP? =

Yes. Unlike JavaScript-set cookies (which Safari caps at 24 hours for URLs with tracking parameters), AG Data uses server-side `setcookie()` calls. These are treated as first-party cookies and persist for the full configured duration.

= How does attribution work? =

AG Data captures UTM parameters and ad click IDs (gclid, fbclid, ttclid, msclkid, li_fat_id) using server-side first-party cookies. First-touch and last-touch attribution data is persisted to every order and sent to PostHog, so you can analyze your full marketing funnel.

= Does AG Data support WooCommerce Blocks checkout? =

Yes. Both classic (shortcode) and block-based checkout flows are fully supported for identity persistence and event tracking.

== External services ==

This plugin connects to PostHog, a third-party product analytics service, to send your store's analytics and e-commerce event data. This connection is required for the plugin to work — its entire purpose is to record analytics in PostHog. No data is sent until you enter a PostHog Project API key in the plugin settings.

What PostHog is used for:

* Receiving server-side e-commerce events (Order Completed, Order Refunded, Order Status Changed).
* Receiving frontend browsing events (Product Viewed, Cart Viewed, Checkout Started, and similar) via the PostHog JavaScript SDK, which is loaded on your site's pages from your configured PostHog host.
* Storing person profiles enriched with order/LTV data and marketing attribution data.

What data is sent, and when:

* While a visitor browses your store, the PostHog JavaScript SDK captures pageviews and browsing events. This includes page URLs, referrer, UTM parameters, ad click IDs (gclid, fbclid, ttclid, msclkid, li_fat_id), and a PostHog-generated anonymous identifier.
* When an order is placed, refunded, or changes status, the plugin sends order data from your server — order ID, totals, currency, line items, payment and shipping method, and billing/shipping country. For logged-in users, a WordPress-based identifier and the customer email may also be sent so anonymous and known profiles can be merged.
* Requests are sent to the PostHog host you configure in the settings (PostHog US Cloud, PostHog EU Cloud, or your own self-hosted/proxy URL).

Service provider: PostHog Inc.
Terms of Service: https://posthog.com/terms
Privacy Policy: https://posthog.com/privacy

== Changelog ==

= 1.5.3 =
* Fix: Adds app_source=wordpress to server-side Order Completed attribution

= 1.5.2 =
* Fix: Escapes PostHog JavaScript property names and $pageview in the inline bootstrap snippet

= 1.5.1 =
* New: Adds a stable funnel_session_id across WordPress pageview, checkout, and server-side order events
* New: Adds funnel_key, host, source_host, source_page, and URL properties for cleaner PostHog CRO reporting
* Fix: Captures $pageview manually after registering funnel properties so landing-page views can join to checkout/order events

= 1.4.0 =
* Renamed plugin to AG Data for PostHog
* Fix: Inline scripts now use wp_add_inline_script() for WordPress standards compliance

= 1.3.1 =
* Fix: Form identify race condition — added submit listener to catch email before Elementor/AJAX redirect
* Fix: Autofill safety net — input listener catches browser autofill without blur
* Fix: Reduced form identify debounce from 400ms to 100ms
* Fix: Order Completed now fires identify before capture — events use email as distinct_id
* Fix: Upsell orders use billing email instead of random UUID fallback

= 1.3.0 =
* New: Element visibility tracking — fire PostHog events when visitors see key page elements
* New: Add CSS class `apha-track-view` to any element (works with Elementor, Block Editor, raw HTML)
* New: Custom event names via `data-apha-event` attribute
* New: Custom visibility threshold via `data-apha-threshold` attribute (default 50%)
* New: IntersectionObserver-based — no scroll listeners, great performance
* New: MutationObserver catches lazy-loaded/dynamic content
* New: "Element Visibility Tracking" toggle in WooCommerce > Settings > AG Data
* New: Consent-aware — re-initializes after opt-in when consent mode is active

= 1.2.0 =
* New: Form identification — identifies anonymous visitors in PostHog when they enter an email in any form (checkout, contact, signup)
* New: Supports WooCommerce classic checkout, block checkout, and generic forms (Elementor, CF7, WPForms, plain HTML)
* New: Auto-detects email and name fields on blur — captures even abandoned forms
* New: "Form Identification" toggle in WooCommerce > Settings > AG Data
* New: Respects person_profiles mode — uses setPersonProperties (always) or identify (identified_only)
* New: Consent-aware — re-initializes after opt-in when consent mode is active

= 1.1.0 =
* New: Marketing attribution engine with first-touch/last-touch UTM tracking
* New: Ad click ID capture (Google, Meta, TikTok, Microsoft, LinkedIn)
* New: Server-side first-party cookies (bypasses Safari ITP)
* New: LTV person enrichment (total_orders, lifetime_value, avg_order_value)
* New: Identity stitching — reads PostHog JS cookie server-side for seamless funnels
* New: Browser posthog.identify() for logged-in users
* New: Product Clicked, Coupon Applied/Removed, Payment Info Entered events
* New: Batch API endpoint support
* New: $set_once support for first_order_date, acquisition_source, created_at
* New: GDPR consent mode with CookieYes and Complianz integration
* New: WooCommerce 8.5+ native attribution fallback
* Fix: Race condition in Order Completed deduplication (TOCTOU)
* Fix: Replaced deprecated $create_alias with $identify + $anon_distinct_id
* Fix: Enabled capture_pageview for PostHog web analytics and session replay
* Fix: Standardized variant format (human-readable labels instead of IDs)
* Fix: jQuery dependency made optional for block themes
* Fix: False-positive product search detection
* Fix: Consolidated duplicate variation data loading (N+1 query)
* Improvement: Added payment_method, shipping_method, order_number, billing/shipping_country to Order Completed
* Improvement: Refund deduplication prevents duplicate Order Refunded events
* Improvement: Max products filter for data layer safety valve

= 1.0.0 =
* Initial release
* Server-side Order Completed, Order Refunded, Order Status Changed tracking
* Frontend Product Viewed, Product Added/Removed, Cart Viewed, Checkout Started
* Product List Viewed and Products Searched
* PostHog JS SDK integration with reverse proxy support
* WooCommerce HPOS and Blocks compatibility
* Identity management with cookie-based distinct IDs

== Upgrade Notice ==

= 1.4.0 =
Plugin renamed to AG Data for PostHog. All functionality and settings are preserved — no reconfiguration needed.

= 1.3.1 =
Fixes identity stitching — form identify now fires on submit (not just blur), Order Completed events use email as distinct_id, and upsell orders are properly attributed.

= 1.3.0 =
New element visibility tracking lets you know who actually saw key content on your landing pages — not just who triggered a pageview. Add `apha-track-view` class to any element.

= 1.2.0 =
New form identification feature links anonymous visitors to PostHog profiles when they enter their email in any form. Works with all form builders and WooCommerce checkout flows.

= 1.1.0 =
Major update: marketing attribution engine, identity stitching fix for PostHog funnels, LTV enrichment, and consent management. Recommended for all users.
