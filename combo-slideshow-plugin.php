<?php
class CMBSLD_GalleryPlugin {
	var $version = '1.4';
	var $plugin_name;
	var $plugin_base;
	var $pre = 'Gallery';
	var $debugging = false;
	var $menus = array();
	var $sections = array(
		'gallery'		=>	'gallery-slides',
		'settings'		=>	'gallery',
	);
	var $helpers = array('Db', 'Html', 'Form', 'Metabox');
	var $models = array('Slide');
	
	function register_plugin($name, $base) {
		$this -> plugin_name = $name;
		$this -> plugin_base = rtrim(dirname($base), DS);
		$this -> enqueue_scripts();
		$this -> initialize_classes();
		$this -> initialize_options();
		if (function_exists('load_plugin_textdomain')) {
			$currentlocale = get_locale();
			if(!empty($currentlocale)) {
				$moFile = dirname(__FILE__) . DS . "languages" . DS . $this -> plugin_name . "-" . $currentlocale . ".mo";				
				if(@file_exists($moFile) && is_readable($moFile)) {
					load_textdomain($this -> plugin_name, $moFile);
				}
			}
		}
		if ($this -> debugging == true) {
			global $wpdb;
			$wpdb -> show_errors();
			error_reporting(E_ALL);
			@ini_set('display_errors', 1);
		}
		$this -> add_action( 'wp_print_styles', 'cmbsld_enqueue_styles' );
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
	
	function initialize_classes() {
		if (!empty($this -> helpers)) {
			foreach ($this -> helpers as $helper) {
				$hfile = dirname(__FILE__) . DS . 'helpers' . DS . strtolower($helper) . '.php';
				if (file_exists($hfile)) {
					require_once($hfile);
					if (empty($this -> {$helper}) || !is_object($this -> {$helper})) {
						$classname = $this -> pre . $helper . 'Helper';
						if (class_exists($classname)) {
							$this -> {$helper} = new $classname;
						}
					}
				} 
			}
		}
		if (!empty($this -> models)) {
			foreach ($this -> models as $model) {
				$mfile = dirname(__FILE__) . DS . 'models' . DS . strtolower($model) . '.php';
				if (file_exists($mfile)) {
					require_once($mfile);
					if (empty($this -> {$model}) || !is_object($this -> {$model})) {
						$classname = $this -> pre . $model;
					
						if (class_exists($classname)) {
							$this -> {$model} = new $classname;
						}
					}
				} 
			}
		}
	}
	
	function initialize_options() {
		$styles = array(
			'width'			=>	"450",
			'height'		=>	"300",
			'wpns_width'		=>	"450",
			'wpns_height'		=>	"300",
			'border'		=>	"1px solid #CCCCCC",
			'background'		=>	"#202834",
			'infobackground'	=>	"#000000",
			'infocolor'		=>	"#FFFFFF",
			'resizeimages'		=>	"Y",
			'resizeimages2'		=>	"N",
			'thumbs'		=>	"N",
			'navbuttons'		=>	"0",
			'navbullets'		=>	"0",
			'controlnumbers'	=>	"N",
			'offsetnav'		=>	"0",
			'offsetcap'		=>	"0",
			'customnav'		=>	"",
			'custombul'		=>	""
		);
		
		$this -> add_option('styles', $styles);
		//General Settings
		$this -> add_option('navigation', 'Y');
		$this -> add_option('navhover', 'Y');
		$this -> add_option('controlnav', 'Y');
		$this -> add_option('keyboardnav', 'Y');
		$this -> add_option('pausehover', 'Y');
		$this -> add_option('fadespeed', 500);
		$this -> add_option('captionopacity', 80);
		$this -> add_option('navhover', "N");
		$this -> add_option('linker', "Y");
		$this -> add_option('nolinkpage', "N");
		$this -> add_option('pagelink', "S");
		$this -> add_option('information', "Y");
		$this -> add_option('information_temp', "Y");
		// $this -> add_option('infospeed', 10);
		$this -> add_option('thumbnails', "N");
		$this -> add_option('thumbnails_temp', "N");
		// $this -> add_option('thumbposition', "bottom");
		// $this -> add_option('thumbopacity', 70);
		// $this -> add_option('thumbscrollspeed', 5);
		// $this -> add_option('thumbspacing', 5);
		// $this -> add_option('thumbactive', "#FFFFFF");
		$this -> add_option('autoslide', "Y");
		$this -> add_option('autoslide_temp', "Y");
		$this -> add_option('autospeed', 3000);
		$this -> add_option('imagesbox', "T");
		$this -> add_option('wpns_category','1');
		$this -> add_option('wpns_effect','random');
		$this -> add_option('wpns_slices','10');	
		$this -> add_option('wpns_home','N');
		//$this -> add_option('wpns_autocustom_home','0');
		$this -> add_option('wpns_auto','N');
		//$this -> add_option('wpns_autocustom_post','0');
		$this -> add_option('wpns_auto_position','B');
		$this -> add_option('pausehover','Y');
		$this -> add_option('keyboardnav','N');
		$this -> add_option('slide_theme','0');
		$this -> add_option('jsframe','jquery');
		$this -> add_option('wprfss_effect','fade');
		$this -> add_option('wprfss_cssfx','pushLeftCSS');
		$this -> add_option('wprfss_tips','N');
		$this -> add_option('customtheme','');
		$this -> add_option('custombox','');
		$this -> add_option('css_transform','N');
		$this -> add_option('postlimit','');
		$this -> add_option('exclude','');
		$this -> add_option('offset','');
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
	
	function paginate($model = null, $fields = '*', $sub = null, $conditions = null, $searchterm = null, $per_page = 10, $order = array('modified', "DESC")) {
		global $wpdb;
	
		if (!empty($model)) {
			global $paginate;
			$paginate = $this -> vendor('Paginate');
			$paginate -> table = $this -> {$model} -> table;
			$paginate -> sub = (empty($sub)) ? $this -> {$model} -> controller : $sub;
			$paginate -> fields = (empty($fields)) ? '*' : $fields;
			$paginate -> where = (empty($conditions)) ? false : $conditions;
			$paginate -> searchterm = (empty($searchterm)) ? false : $searchterm;
			$paginate -> per_page = $per_page;
			$paginate -> order = $order;
			$data = $paginate -> start_paging($_GET[$this -> pre . 'page']);
			if (!empty($data)) {
				$newdata = array();
				foreach ($data as $record) {
					$newdata[] = $this -> init_class($model, $record);
				}
				$data = array();
				$data[$model] = $newdata;
				$data['Paginate'] = $paginate;
			}
			return $data;
		}
		return false;
	}
	
	function vendor($name = '', $folder = '') {
		if (!empty($name)) {
			$filename = 'class.' . strtolower($name) . '.php';
			$filepath = rtrim(dirname(__FILE__), DS) . DS . 'vendors' . DS . $folder . '';
			$filefull = $filepath . $filename;
			if (file_exists($filefull)) {
				require_once($filefull);
				$class = 'Gallery' . $name;
				if (${$name} = new $class) {
					return ${$name};
				}
			}
		}
		return false;
	}
	function check_uploaddir() {
		$uploaddir = ABSPATH . 'wp-content' . DS . 'uploads' . DS . $this -> plugin_name . DS;
		if (!file_exists($uploaddir)) {
			if (@mkdir($uploaddir, 0777)) {
				@chmod($uploaddir, 0777);
				return true;
			} else {
				$message = __('Uploads folder named "' . $this -> plugin_name . '" cannot be created inside "wp-content/uploads"', $this -> plugin_name);
				$this -> render_msg($message);
			}
		}
		return false;
	}
	
	function add_action($action, $function = null, $priority = 10, $params = 1) {
		if (add_action($action, array($this, (empty($function)) ? $action : $function), $priority, $params)) {
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
		global $version;
		$galleryStyleUrl = CMBSLD_PLUGIN_URL . '/css/gallery-css.php?v='. $version .'&amp;pID=' . $GLOBALS['post']->ID;
		if($_SERVER['HTTPS']) {
			$galleryStyleUrl = str_replace("http:","https:",$galleryStyleUrl);
		}		
        $galleryStyleFile = CMBSLD_PLUGIN_DIR . '/css/gallery-css.php';
//		$src = WP_PLUGIN_DIR.'/' . $this -> plugin_name . '/css/gallery-css.php?2=1&site='.WP_PLUGIN_DIR;
//		define $infogal = $this;
		$infogal = $this;
		if ( file_exists($galleryStyleFile) ) {
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
			if ($this-> get_option('thumbnails') == 'Y') {
					$galleryStyleUrl .= "&amp;thumbs=Y";
			}
			wp_register_style( 'combo-slideshow', $galleryStyleUrl);
			wp_enqueue_style( 'combo-slideshow', $galleryStyleUrl,	array(), CMBSLDVERSION, 'all' );
		}

$use_themes = $this -> get_option('slide_theme');
if ($use_themes != '0'){
		if ($use_themes == 'custom'){
			$use_themes = $this -> get_option('customtheme');
			$galleryThemeUrl = get_stylesheet_directory_uri().'/'.$use_themes.'/'.$use_themes.'.css';
		}
		$galleryThemeUrl = CMBSLD_PLUGIN_URL . '/css/'.$use_themes.'/'.$use_themes.'.css';
			wp_register_style( 'combo-slideshow-'.$use_themes, $galleryThemeUrl);
			wp_enqueue_style( 'combo-slideshow-'.$use_themes, $galleryThemeUrl, array(), CMBSLDVERSION, 'all' );
}

/*		function cmbsld_style_head($url) {
			print "<link rel='stylesheet' type='text/css' href='" . get_bloginfo('wpurl') . "/wp-content/plugins/combo-slideshow-2/?my-custom-content=css'/>";
		}
		function cmbsld_style_cheat( $wp ) {
			print"<link id='combo-slideshow' rel='stylesheet' type='text/css' href='" . $wp . "'/>";
		}
		/* Known Issue - passing a function into the second string makes the link info go above <html> */
		/* FIX for QTranslate - Uncomment for this plugin */
	/*	if (!is_admin) {
			add_filter('wp_print_styles', cmbsld_style_cheat($galleryStyleUrl) );
		}*/
		
		
	}
	function enqueue_scripts() {
		
		if (is_admin()) {
			wp_enqueue_script('jquery');
			if (!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections)) {
				wp_enqueue_script('autosave');
			
				if ($_GET['page'] == 'gallery') {
					wp_enqueue_script('common');
					wp_enqueue_script('wp-lists');
					wp_enqueue_script('postbox');
					
					wp_enqueue_script('settings-editor', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/settings-editor.js', array('jquery'), '1.0');
				}
				
				if ($_GET['page'] == "gallery-slides" && $_GET['method'] == "order") {
					wp_enqueue_script('jquery-ui-sortable');
				}
				wp_enqueue_script('jquery-ui-sortable');
				
				add_thickbox();
			}
			
			wp_enqueue_script($this -> plugin_name . 'admin', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/admin.js', null, '1.0');

		} else {

		    $js_framework = $this -> get_option('jsframe');

		    if($js_framework == 'mootools') {

			wp_register_script('moocore', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/mootools-core-1.3.2-full-nocompat-yc.js', false, '1.3');
			wp_register_script('moomore', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/mootools-more-1.3.2.1-yc.js', false, '1.3');
			wp_enqueue_script('moocore');
			wp_enqueue_script('moomore');
			wp_enqueue_script('moo_loop', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/Loop.js', array('moocore','moomore'), '1.3');
			wp_enqueue_script('moo_slideshow', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/SlideShow.js', array('moocore','moomore','moo_loop'), '1.3');
			if($this -> get_option('css_transform') == 'Y') {
			      wp_enqueue_script('cssanimation', $this -> plugin_name, '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/CSSAnimation.js', false, '1.3');
			      wp_enqueue_script('moo_cssanimation', $this -> plugin_name, '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/CSSAnimation.MooTools.js', array('moocore','moomore','cssanimation'), '1.3');
			      wp_enqueue_script('slideshow_css', $this -> plugin_name, '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/SlideShow.CSS.js', array('moocore','moomore','moo_slideshow','moo_cssanimation'), '1.3');
			}

		    } elseif ($js_framework == 'jquery'){

			wp_enqueue_script('jquery');

			wp_enqueue_script($this -> plugin_name, '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/jquery.nivo.slider.js', array('jquery'), '2.6' );
			
			if ($this -> get_option('imagesbox') == "T") {
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
	function debug($var = array()) {
		if ($this -> debugging) {
			echo '<pre>' . print_r($var, true) . '</pre>';
			return true;
		}
		
		return false;
	}
	
	function check_table($model = null) {
		global $wpdb;
	
		if (!empty($model)) {			
			if (!empty($this -> fields) && is_array($this -> fields)) {			
				if (!$wpdb -> get_var("SHOW TABLES LIKE '" . $this -> table . "'")) {				
					$query = "CREATE TABLE `" . $this -> table . "` (";
					$c = 1;
				
					foreach ($this -> fields as $field => $attributes) {
						if ($field != "key") {
							$query .= "`" . $field . "` " . $attributes . "";
						} else {
							$query .= "" . $attributes . "";
						}
						if ($c < count($this -> fields)) {
							$query .= ",";
						}
						$c++;
					}
					
					$query .= ") ENGINE=MyISAM AUTO_INCREMENT=1 CHARSET=UTF8;";
					
					if (!empty($query)) {
						$this -> table_query[] = $query;
					}
				} else {
					$field_array = $this -> get_fields($this -> table);
					
					foreach ($this -> fields as $field => $attributes) {					
						if ($field != "key") {
							$this -> add_field($this -> table, $field, $attributes);
						}
					}
				}
				
				if (!empty($this -> table_query)) {				
					require_once(ABSPATH . 'wp-admin' . DS . 'upgrade-functions.php');
					dbDelta($this -> table_query, true);
				}
			}
		}
		
		return false;
	}
	
	function get_fields($table = null) {	
		global $wpdb;
	
		if (!empty($table)) {
			$fullname = $table;
			if (($tablefields = mysql_list_fields(DB_NAME, $fullname, $wpdb -> dbh)) !== false) { 
				$columns = mysql_num_fields($tablefields);
				$field_array = array();
				for ($i = 0; $i < $columns; $i++) {
					$fieldname = mysql_field_name($tablefields, $i);
					$field_array[] = $fieldname;
				}
	
				return $field_array;
			}
		}
		return false;
	}
	
	function delete_field($table = '', $field = '') {
		global $wpdb;
		
		if (!empty($table)) {
			if (!empty($field)) {
				$query = "ALTER TABLE `" . $wpdb -> prefix . "" . $table . "` DROP `" . $field . "`";
				
				if ($wpdb -> query($query)) {
					return false;
				}
			}
		}
		
		return false;
	}
	
	function change_field($table = '', $field = '', $newfield = '', $attributes = "TEXT NOT NULL") {
		global $wpdb;
		
		if (!empty($table)) {		
			if (!empty($field)) {			
				if (!empty($newfield)) {
					$field_array = $this -> get_fields($table);
					
					if (!in_array($field, $field_array)) {
						if ($this -> add_field($table, $newfield)) {
							return true;
						}
					} else {
						$query = "ALTER TABLE `" . $table . "` CHANGE `" . $field . "` `" . $newfield . "` " . $attributes . ";";
						
						if ($wpdb -> query($query)) {
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	function add_field($table = '', $field = '', $attributes = "TEXT NOT NULL") {
		global $wpdb;
	
		if (!empty($table)) {
			if (!empty($field)) {
				$field_array = $this -> get_fields($table);
				
				if (!empty($field_array)) {				
					if (!in_array($field, $field_array)) {					
						$query = "ALTER TABLE `" . $table . "` ADD `" . $field . "` " . $attributes . ";";
						
						if ($wpdb -> query($query)) {
							return true;
						}
					}
				}
			}
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
	
    function show_combo_slider($category = null, $n_slices = null, $exclude = null, $offset = null) {
	global $post;
	$post_switch = $post;
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
	      $thumbnails 	= $this -> get_option('thumbnails');

	      $keyboardnav 	= $this -> get_option('keyboardnav');
	      $pausehover 	= $this -> get_option('pausehover');
	      $autoslide 	= $this -> get_option('autoslide');
	      $captionopacity 	= $this -> get_option('captionopacity');

	      $information 	= $this -> get_option('information');
	      $csstransform 	= $this -> get_option('csstransform');
	      $wprfss_effect 	= $this -> get_option('wprfss_effect');
	      $wprfss_cssfx 	= $this -> get_option('wprfss_cssfx');
	      $wprfss_tips 	= $this -> get_option('wprfss_tips');
	      $slide_theme 	= $this -> get_option('slide_theme');


	// $category = get_option('wpns_category');
	// $n_slices = get_option('wpns_slices');
	if ($category != null)
	$category = $this -> get_option('wpns_category');
	if ($n_slices != null)
	$n_slices = $this -> get_option('postlimit');
	if ($exclude != null)
	$exclude = $this -> get_option('exclude');
	if ($offset != null)
	$offset = $this -> get_option('offset');
	$use_themes = $slide_theme;

	$slided = get_posts( 'category='.$category.'&numberposts='.$n_slices );
	//query_posts( 'cat='.$category.'&posts_per_page='.$n_slices );
	$query_args = array( 'cat' => $category, 'posts_per_page' => $n_slices, 'post__not_in' => $exclude, 'offset' => $offset );
	$slided = new WP_Query($query_args);
	if( $slided->have_posts() ){
		$append = '';
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
			$append .= "directionNav:true, //Next & Prev";
		else
			$append .= "directionNav:false,";
		if ($navhover=="Y")
			$append .= "directionNavHide:true, //Only show on hover";
		else
			$append .= "directionNavHide:false,";
		if ($controlnav=="Y")
			$append .= "controlNav:true, //1,2,3...";
		else
			$append .= "controlNav:false,";
		if ($thumbnails == "Y")
			$append .= "controlNavThumbs:true,
				    controlNavThumbsFromRel:true, //Use image rel for thumbs";
		else
			$append .= "controlNavThumbs:false, //Use thumbnails for Control Nav
				    controlNavThumbsFromRel:false, //Use image rel for thumbs";

			$append .= "controlNavThumbsSearch: '.jpg', //Replace this with...
				    controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src";
		if ($keyboardnav=="Y")
			$append .= "keyboardNav:true, //Use left & right arrows";
		else
			$append .= "keyboardNav:false,";

		if ($pausehover=="Y")
			$append .= "pauseOnHover:true, //Stop animation while hovering";
		else
			$append .= "pauseOnHover:false,";

		if ($autoslide=="Y")
			$append .= "manualAdvance:false, //Force manual transitions";
		else
			$append .= "manualAdvance:true,";

			$append .= "captionOpacity:".round(($captionopacity/100), 1).", // Universal caption opacity
				    beforeChange: function(){},
				    afterChange: function(){},
				    slideshowEnd: function(){}, //Triggers after all slides have been shown
				    lastSlide: function(){}, //Triggers when last slide is shown
				    afterLoad: function(){} //Triggers when slider has loaded
				 });
				});
			</script>";
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
				    $$('.slider-wrapper .nivoSlider img').setStyle('display','block');
				    $('ngslideshow-".$slideshow_id."').getParent().setStyle('position','relative');
				    ";
		if ($information == "Y"){
			$append .= "var capWrap = $('ngslideshow-".$slideshow_id."').getElement('div.nivo-caption');
				    capWrap.setStyles({ width: $('ngslideshow-".$slideshow_id."').getSize().x,
					    height: '1.6em',
					    margin: $('ngslideshow-".$slideshow_id."').getStyle('margin'),
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
					    width: '". $style['width'] ."px'
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
				   ";
		if ($csstransform=="Y")
			$append .= "comboSlideShow.useCSS();
				   ";
		if ($controlnav == "Y"){
			$append .= "navItems.each(function(item, index){";
		    if ($style['controlnumbers']=="Y"){
			$append .= "item.set('text',index+1);
				    item.set('rel',index+1);";
		    }
				// click a nav item ...
			$append .= "item.addEvent('click', function(event){
				    event.stop();
				    var transition = (comboSlideShow.index < index) ? 'pushLeft' : 'pushRight';
				    comboSlideShow.show(index, {transition: transition});
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
			  while( $slided->have_posts() ) : $slided->the_post();
				$full_image_href = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large', false);
				$thumbnail_link = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail', false);
				if ( CMBSLD_PRO )
					require CMBSLD_PLUGIN_DIR . '/pro/image_tall_frompost.php';
				if ($thumbnails == "Y")
					$thumbrel = 'rel="'. $thumbnail_link[0] .'" ';
				if ($information == "Y")
					$captitle = 'title="#'. $post -> ID .'-'.$post -> post_title.'"';
				if ($jsframe == 'jquery'){
				    $resize = '';
				    if( !empty($style['resizeimages']) && $style['resizeimages'] == "Y") {
					$resize .= ' width="'. $styles['wpns_width'] .'"';
				    }
				    if( !empty($style['resizeimages2']) && $style['resizeimages2'] == "Y") {
					$resize .= ' height="'. $style['wpns_height'] .'"';
				    }
				}
				if(has_post_thumbnail()){
					//$append .= '<a href="'. post_permalink() .'" title="'. the_title('','',false).'">';
					//$append .= get_the_post_thumbnail();
					//$append .= '</a>';
					if ($imagesbox != "nolink")
						$append .= '<a href="'.post_permalink().'">';
					$append .= '<img src="'.$full_image_href[0].'" alt="'.$this -> Html -> sanitize($post -> post_title).'" '.$thumbrel.' '.$captitle.' />';
					//$append .= get_the_post_thumbnail($post->ID,$size,$attr);
					if ($imagesbox != "nolink")
						$append .= '</a>';
				}
			  endwhile;
	if ($jsframe == 'mootools' && $information == "Y") 
				$append .= "<div class='nivo-caption' style='opacity:".round(($captionopacity/100), 1) .";'>
					    </div>";
	if ($jsframe == 'mootools' && $navigation == "Y"){
	}
	if ($jsframe == 'mootools' && ($controlnav == "Y" || $thumbnails == "Y")){
				$append .= "<div class='nivo-controlNav'>";
			  while( $slided->have_posts() ) : $slided->the_post();
				$append .= "<a class='nivo-control' href='#slide-". $slided -> ID ."' title='".$slided -> post_title."'>";
		if ($thumbnails == "Y"){
				$thumbnail_link = wp_get_attachment_image_src($slided -> ID, 'thumbnail', false);
				$append .= "<img src='".$thumbnail_link[0]."' alt='slideshow-thumbnail-".$slided -> ID."' />";
		} else{
				$append .= $index+1;
		}
				$append .= "</a>";
			  endwhile;
				$append .= '</div>';
	}
		$append .= '</div>';
			  while( $slided->have_posts() ) : $slided->the_post();
			    $append .= '<div id="slide_caption-'. $post -> ID .'" class="nivo-html-caption">';
			    if(has_post_thumbnail()){
			    //$append .= '<a href="'. get_permalink(get_the_ID()) .'" title="'. $slide -> post_title .'">'. $slide -> post_title .'</a>';
			    $append .= '<a href="'. post_permalink() .'" title="'. $post -> post_title .'">'. $post -> post_title .'</a>';
			    $append .= '</div>';
			    }
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