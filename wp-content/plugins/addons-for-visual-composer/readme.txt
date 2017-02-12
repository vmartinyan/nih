=== Addons for Visual Composer ===
Author URI: http://portfoliotheme.org
Plugin URI: http://portfoliotheme.org/visual-composer-addons
Contributors: livemesh
Tags: visual composer, visual composer addons, vc addons, visual composer extensions, vc extensions, page builder, portfolio, carousel, Post, posts, shortcode, tabs, admin, plugin, page
Requires at least: 4.1
Tested up to: 4.7
Stable Tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html-func

A collection of premium quality addons or extensions for Visual Composer page builder. Visual composer must be installed and activated.

== Description ==

Addons for Visual Composer features professional looking, easy to use yet highly functional extensions that can be used in a WPBakery Visual Composer page builder.

Visual Composer plugin must be activated to use this plugin. After you activate the required plugins, the elements should be available for use in Visual Composer.

See the all of elements in action here -

<a href="http://portfoliotheme.org/visual-composer-addons" title="Addons for Visual Composer Demo Site"><strong>LIVE DEMO</strong></a>.

The plugin comes with the following VC addons or extensions. <strong>Almost all of the elements come with a dark version.</strong> -

<ul>
<li>Services that capture what you can offer for your clients/customers.</li>
<li>Responsive Tabs that function seamlessly across all devices and resolutions.</li>
<li>Accordion/Toggle that capture collapsible content panels when space is limited.</li>
<li>Heading styles to capture effective headings for your page sections.</li>
<li>Team Profiles elements to display all the team members.</li>
<li>Odometer to show impressive numbers pertaining to your work or company.</li>
<li>Bar charts element to capture skills or any type of percentage stats.</li>
<li>Animated Pie charts for visual depiction of percentage stats.</li>
<li>Testimonials to tell everyone the good things you often hear from your clients/customers.</li>
<li>Testimonials slider is a responsive touch enabled slider that cycles through testimonials.</li>
<li>Post Carousel element that displays your posts as a highly responsive carousel.</li>
<li>Generic Carousel element that displays lets you present a list of HTML content in a carousel.</li>
<li>Spacer element that displays lets you set space between elements and vary the spacing across device resolutions.</li>
<li>Grid elements that displays portfolio/blog entries in a nice responsive grid. Masonry and packed options are supported.</li>
<li>Client List element to showcase the clients that you have handled.</li>
<li>Pricing Plans to help get more sales.</li>
</ul>

Visit Tools &gt; Import page in WordPress admin to import into your site sample-data.xml file located in the plugin folder. The sample data lets you replicate the demo site fully to help get a head start on using the extensions bundled with the plugin.

Do you have suggestions to make or want to be notified of important updates? Reach out to us on Twitter -
http://twitter.com/live_mesh

== Installation ==

1. Install and activate the Visual Composer page builder.
2. Unzip the downloaded livemesh-vc-addons.zip file and upload to the `/wp-content/plugins/` directory or install the Visual Composer Addons by Livemesh plugin from WordPress repository. Activate the plugin through the 'Plugins' menu in WordPress.
4. For Portfolio element, install and activate the <strong>optional plugin</strong> <a href="https://wordpress.org/plugins/jetpack/" rel="nofollow">Jetpack by WordPress.com</a>. The Portfolio element is built using custom post types registered by <strong>Custom Content Types</strong> module. Activate and configure this Jetpack module and check the option 'Enable Portfolio Projects for this site' at the bottom of Settings &gt; Writing page.

Optionally, you can import the sample data that replicates the demo site for you by importing the file sample-data.xml file located in the plugin directory. The import option is available under Tools &gt; Import in WordPress admin. 

== Frequently Asked Questions ==

= Does it work with the theme that I am using? =

Our tests indicate that the elements work well with most themes that are well coded. You may need some minor custom CSS with themes that hijack the styling for heading tags by using !important keyword.

Some themes override default templates provided by Visual Composer. The themes that override VC Row template may require you to manually set the attributes required for the dark version (see below).

The demo site is best recreated with a theme that supports a full width page template without sidebars. The elements can still be used in the pages of default template.

= How to enable the dark version for any element? =

In Visual Composer page builder, add a row wrapper for the element, edit row and check the option 'Dark Background?' at the end of General tab of the row or an inner row element.

For themes that override the VC row template with one of their own, you may need to add a custom class 'lvca-dark-bg' manually to the VC row wrapper element to activate the dark version of an element.

= My portfolio does not show any items. =

Pls install and activate Jetpack plugin, activate the Custom Post Types module and make sure the option 'Enable Portfolio Projects for this site' is checked at the bottom of Settings &gt; Writing page in WordPress admin.

== Screenshots ==
1. The plugin Addons for Visual Composer tab in Visual Composer Add Element window.
2. Visual Composer addon elements in action in Visual Composer Page Builder tab of Page Edit window.
3. Editing a addon/extension element in the Visual Composer Page Builder.

== Changelog ==

= 1.4 =
* Added - Left, right and center alignment option to the heading element
* Added - Styling for services when font icons are chosen instead of image icons
* Fixed - The testimonials slider content not aligned to the center
* Fixed - The tab title width was fixed with no wrapping
* Updated - The isotope and imagesloaded JS libraries.

= 1.3 =
* Fixed - Check for page id when displaying posts/pages in a grid to avoid infinite loop
* Fixed - Tabs not processing shortcode content
* Fixed - Accordion/Toggle element not processing shortcode content

= 1.2 =
* Fixed PHP warnings raised in certain themes that customize VC.
* Performed compatibility checks with a number of premium themes; fixed any issues found.
* Compatibility fixes along with some minor styling tweaks for tabs, accordion, carousel and portfolio/post grid elements.

= 1.1 =
* New elements - Responsive Tabs and Accordion of variety of styles
* Fixed a bug that caused many elements to become uneditable in VC editor
* New services element style
* Ability to choose entry meta contents for carousel and grid
* Ability to set a link to the clients website in clients element
* Email icon restored for team profiles element
* Fixed some bugs, incompatibilities and design improvements

= 1.0 =
* Initial release.
