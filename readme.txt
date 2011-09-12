=== Bolts WordPress Parent Theme ===
Contributors: aliso
Requires at least: 3.1
Tested up to: 3.2.1
Version: 1.2

== Description ==

Bolts is a WordPress parent theme designed to make theme development swift and simple. It's written in valid HTML 5 and comes with some basic styling in place, so it could be used on its own if desired.

Custom widgets:
* Popular Posts (based on view count, not on comments!)
* Facebook Like Box
* Twitter feed
* Login form
* Contact form

Custom shortcodes:
* Horizontal divider
* Facebook Like button (with appearance options)
* Twitter button (with appearance options)
* Digg button (with appearance options)
* Contact form

Custom content styles:
* Buttons (normal, primary, cancel, disabled)
* Download link
* Callout boxes (normal/note, info, success, alert, warning)

Theme options:
* General settings
* Appearance
* SEO
* Social media
* Contact form

== Installation ==

1. Upload `bolts` to your WordPress theme directory.
2. Activate the theme under the Appearance options in the admin.
3. To build a custom theme using Bolts, create a child theme by adding `Template: bolts` to your theme header.

== Frequently Asked Questions ==

= What if I have feedback or a question about Bolts? =

Contact us with feedback at [Themejack](http://themejack.net) or our [support site](http://themejack.zendesk.com).

== Changelog ==

= 1.2 =
* Fixed: Facebook widget no longer gets cut off
* Enhanced: Login form widget displays user avatar & custom links
* Improved: CSS files are queued consecutively to improve performance
* Added: StumbleUpon shortcode
* Added: Admin notices now present to notify users of updates
* Added: New hooks around sidebar registration to allow unregistering sidebars via child themes
* Misc. PHP Notice-level debugging

= 1.1.1 =
* Fixed contact form widget (was using incorrect shortcode)

= 1.1 =
* Misc. code cleanup

= 1.0 =
* Initial release