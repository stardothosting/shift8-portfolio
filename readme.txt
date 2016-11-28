=== Shift8 Full Width Portfolio ===
Contributors: 
Donate link: https://www.shift8web.ca
Tags: full width portfolio, portfolio, artwork, full width showcase, full width gallery, portfolio grid, full width grid, full width portfolio grid, full screen portfolio, responsive portfolio, responsive portfolio grid, responsive grid
Requires at least: 3.0.1
Tested up to: 4.5.2
Stable tag: 4.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This is a Wordpress plugin that allows you to easily manage and showcase a full width grid of your portfolio items. If an item has a "Writeup" or additional information, then clicking the image will go to the single portfolio item page. If not, then it will expand to a larger image.

== Description ==

This plugin integrates a stripped down bootstrap scaffolding in order to allow you to showcase a full screen / full width grid of portfolio items on your site. Simply use the shortcode to place your grid anywhere you want. A custom content type called "Shift8 Portfolio" is created for you to manage internally. You have the option of having a separate single page for each portfolio item added (that you will arrive when you click the image in the grid). If no additional information is given in the backend then clicking the image in the grid will simply enlarge it as a modal window.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/shift8-portfolio` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the shortcode markup anywhere in your site 


== Frequently Asked Questions ==

= What are the shortcode options? =

An example shortcode would be the following :

<pre>
[shift8-portfolio numposts="10"]
</pre>


= How can I style the markup? =

You can either style the content by using the built-in Wordpress WYSIWYG editor or you can apply CSS styling to the custom classes that are generated in the markup. There will be general "catch-all" CSS classes generated and custom per-shortcode classes that will allow you to style each markup individually, or all at once.

= How do I change the number of grid items per row? =

Unfortunately this is not possible at this point. Eventually a number will be passed via shortcode options

= What else have you done? =

You can visit [our website](https://www.shift8web.ca "Toronto Web Design") to see! :)

== Screenshots ==

1. This is the trigger button. It can either be a *<button>* or a text a href link. Both options will have CSS classes wrapping the modal trigger so you can style it however you want.
2. This is the flyout area. You can set the background color with the **color** shortcode option. The option takes an HTML color code and applies it to the background of the modal window.

== Changelog ==

= 1.0 =
* Stable version created
* Implemented short code options 

