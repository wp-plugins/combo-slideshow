=== Combo Slideshow ===
Contributors: 3dolab
Donate link: http://www.3dolab.net/en/combo-slideshow
Tags: slideshow, slide show, combo, slideshow gallery, slides, image, gallery, content, highlight, showcase, javascript, jquery, mootools, nivo, nivo slider
Requires at least: 2.8
Tested up to: 3.1.3
Stable tag: 1.0.0
Combo Slideshow is a mash-up plugin that showcases the features of the best slideshow javascript and WordPress plugins.
Blog posts highlights, image gallery, custom slideshows!


== Description ==

Combo Slideshow is a photo and image viewing mash-up plugin that integrates the features of the best javascript slideshow effects and WordPress plugins available on the net.
It works natively in conjunction with the WordPress image upload and gallery system, through the javascript frameworks JQuery or MooTools.

= Enjoy: = 
* Full control over speed, transition and navigation options
* Nivo Slider slideshow themes supported, 3 preset available
* Custom CSS supported
* Lightbox, FancyBox, MultiBox and custom class names supported
* Navigation Arrows (jQuery) and Tips (MooTools)
* Auto insertion of latest posts (category-based) slideshow in home or single page/post
* Custom slides management
* Page/Post gallery shortcode <code>[slideshow]</code> (with optional <code>post_id</code>, <code>exclude</code>, <code>exclude</code>, and <code>auto</code>  parameters)
* Hardcode into any PHP file of a WordPress theme with <code><?php if (class_exists('Gallery')) { $Gallery = new Gallery(); $Gallery -> slideshow($output = true, $post_id = null); } ?></code> and the required <code>$post_id</code> parameter accordingly specified
* Global post slideshow: auto mode in Homepage and/or Posts + manual function show_combo_slider($category, $postlimit, $exclude, $offset)

Administration and Settings are heavily borrowed from the Slideshow Gallery Pro plugin (free version) by Cameron Preston and WP Nivo Slider by Rafael Cirolini.
The selectable front-end effect scripts are the Nivo Slider plugin (on jQuery framework) or SlideShow by Ryan Florence (on MooTools).

Plugin homepage: http://www.3dolab.net/en/combo-slideshow/


== Installation ==

= Manual Installation: = 
1. Extract the package to obtain the `combo-slideshow` folder
2. Upload the `combo-slideshow` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the settings according to your needs through the 'Slideshow' > 'Configuration' menu
5. Add and manage your slides in the 'Slideshow' section (Or just use the built in wordpress gallery)
6. Put `[slideshow post_id="X" exclude="" caption="on/off"]` to embed a slideshow with the images of a post into your posts/pages or use `[slideshow custom=1]` to embed a slideshow with your custom added slides or `<?php if (class_exists('Gallery')) { $Gallery = new Gallery(); $Gallery -> slideshow($output = true, $post_id = null); }; ?>` into your WordPress theme

== Frequently Asked Questions ==

= Can I display/embed multiple instances of the slideshow gallery? =
Yes, you can, but only one slideshow per page.

= How Can I auto insert a blog posts slideshow in my home or single post/page? =
Enable it in the plugin settings. Make sure that a post thumbnail is set in each post.

= What if I only want captions on some of my pages
Set your default captions to off; for any slideshow you put on your page use `[slideshow caption="on"]`

= What if my configuration isn't showing up? =
You're most likely not running PHP5. Talk to your host to upgrade or switch your hosting provider. PHP5 is eleventy years old.

= How do I find the numbers to exclude (or include)? =
Not as easy as it used to be! Go into the Media Library. Choose an image you want to exclude and click on it and notice your address bar: "/wp-admin/media.php?action=edit&attachment_id=353". Therefore, `[slideshow exclude=353]`

= My thumbnails aren't scrolling, what's up? =
Make sure you have at least 6 thumbnails for that to work properly. Otherwise thumbnails are probably not necessary.

= How do I change the color to the left and right of my images in the slideshow? =
In /views/default/gallery.php find this line: slideshow.letterbox = "#000"; Change #000 to #FFF for white, or any other hex color code.

== Screenshots ==

1. Slideshow gallery pro with thumbnails at the bottom.
2. Slideshow gallery pro with thumbnails turned OFF.
3. Slideshow gallery pro with thumbnails at the top.
4. Different styles/colors.

== Changelog ==

= 1.0.0 (2011.07.12) = 
* First Release