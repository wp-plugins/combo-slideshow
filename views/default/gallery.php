<?php if (!empty($slides)) : ?>
<?php 
if ($this -> get_option('imagesbox') == "T") 
		$imgbox = "thickbox";
	elseif ($this -> get_option('imagesbox') == "S") 
		$imgbox = "shadowbox";
	elseif ($this -> get_option('imagesbox') == "P") 
		$imgbox = "prettyphoto";
	elseif ($this -> get_option('imagesbox') == "L") 
		$imgbox = "lightbox";
	elseif ($this -> get_option('imagesbox') == "F")
		$imgbox = "fancybox";
	elseif ($this -> get_option('imagesbox') == "M")
		$imgbox = "multibox";
	elseif ($this -> get_option('imagesbox') == "custom")
		$imgbox = $this -> get_option('custombox');
	elseif ($this -> get_option('imagesbox') == "N") 
		$imgbox = "nolink";
	else 
		$imgbox = "window";

	      $style 		= $this -> get_option('styles'); 
	      $jsframe 		= $this -> get_option('jsframe');
	      $wpns_effect 	= $this -> get_option('wpns_effect');
	      $wpns_slices 	= $this -> get_option('wpns_slices');
	      $fadespeed 	= $this -> get_option('fadespeed');
	      $autospeed 	= $this -> get_option('autospeed');
	      $navigation 	= $this -> get_option('navigation');

	      $navhover 	= $this -> get_option('navhover');
	      $controlnav 	= $this -> get_option('controlnav');
	      $thumbnails_temp 	= $this -> get_option('thumbnails_temp');

	      $keyboardnav 	= $this -> get_option('keyboardnav');
	      $pausehover 	= $this -> get_option('pausehover');
	      $autoslide_temp 	= $this -> get_option('autoslide_temp');
	      $captionopacity 	= $this -> get_option('captionopacity');

	      $information_temp = $this -> get_option('information_temp');
	      $csstransform 	= $this -> get_option('csstransform');
	      $wprfss_effect 	= $this -> get_option('wprfss_effect');
	      $wprfss_cssfx 	= $this -> get_option('wprfss_cssfx');
	      $wprfss_tips 	= $this -> get_option('wprfss_tips');
	      $slide_theme 	= $this -> get_option('slide_theme');



