=== Combo Slideshow ===
Contributors: 3dolab
Donate link: http://www.3dolab.net/en/combo-slideshow
Tags: slideshow, slide show, combo, slideshow gallery, slides, image, gallery, content, highlight, showcase, javascript, jquery, mootools, nivo, nivo slider
Requires at least: 2.8
Tested up to: 4.0.1
Stable tag: 1.9
The features of the best slideshow javascript effects and WP plugins:
blog posts highlights, image galleries, custom slides and more!


== Description ==

Combo Slideshow is a photo and image viewing mash-up plugin that integrates the features of the best available javascript slideshow effects and WordPress plugins.
It works natively in conjunction with the WordPress image upload and gallery system, through the javascript frameworks JQuery or MooTools.

= Enjoy: = 
* Full control over speed, transition and navigation options
* Nivo Slider slideshow themes supported, 3 preset available
* Custom CSS supported
* Lightbox, FancyBox, MultiBox and custom class names supported
* Navigation Arrows (jQuery) and Tips (MooTools)
* Auto insertion of latest posts (category-based) slideshow in home or single page/post
* Custom slides management
* Page/Post gallery shortcode <code>[slideshow]</code> (with optional <code>post_id</code>, <code>custom</code>, <code>exclude</code>, <code>exclude</code>, and <code>auto</code>  parameters)
* Hardcode into any PHP file of a WordPress theme with <code><?php if (class_exists('CMBSLD_Gallery')) { $CMBSLD_Gallery = new CMBSLD_Gallery(); $CMBSLD_Gallery -> slideshow($output = true, $post_id, $exclude, $include, $custom, $width, $height, $thumbs, $caption, $auto, $nolink, $slug, $limit, $size); } ?></code> and the required <code>$post_id</code> or <code>$custom</code> parameters accordingly specified
* Global post slideshow: auto mode in Homepage and/or Posts + manual function show_combo_slider($category, $postlimit, $exclude, $offset, $n_slices, $size, $width, $height)

