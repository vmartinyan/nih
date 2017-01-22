=== Total Slider ===
Contributors: PeterUpfold, VanPattenMedia
Donate link: http://www.totalslider.com/donate/
Tags: slider, slideshow, rotation, rotator
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: 2.0.1
License: GPLv2 or later

Transform your experience with sliders forever. A beautiful, true WYSIWYG interface designed to blend seamlessly with the WordPress core.

== Description ==

**[Total Slider](http://www.totalslider.com/)** is a plugin for WordPress from Van Patten Media that helps web developers build sliders that can be easily managed by non-technical users.

Build your own templates in HTML/PHP, CSS, and JavaScript, and Total Slider will supply a WYSIWYG interface designed to blend seamlessly wit the WordPress core.

= Note to non-technical users =

Total Slider makes editing sliders easy, but it typically needs to be installed and configured by an experienced developer first. Out of the box, Total Slider does _not_ provide a way to edit your theme, add previous/next buttons, and otherwise customise the look of the slider without diving into code.

It does, however, ship with three built-in templates and is very easy to use if you are happy using those.

If you're looking for a slider solution that won't involve editing code to set it up, Total Slider probably is not for you.

= How it works =

Total Slider allows you to create a number of ‘slide groups’. Each slide in the group can be given a title, some description text, a background image and, optionally, a link. You can then have these displayed in a slideshow interface on a portion of your page.

Once this plugin is installed and activated, use the Slider tab in your WordPress dashboard to assemble a group of slides with text, backgrounds and so on. You can then have the slides show up on any page of your site using the Total Slider widget.

Go to **Appearance** > **Widgets** in WordPress and drag a new Total Slider widget to the correct area. Then, simply select the slide group to show in this area of your site. You can also use the Total Slider shortcode to add a slider into a post or page by clicking the new button in the editor toolbar.

**Available in**: English, Français

= Key links =

* [TotalSlider.com](http://www.totalslider.com)
* [User Docs](http://www.totalslider.com/docs/)
* [Developer Docs](https://github.com/vanpattenmedia/total-slider/wiki)
* [License](https://raw.github.com/vanpattenmedia/total-slider/master/license.txt)
	
== Installation ==

1. Install Total Slider either by searching for it under **Plugins** > **Add New** in your WordPress site dashboard, or download it here from the Plugin Directory, extract the zip file and upload the **total-slider** directory to **wp-content/plugins**.
2. Activate the plugin on the **Plugins** page of your dashboard.
3. Click **Slider** in the admin menu and get started on your first slide group!

== Screenshots ==

1. The slide groups screen.
2. Creating a new slide group is easy: just give it a name and choose a template.
3. Getting started on a new slide group.
4. Make changes to the slide, and see the preview update in real time.
5. Use the standard WordPress uploader to set your background image.
6. Position the title and description anywhere over the background with drag and drop.
7. Link the slide to a page or post on your site easily.

== Changelog ==

= 2.0.1 =
* Fixes some uncommon issues that may cause slides to become orphaned during an upgrade.
* Fixes any slides that have become orphaned due to the issue above, re-connecting them to their slide groups.
* Fix for issue where a slide with a blank description would display the previous slide's description (reported by [Rachel on WP.org Support Forums](https://wordpress.org/support/profile/rleggett))

= 2.0 =
* Major new release, featuring drafts, auto-saving drafts and improved behind-the-scenes data storage.

= 1.1.5 =
* Fixes compatibility with WordPress 4.0. No longer requires you to enter a slide description if you do not want one.

= 1.1.4 =
* Important fix for WordPress 3.7 — prevents new slides from replacing old ones when you add a new slide.

= 1.1.3 =
* Fix a bug where Total Slider’s interface would not be functional if the user preferred to not use WordPress’ rich text editor.

= 1.1.2 =

* Support for the WordPress 3.5 uploader.
* Code cleanup, now complies with WordPress Coding Standards.

= 1.1.1 =
* Some minor user interface tweaks in readiness for WordPress 3.5.
* Fixes an issue where the user who installed Total Slider may not see it in the WordPress admin sidebar.
* A moderate impact security update — prevents malicious slide group names from interacting with the Insert Slider popup window in the Editor.

= 1.1 =
* Introducing multiple slide templates — use Total Slider on different parts of your site, with a unique look for each of your slide groups.
* Includes two beautiful new built-in templates, Twenty Twelve and Twenty Twelve (Alternate), which perfectly complement [WordPress’ new theme](http://wordpress.org/extend/themes/twentytwelve) for this year.
* Easily add a slider to any post or page with the shortcode. Look for the Total Slider button in the editor toolbar.
* New, more flexible support for (multiple) custom templates. Your templates can now have any type of DOM structure and this will be reflected automatically in the editor, for a fully WYSIWYG experience.
* Many minor improvements, including `E_STRICT` and `E_NOTICE` compliance, a fix for a bug where the first slide would always be blank and adoption of the `.min.js` naming standard for minified JavaScript files, ready for WordPress 3.5.

= 1.0.4 =
* Fix some potential issues with JavaScript enqueueing, minify and combine JavaScript

= 1.0.3 =
* Add developer-focused shortcode support, French translation (thanks Frédéric Serva) and fixed a few i18n omissions

= 1.0.2 =
* Fix a few minor interface issues for WordPress 3.4 that did not show up in the release candidate testing.

= 1.0.1 =
* Fix bug where Total Slider would fail to enqueue the slider JavaScript if you used a custom PHP template or custom CSS, but not your own custom JavaScript.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 2.0.1 =

Fixes various bugs, including orphaned slides during v1.1.x -> v2.0 upgrades.

= 2.0 =

Major new release featuring drafts, auto-save and an updated data format. Please back up your database!

= 1.1.5 =

Fixes compatibility with WordPress 4.0. No longer requires you to enter a slide description if you do not want one.

= 1.1.4 =

Important fix for WordPress 3.7 — prevents new slides from replacing old ones when you add a new slide.

= 1.1.3 =

Fixes a bug that would cause Total Slider to not be functional with rich text editing turned off.

= 1.1.2 =

Adds support for the WordPress 3.5 media uploader.

= 1.1.1 =

This release is a bugfix release, with some WordPress 3.5 fixes, as well as a moderate impact security update.

= 1.1 =

This release is a significant new feature release.

**Please note:** users of custom templates should read [about the changes to custom templates](https://github.com/vanpattenmedia/total-slider/wiki/Upgrading-v1.0.x-Templates-to-v1.1) and back up their WordPress database before running the upgrade.

* Introducing multiple slide templates — use Total Slider on different parts of your site, with a unique look for each of your slide groups.
* Includes two beautiful new built-in templates, Twenty Twelve and Twenty Twelve (Alternate), which perfectly complement [WordPress’ new theme](http://wordpress.org/extend/themes/twentytwelve) for this year.
* Easily add a slider to any post or page with the shortcode. Look for the Total Slider button in the editor toolbar.
* New, more flexible support for (multiple) custom templates. Your templates can now have any type of DOM structure and this will be reflected automatically in the editor, for a fully WYSIWYG experience.
* Many minor improvements, including `E_STRICT` and `E_NOTICE` compliance, a fix for a bug where the first slide would always be blank and adoption of the `.min.js` naming standard for minified JavaScript files, ready for WordPress 3.5.

= 1.0.4 =
Fixes some potential issues with JavaScript enqueueing, and adds minified and combined JavaScript for improved site performance.

= 1.0.3 =
Adds developer-focused shortcode support, French translation (thanks Frédéric Serva) and fixed a few i18n omissions.

= 1.0.2 =
Fixes a few minor interface issues for WordPress 3.4 that did not show up in the release candidate testing.

= 1.0.1 =

Fixes a bug where Total Slider would fail to enqueue the slider JavaScript in certain circumstances.