?>
	<?php if ($jsframe == 'jquery') : ?>
		<script type="text/javascript">
			jQuery(window).load(function() {
				jQuery('.ngslideshow').nivoSlider({
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
					directionNavHide:true, //Only show on hover
				<?php else : ?>
					directionNavHide:false,
				<?php endif; ?>
				<?php if ($controlnav=="Y") : ?>
					controlNav:true, //1,2,3...
				<?php else : ?>
					controlNav:false,
				<?php endif; ?>
				<?php if ($thumbnails_temp == "Y") : ?>
					controlNavThumbs:true,
					controlNavThumbsFromRel:true, //Use image rel for thumbs
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
					afterLoad: function(){} //Triggers when slider has loaded
				});
			});
		</script>
	<?php elseif ($jsframe == 'mootools') : ?>
		<script type="text/javascript">
		    document.addEvent('domready', function(){
			<?php if ($controlnav=="Y" || $thumbnails_temp=="Y" ) : ?>
			var navItems = $('ngslideshow-<?php echo get_the_ID(); ?>').getElements('.nivo-controlNav a.nivo-control');
//alert(navItems[0].get('title'));
			var navMenu = $('ngslideshow-<?php echo get_the_ID(); ?>').getElement('div.nivo-controlNav');
			navMenu.inject($('ngslideshow-<?php echo get_the_ID(); ?>'),'after');
			//navMenu.addClass('ngslideshow');
			//navMenu.setStyle('margin-top','-'+$('ngslideshow-<?php echo get_the_ID(); ?>').getSize().y+'px');
			//navMenu.setStyle('top','10px');
			navMenu.setStyle('bottom',0);
			navItems[0].addClass('active');
			<?php endif; ?>
			$('ngslideshow-<?php echo get_the_ID(); ?>').addClass('nivoSlider');
			$('ngslideshow-<?php echo get_the_ID(); ?>').setStyle('overflow','hidden');
$$('.slider-wrapper .nivoSlider img').setStyle('display','block');
$('ngslideshow-<?php echo get_the_ID(); ?>').getParent().setStyle('position','relative');
			<?php if ($information_temp == "Y") : ?>
			//var capWrap = new Element('div', {class: 'nivo-caption'});
			var capWrap = $('ngslideshow-<?php echo get_the_ID(); ?>').getElement('div.nivo-caption');
			capWrap.setStyles({ width: $('ngslideshow-<?php echo get_the_ID(); ?>').getSize().x,
					    height: '1.6em',
					    margin: $('ngslideshow-<?php echo get_the_ID(); ?>').getStyle('margin'),
					    bottom: 0
				});
			capWrap.inject($('ngslideshow-<?php echo get_the_ID(); ?>'),'after');
			var slideCaptions = $$('div.nivo-html-caption').setStyles({display: 'block',
opacity: 0,
visibility: 'hidden',
position:'absolute',
'z-index': 9,
										   top:0,
										   left:0,
										   width: '<?php echo $style['width'];?>px'
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
			var slideItems = $('ngslideshow-<?php echo get_the_ID(); ?>').getElements('a').setStyle('position','absolute');
			var comboSlideShow = new SlideShow($('ngslideshow-<?php echo get_the_ID(); ?>'),  {
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
			<?php if ($csstransform=="Y") : ?>
			      //if (Modernizr.csstransitions && Modernizr.csstransforms){
				      comboSlideShow.useCSS();
			      //}
			<?php endif; ?>
		<?php if ($controlnav=="Y") : ?>

			navItems.each(function(item, index){
			<?php if ($style['controlnumbers']=="Y") : ?>
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
		<?php $use_themes = $slide_theme; ?>
		<?php if($use_themes != '0') : ?>
			<div class="slider-wrapper theme-<?php echo $use_themes; ?>">
				<div class="ribbon"></div>
		<?php endif; ?>
		<?php if ($frompost) : // WORDPRESS IMAGE GALLERY ONLY   ?>
				<div id="ngslideshow-<?php echo get_the_ID(); ?>" class="ngslideshow">
			<?php foreach ($slides as $slide) : ?>
				<?php // echo $slide -> post_title;
				$full_image_href = wp_get_attachment_image_src($slide -> ID, 'full', false);
				$thumbnail_link = wp_get_attachment_image_src($slide -> ID, 'thumbnail', false);
				if ( CMBSLD_PRO ) {
					require CMBSLD_PLUGIN_DIR . '/pro/image_tall_frompost.php';
				} else {
					// echo "<h4>&nbsp;</h4>";
				} if ($thumbnails_temp == "Y") {
					$thumbrel = 'rel="'. $thumbnail_link[0] .'" ';
				} if ($information_temp == "Y") {
					$captitle = 'title="#slide_caption-'. $slide -> ID .'"';
				}
				if ($jsframe == 'jquery'){
				    $resize = '';
				    if( !empty($style['resizeimages']) && $style['resizeimages'] == "Y") {
					$resize .= ' width="'. $styles['wpns_width'] .'"';
				    }
				    if( !empty($style['resizeimages2']) && $style['resizeimages2'] == "Y") {
					$resize .= ' height="'. $style['wpns_height'] .'"';
				    }
				}
				?>
				<?php if ($imgbox != "nolink") : ?>
					<a href="<?php echo $full_image_href[0]; ?>" class="<?php echo $imgbox; ?>">
				<?php endif; ?>
						<img id="slide-<?php echo $slide -> ID; ?>" src="<?php echo $full_image_href[0]; ?>" alt="<?php echo $this -> Html -> sanitize($slide -> post_title); ?>" <?php echo $thumbrel.$captitle; ?> />
				<?php if ($imgbox != "nolink") : ?>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if ($jsframe == 'mootools' && $information_temp == "Y") : ?>
				<div class="nivo-caption" style="opacity:<?php round(($captionopacity/100), 1) ?>;">
				</div>
			<?php endif; ?>
			<?php if ($jsframe == 'mootools' && $navigation == "Y") : ?>
			<?php endif; ?>
			<?php if ($jsframe == 'mootools' && ($controlnav == "Y" || $thumbnails_temp == "Y")) : ?>
					<div class="nivo-controlNav">
				<?php foreach ($slides as $index => $slide) : ?>
						<a class="nivo-control" href="#slide-<?php echo $slide -> ID; ?>" title="<?php echo $slide -> post_title; ?>">
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
					<a href="<?php echo get_permalink($slide -> ID); ?>" title="<?php echo $slide -> post_title; ?>"><?php echo $slide -> post_title; ?></a>
				</div>
			    <?php endforeach; ?>
			<?php endif; ?>
		<?php else : // CUSTOM SLIDES - MANAGE SLIDES ONLY  ?>
				<div id="ngslideshow-<?php echo get_the_ID(); ?>" class="ngslideshow">
			<?php foreach ($slides as $slide) : ?>
				<?php // echo $slide -> title;
				if ( CMBSLD_PRO ) {
					require CMBSLD_PLUGIN_DIR . '/pro/image_tall_custom.php';
				} else {
					// echo "<h4>&nbsp;</h4>";
				} if ($thumbnails_temp == "Y") {
					$thumbrel = 'rel="'. $this -> Html -> image_url($this -> Html -> thumbname($slide -> image)) .'"';
				} if ($information_temp == "Y") {
					$captitle = 'title="#slide_caption-'. $slide -> ID .'"';
				}
				if ($jsframe == 'jquery'){
				    $resize = '';
				    if( !empty($style['resizeimages']) && $style['resizeimages'] == "Y") {
					$resize .= ' width="'. $styles['wpns_width'] .'"';
				    }
				    if( !empty($style['resizeimages2']) && $style['resizeimages2'] == "Y") {
					$resize .= ' height="'. $style['wpns_height'] .'"';
				    }
				}
				?>
				<?php if ($slide -> uselink == "Y" && !empty($slide -> link)) : ?>
					<a href="<?php echo $slide -> link; ?>" title="<?php echo $slide -> title; ?>">
				<?php else : ?>
					<a href="<?php echo $this -> Html -> image_url($slide -> image); ?>" title="<?php echo $slide -> title; ?>">
				<?php endif; ?>
					<img id="slide-<?php echo $slide -> ID; ?>" src="<?php echo CMBSLD_UPLOAD_URL ?>/<?php echo $slide -> image; ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" <?php echo $thumbrel.$captitle.$resize; ?> />
					</a>
			<?php endforeach; ?>
			<?php if ($jsframe == 'mootools' && $information_temp == "Y") : ?>
				<div class="nivo-caption" style="opacity:<?php round(($captionopacity/100), 1) ?>;">
				</div>
			<?php endif; ?>
			<?php if ($jsframe == 'mootools' && $navigation == "Y") : ?>
			<?php endif; ?>
			<?php if ($jsframe == 'mootools' && ($controlnav == "Y" || $thumbnails_temp == "Y")) : ?>
					<div class="nivo-controlNav">
				<?php foreach ($slides as $index => $slide) : ?>
						<a class="nivo-control" href="#slide-<?php echo $slide -> ID; ?>" title="<?php echo $slide -> post_title; ?>">
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
				    <?php if ($slide -> uselink == "Y" && !empty($slide -> link)) : ?>
				      <a href="<?php echo $slide -> link; ?>" title="<?php echo $slide -> title; ?>">
				    <?php endif; ?>
				    <?php echo $slide -> description; ?>
				    <?php if ($slide -> uselink == "Y" && !empty($slide -> link)) : ?>
				      </a>
				    <?php endif; ?>
				</div>
			    <?php endforeach; ?>
			<?php endif; ?>
		<?php endif; ?>
		<?php if($use_themes != '0') : ?>
			</div>
		<?php endif; ?>
<?php endif; // END SLIDES?>