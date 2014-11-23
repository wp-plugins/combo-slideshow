<?php if (!empty($slides)) : ?>
<?php 	if($params['custom'] == false && $custom == false){
		$combo_id = get_the_ID();		
	} else {
		$combo_id = 'custom';
		if(is_numeric($params['custom']))
			$combo_id .= $params['custom'];
		elseif(is_numeric($custom))
			$combo_id .= $custom;
	}
	
	$general = $this -> get_option('general');
	$slideopts	= $this -> get_option('slides');
	$styles	= $this -> get_option('styles');
	$links = $this -> get_option('links');
	
	if ($links['imagesbox_temp'] == "T") 
		$imgbox = "thickbox";
	elseif ($links['imagesbox_temp'] == "S") 
		$imgbox = "shadowbox";
	elseif ($links['imagesbox_temp'] == "P") 
		$imgbox = "prettyphoto";
	elseif ($links['imagesbox_temp'] == "L") 
		$imgbox = "lightbox";
	elseif ($links['imagesbox_temp'] == "F")
		$imgbox = "fancybox";
	elseif ($links['imagesbox_temp'] == "M")
		$imgbox = "multibox";
	elseif ($links['imagesbox_temp'] == "custom")
		$imgbox = $links['custombox'];
	elseif ($links['imagesbox_temp'] == "N") 
		$imgbox = "nolink";
	else 
		$imgbox = "window";

	$jsframe = $general['jsframe'];
	$wpns_effect = $slideopts['wpns_effect'];
	$wpns_slices = $slideopts['wpns_slices'];
	$fadespeed = $slideopts['fadespeed'];
	$autospeed = $slideopts['autospeed'];
	$navigation = $slideopts['navigation'];

	$navhover = $slideopts['navhover'];
	$controlnav = $slideopts['controlnav'];
	$thumbnails_temp = $slideopts['thumbnails_temp'];

	$keyboardnav = $slideopts['keyboardnav'];
	$pausehover = $slideopts['pausehover'];
	$autoslide_temp = $slideopts['autoslide_temp'];
	$captionopacity = $slideopts['captionopacity'];

	$information_temp = $slideopts['information_temp'];
	$csstransform = $slideopts['csstransform'];
	$wprfss_effect = $slideopts['wprfss_effect'];
	$wprfss_cssfx = $slideopts['wprfss_cssfx'];
	$wprfss_tips = $slideopts['wprfss_tips'];
	$slide_theme = $general['slide_theme'];

	if(empty($size))
		$size = $params['size'];
	if(empty($size))
		$size = 'comboslide';
	$totalwidth = (count($slides) * (get_option( 'thumbnail_size_w' ) + 10) + 2);
	$additional_style = '<style type="text/css">';
	if(empty($width))
		$width 	= $params['width'];
	if(empty($height))
		$height = $params['height'];
	if(!empty($width) || !empty($height)){
		$additional_style .= '
			#ngslideshow-'.$combo_id.' {';
	if(!empty($width))
		$additional_style .= '
			width:'.$width.'px;';
	if(!empty($height))
		$additional_style .= '
			height:'.$height.'px;';
		$additional_style .= '
			margin: 0 auto;
			overflow: hidden;
		  }';
	}
	if(empty($width))
		$width 	= $styles['width'];
	if(empty($height))
		$height = $styles['height'];

	if ((!empty($styles['resizeimages']) && $styles['resizeimages'] == "Y") || (!empty($styles['resizeimages2']) && $styles['resizeimages2'] == "Y")){
	}
	if (!empty($styles['resizeimages']) && $styles['resizeimages'] == "Y")
		  $additional_style .= '
		  #ngslideshow-'.$combo_id.' img { width:'.$width.'px;} ';
	if (!empty($styles['resizeimages2']) && $styles['resizeimages2'] == "Y")
		  $additional_style .= '
		  #ngslideshow-'.$combo_id.' img { height:'.$height.'px;} ';
	if (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y")
		  $additional_style .= '
		  #ngslideshow-'.$combo_id.' .nivo-controlNav { width:'.$width.'px;} ';
	if ($thumbnails_temp == "Y"){
		$additional_style .= '
			#ngslideshow-'.$combo_id.' .nivo-controlNav, .nivo-controlNav {
			position: relative;
			//margin: 0 auto;
			//bottom: '.(int)$styles['offsetnav'].'px;
			top:'.$height.'px;
			text-align:center;
			float:left;
			}
			#ngslideshow-'.$combo_id.'.controlnav-thumbs .nivo-controlNav .nivo-controlNavScroll{ width:'.$totalwidth.'px; position:relative; margin:0 auto;}
			#ngslideshow-'.$combo_id.' .nivo-controlNav img, .nivo-controlNav img  {
				display:inline; /* Unhide the thumbnails */
				position:relative;
				margin-right:6px;
				height: auto;
				width: auto;
			}
			#ngslideshow-'.$combo_id.' .nivo-controlNav a.active img {
				border: 2px solid #000;
			}
			#ngslideshow-'.$combo_id.' .nivo-controlNav a, .nivo-controlNav a {';
		if (empty($styles['controlnumbers']) || $styles['controlnumbers'] == "N")
				$additional_style .= '
				font-size: 0;
				line-height: 0;
				text-indent:-9999px;';
		$additional_style .= '
				display:inline;
				margin-right:0;
			  }';
	}
	if($additional_style != '<style type="text/css">')
		echo $additional_style.'</style>';
	echo '<!--[if lte IE 7]>
		<style type="text/css">
		.nivo-directionNav{ width:100%; }
		a.nivo-prevNav{ float:left; }
		a.nivo-nextNav{ float:right; }
		</style>
		<![endif]-->';

