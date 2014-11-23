<?php
class CMBSLD_GalleryPlugin {
	var $version = '1.9';
	var $plugin_name;
	var $plugin_base;
	var $pre = 'Gallery';
	var $debugging = false;
	var $menus = array();
	var $sections = array(
		//'slideshow'		=>	'slideshow-slides',
		'settings'		=>	'settings',
	);
	//var $helpers = array('Db', 'Html', 'Form', 'Metabox');
	//var $models = array('Slide');
	
	function register_plugin($name, $base) {
		$this -> plugin_name = $name;
		$this -> plugin_base = rtrim(dirname($base), DS);
		//$this -> enqueue_scripts();
		$this -> initialize_options();
		$this -> initialize_adminpage();
		if (function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain( $this -> plugin_name, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			/*
			$currentlocale = get_locale();
			if(!empty($currentlocale)) {
				$moFile = dirname(__FILE__) . DS . "languages" . DS . $this -> plugin_name . "-" . $currentlocale . ".mo";				
				if(@file_exists($moFile) && is_readable($moFile)) {
					load_textdomain($this -> plugin_name, $moFile);
				}
			}
			*/
		}
		if ($this -> debugging == true) {
			global $wpdb;
			$wpdb -> show_errors();
			error_reporting(E_ALL);
			@ini_set('display_errors', 1);
		}
		$this -> add_action( 'wp_print_styles', 'cmbsld_enqueue_styles' );
		//$this -> add_action( 'wp_enqueue_styles', 'cmbsld_enqueue_styles' );
		$this -> add_action( 'init', 'register_slideshow_post_type', 0);
		$this -> add_filter('manage_edit-slideshow_columns', 'slideshow_edit_columns');
		$this -> add_action('manage_slideshow_posts_custom_colum', 'slideshow_custom_columns', 10, 2);
		//$this -> add_action( "admin_print_scripts-settings_page_YOURPAGENAME", 'enqueue_scripts' );
		$this -> add_action( "admin_enqueue_scripts", 'enqueue_scripts' );
		$this -> add_action( "wp_enqueue_scripts", 'enqueue_scripts' );
		//$this -> add_filter('post_updated_messages', array(&$this, 'updated_messages'));
		return true;
	}
	
	function init_class($name = null, $params = array()) {
		if (!empty($name)) {
			$name = $this -> pre . $name;
			if (class_exists($name)) {
				if ($class = new $name($params)) {							
					return $class;
				}
			}
		}
		$this -> init_class('Country');
		return false;
	}
	
	function initialize_adminpage() {
		$helper = 'Template';
		$hfile = dirname(__FILE__) . DS . 'views' . DS . 'admin' . DS . strtolower($helper) . '.php';
		if (file_exists($hfile)) {
			require_once($hfile);
			if (empty($this -> {$helper}) || !is_object($this -> {$helper})) {
				$classname = $helper;
				if (class_exists($classname)) {
					$this -> {$helper} = new $classname;
				}
			}
		}
	}
	
	function initialize_options() {	
	
		$general = array(
			'jsframe' 		=> 'jquery',
			'slide_theme'	=> '1',
			'customtheme'	=> '',
			'wpns_home'		=> 'N',
			'wpns_auto'		=> 'N',
			'wpns_auto_position'	=> 'B',
			'wpns_category'	=> array('1'),
			'slide_gallery'	=> '',
			'exclude'		=> '',
			'offset'		=> '',
			'postlimit'		=> ''
		);
		if($this -> get_option('jsframe')) {
			$general['jsframe'] = $this -> get_option('jsframe');
			$this -> delete_option('jsframe');
		}
		if($this -> get_option('wpns_home')) {
			$general['wpns_home'] = $this -> get_option('wpns_home');
			$this -> delete_option('wpns_home');
		}
		if($this -> get_option('wpns_auto')) {
			$general['wpns_auto'] = $this -> get_option('wpns_auto');
			$this -> delete_option('wpns_auto');
		}
		if($this -> get_option('wpns_auto_position')) {
			$general['wpns_auto_position'] = $this -> get_option('wpns_auto_position');
			$this -> delete_option('wpns_auto_position');
		}
		if($this -> get_option('wpns_effect')) {
			$general['wpns_effect'] = $this -> get_option('wpns_effect');
			$this -> delete_option('wpns_effect');
		}
		if($this -> get_option('wpns_category')) {
			$general['wpns_category'] = $this -> get_option('wpns_category');
			$this -> delete_option('wpns_category');
		}
		if($this -> get_option('slide_theme')) {
			$general['slide_theme'] = $this -> get_option('slide_theme');
			$this -> delete_option('slide_theme');
		}
		if($this -> get_option('customtheme')) {
			$general['customtheme'] = $this -> get_option('customtheme');
			$this -> delete_option('customtheme');
		}
		if($this -> get_option('postlimit')) {
			$general['postlimit'] = $this -> get_option('postlimit');
			$this -> delete_option('postlimit');
		}
		if($this -> get_option('exclude')) {
			$general['exclude'] = $this -> get_option('exclude');
			$this -> delete_option('exclude');
		}
		if($this -> get_option('offset')) {
			$general['offset'] = $this -> get_option('offset');
			$this -> delete_option('offset');
		}
		if($this -> get_option('slide_gallery')) {
			$general['slide_gallery'] = $this -> get_option('slide_gallery');
			$this -> delete_option('slide_gallery');
		}
		
		$slides = array(
			'wpns_slices'	=> '10',
			'wpns_effect'	=> 'random',
			'wprfss_effect'	=> 'fade',
			'wprfss_cssfx'	=> 'pushLeftCSS',
			'wprfss_tips'	=> 'N',
			'csstransform'	=> 'N',
			'pausehover'	=> 'Y',
			'autoslide'		=> 'Y',
			'autoslide_temp'	=> 'Y',
			'autospeed'		=> '3000',
			'information'	=> 'Y',
			'information_temp'	=> 'Y',
			'captionopacity'	=> '80',
			'fadespeed'		=> '500',
			'controlnav'	=> 'Y',			
			'keyboardnav'	=> 'N',
			'thumbnails'	=> 'N',
			'thumbnails_temp'	=> 'N',
			'navigation'	=> 'Y',
			'navhover'		=> 'Y'			
		);
		if($this -> get_option('navigation')) {
			$slides['navigation'] = $this -> get_option('navigation');
			$this -> delete_option('navigation');
		}
		if($this -> get_option('navhover')) {
			$slides['navhover'] = $this -> get_option('navhover');
			$this -> delete_option('navhover');
		}
		if($this -> get_option('controlnav')) {
			$slides['controlnav'] = $this -> get_option('controlnav');
			$this -> delete_option('controlnav');
		}
		if($this -> get_option('keyboardnav')) {
			$slides['keyboardnav'] = $this -> get_option('keyboardnav');
			$this -> delete_option('keyboardnav');
		}
		if($this -> get_option('pausehover')) {
			$slides['navigation'] = $this -> get_option('pausehover');
			$this -> delete_option('pausehover');
		}
		if($this -> get_option('fadespeed')) {
			$slides['fadespeed'] = $this -> get_option('fadespeed');
			$this -> delete_option('fadespeed');
		}
		if($this -> get_option('captionopacity')) {
			$slides['captionopacity'] = $this -> get_option('captionopacity');
			$this -> delete_option('captionopacity');
		}
		if($this -> get_option('information')) {
			$slides['information'] = $this -> get_option('information');
			$this -> delete_option('information');
		}
		if($this -> get_option('information_temp')) {
			$slides['information_temp'] = $this -> get_option('information_temp');
			$this -> delete_option('information_temp');
		}
		if($this -> get_option('thumbnails')) {
			$slides['thumbnails'] = $this -> get_option('thumbnails');
			$this -> delete_option('thumbnails');
		}
		if($this -> get_option('thumbnails_temp')) {
			$slides['thumbnails_temp'] = $this -> get_option('thumbnails_temp');
			$this -> delete_option('thumbnails_temp');
		}
		if($this -> get_option('autoslide')) {
			$slides['autoslide'] = $this -> get_option('autoslide');
			$this -> delete_option('autoslide');
		}
		if($this -> get_option('autoslide_temp')) {
			$slides['autoslide_temp'] = $this -> get_option('autoslide_temp');
			$this -> delete_option('autoslide_temp');
		}
		if($this -> get_option('autospeed')) {
			$slides['autospeed'] = $this -> get_option('autospeed');
			$this -> delete_option('autospeed');
		}
		if($this -> get_option('captionopacity')) {
			$slides['captionopacity'] = $this -> get_option('captionopacity');
			$this -> delete_option('captionopacity');
		}
		if($this -> get_option('pausehover')) {
			$slides['pausehover'] = $this -> get_option('pausehover');
			$this -> delete_option('pausehover');
		}
		if($this -> get_option('keyboardnav')) {
			$slides['keyboardnav'] = $this -> get_option('keyboardnav');
			$this -> delete_option('keyboardnav');
		}
		if($this -> get_option('csstransform')) {
			$slides['csstransform'] = $this -> get_option('csstransform');
			$this -> delete_option('csstransform');
		}
		if($this -> get_option('wprfss_cssfx')) {
			$slides['wprfss_cssfx'] = $this -> get_option('wprfss_cssfx');
			$this -> delete_option('wprfss_cssfx');
		}
		if($this -> get_option('wprfss_tips')) {
			$slides['wprfss_tips'] = $this -> get_option('wprfss_tips');
			$this -> delete_option('wprfss_tips');
		}
		if($this -> get_option('wpns_slices')) {
			$slides['wpns_slices'] = $this -> get_option('wpns_slices');
			$this -> delete_option('wpns_slices');
		}

		$slidestyles = array(
			'thumbs'		=>	'N',
			'navbuttons'		=>	'0',
			'navbullets'		=>	'0',
			'controlnumbers'	=>	'N',
			'offsetnav'		=>	'0',
			'offsetcap'		=>	'0',
			'customnav'		=>	'',
			'custombul'		=>	'',
		);
		$savedstyles = $this -> get_option('styles');
		if($savedstyles && isset($savedstyles['resizeimages']) && !empty($savedstyles['resizeimages'])) {
			//$slidestyles = array_intersect($savedstyles, $slidestyles);
			$slidestyles['resizeimages'] = $savedstyles['resizeimages'];
		}

		$styles = array(
			'width'			=>	'450',
			'height'		=>	'300',
			'wpns_width'		=>	'450',
			'wpns_height'		=>	'300',
			'border'		=>	'1px solid #CCCCCC',
			'background'		=>	'#FFFFFF',
			'infobackground'	=>	'#000000',
			'infocolor'		=>	'#FFFFFF',
			'resizeimages'		=>	'Y',
			'resizeimages2'		=>	'N',
			'thumbs'		=>	'N',
			'navbuttons'		=>	'0',
			'navbullets'		=>	'0',
			'controlnumbers'	=>	'N',
			'offsetnav'		=>	'0',
			'offsetcap'		=>	'0',
			'customnav'		=>	'',
			'custombul'		=>	'',
			'crop'			=>  'N'
		);
		if($this -> get_option('crop_thumbs')) {
			$styles['crop'] = $this -> get_option('crop_thumbs');
			$this -> delete_option('crop_thumbs');
		}
		$links = array(
			'imagesbox'		=>	'T',
			'imagesbox_temp'=>	'N',
			'custombox'		=>	'',
			'pagelink'		=>  'S'
		);	
		if($this -> get_option('pagelink')) {
			$links['pagelink'] = $this -> get_option('pagelink');
			$this -> delete_option('pagelink');
		}
		if($this -> get_option('imagesbox')) {
			$links['imagesbox'] = $this -> get_option('imagesbox');
			$this -> delete_option('imagesbox');
		}
		if($this -> get_option('imagesbox_temp')) {
			$links['imagesbox_temp'] = $this -> get_option('imagesbox_temp');
			$this -> delete_option('imagesbox_temp');
		}
		if($this -> get_option('custombox')) {
			$links['custombox'] = $this -> get_option('custombox');
			$this -> delete_option('custombox');
		}
		
		$this -> add_option('general', $general);
		$this -> add_option('slides', $slides);
		$this -> add_option('styles', $styles);
		$this -> add_option('slidestyles', $slidestyles);
		$this -> add_option('links', $links);
	}
	
	function render_msg($message = '') {
		$this -> render('msg-top', array('message' => $message), true, 'admin');
	}
	
	function render_err($message = '') {
		$this -> render('err-top', array('message' => $message), true, 'admin');
	}
	function redirect($location = '', $msgtype = '', $message = '') {
		$url = $location;
		if ($msgtype == "message") {
			$url .= '&' . $this -> pre . 'updated=true';
		} elseif ($msgtype == "error") {
			$url .= '&' . $this -> pre . 'error=true';
		}
		if (!empty($message)) {
			$url .= '&' . $this -> pre . 'message=' . urlencode($message);
		}
		?>
		<script type="text/javascript">
			window.location = '<?php echo (empty($url)) ? get_option('home') : $url; ?>';
		</script>
		<?php
		flush();
	}
	
	function add_action($action, $function = null, $priority = 10, $params = 1) {
		if (add_action($action, array($this, (empty($function)) ? $action : $function), $priority, $params)) {
			return true;
		}
		return false;
	}
	function remove_action($action, $function = null) {
		if (remove_action($action, array($this, (empty($function)) ? $action : $function))) {
			return true;
		}
		return false;
	}
	function add_filter($filter, $function = null, $priority = 10, $params = 1) {
		if (add_filter($filter, array($this, (empty($function)) ? $filter : $function), $priority, $params)) {
			return true;
		}
		return false;
	}
	
//	IF ( CMBSLD_LOAD_CSS )
	function cmbsld_enqueue_styles() {
		global $version, $post;
		$galleryStyleUrl = false;
		if(isset($GLOBALS['post']))
			$galleryStyleUrl = CMBSLD_PLUGIN_URL . 'css/gallery-css.php?v='. $version .'&amp;pID=' . $GLOBALS['post']->ID;
		//$galleryStyleUrl = CMBSLD_PLUGIN_URL . 'css/gallery-css.php?v='. $version .'&amp;pID=' .$post->ID;
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
			$galleryStyleUrl = str_replace("http:","https:",$galleryStyleUrl);
		}		
        $galleryStyleFile = CMBSLD_PLUGIN_DIR . 'css/gallery-css.php';
//		$src = WP_PLUGIN_DIR.'/' . $this -> plugin_name . '/css/gallery-css.php?2=1&site='.WP_PLUGIN_DIR;
//		define $infogal = $this;
		$infogal = $this;
		if ( file_exists($galleryStyleFile) && $galleryStyleUrl ) {
			if ($styles = $this -> get_option('styles')) {
				foreach ($styles as $skey => $sval) {
					$galleryStyleUrl .= "&amp;" . $skey . "=" . urlencode($sval);
				}
			}
			if ($width_temp = $this-> get_option('width_temp')) {
				foreach ($width_temp as $skey => $sval) {
					if ($skey == $GLOBALS['post']->ID)
					$galleryStyleUrl .= "&amp;width_temp=" . urlencode($sval);
				}
			}
			if ($height_temp = $this-> get_option('height_temp')) {
				foreach ($height_temp as $skey => $sval) {
					if ($skey == $GLOBALS['post']->ID)
					$galleryStyleUrl .= "&amp;height_temp=" . urlencode($sval);
				}
			}
			if ($wpns_width_temp = $this-> get_option('wpns_width_temp')) {
				foreach ($wpns_width_temp as $skey => $sval) {
					if ($skey == $GLOBALS['post']->ID)
					$galleryStyleUrl .= "&amp;wpns_width_temp=" . urlencode($sval);
				}
			}
			if ($wpns_height_temp = $this-> get_option('wpns_height_temp')) {
				foreach ($wpns_height_temp as $skey => $sval) {
					if ($skey == $GLOBALS['post']->ID)
					$galleryStyleUrl .= "&amp;wpns_height_temp=" . urlencode($sval);
				}
			}
			if ($this-> get_option('thumbnails') == 'Y' && $this-> get_option('thumbnails_temp') == 'Y') {
					$galleryStyleUrl .= "&amp;thumbs=Y";
			}
			wp_register_style( 'combo-slideshow', $galleryStyleUrl);
			wp_enqueue_style( 'combo-slideshow', $galleryStyleUrl,	array(), CMBSLD_VERSION, 'all' );
		}
		$general = $this -> get_option('general');
		$use_themes = $general['slide_theme'];
		if ($use_themes != '0'){
			if ($use_themes == 'custom'){
				$use_themes = $general['customtheme'];
				$galleryThemeUrl = get_stylesheet_directory_uri().'/'.$use_themes.'/'.$use_themes.'.css';
			}
			$galleryThemeUrl = CMBSLD_PLUGIN_URL . 'css/'.$use_themes.'/'.$use_themes.'.css';
				wp_register_style( 'combo-slideshow-'.$use_themes, $galleryThemeUrl);
				wp_enqueue_style( 'combo-slideshow-'.$use_themes, $galleryThemeUrl, array(), CMBSLD_VERSION, 'all' );
		}
	}
	function enqueue_scripts($hook=false) {
		
		if (is_admin()) {
			if( 'slideshow_page_settings' != $hook )
				return;
			wp_enqueue_script('jquery');
			if (!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections)) {
				wp_enqueue_script('autosave');
			
				if ($_GET['page'] == 'slideshow') {
					wp_enqueue_script('common');
					wp_enqueue_script('wp-lists');
					wp_enqueue_script('postbox');
					
					wp_enqueue_script('settings-editor', '/' . CMBSLD_PLUGIN_URL . 'js/settings-editor.js', array('jquery'), '1.0');
				}
				
				if ($_GET['page'] == "slideshow-slides" && $_GET['method'] == "order") {
					wp_enqueue_script('jquery-ui-sortable');
				}
				wp_enqueue_script('jquery-ui-sortable');
				
				add_thickbox();
			}
			
			wp_enqueue_script($this -> plugin_name . 'admin', CMBSLD_PLUGIN_URL . 'js/admin.js', 'jquery', '1.0');

		} else {
			$general = $this -> get_option('general');
		    $js_framework = $general['jsframe'];

		    if($js_framework == 'mootools') {

			wp_register_script('moocore', '/' . CMBSLD_PLUGIN_URL . 'js/mootools-core-1.3.2-full-nocompat-yc.js', false, '1.3');
			wp_register_script('moomore', '/' . CMBSLD_PLUGIN_URL . 'js/mootools-more-1.3.2.1-yc.js', false, '1.3');
			wp_enqueue_script('moocore');
			wp_enqueue_script('moomore');
			wp_enqueue_script('moo_loop', '/' . CMBSLD_PLUGIN_URL . 'js/Loop.js', array('moocore','moomore'), '1.3');
			wp_enqueue_script('moo_slideshow', '/' . CMBSLD_PLUGIN_URL . 'js/SlideShow.js', array('moocore','moomore','moo_loop'), '1.3');
			if($general['csstransform'] == 'Y') {
			      wp_enqueue_script('cssanimation', $this -> plugin_name, '/' . CMBSLD_PLUGIN_URL . 'js/CSSAnimation.js', false, '1.3');
			      wp_enqueue_script('moo_cssanimation', $this -> plugin_name, '/' . CMBSLD_PLUGIN_URL . 'js/CSSAnimation.MooTools.js', array('moocore','moomore','cssanimation'), '1.3');
			      wp_enqueue_script('slideshow_css', $this -> plugin_name, '/' . CMBSLD_PLUGIN_URL . 'js/SlideShow.CSS.js', array('moocore','moomore','moo_slideshow','moo_cssanimation'), '1.3');
			}

		    } elseif ($js_framework == 'jquery'){

			wp_enqueue_script('jquery');

			wp_enqueue_script($this -> plugin_name, CMBSLD_PLUGIN_URL . 'js/jquery.nivo.slider.js', array('jquery'), '2.6' );

			$links = $this -> get_option('links');
			if ($links['imagesbox'] == "T") {
				add_thickbox();
			}

		    }

		}
		
