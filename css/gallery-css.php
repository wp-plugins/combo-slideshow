<?php header("Content-Type: text/css"); ?>
<?php $styles = array(); ?>
<?php 
foreach ($_GET as $skey => $sval) :
	$styles[$skey] = urldecode($sval);
endforeach;
if (isset($styles['width_temp'])) {
	$styles['width'] = $styles['width_temp'];
}
IF (isset($styles['height_temp'])) {
	$styles['height'] = $styles['height_temp'];
}
IF (isset($styles['wpns_width_temp'])) {
	$styles['wpns_width'] = $styles['wpns_width_temp'];
}
IF (isset($styles['wpns_height_temp'])) {
	$styles['wpns_height'] = $styles['wpns_height_temp'];
}
$navimg = "../images/arrows.png";
$controlimg = "../images/bullets.png";
IF ($styles['navbuttons'] == '0') { $navimg = '../images/arrows.png'; }
ELSEIF ($styles['navbuttons'] == 'default') { $navimg = 'default/arrows.png'; }
ELSEIF ($styles['navbuttons'] == 'orman') { $navimg = 'orman/arrows.png';  }
ELSEIF ($styles['navbuttons'] == 'pascal') { $navimg = 'pascal/arrows.png'; }
ELSEIF ($styles['navbuttons'] == 'custom') { $navimg = get_stylesheet_directory_uri().'/'.$styles['customnav'].'/arrows.png'; }
IF ($styles['navbullets'] == '0') { $controlimg = "../images/bullets.png"; }
ELSEIF ($styles['navbullets'] == 'default') { $controlimg = "default/bullets.png"; }
ELSEIF ($styles['navbullets'] == 'orman') { $controlimg = "orman/bullets.png"; }
ELSEIF ($styles['navbullets'] == 'pascal') { $controlimg = "pascal/bullets.png"; }
ELSEIF ($styles['navbullets'] == 'custom') { $controlimg = get_stylesheet_directory_uri().'/'.$styles['custombul'].'/bullets.png'; }
/*
	      if($params['frompost'] == true || is_single()){
		    $combo_id = get_the_ID();
		    $args = array(
			'post_type' => 'attachment',
			'numberposts' => $featured_num,
			'post_status' => null,
			'post_parent' => $combo_id,
			'post_mime_type' => 'image'
		);
		$attachments = get_posts($args);
		if ($attachments) {
		    foreach ($attachments as $attachment) {
			$att_info = wp_get_attachment_image_src( $attachment->ID, 'comboslide' );
			$img_width[] = $att_info[1];
			$img_height[] = $att_info[2];
		    }
		    $styles['width'] = $styles['wpns_width'] = min($img_width);
		    $styles['height'] = $styles['wpns_height'] = min($img_height);
		}
	      }
*/
?>
.ngslideshow {
	/* -moz-box-shadow:0 0 10px #333333; */
	background:url("<?php echo "../images/loading.gif"; ?>") no-repeat scroll 50% 50% <?php echo $styles['background']; ?>;
	width:<?php echo ((int) $styles['width']);?>px; /* Change this to your images width */
    height:<?php echo ((int) $styles['height'] );?>px; /* Change this to your images height */
	margin: 0 auto;
	overflow: hidden;
text-align:center;
}
.ngslideshow img {
	/* position:absolute; */
	top:0px;
	left:0px;
<?php if (!empty($styles['resizeimages']) && $styles['resizeimages'] == "Y") : ?>
width:<?php echo ((int) $styles['wpns_width']);?>px;
<?php else: ?>
width:100%;
<?php endif; ?>
<?php if (!empty($styles['resizeimages2']) && $styles['resizeimages2'] == "Y") : ?>
height:<?php echo ((int) $styles['wpns_height']);?>px;
<?php endif; ?> 
	left:-<?php echo ((int) $styles['width']);?>px;
	/* visibility:hidden; */
	display:none;
}
.ngslideshow a {
	//position:absolute;
	//top:0px;
	//left:0px;
	border:0 none;
	display:block;
}
/* The Nivo Slider styles */
.nivoSlider {
	position:relative;
}
.nivoSlider img {
	position: absolute;
	top:0px;
	left:0px;
	width:100%;
}
.nivoSlider div img {
	position:relative;
	top:0px;
	left:0px;
	display:block;
	visibility:visible;
	max-width: none;
}
.nivo-main-image {
	display: block !important;
	position: relative !important; 
	width: 100% !important;
}
/* If an image is wrapped in a link */
.nivoSlider a.nivo-imageLink {
	position:absolute;
	top:0px;
	/* left:-<?php echo ((int) $styles['width']);?>px; */
	left: 0px;
	width:100%;
	height:100%;
	border:0;
	padding:0;
	margin:0;
	z-index:6;
	/* visibility:hidden; */
	overflow:hidden;
	display:none;
}
.nivoSlider a.nivo-imageLink img {

}
/* The slices and boxes in the Slider */
.nivo-slice {
	display:block;
	position:absolute;
	margin:0 auto;
	z-index:5;
	height:100%;
}
.nivo-box {
	display:block;
	position:absolute;
	z-index:5;
}
/* Caption styles */
.nivo-caption {
	position:absolute;
	left:0px;
	/* bottom:0px; */
	margin-top: <?php echo ((int)$styles['offsetcap']);?>px;
	background:<?php echo $styles['infobackground']; ?>;
	color:<?php echo $styles['infocolor']; ?>;
	opacity:0.8; /* Overridden by captionOpacity setting */
	width:100%;
	z-index:8;
	text-align:left;
}
.nivo-caption p {
	padding:5px;
	margin:0;
}
.nivo-caption a {
	display:inline !important;
}
.nivo-html-caption {
    display:none;
}
/* Direction nav styles (e.g. Next & Prev) */
.nivo-directionNav a {
	position:absolute;
	top:<?php echo (((int)($styles['height'])-60)/2);?>px;;
	z-index:9;
	cursor:pointer;
}
.nivo-prevNav {
	left:0px;
}
.nivo-nextNav {
	right:0px;
}

