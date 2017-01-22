=== Cactus Info Slider ===
Contributors: thehappycactus
Tags: slider
Requires at least: 3.0.1
Tested up to: 4.2.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A very simple slider devoted to displaying sequential information.  Explanatory text on left, image on right.

== Description ==
The Cactus Info Slider is a simple plugin whose purpose is to display sequential information.  As opposed to the many sliders that exist whose main purpose is to showcase photos, Info Slider's main purpose is to showcase information.  Its best use is for anyone looking to display a step-by-step process with both text and a visual aid.

Info Slider uses 2 simple shortcodes and 3 simple attributes to create the slides:

* [cactus-slider] - Open and close your entire set of slides with this shortcode.
* [slider-item] - Open and close a single slide with this shortcode.  All informational text you want displayed should be between this open/close shortcode.
	* [slider-item nbr="1"] - The "nbr" attribute gives the slide a numerical value for easier tracking.
	* [slider-item title="My Slide"] - The "title" attribute gives the slide a title, which will be represented as an h2 header.
	* [slider-item img="http://server.com/myImage.jpg"]  - the "img" attribute is a URL to the image you want to be associated with the slide.

== Installation ==
1. Upload `cactus-info-slider.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use the aforementioned shortcodes to insert the slider anywhere in your pages or posts.

== Changelog ==

= 1.0 = 
* Initial upload of basic Cactus Info Slider design.