		return true;
	}
	function plugin_base() {
		return rtrim(dirname(__FILE__), '/');
	}
	function url() {
		return rtrim(WP_PLUGIN_URL , '/') . '/' . substr(preg_replace("/\\" . DS . "/si", "/", $this -> plugin_base()), strlen(ABSPATH));
	}
	function add_option($name = '', $value = '') {
		if (add_option($this -> pre . $name, $value)) {
			return true;
		}
		return false;
	}
	function update_option($name = '', $value = '') {
		if (update_option($this -> pre . $name, $value)) {
			return true;
		}
		return false;
	}
	function delete_option($name = '', $value = '') {
		if (delete_option($this -> pre . $name, $value)) {
			return true;
		}
		return false;
	}
	function get_option($name = '', $stripslashes = true) {
		if ($option = get_option($this -> pre . $name)) {
			if (@unserialize($option) !== false) {
				return unserialize($option);
			}
			if ($stripslashes == true) {
				$option = stripslashes_deep($option);
			}
			return $option;
		}
		return false;
	}
	function render($file = '', $params = array(), $output = true, $folder = 'admin') {
		if (!empty($file)) {
			$filename = $file . '.php';
			$filepath = $this -> plugin_base() . DS . 'views' . DS . $folder . DS;
			$filefull = $filepath . $filename;
			if (file_exists($filefull)) {
				if (!empty($params)) {
					foreach ($params as $pkey => $pval) {
						${$pkey} = $pval;
					}
				}
				if ($output == false) {
					ob_start();
				}
				include($filefull);
				if ($output == false) {
					$data = ob_get_clean();
					return $data;
				} else {
					flush();
					return true;
				}
			}
		}
		return false;
	}
	
	function slideshow_edit_columns( $columns ) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Name', $this -> plugin_name ),
            'shortcode' => __( 'Shortcode', $this -> plugin_name ),
            'author' => __( 'Author', $this -> plugin_name ),
            'images' => __( 'Images', $this -> plugin_name ),
            'date' => __( 'Date', $this -> plugin_name )
        );
        return $columns;
    }

    function slideshow_custom_columns( $column, $post_id ) {
        global $post;
        switch ( $column )
        {
            case 'images':     
                $limit = 5;
                if(isset($_GET['mode']) && $_GET['mode'] == 'excerpt') $limit = 20;
                //$images = get_the_post_thumbnail($post->ID, array(32, 32));
				$images = get_posts(array(
							'post_parent' => $post->ID,
							'post_type' => 'attachment',
							'numberposts' => -1,
							'post_mime_type' => 'image',));
				
                if ( $images ) {
                    echo '<ul class="slideshow-thumbs">';
                    foreach( $images as $image ){
                        //echo '<li><img src="'. $image['image_src'] .'" alt="" style="width:32px;height:32px;" /></li>';
						$imagesrc = wp_get_attachment_image_src( $image->ID, array(32, 32) );
						echo '<li><img src="'.$imagesrc[0].'" alt="" style="width:32px;height:32px;" /></li>';
                    }
                    echo '</ul>'; 
                }
                break;
            case 'shortcode':  
                echo '<code>[slideshow id="'. $post->ID .'"]</code>';
                if($post->post_name != '') echo '<br /><code>[slideshow slug="'. $post->post_name .'"]</code>';
                break;
        }
    }
	function combo_gallery_metabox_add_post_type($types) {
		if(is_array($types))
			$types[] = 'slideshow';
		return $types;
	}
