<?php 
if ($this -> get_option('imagesbox') == "T") 
		$imgbox = "thickbox";
	elseif ($this -> get_option('imagesbox') == "S") 
		$imgbox = "shadowbox";
	elseif ($this -> get_option('imagesbox') == "P") 
		$imgbox = "prettyphoto";
	elseif ($this -> get_option('imagesbox') == "F")
		$imgbox = "fancybox";
	elseif ($this -> get_option('imagesbox') == "N") 
		$imgbox = "nolink";
	else 
		$imgbox = "window";
?>
<?php if (!empty($slides)) : ?>
<?php $style = $this -> get_option('styles'); ?>
<script type="text/javascript">
jQuery(window).load(function() {
  if(jQuery.browser.msie && jQuery.browser.version=="6.0"){
    return;
  };
    jQuery('.ngslideshow').nivoSlider({
	effect:'<?php echo $this -> get_option('wpns_effect'); ?>',
	slices:<?php echo $this -> get_option('wpns_slices'); ?>,
	animSpeed:<?php echo $this -> get_option('fadespeed'); ?>, // Slide transition speed
        pauseTime:<?php echo $this -> get_option('autospeed'); ?>, // Interval
        startSlide:0, //Set starting Slide (0 index)
<?php if ($this -> get_option('navigation')=="Y") : ?>
	directionNav:true, //Next & Prev
<?php else : ?>
	directionNav:false,
<?php endif; ?><?php if ($this -> get_option('navhover')=="Y") : ?>
	directionNavHide:true, //Only show on hover
<?php else : ?>
	directionNavHide:false,
<?php endif; ?>
<?php if ($this -> get_option('controlnav')=="Y") : ?>
	controlNav:true, //1,2,3...
<?php else : ?>
	controlNav:false,
<?php endif; ?><?php if ($this -> get_option('thumbnails_temp') == "Y") : ?>
	controlNavThumbs:true,
        controlNavThumbsFromRel:true, //Use image rel for thumbs
        <?php else : ?>
	controlNavThumbs:false, //Use thumbnails for Control Nav
        controlNavThumbsFromRel:false, //Use image rel for thumbs
<?php endif; ?>
	controlNavThumbsSearch: '.jpg', //Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
<?php if ($this -> get_option('keyboardnav')=="Y") : ?>
	keyboardNav:true, //Use left & right arrows
	<?php else : ?>
	keyboardNav:false,
<?php endif; ?>
<?php if ($this -> get_option('pausehover')=="Y") : ?>
	pauseOnHover:true, //Stop animation while hovering
<?php else : ?>
	pauseOnHover:false,<?php endif; ?>	
<?php if ($this -> get_option('autoslide_temp')=="Y") : ?>
	manualAdvance:false, //Force manual transitions
<?php else : ?>
	manualAdvance:true,<?php endif; ?>	
        captionOpacity:<?php echo round(($this -> get_option('captionopacity')/100), 1); ?>, // Universal caption opacity
        beforeChange: function(){},
        afterChange: function(){},
        slideshowEnd: function(){}, //Triggers after all slides have been shown
        lastSlide: function(){}, //Triggers when last slide is shown
        afterLoad: function(){} //Triggers when slider has loaded
	});
});
</script>
<?php if ($frompost) : // WORDPRESS IMAGE GALLERY ONLY   ?>
<div id="ngslideshow-<?php echo get_the_ID(); ?>" class="ngslideshow">
<?php foreach ($slides as $slide) : ?><?php // echo $slide -> post_title;
$full_image_href = wp_get_attachment_image_src($slide -> ID, 'full', false);
$thumbnail_link = wp_get_attachment_image_src($slide -> ID, 'thumbnail', false);
if ( NSG_PRO ) {
	 require NSG_PLUGIN_DIR . '/pro/image_tall_frompost.php';
} else { // echo "<h4>&nbsp;</h4>";
} if ($this -> get_option('thumbnails_temp') == "Y") {
$thumbrel = 'rel="'. $thumbnail_link[0] .'" ';
} if ($this -> get_option('information_temp') == "Y") {
$captitle = 'title="#slide_caption-'. $slide -> ID .'"';
}?>
<?php if ($this -> get_option('imagesbox') != "N") : ?>
	<a href="<?php echo $full_image_href[0]; ?>" class="<?php echo $imgbox; ?>">
<?php	endif; ?>
	<img src="<?php echo $full_image_href[0]; ?>" alt="<?php // echo $this -> Html -> sanitize($slide -> post_title); ?>" <?php echo $thumbrel.$captitle; ?> />
<?php if ($this -> get_option('imagesbox') != "N") : ?>
	</a>
<?php endif; ?>
<?php endforeach; ?>
</div>
<?php if ($this -> get_option('information_temp') == "Y") : ?>
<?php foreach ($slides as $slide) : ?>
<div id="slide_caption-<?php echo ($slide -> ID); ?>" class="nivo-html-caption">
	<a href="<?php echo get_permalink($slide -> ID); ?>" title="<?php echo $slide -> post_title; ?>"><?php echo $slide -> post_title; ?></a>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?php else : // CUSTOM SLIDES - MANAGE SLIDES ONLY  ?>
<div id="ngslideshow-<?php echo get_the_ID(); ?>" class="ngslideshow">
<?php foreach ($slides as $slide) : ?>
<?php // echo $slide -> title;
if ( NSG_PRO ) {
	 require NSG_PLUGIN_DIR . '/pro/image_tall_custom.php';
} else { // echo "<h4>&nbsp;</h4>";
} if ($this -> get_option('thumbnails_temp') == "Y") {
$thumbrel = 'rel="'. $this -> Html -> image_url($this -> Html -> thumbname($slide -> image)) .'"';
} if ($this -> get_option('information_temp') == "Y") {
$captitle = 'title="#slide_caption-'. $slide -> ID .'"';
}?>
<?php if ($slide -> uselink == "Y" && !empty($slide -> link)) : ?>
	<a href="<?php echo $slide -> link; ?>" title="<?php echo $slide -> title; ?>">
<?php else : ?>
	<a href="<?php echo $this -> Html -> image_url($slide -> image); ?>" title="<?php echo $slide -> title; ?>">
<?php endif; ?>
	<img src="<?php echo NSG_UPLOAD_URL ?>/<?php echo $slide -> image; ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" title="#slide_caption-<?php echo ($slide -> ID); ?>" <?php echo $thumbrel.$captitle; ?> />
	</a>
<?php endforeach; ?>
</div>
<?php foreach ($slides as $slide) : ?>
<div id="slide_caption-<?php echo ($slide -> ID); ?>" class="nivo-html-caption"><?php echo $slide -> description; ?></div>
<?php endforeach; ?>
<?php endif; ?>
<?php endif; ?>