?>
	<?php if($slide_theme != '0') : ?>
		<?php $use_themes = $slide_theme; ?>
		<div class="slider-wrapper theme-<?php echo $use_themes; ?>">
			<div class="ribbon"></div>
	<?php else : ?>
		<div class="slider-wrapper">
	<?php endif; ?>
	<?php if ($jsframe == 'jquery') : ?>
		<script type="text/javascript">
			jQuery(window).load(function() {
				// jQuery('.ngslideshow').nivoSlider({
				 jQuery('#ngslideshow-<?php echo $combo_id; ?>').nivoSlider({
					effect:'<?php echo $wpns_effect; ?>',
					slices:<?php echo $wpns_slices; ?>,
					animSpeed:<?php echo $fadespeed; ?>, // Slide transition speed
					pauseTime:<?php echo $autospeed; ?>, // Interval
					startSlide:0, //Set starting Slide (0 index)
				<?php if ($navigation=="Y") : ?>
					directionNav:true, //Next & Prev
				<?php else : ?>
					directionNav:false,
				<?php endif; ?>
				<?php if ($navhover=="Y") : ?>
					//ex directionNavHide:true, Only show on hover
					afterLoad: function(){
									// return the useful on-hover display of nav arrows
									jQuery(".nivo-directionNav", jQuery("#ngslideshow-<?php echo $combo_id; ?>")).hide();
									jQuery("#ngslideshow-<?php echo $combo_id; ?>").hover(function(){ jQuery(".nivo-directionNav", jQuery(this)).fadeIn(200); }, function(){ jQuery(".nivo-directionNav", jQuery(this)).fadeOut(200); });
									},
				<?php else : ?>
					//ex directionNavHide:false,
					afterLoad: function(){}, //Triggers when slider has loaded
				<?php endif; ?>
				<?php if ($controlnav=="Y" || $thumbnails_temp == "Y") : ?>
					controlNav:true, //1,2,3...
				<?php else : ?>
					controlNav:false,
				<?php endif; ?>
				<?php if ($thumbnails_temp == "Y") : ?>
					controlNavThumbs:true,
					controlNavThumbsFromRel:true, //Use image rel for thumbs
					controlNavThumbsScroll:true,
				<?php else : ?>
					controlNavThumbs:false, //Use thumbnails for Control Nav
					controlNavThumbsFromRel:false, //Use image rel for thumbs
				<?php endif; ?>
					controlNavThumbsSearch: '.jpg', //Replace this with...
					controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
				<?php if ($keyboardnav=="Y") : ?>
					keyboardNav:true, //Use left & right arrows
				<?php else : ?>
					keyboardNav:false,
				<?php endif; ?>
				<?php if ($pausehover=="Y") : ?>
					pauseOnHover:true, //Stop animation while hovering
				<?php else : ?>
					pauseOnHover:false,
				<?php endif; ?>	
				<?php if ($autoslide_temp=="Y") : ?>
					manualAdvance:false, //Force manual transitions
				<?php else : ?>
					manualAdvance:true,
				<?php endif; ?>	
					captionOpacity:<?php echo round(($captionopacity/100), 1); ?>, // Universal caption opacity
					beforeChange: function(){},
					afterChange: function(){},
					slideshowEnd: function(){}, //Triggers after all slides have been shown
					lastSlide: function(){}, //Triggers when last slide is shown
				});
				<?php if (isset($params['frompost']) && $params['frompost'] == true && $attachments) : ?>
					jQuery('#ngslideshow-<?php echo $combo_id; ?>').width(<?php echo $width; ?>);
				<?php endif; ?>

				<?php if ($thumbnails_temp == "Y") : ?>
					jQuery('#ngslideshow-<?php echo $combo_id; ?>').addClass('controlnav-thumbs');
					jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNav').css('overflow-x','hidden');
					var thumbcw<?php echo $combo_id; ?> = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').width();
					//var thumbtw<?php echo $combo_id; ?> = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.nivo-control img').width();
					//var margin<?php echo $combo_id; ?> = parseInt(jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.nivo-control img').css('margin-right').replace('px',''));
				    if(thumbcw<?php echo $combo_id; ?>><?php echo $width; ?>) {
					jQuery.fn.loopMove = function(direction, props, dur, eas){
					    if( this.data('loop') == true ){
						//if((parseInt(jQuery(this).css('left').replace('px',''))>-thumbcw<?php echo $combo_id; ?>+thumbtw<?php echo $combo_id; ?>+margin<?php echo $combo_id; ?> && direction == true) || (direction == false && parseInt(jQuery(this).css('left').replace('px',''))<=0))
						if((parseInt(jQuery(this).css('left').replace('px',''))>-thumbcw<?php echo $combo_id; ?>+<?php echo $width; ?> && direction == true) || (direction == false && parseInt(jQuery(this).css('left').replace('px',''))<=0))
							jQuery(this).animate( props, dur, eas, function(){
						           if( jQuery(this).data('loop') == true ) jQuery(this).loopMove(direction, props, dur, eas);
							});
					    }
					    return this; // Don't break the chain
					}
					jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-directionNav a.nivo-nextNav').hover(function() {
						if(parseInt(jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').css('left').replace('px',''))>-thumbcw<?php echo $combo_id; ?>+<?php echo $width; ?> )
								jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').data('loop', true).stop().loopMove(true, {left: '-=5px'}, 10);
					     }, function() {
						jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').data('loop', false).stop();
					});
					jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-directionNav a.nivo-prevNav').hover(function() {
						if(parseInt(jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').css('left').replace('px',''))<=0)
								jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').data('loop', true).stop().loopMove(false, { left: '+=5px'}, 10);
					     }, function() {
						jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').data('loop', false).stop();
					});
					
					jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-directionNav a').click(function() {
						jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').stop();
						var thumbOffset<?php echo $combo_id; ?> = thumbcw<?php echo $combo_id; ?>-<?php echo $width; ?>;
						var currentPos<?php echo $combo_id; ?> = parseInt(jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').css('left').replace('px',''));
						//var thumbSingle = (jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.nivo-control img').width() + parseInt(jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.nivo-control img').css('margin-right').replace('px','')));
						//if(jQuery(this).hasClass('.nivo-nextNav')) active<?php echo $combo_id; ?> += thumbSingle;
						//else if(jQuery(this).hasClass('.nivo-prevNav')) active<?php echo $combo_id; ?> -= thumbSingle;
						var next = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.active').next();
						var prev = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.active').prev();
						if(jQuery(this).hasClass('nivo-nextNav')){
							if(jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.active').next().length != 0)
								var active<?php echo $combo_id; ?> = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.active').next().position().left;
							else
								var active<?php echo $combo_id; ?> = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a').first().position().left;

						}else if(jQuery(this).hasClass('nivo-prevNav')){
							if(jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.active').prev().length != 0)
								var active<?php echo $combo_id; ?> = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a.active').prev().position().left;
							else
								var active<?php echo $combo_id; ?> = jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll a').last().position().left;

						}
						if(active<?php echo $combo_id; ?> < thumbOffset<?php echo $combo_id; ?>){
							jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').animate({
								left: - active<?php echo $combo_id; ?>
							}, 2*(Math.abs(currentPos<?php echo $combo_id; ?>-active<?php echo $combo_id; ?>)));
						}else {
							jQuery('#ngslideshow-<?php echo $combo_id; ?> .nivo-controlNavScroll').animate({
								left: - thumbOffset<?php echo $combo_id; ?>
							}, 2*(Math.abs(currentPos<?php echo $combo_id; ?>-thumbOffset<?php echo $combo_id; ?>)));
						}
					});
				      }
				<?php endif; ?>
				<?php if ($combo_id == "custom") : ?>
					jQuery('#ngslideshow-<?php echo $combo_id; ?> a.nivo-imageLink').each(function(){
						if (this.href.indexOf(location.hostname) == -1){
							jQuery(this).addClass('external').attr({ 'rel':'external' }).click(function(e){
								e.preventDefault();
								window.open(this.href);
							});
						}
					});
				<?php endif; ?>
			});
		</script>
	<?php elseif ($jsframe == 'mootools') : ?>
		<script type="text/javascript">
		    document.addEvent('domready', function(){
			<?php if ($controlnav=="Y" || $thumbnails_temp=="Y" ) : ?>
				var navItems = $('ngslideshow-<?php echo $combo_id; ?>').getElements('.nivo-controlNav a.nivo-control');
	//alert(navItems[0].get('title'));
				var navMenu = $('ngslideshow-<?php echo $combo_id; ?>').getElement('div.nivo-controlNav');
				navMenu.inject($('ngslideshow-<?php echo $combo_id; ?>'),'after');
				//navMenu.addClass('ngslideshow');
				//navMenu.setStyle('margin-top','-'+$('ngslideshow-<?php echo $combo_id; ?>').getSize().y+'px');
				//navMenu.setStyle('top','10px');
				navMenu.setStyle('bottom',0);
				navItems[0].addClass('active');
			<?php endif; ?>
			$('ngslideshow-<?php echo $combo_id; ?>').addClass('nivoSlider');
			$('ngslideshow-<?php echo $combo_id; ?>').setStyle('overflow','hidden');
			$$('.slider-wrapper .nivoSlider img').setStyle('display','block');
			$('ngslideshow-<?php echo $combo_id; ?>').getParent().setStyle('position','relative');
			<?php if ($navigation=="Y") : ?>
				var directionNav = $('ngslideshow-<?php echo $combo_id; ?>').getElement('div.nivo-directionNav');
				directionNav.inject($('ngslideshow-<?php echo $combo_id; ?>'),'after').setStyle('display','none').getElements().setStyles({display:'block', 'z-index':9});
				<?php if ($navhover=="Y") : ?>
					directionNav.setStyle('display','none');
					$('ngslideshow-<?php echo $combo_id; ?>').getParent().addEvents({
						mouseover: function(){
						this.getElements('div.nivo-directionNav').setStyle('display','block');
					<?php if ($pausehover=="Y") : ?>
						comboSlideShow.pause();
					<?php endif; ?>
						},
						mouseout: function(){
						this.getParent().getElements('div.nivo-directionNav').setStyle('display','none');
					<?php if ($pausehover=="Y") : ?>
						comboSlideShow.play();
					<?php endif; ?>
						}
					});
				<?php else: ?>
					directionNav.setStyle('display','block');
					<?php if ($pausehover=="Y") : ?>
						comboSlideShow.play();
						$('ngslideshow-<?php echo $combo_id; ?>').getParent().addEvents({
							mouseover: function(){
							comboSlideShow.pause();
							},
							mouseout: function(){
							comboSlideShow.play();
							}
						});
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($information_temp == "Y") : ?>
			//var capWrap = new Element('div', {class: 'nivo-caption'});
			var capWrap = $('ngslideshow-<?php echo $combo_id; ?>').getElement('div.nivo-caption');
			capWrap.setStyles({ width: $('ngslideshow-<?php echo $combo_id; ?>').getSize().x,
					    display: 'block',
					    // height: '1.6em',
					    //margin: $('ngslideshow-<?php echo $combo_id; ?>').getStyle('margin'),
					    bottom: 0
				});
			capWrap.inject($('ngslideshow-<?php echo $combo_id; ?>'),'after');
			var slideCaptions = $$('div.nivo-html-caption').setStyles({display: 'block',
									opacity: 0,
									visibility: 'hidden',
									position:'absolute',
									'z-index': 9,
									top:0,
									left:0,
									width: $('ngslideshow-<?php echo $combo_id; ?>').getSize().x
									// width: '<?php echo $width;?>px'
									});
			slideCaptions.inject(capWrap,'inside');
			slideCaptions[0].fade('in');
			//capWrap.wraps(slideCaptions);
			<?php elseif ($information_temp == "N") : ?>
			var slideCaptions = $$('div.nivo-html-caption').setStyle('display','none');
			<?php endif; ?>
/*
		var capFade = new Fx.Tween(el, {
			link: 'chain',
			duration: <?php echo $fadespeed; ?> // Interval
		});
*/
			var slideItems = $('ngslideshow-<?php echo $combo_id; ?>').getElements('a').setStyle('position','absolute');
			var comboSlideShow = new SlideShow($('ngslideshow-<?php echo $combo_id; ?>'),  {
			<?php if ($csstransform!="Y") : ?>
				transition:  '<?php echo $wprfss_effect; ?>',
			<?php else : ?>
				transition:  '<?php echo $wprfss_cssfx; ?>',
			<?php endif; ?>
				delay: <?php echo $autospeed; ?>, // Slide transition speed
				duration: <?php echo $fadespeed; ?>, // Interval
			<?php if ($autoslide_temp=="Y") : ?>
				autoplay: true, //Force manual transitions
			<?php else : ?>
				autoplay: false,
			<?php endif; ?>
				initialSlideIndex:0,
				/*
				onShow: function(){},
				onShowComplete: function(){},
				onPlay: function(){},
				onPause: function(){},
				onReverse: function(){},
				*/
			<?php if ($controlnav=="Y" || $information_temp == "Y") : ?>
				onShow: function(data){
			    <?php if ($information_temp == "Y") : ?>
//alert(slideCaptions.length);
//alert(data.next.index);
					slideCaptions[data.previous.index].removeClass('active');
					slideCaptions[data.next.index].addClass('active');
					slideCaptions[data.previous.index].fade('out');
					slideCaptions[data.next.index].fade('in');
					// hide captions except active
			    <?php endif; ?>
//alert(data.next.index);
//alert(navItems[data.previous.index].get('title'));
					// update navigation elements' class depending upon the current slide
// cycle problem => if next defined, naviItems.length - data.previous.index
// only for auto slideshow?
			    <?php if ($controlnav=="Y") : ?>
					navItems[data.previous.index].removeClass('active');
					//initial slide index

					//if (navItems[data.next.index] === undefined)
					//  navItems[(navItems.length - data.previous.index)].addClass('active');
					//else
					navItems[data.next.index].addClass('active');
			    <?php endif; ?>
				},
			<?php endif; ?>
				selector: 'a'
			});
			$('ngslideshow-<?php echo $combo_id; ?>').setStyle('background-image','none');
			<?php if ($csstransform=="Y") : ?>
			      //if (Modernizr.csstransitions && Modernizr.csstransforms){
				      comboSlideShow.useCSS();
			      //}
			<?php endif; ?>
			<?php if ($navigation=="Y") : ?>
				directionNav.getElement('.nivo-prevNav').addEvent('click', function(event){
					event.stop();
					comboSlideShow.show('previous');
				});
				directionNav.getElement('.nivo-nextNav').addEvent('click', function(event){
					event.stop();
					comboSlideShow.show('next');
				});
			<?php endif; ?>

		<?php if ($controlnav=="Y") : ?>

			navItems.each(function(item, index){
			<?php if ($styles['controlnumbers']=="Y") : ?>
				item.set('text',index+1);
				item.set('rel',index+1);
			<?php endif; ?>
				// click a nav item ...
				item.addEvent('click', function(event){
				    event.stop();
				    // pushLeft or pushRight, depending upon where
				    // the slideshow already is, and where it's going
				    var transition = (comboSlideShow.index < index) ? 'pushLeft' : 'pushRight';
				    // call show method, index of the navigation element matches the slide index
				    // on-the-fly transition option
				    comboSlideShow.show(index, {transition: transition});
				});
			});
		    <?php if ($wprfss_tips=="Y") : ?>
			new Tips(navItems, {
				fixed: true,
				text: '',
				offset: {
					x: -100,
					y: 20
				}
			});
		    <?php endif; ?>
		<?php endif; ?>
		    });
		</script>
	<?php endif; // END MOOTOOLS ?>
		<div id="ngslideshow-<?php echo $combo_id; ?>" class="ngslideshow">
			<?php foreach ($slides as $slide) : ?>
				<?php
				//echo '<pre>'; print_r($slide); echo '</pre>';
				if(!is_object($slide))
					echo 'stocazzo'.$slide;
				$full_image_href = wp_get_attachment_image_src($slide -> ID, $size, false);
				$full_slide_href = wp_get_attachment_image_src($slide -> ID, 'full', false);
				$thumbnail_link = wp_get_attachment_image_src($slide -> ID, 'thumbnail', false);
				if ( CMBSLD_PRO ) {
					require CMBSLD_PLUGIN_DIR . '/pro/image_tall_frompost.php';
				} else {
					// echo "<h4>&nbsp;</h4>";
				} 
				if ($thumbnails_temp == "Y") {
					$thumbrel = 'rel="'. $thumbnail_link[0] .'" ';
				} else
					$thumbrel = '';
				if ($information_temp == "Y") {
					$captitle = 'title="slide_caption-'. $slide -> ID .'"';
				} else
					$captitle = '';
				$resize = '';
				if ($jsframe == 'jquery'){
				    if( !empty($styles['resizeimages']) && $styles['resizeimages'] == "Y") {
					$resize .= ' width="'. $styles['wpns_width'] .'"';
				    }
				    if( !empty($styles['resizeimages2']) && $styles['resizeimages2'] == "Y") {
					$resize .= ' height="'. $styles['wpns_height'] .'"';
				    }
				}
				?>
				<?php if ($imgbox != "nolink") : ?>
					<?php if ($params['custom'] == false && $custom == false) : ?>
						<a href="<?php echo $full_slide_href[0]; ?>" class="<?php echo $imgbox; ?>">
					<?php else: ?>
						<a href="<?php echo get_post_meta($slide -> ID, '_comboslide_link', true); //echo get_attachment_link($slide -> ID); ?>">
					<?php endif; ?>
				<?php endif; ?>
						<img id="slide-<?php echo $slide -> ID; ?>" src="<?php echo $full_image_href[0]; ?>" alt="<?php echo sanitize_title($slide -> post_title); ?>" <?php echo $thumbrel.$captitle; ?> />
				<?php if ($imgbox != "nolink") : ?>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if ($jsframe == 'mootools' && $information_temp == "Y") : ?>
				<div class="nivo-caption" style="opacity:<?php round(($captionopacity/100), 1) ?>;">
				</div>
			<?php endif; ?>
			<?php if ($jsframe == 'mootools' && $navigation == "Y") : ?>
				<div class='nivo-directionNav' style='display:none'>
					    <a class='nivo-prevNav'><?php _e('Prev', $this -> plugin_name); ?></a>
					    <a class='nivo-nextNav'><?php _e('Next', $this -> plugin_name); ?></a>
				</div>
			<?php endif; ?>
			<?php if ($jsframe == 'mootools' && ($controlnav == "Y" || $thumbnails_temp == "Y")) : ?>
					<div class="nivo-controlNav">
				<?php foreach ($slides as $index => $slide) : ?>
						<a class="nivo-control" href="#slide-<?php echo $slide -> ID; ?>" title="<?php echo sanitize_title($slide -> post_title) ?>">
						<?php if ($thumbnails_temp == "Y") : ?>
						      <?php $thumbnail_link = wp_get_attachment_image_src($slide -> ID, 'thumbnail', false); ?>
						      <img src="<?php echo $thumbnail_link[0]; ?>" alt="slideshow-thumbnail-<?php echo $index+1; ?>" />
						<?php else : ?>
						      <?php echo $index+1; ?>
						<?php endif; ?></a>
				<?php endforeach; ?>
					</div>
			<?php endif; ?>
				</div>
			<?php if ($information_temp == "Y") : ?>
			    <?php foreach ($slides as $slide) : ?>
				<div id="slide_caption-<?php echo ($slide -> ID); ?>" class="nivo-html-caption">
					<a href="<?php echo get_permalink($slide -> ID); ?>" title="<?php echo sanitize_title($slide -> post_title); ?>"><?php echo sanitize_title($slide -> post_title); ?></a>
				</div>
			    <?php endforeach; ?>
			<?php endif; ?>
			</div>
<?php endif; // END SLIDES?>