function register_slideshow_post_type() {
	$labels = array(
		'name' 					=> _x( 'Slideshows', 'post type general name', $this -> plugin_name ),
		'singular_name' 		=> _x( 'Slideshow', 'post type singular name', $this -> plugin_name ),
		'add_new' 				=> _x( 'Add New', 'slideshow item', $this -> plugin_name ),
		'add_new_item'			=> __( 'Add New Slideshow', $this -> plugin_name ),
		'edit_item' 			=> __( 'Edit Slideshow', $this -> plugin_name ),
		'new_item' 				=> __( 'New Slideshow', $this -> plugin_name ),
		'all_items' 			=> __( 'All Slideshows', $this -> plugin_name ),
		'view_item' 			=> __( 'View Slideshow', $this -> plugin_name ),
		'search_items' 			=> __( 'Search Slideshows', $this -> plugin_name ),
		'not_found' 			=> __( 'Nothing found', $this -> plugin_name ),
		'not_found_in_trash' 	=> __( 'Nothing found in Trash', $this -> plugin_name ),
		'parent_item_colon' 	=> ''
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export'			=> true,
		'show_in_nav_menus'		=> true,
		//'show_in_menu'			=> true,
		'query_var' 			=> true,
		'has_archive' 			=> true,
		'rewrite' 				=> apply_filters( 'slideshow_posttype_rewrite_args', array( 'slug' => 'slideshow', 'with_front' => false ) ),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		//'menu_icon'				=> CMBSLD_PLUGIN_URL . 'images/icon.png',
		'menu_icon'				=> 'dashicons-format-gallery',
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields', 'be_gallery_metabox' )
	);

	register_post_type( 'slideshow' , apply_filters( 'slideshow_posttype_args', $args ) );
	
	$this -> add_filter( 'be_gallery_metabox_post_types', 'combo_gallery_metabox_add_post_type' );
	
	$labels['name'] = __( 'Slideshow Categories', $this -> plugin_name );

	register_taxonomy( 'slideshow_category', array( 'slideshow' ), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> apply_filters( 'slideshow_category_rewrite_args', array( 'slug' => 'slideshow_category', 'with_front' => false ) )
	) );
	//remove_post_type_support( 'slideshow', 'editor' );
}
function show_combo_slider($category = null, $n_slices = null, $exclude = null, $offset = null, $size = null, $width = null, $height = null) {
	global $post;
	$post_switch = $post;
	$combo_id = get_the_ID();
	$opt_args = array('caption' => '', 'thumbs' => '', 'auto' => '', 'nolink' => '');
	$options = $this -> parse_temp_options($opt_args);
	
	$general = $this -> get_option('general');
	$slides	= $this -> get_option('slides');
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
	$wpns_effect = $slides['wpns_effect'];
	$wpns_slices = $slides['wpns_slices'];
	$fadespeed = $slides['fadespeed'];
	$autospeed = $slides['autospeed'];
	$navigation = $slides['navigation'];

	$navhover = $slides['navhover'];
	$controlnav = $slides['controlnav'];
	$thumbnails = $slides['thumbnails_temp'];

	$keyboardnav = $slides['keyboardnav'];
	$pausehover = $slides['pausehover'];
	$autoslide = $slides['autoslide_temp'];
	$captionopacity = $slides['captionopacity'];

	$information = $slides['information_temp'];
	$csstransform = $slides['csstransform'];
	$wprfss_effect = $slides['wprfss_effect'];
	$wprfss_cssfx = $slides['wprfss_cssfx'];
	$wprfss_tips = $slides['wprfss_tips'];
	$slide_theme = $general['slide_theme'];

	// $category = get_option('wpns_category');
	// $n_slices = get_option('wpns_slices');
	if (empty($category))
		$category = $general['wpns_category'];
	if(!is_array($category))
		$category = explode(',',$category);
	if (empty($n_slices))
		$n_slices = $wpns_slices;
	if (empty($exclude))
		$exclude = $general['exclude'];
	if (empty($offset))
		$offset = $general['offset'];
	$use_themes = $slide_theme;
	if(empty($size))
		$size = 'comboslide';
	$exclude = explode(',',$exclude);
	//$slides = get_posts( 'category='.$category.'&numberposts='.$n_slices );
	//query_posts( 'cat='.$category.'&posts_per_page='.$n_slices );
	//$query_args = array( 'cat' => $category, 'posts_per_page' => $n_slices, 'post__not_in' => $exclude, 'offset' => $offset );
	$query_args = array( 'category__in' => $category, 'posts_per_page' => $n_slices, 'post__not_in' => $exclude, 'offset' => $offset );
	$slides = new WP_Query($query_args);
//print_r($query_args);
//print_r($slides);
	if( $slides->have_posts() ){
		$append = '';

	      $totalwidth = (count($slides) * (get_option( 'thumbnail_size_w' ) + 10) + 2);
	      $additional_style = '<style type="text/css">';
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
			  #ngslideshow-'.$combo_id.' img { width:'.$styles['wpns_width'].'px;} ';
		    if (!empty($styles['resizeimages2']) && $styles['resizeimages2'] == "Y")
			  $additional_style .= '
			  #ngslideshow-'.$combo_id.' img { height:'.$styles['wpns_height'].'px;} ';
		    if (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y")
			  $additional_style .= '
			  #ngslideshow-'.$combo_id.' .nivo-controlNav { width:'.$styles['wpns_width'].'px;} ';
		    if ($thumbnails == "Y"){
			  $additional_style .= '
			  #ngslideshow-'.$combo_id.' .nivo-controlNav, .nivo-controlNav {
			  	position:relative;
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
			  $append .= $additional_style.'</style>';
	$append .= '<!--[if lte IE 7]>
		    <style type="text/css">
		    .nivo-directionNav{ width:100%; }
		    a.nivo-prevNav{ float:left; }
		    a.nivo-nextNav{ float:right; }
		    </style>
		    <![endif]-->';

	if($use_themes != '0') {
		$append .= '<div class="slider-wrapper theme-'.$use_themes.'">
				<div class="ribbon"></div>';
	} else {
		$append .= '<div class="slider-wrapper">';
	}
	if ($jsframe == 'jquery'){
		$append .= "<script type='text/javascript'>
			      jQuery(window).load(function() {
				jQuery('.ngslideshow').nivoSlider({
					effect:'". $wpns_effect ."',
					slices:". $wpns_slices .",
					animSpeed:". $fadespeed .", // Slide transition speed
					pauseTime:". $autospeed .", // Interval
					startSlide:0, //Set starting Slide (0 index)";
		if ($navigation=="Y")
			$append .= "directionNav:true, //Next & Prev
			";
		else
			$append .= "directionNav:false,
			";
/*
		if ($navhover=="Y")
			$append .= "directionNavHide:true, //Only show on hover
				   ";
		else
			$append .= "directionNavHide:false,
				   ";
*/
		if ($navhover=="Y")
			$append .= "afterLoad: function(){
									// return the useful on-hover display of nav arrows
									jQuery('.nivo-directionNav', jQuery('#ngslideshow-".$combo_id."')).hide();
									jQuery('#ngslideshow-".$combo_id."').hover(function(){ jQuery('.nivo-directionNav', jQuery(this)).show(); }, function(){ jQuery('.nivo-directionNav', jQuery(this)).hide(); });
									},";
		else
			$append .= 	"
			afterLoad: function(){}, //Triggers when slider has loaded
			";
			
		if ($controlnav=="Y" || $thumbnails == "Y")
			$append .= "controlNav:true, //1,2,3...
			";
		else
			$append .= "controlNav:false,
			";
		if ($thumbnails == "Y")
			$append .= "controlNavThumbs:true,
			controlNavThumbsFromRel:true, //Use image rel for thumbs
			";
		else
			$append .= "controlNavThumbs:false, //Use thumbnails for Control Nav
			controlNavThumbsFromRel:false, //Use image rel for thumbs
			";

			$append .= "controlNavThumbsSearch: '.jpg', //Replace this with...
			controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
			";
		if ($keyboardnav=="Y")
			$append .= "keyboardNav:true, //Use left & right arrows
			";
		else
			$append .= "keyboardNav:false,
			";

		if ($pausehover=="Y")
			$append .= "pauseOnHover:true, //Stop animation while hovering
			";
		else
			$append .= "pauseOnHover:false,
			";

		if ($autoslide=="Y")
			$append .= "manualAdvance:false, //Force manual transitions
			";
		else
			$append .= "manualAdvance:true,
			";

			$append .= "captionOpacity:".round(($captionopacity/100), 1).", // Universal caption opacity
					beforeChange: function(){},
					afterChange: function(){},
					slideshowEnd: function(){}, //Triggers after all slides have been shown
					lastSlide: function(){}, //Triggers when last slide is shown
				});
			});
			";
		if ($thumbnails=="Y")
			$append .= "jQuery('#ngslideshow-".$combo_id."').addClass('controlnav-thumbs');
					jQuery('#ngslideshow-".$combo_id." .nivo-controlNav').css('overflow-x','hidden');
					var thumbcw".$combo_id." = jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').width();
				    if(thumbcw".$combo_id.">".$width.") {
					jQuery.fn.loopMove = function(direction, props, dur, eas){
					    if( this.data('loop') == true ){
						if((parseInt(jQuery(this).css('left').replace('px',''))>-thumbcw".$combo_id."+".$width." && direction == true) || (direction == false && parseInt(jQuery(this).css('left').replace('px',''))<=0))
							jQuery(this).animate( props, dur, eas, function(){
						           if( jQuery(this).data('loop') == true ) jQuery(this).loopMove(direction, props, dur, eas);
							});
					    }
					    return this; // Don't break the chain
					}
					jQuery('#ngslideshow-".$combo_id." .nivo-directionNav a.nivo-nextNav').hover(function() {
						if(parseInt(jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').css('left').replace('px',''))>-thumbcw".$combo_id."+".$width." )
								jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').data('loop', true).stop().loopMove(true, {left: '-=5px'}, 10);
					     }, function() {
						jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').data('loop', false).stop();
					});
					jQuery('#ngslideshow-".$combo_id." .nivo-directionNav a.nivo-prevNav').hover(function() {
						if(parseInt(jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').css('left').replace('px',''))<=0)
								jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').data('loop', true).stop().loopMove(false, { left: '+=5px'}, 10);
					     }, function() {
						jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').data('loop', false).stop();
					});
					
					jQuery('#ngslideshow-".$combo_id." .nivo-directionNav a').click(function() {
						jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').stop();
						var thumbOffset".$combo_id." = thumbcw".$combo_id."-".$width.";
						var currentPos".$combo_id." = parseInt(jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').css('left').replace('px',''));
						var next = jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a.active').next();
						var prev = jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a.active').prev();
						if(jQuery(this).hasClass('nivo-nextNav')){
							if(jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a.active').next().length != 0)
								var active".$combo_id." = jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a.active').next().position().left;
							else
								var active".$combo_id." = jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a').first().position().left;

						}else if(jQuery(this).hasClass('nivo-prevNav')){
							if(jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a.active').prev().length != 0)
								var active".$combo_id." = jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a.active').prev().position().left;
							else
								var active".$combo_id." = jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll a').last().position().left;

						}
						if(active".$combo_id." < thumbOffset".$combo_id."){
							jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').animate({
								left: - active".$combo_id."
							}, 2*(Math.abs(currentPos".$combo_id."-active".$combo_id.")));
						}else {
							jQuery('#ngslideshow-".$combo_id." .nivo-controlNavScroll').animate({
								left: - thumbOffset".$combo_id."
							}, 2*(Math.abs(currentPos".$combo_id."-thumbOffset".$combo_id.")));
						}
					});
				      }
				   ";
			$append .= "</script>
				   ";

	}elseif ($jsframe == 'mootools'){
			$slideshow_id = get_the_ID();
			$append .= "<script type='text/javascript'>
			      document.addEvent('domready', function(){
			      ";
		if ($controlnav=="Y" || $thumbnails=="Y" ){
			$append .= "var navItems = $('ngslideshow-".$slideshow_id."').getElements('.nivo-controlNav a.nivo-control');
				    var navMenu = $('ngslideshow-".$slideshow_id."').getElement('div.nivo-controlNav');
				    navMenu.inject($('ngslideshow-".$slideshow_id."'),'after');
				    //navMenu.setStyle('bottom',0);
				    navItems[0].addClass('active');
				    ";
		}
			$append .= "$('ngslideshow-".$slideshow_id."').addClass('nivoSlider');
				    $('ngslideshow-".$slideshow_id."').setStyle('overflow','hidden');
				    $('.slider-wrapper .nivoSlider img').setStyle('display','block');
				    $('ngslideshow-".$slideshow_id."').getParent().setStyle('position','relative');
				    ";
		if ($navigation=="Y"){
			    $append .= "var directionNav = $('ngslideshow-".$slideshow_id."').getElement('div.nivo-directionNav');
					directionNav.inject($('ngslideshow-".$slideshow_id."'),'after').setStyle('display','none').getElements().setStyles({display:'block', 'z-index':9});
				    ";
		    if ($navhover=="Y"){
			    $append .= "directionNav.setStyle('display','none');
					$('ngslideshow-".$slideshow_id."').getParent().addEvents({
					  mouseover: function(){
					      this.getElements('div.nivo-directionNav').setStyle('display','block');";
				if ($pausehover=="Y")
					      $append .= "comboSlideShow.pause();";
			    $append .= 	  "},
					  mouseout: function(){
					      this.getParent().getElements('div.nivo-directionNav').setStyle('display','none');";
				if ($pausehover=="Y")
					      $append .= "comboSlideShow.play();";
			    $append .= 	  "},
					});
				      ";
		    }else{
			    $append .= "directionNav.setStyle('display','block');
				      ";
			    if ($pausehover=="Y")
				$append .= "$('ngslideshow-".$slideshow_id."').getParent().addEvents({
						mouseover: function(){
						    comboSlideShow.pause();
						},
						mouseout: function(){
						    comboSlideShow.play();
						}
					    });
					   ";
		    }
		}
		if ($information == "Y"){
			$append .= "var capWrap = $('ngslideshow-".$slideshow_id."').getElement('div.nivo-caption');
				    capWrap.setStyles({ width: $('ngslideshow-".$slideshow_id."').getSize().x,
					    display: 'block',
					    // height: '1.6em',
					    // margin: $('ngslideshow-".$slideshow_id."').getStyle('margin'),
					    bottom: 0
				    });
				    capWrap.inject($('ngslideshow-".$slideshow_id."'),'after');
				    var slideCaptions = $$('div.nivo-html-caption').setStyles({display: 'block',
					    opacity: 0,
					    visibility: 'hidden',
					    position:'absolute',
					    'z-index': 9,
					    top:0,
					    left:0,
					    width: $('ngslideshow-".$slideshow_id."').getSize().x
					    // width: '". $styles['width'] ."px'
				    });
				    slideCaptions.inject(capWrap,'inside');
				    slideCaptions[0].fade('in');
				    ";
		} elseif ($information == "N"){
			$append .= "var slideCaptions = $$('div.nivo-html-caption').setStyle('display','none');
				   ";
		}
			$append .= "var slideItems = $('ngslideshow-".$slideshow_id."').getElements('a').setStyle('position','absolute');
				    var comboSlideShow = new SlideShow($('ngslideshow-".$slideshow_id."'),  {
					";
		if ($csstransform!="Y")
			$append .= "transition: '".$wprfss_effect."',";
		else
			$append .= "transition: '".$wprfss_cssfx."',";
			$append .= "delay: '".$autospeed."',
				    duration: '".$fadespeed."',";
		if ($autoslide=="Y")
			$append .= "autoplay: true,";
		else
			$append .= "autoplay: false,";
			$append .= "initialSlideIndex: 0,";
		if ($controlnav=="Y" || $information == "Y"){
			$append .= "onShow: function(data){
				   ";
		  if ($information == "Y"){
			$append .= "	slideCaptions[data.previous.index].removeClass('active');
					slideCaptions[data.next.index].addClass('active');
					slideCaptions[data.previous.index].fade('out');
					slideCaptions[data.next.index].fade('in');
					";
		  }
		  if ($controlnav == "Y"){
			$append .= "navItems[data.previous.index].removeClass('active');
					navItems[data.next.index].addClass('active');
					";
		  }
			$append .= "},
				   ";
		}
			$append .= "	selector: 'a'
				    });
				   $('ngslideshow-".$slideshow_id."').setStyle('background-image','none');
				   ";
		if ($csstransform=="Y")
			$append .= "comboSlideShow.useCSS();
				   ";
		if ($navigation=="Y")
			    $append .= "directionNav.getElement('.nivo-prevNav').addEvent('click', function(event){
									event.stop();
									comboSlideShow.show('previous');
								    });
					directionNav.getElement('.nivo-nextNav').addEvent('click', function(event){
									event.stop();
									comboSlideShow.show('next');
								    });
				    ";
		if ($controlnav == "Y"){
			$append .= "navItems.each(function(item, index){";
		    if ($styles['controlnumbers']=="Y"){
			$append .= "item.set('text',index+1);
				    item.set('rel',index+1);";
		    }
				// click a nav item ...
			$append .= "item.addEvent('click', function(event){
				    event.stop();
				    // var transition = (comboSlideShow.index < index) ? 'pushLeft' : 'pushRight';
				    // comboSlideShow.show(index, {transition: transition});
				    comboSlideShow.show(index);
				});
			});
			";
		    if ($wprfss_tips=="Y"){
			$append .= "new Tips(navItems, {
				      fixed: true,
				      text: '',
				      offset: {
					x: -100,
					y: 20
				      }
				    });";
		    }
		    
		}
		$append .= "});
				   </script>";
	}
	$append .= '<div id="ngslideshow-'.get_the_ID().'" class="ngslideshow">';
			  while( $slides->have_posts() ) : $slides->the_post();
				$full_image_href = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size, false);
				//$full_slide_href = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
				$thumbnail_link = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail', false);
				if ( CMBSLD_PRO )
					require CMBSLD_PLUGIN_DIR . 'pro/image_tall_frompost.php';
				if ($thumbnails == "Y")
					$thumbrel = 'rel="'. $thumbnail_link[0] .'" ';
				else
					$thumbrel = '';
				if ($information == "Y")
					$captitle = 'title="'. $post -> ID .'-'.sanitize_title($post -> post_title).'"';
				else
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
				if(has_post_thumbnail()){
					//$append .= '<a href="'. post_permalink() .'" title="'. the_title('','',false).'">';
					//$append .= get_the_post_thumbnail();
					//$append .= '</a>';
					if ($imgbox != "nolink")
						$append .= '<a href="'.post_permalink().'">';
					//$append .= '<img src="'.$full_image_href[0].'" alt="'.$this -> Html -> sanitize($post -> post_title).'" '.$thumbrel.' '.$captitle.' />';
					$append .= '<img src="'.$full_image_href[0].'" alt="'.sanitize_title($post -> post_title).'" '.$thumbrel.' '.$captitle.' />';
					//$append .= get_the_post_thumbnail($post->ID,$size,$attr);
					if ($imgbox != "nolink")
						$append .= '</a>';
				}
			  endwhile;
	if ($jsframe == 'mootools' && $information == "Y") 
				$append .= "<div class='nivo-caption' style='display:none; opacity:".round(($captionopacity/100), 1) .";'>
					    </div>";
	if ($jsframe == 'mootools' && $navigation == "Y"){
				$append .= "<div class='nivo-directionNav' style='display:none'>
					    <a class='nivo-prevNav'>Prev</a>
					    <a class='nivo-nextNav'>Next</a>
					    </div>";
	}
	if ($jsframe == 'mootools' && ($controlnav == "Y" || $thumbnails == "Y")){
				$append .= "<div class='nivo-controlNav'>";
		while( $slides->have_posts() ) : $slides->the_post();
				$append .= "<a class='nivo-control' href='#slide-". $post -> ID ."' title='".$post -> post_title."'>";
		if ($thumbnails == "Y"){
				$thumbnail_link = wp_get_attachment_image_src(get_post_thumbnail_id( $post -> ID ), 'thumbnail', false);
				$append .= "<img src='".$thumbnail_link[0]."' alt='slideshow-thumbnail-".$post -> ID."' />";
		} else {
				$append .= $slides->current_post+1;
		}
				$append .= "</a>";
			  endwhile;
				$append .= '</div>';
	}
		$append .= '</div>';
			  while( $slides->have_posts() ) : $slides->the_post();
			    $append .= '<div id="slide_caption-'. $post -> ID .'" class="nivo-html-caption">';
			    if(has_post_thumbnail()){
			    //$append .= '<a href="'. get_permalink(get_the_ID()) .'" title="'. $slide -> post_title .'">'. $slide -> post_title .'</a>';
			    $append .= '<a href="'. post_permalink() .'" title="'. $post -> post_title .'">'. $post -> post_title .'</a>';
			    }
				$append .= '</div>';
			  endwhile;

		//if($use_themes != '0'){
			$append .= '</div>';
		//}
			}
		//wp_reset_query();
		wp_reset_postdata();
		$post = $post_switch;
		return $append;
	}
}
?>