<?php if (isset($styles['thumbs']) && $styles['thumbs'] == "Y") : ?>
.ngslideshow .nivo-controlNav, .nivo-controlNav {
	position:relative;
	//margin: 0 auto;
	bottom: 0;
	margin-top: <?php echo ((int)$styles['offsetnav']);?>px;
	//top:<?php echo ((int) (10 + $styles['height']) );?>px; /* Put the nav below the slider */
	text-align:center;
	background-color: <?php echo $styles['background']; ?>;
}
.ngslideshow .nivo-controlNav img, .nivo-controlNav img  {
	display:inline; /* Unhide the thumbnails */
	position:relative;
	margin-right:6px;
	height: auto;
	width: auto;
}
.nivo-controlNav a.active img {
	border: 2px solid #000;
}
.ngslideshow .nivo-controlNav a, .nivo-controlNav a {
<?php if (empty($styles['controlnumbers']) || $styles['controlnumbers'] == "N") : ?>
	font-size: 0;
	line-height: 0;
	text-indent:-9999px;
<?php endif; ?>
	display:inline;
}
<?php else : ?>
.ngslideshow .nivo-controlNav, .nivo-controlNav {
	bottom: 0;
	margin-top: <?php echo ((int)$styles['offsetnav']);?>px;
	/* top:<?php echo ((int) (10 + $styles['height']) );?>px; */
	position:relative;
	text-align:center;
}
.ngslideshow .nivo-controlNav a, .nivo-controlNav a {
<?php if (empty($styles['controlnumbers']) || $styles['controlnumbers'] == "N") : ?>
	background:url("<?php echo($controlimg); ?>") no-repeat scroll 0 0 transparent;
	font-size: 0;
	line-height: 0;
	text-indent:-9999px;
<?php endif; ?>
	border:0 none;
	height:10px;
	margin-right:3px;
	/* text-indent:-9999px; */
	width:10px;
	// display:inline;
	// float:left;
display:inline-block;
}
<?php	endif; ?>

.nivo-controlNav a.active {
	background-position:-10px 0;
}
.nivo-controlNav a {
	cursor:pointer;
	position:relative;
	z-index:9;
}
.nivo-controlNav a.active {
	font-weight:bold;
}
.nivo-directionNav a {
	background:url("<?php echo($navimg); ?>") no-repeat scroll 0 0 transparent;
	border:0 none;
	display:block;
	height:60px;
	text-indent:-9999px;
	width:32px;
}
a.nivo-nextNav {
	background-position:-32px 0;
	right:10px;
}
a.nivo-prevNav {
	left:10px;
}