Administration and Settings have been completely renewed! 
(whereas in previous versions they were heavily borrowed from the Slideshow Gallery Pro plugin (free version) by Cameron Preston and WP Nivo Slider by Rafael Cirolini)
The selectable front-end effect scripts are the Nivo Slider plugin (on jQuery framework) or SlideShow by Ryan Florence (on MooTools).
It works great in conjunction with the [Gallery Metabox plugin](http://wordpress.org/plugins/gallery-metabox/ "Gallery Metabox plugin").

[Plugin Homepage: http://www.3dolab.net/en/combo-slideshow/](http://www.3dolab.net/en/combo-slideshow/ "Combo Slideshow @ 3dolab")

[Running Demo](http://www.3dolab.net/en/ "Combo Slideshow Running Demo")

*[banner image by batintherain](https://www.flickr.com/photos/batintherain/3261025426/)*
*[icon by fdecomite](https://www.flickr.com/photos/fdecomite/3489799838/)*

== Installation ==

= Manual Installation: = 
1. Extract the package to obtain the `combo-slideshow` folder
2. Upload the `combo-slideshow` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the settings according to your needs through the 'Slideshow' > 'Settings' menu
5. Add and manage your slides in the 'Slideshow' section (or just use the built in wordpress gallery)
6. Put the shortcode `[slideshow post_id="X" exclude="" caption="on/off"]` to embed a slideshow with the images of a post into your posts/pages or use `[slideshow custom=1]` to embed a slideshow with your custom added slides or `<?php if (class_exists('CMBSLD_Gallery')) { $CMBSLD_Gallery = new CMBSLD_Gallery(); $CMBSLD_Gallery -> slideshow($output = true, $post_id = null); }; ?>` into your WordPress theme

* Please take care when updating, due to the new slide administration system any custom slideshow created with previous versions of the plugin will not work and won't even be shown

== Other Notes ==

= [slideshow] shortcode & $CMBSLD_Gallery -> slideshow() = 
* $output (default = true): echoes the content, or just returns it if set to false
* $post_id (default = null): retrieves attached images from a particular post by id, or from the global $post object if left unspecified
* $exclude (default = null): removes the specified attachment IDs (set in a comma-separated list) from the slideshow 
* $include (default = null): removes anything but the attachment IDs (set in a comma-separated list)
* $custom (default = null): retrieves the custom images uploaded as slides, just set to whatever value but note that it does work only when $post_id and $slug are empty
* $width, $height (default = null): sets dimensions in pixels, or default values if left unspecified
* $thumbs (default = null): sets with 'on'/'off' the values for displaying thumbnails, disregarding the main setting
* $caption (default = null): overwrites with 'on'/'off' values the main setting for displaying captions
* $auto (default = null): sets with 'on'/'off' the values for the auto-slide feature, disregarding the main setting
* $nolink (default = null): overwrites with 'on'/'off' values the main setting for removing links from captions
* $slug (default = null): retrieves attached images from a particular post by slug
* $limit (default = null): limits the amount of slides loaded in the slideshow, or uses the global post limit setting
* $size (default = null): sets dimensions as in the Media Settings screen (e.g. 'thumbnail', 'medium', etc), or 'comboslide' if nothing specified even in pixels

= $CMBSLD_Gallery -> show_combo_slider() =
* $category (default = null): loads only posts from the specified category
* $n_slices (default = null): limits the amount of slides loaded in the slideshow, or uses the global post limit setting
* $exclude (default = null): removes the specified attachment IDs (set in a comma-separated list) from the slideshow 
* $offset (default = null): starts the slideshow from the nth post
* $width, $height, $size (default = null): sets dimensions in pixels or as in the Media Settings screen
* please note that, unlike in shortcodes, only the main settings are in use for the caption, links, thumbs and auto options 

== Frequently Asked Questions ==

= Can I display/embed multiple instances of the slideshow gallery? =
Yes, you can: summon each instance anywhere with the appropriate shortcode or manual function.

= How Can I auto insert a blog posts (or custom) slideshow in my home or single post/page? =
Enable it in the plugin settings and make sure that a post thumbnail is set in each post.
Auto-insertion features may not work if standard functions are not supported by the theme in use or plugins such as e-commerce, etc...

= How Can I insert a custom slideshow in my content? =
First create a new Slideshow and add images to the media gallery. Use the shortcode or the manual function with the `custom` parameter set accordingly.
Please note that images have to be uploaded from this screen, in order to be associated as "attachments" of the slideshow object / custom post type.
The Content Editor is actually useless except for the Add Media button, or if you ever like to somehow extract it (e.g. slideshow of slideshows post type). 

= What if I only want captions on some of my pages =
Set your default captions to off; for any slideshow you put on your page use `[slideshow caption="on"]`

= What if my configuration isn't showing up? =
You're most likely not running PHP5. Talk to your host to upgrade or switch your hosting provider. PHP5 is eleventy years old.

= How do I find the numbers to exclude (or include)? =
Not as easy as it used to be! Go into the Media Library. Choose an image you want to exclude and click on it and notice your address bar: "/wp-admin/media.php?action=edit&attachment_id=353". Therefore, `[slideshow exclude=353]`

= My thumbnails aren't scrolling, what's up? =
Make sure you have at least 6 thumbnails for that to work properly. Otherwise thumbnails are probably not necessary.

= How do I change the color to the left and right of my images in the slideshow? =
In /views/default/gallery.php find this line: slideshow.letterbox = "#000"; Change #000 to #FFF for white, or any other hex color code.

= How can I achieve a liquid layout? =
First of all disable the built-in width & height crop adjustment in the settings, and then simply apply the "width:100%" rule in your stylesheet using both the ".ngslideshow.nivoSlider" classes: it will override the default fixed width

== Screenshots ==

1. the slideshow in action on a default Twenty Fourteen theme
2. the Admin Settings page

== Changelog ==

= 1.9 (2014.11.22) =
* Tabbed navigation on administration settings
* Fixed compatibility issue with TinyMCE js module on WP 3.9
* Fixes to the "no theme" CSS 
* "default" theme is now really the default option
* Post Category multiple select

= 1.8 (2013.12.03) =
* Bugfix: TinyMCE button for gallery shortcodes
* Bugfix: constants and translations
* Added Italian Translation

= 1.7 (2013.06.18) =
* Updated to Nivo Slider jQuery plugin (v.3.2)
* Full renewal of the slideshow management in admin UI, database and folders
* Added new "Slideshow" post type
* Added crop thumbnails option

= 1.6 (2013.02.15) =
* Bugfix: link in custom slides

= 1.5 (2013.02.02) =
* Improved output: new parameters available ($size, $width, $height, $custom) in manual functions and shortcodes for multiple independent custom slideshow sizes
* Improved cropping / resizing of each slide
* Fixes over caption links generation, auto insert feature, include/exclude parameters
* Several bugfixes over thumbnail generation
* Scrolling thumbnails
* Changed required back-end capability from 'manage_options' to 'edit_others_posts'
* Direction/Arrow navigation controls also available within the MooTools framework
* Fixes and improvements over IE6/7 compatibility

= 1.4 (2011.09.30) =
* Bugfix: custom slideshow gallery output

= 1.3 (2011.09.30) =
* Enabled auto custom slides in homepage and single post/page
* Added auto slideshow position (before/after the content)
* Lightbox enabled for custom slides too
* Using wrapper div even if no theme is set
* Code clean up

= 1.2 (2011.08.13) = 
* Nivo Slider updated to 2.6 and YUI compressed
* Bugfix: 'title is undefined' .attr() error with jQuery 1.6+
* Bugfix: blank admin screens

= 1.1 (2011.07.28) = 
* Bugfix: invalid markup in post slideshows
* Bugfix: JavaScript errors in MSIE6/7

= 1.0 (2011.07.12) = 
* First Release