<?php
/*
Plugin Name: Combo Slideshow
Plugin URI: http://www.3dolab.net/en
Author: 3dolab
Author URI: http://www.3dolab.net
Description: The features of the best slideshow javascript effects and WP plugins. Blog posts highlights, image gallery, custom slides!
Version: 1.9
*/
if ( ! defined( 'DS' ) )
	define('DS', DIRECTORY_SEPARATOR);
if ( ! defined( 'CMBSLD_VERSION' ) )
	define( 'CMBSLD_VERSION', '1.9' );
if ( ! defined( 'CMBSLD_PLUGIN_BASENAME' ) )
	define( 'CMBSLD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'CMBSLD_PLUGIN_NAME' ) )
	define( 'CMBSLD_PLUGIN_NAME', trim( dirname( CMBSLD_PLUGIN_BASENAME ), '/' ) );
if ( ! defined( 'CMBSLD_PLUGIN_DIR' ) )
	define( 'CMBSLD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	//define( 'CMBSLD_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . CMBSLD_PLUGIN_NAME );
if ( ! defined( 'CMBSLD_PLUGIN_URL' ) )
	define( 'CMBSLD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	//define( 'CMBSLD_PLUGIN_URL', WP_PLUGIN_URL . '/' . CMBSLD_PLUGIN_NAME );
if ( ! defined( 'CMBSLD_UPLOAD_URL' ) ) :
	$upload_dir = wp_upload_dir();
	define( 'CMBSLD_UPLOAD_URL', $upload_dir['baseurl'] . CMBSLD_PLUGIN_NAME );
	//define( 'CMBSLD_UPLOAD_URL', get_bloginfo('wpurl')."/wp-content/uploads/". CMBSLD_PLUGIN_NAME );
endif;
if ( ! file_exists( CMBSLD_PLUGIN_DIR . 'pro/' ) )
	define( 'CMBSLD_PRO', false );
else
	define( 'CMBSLD_PRO', true );
	
require_once CMBSLD_PLUGIN_DIR . 'combo-slideshow-plugin.php';
 add_theme_support('post-thumbnails');
// add_filter( 'the_content', 'auto_combo_slider' );
	
class CMBSLD_Gallery extends CMBSLD_GalleryPlugin {
	function __construct() {
		$url = explode("&", $_SERVER['REQUEST_URI']);
		$this -> url = $url[0];
		
		$this -> register_plugin('combo-slideshow', __FILE__);
		
		//WordPress action hooks
		$this -> add_action('admin_menu');
		//$this -> add_action('admin_head');
		$this -> add_action('admin_notices');
		// $this -> add_action('cmbsld_enqueue_styles');
		$this -> add_action('current_screen');
		
		//WordPress filter hooks
		//$this -> add_filter('mce_external_plugins');
		//$this -> add_filter('mce_buttons');
		$this -> add_action('template_redirect','auto_show_context');

		// $this -> add_theme_support('post-thumbnails');
		$this -> add_filter('attachment_fields_to_edit', 'my_image_attachment_fields_to_edit', null, 2);
		$this -> add_filter('attachment_fields_to_save', 'my_image_attachment_fields_to_save', null, 2);
		$styles = $this -> get_option('styles');
		if(isset($styles['crop']) && $styles['crop'])
			$crop = true;
		else
			$crop = false;
		$combowidth = $styles['width'];
		$comboheight = $styles['height'];
		add_image_size( 'comboslide', $combowidth, $comboheight, $crop );
		add_shortcode('slideshow', array($this, 'embed'));
	}
	function auto_show_context() {
		if ( ( is_main_query() && ( is_home() || is_front_page() ) ) ){
			$general = $this -> get_option('general');
			if($general['wpns_auto_position'] == 'B')
				$this -> add_action( 'loop_start', 'auto_combo_slider' );
			elseif($general['wpns_auto_position'] == 'A')
				$this -> add_action( 'loop_end', 'auto_combo_slider' );
		} elseif ( is_main_query() && ( !is_home() && !is_front_page() && is_singular() ) ){
			$this -> add_filter( 'the_content', 'auto_combo_slider' );
		}
	}
	function auto_combo_slider( $content ) {
		global $post;
		$general = $this -> get_option('general');
	    //if ( ( ( is_home() || is_front_page() || is_post_type_archive() ) && $general['wpns_home'] == 'Y' ) ){
		if ( ( is_main_query() && ( is_home() || is_front_page() ) && $general['wpns_home'] == 'Y' && $post->post_type != 'slideshow' ) ){
			if($general['wpns_auto_position'] == 'B')
				$this -> remove_action( 'loop_start', 'auto_combo_slider' );
			elseif($general['wpns_auto_position'] == 'A')
				$this -> remove_action( 'loop_end', 'auto_combo_slider' );
			if(is_main_query())
				$comboslidercode = $this -> show_combo_slider();
	    } elseif ( is_main_query() && ( !is_home() && !is_front_page() && is_singular() ) && $general['wpns_auto'] == 'Y' && $post->post_type != 'slideshow' ){
			$comboslidercode = $this -> embed();
	    } elseif ( is_main_query() && ( ( ( is_home() || is_front_page() ) && $general['wpns_home'] == 'C' ) || ( is_singular() && $general['wpns_auto'] == 'C' ) && $post->post_type != 'slideshow' ) ) {
			if($general['wpns_auto_position'] == 'B')
				$this -> remove_action( 'loop_start', 'auto_combo_slider' );
			elseif($general['wpns_auto_position'] == 'A')
				$this -> remove_action( 'loop_end', 'auto_combo_slider' );
			  //$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"), $general['postlimit']);
			  //$comboslidercode = $this -> render('gallery', array('slides' => $slides, 'frompost' => false), false, 'default');
			$slideshow_id = $general['slide_gallery'];
			$comboslidercode = $this -> embed(array('custom'=>$slideshow_id));
	    } elseif($content) {
			return $content;
	    } else
			$comboslidercode = '';
		if( is_string($content) && ( !is_home() && !is_front_page() && !is_post_type_archive() ) ){
			if ($general['wpns_auto_position'] == 'B')
			  $content = $comboslidercode.$content;
			elseif ($general['wpns_auto_position'] == 'A')
			  $content = $content.$comboslidercode;
			return $content;
		} elseif (is_object($content)||is_array($content))
			echo $comboslidercode;
	}
	function my_image_attachment_fields_to_edit($form_fields, $post) {  
		// $form_fields is a special array of fields to include in the attachment form  
		// $post is the attachment record in the database  
		//     $post->post_type == 'attachment'  
		// (attachments are treated as posts in WordPress)  
		  
		// add our custom field to the $form_fields array  
		// input type="text" name/id="attachments[$attachment->ID][custom1]"  
		$form_fields["comboslide_link"] = array(  
			"label" => __('Slideshow Link', $this -> plugin_name),
			"input" => get_bloginfo('url'), // this is default if "input" is omitted  
			"value" => get_post_meta($post->ID, "_comboslide_link", true)  
		);  
		// if you will be adding error messages for your field,   
		// then in order to not overwrite them, as they are pre-attached   
		// to this array, you would need to set the field up like this:  
		$form_fields["comboslide_link"]["label"] = __('Slideshow Link', $this -> plugin_name);
		$form_fields["comboslide_link"]["input"] = get_bloginfo('url');  
		$form_fields["comboslide_link"]["value"] = get_post_meta($post->ID, '_comboslide_link', true);  
		  
		return $form_fields;  
	}  
	function my_image_attachment_fields_to_save($post, $attachment) {  
		// $attachment part of the form $_POST ($_POST[attachments][postID])  
		// $post attachments wp post array - will be saved after returned  
		//     $post['post_type'] == 'attachment'  
		if( isset($attachment['comboslide_link']) ){  
			// update_post_meta(postID, meta_key, meta_value);  
			update_post_meta($post['ID'], '_comboslide_link', $attachment['comboslide_link']);  
		}  
		return $post;  
	}  
	function admin_menu() {
		$this -> menus['slideshow'] = add_submenu_page('edit.php?post_type=slideshow', __('Combo Slideshow Settings', $this -> plugin_name), __('Settings', $this -> plugin_name), 'edit_others_posts', 'settings', array($this, 'admin_settings'));
		//$this -> menus['slideshow'] = add_menu_page(__('Combo Slideshow', $this -> plugin_name), __('Combo Slideshow', $this -> plugin_name), 'edit_others_posts', "slideshow", array($this, 'admin_settings'), CMBSLD_PLUGIN_URL . '/images/icon.png');
		//add_action('admin_head-' . $this -> menus['slideshow'], array($this, 'admin_head_slideshow_settings'));
		//add_action('admin_head-' . $this -> menus['slideshow'], array($this, 'admin_settings_page'));
	}
	/*
	function admin_head() {
		$this -> render('head', false, true, 'admin');
	}
	*/
	function admin_settings() {	
		if(isset($_REQUEST['method'])){
			switch ($_REQUEST['method']) {
				case 'reset' :
					global $wpdb;
					$query = "DELETE FROM `" . $wpdb -> prefix . "options` WHERE `option_name` LIKE '" . $this -> pre . "%';";
					
					if ($wpdb -> query($query)) {
						$message = __('All configuration settings have been reset to their defaults', $this -> plugin_name);
						$msg_type = 'message';
						$this -> render_msg($message);	
					} else {
						$message = __('Configuration settings could not be reset', $this -> plugin_name);
						$msg_type = 'error';
						$this -> render_err($message);
					}
					
					$this -> redirect($this -> url, $msg_type, $message);
					break;
				case 'settings' :
					if (!empty($_POST)) {
						foreach ($_POST as $pkey => $pval) {					
							$this -> update_option($pkey, $pval);
						}
						
						$message = __('Configuration has been saved', $this -> plugin_name);
						$this -> render_msg($message);
					}	
					break;
			}
		}	
		//$this -> render('settings', false, true, 'admin');
		$this -> admin_settings_page();
	}
	
	function admin_settings_page() {
		if(isset( $_REQUEST[ 'tab' ] ))	 {		
			switch ( $_REQUEST[ 'tab' ] ) {
				case 'slide':
					$tab = 'slide';
				break;
				case 'style':
					$tab = 'style';
				break;
				case 'link':
					$tab = 'link';
				break;	
				default:
					$tab = 'general';
				break;
			}
		} else
			$tab = 'general';
		?>
		<!-- ... -->
		<div class="wrap">
			<h2><?php _e('Combo Slideshow Settings', $this->plugin_name); ?></h2>
			<div class="metabox-holder has-right-sidebar">
				<div id="icon-options-general" class="icon32"></div>
				<h2 class="nav-tab-wrapper">
					<a href="<?php echo admin_url( 'edit.php?post_type=slideshow&page=settings'); ?>" class="nav-tab <?php echo ( $tab == 'general' ) ? 'nav-tab-active' : '' ?>">
						<?php echo __( 'General Settings', $this->plugin_name ); ?>
					</a>
					<a href="<?php echo ( 'edit.php?post_type=slideshow&page=settings&tab=slide') ?>" class="nav-tab <?php echo ( $tab == 'slide' ) ? 'nav-tab-active' : '' ?>">
						<?php echo __( 'Slideshow', $this->plugin_name ); ?>
					</a>
					<a href="<?php echo ( 'edit.php?post_type=slideshow&page=settings&tab=style') ?>" class="nav-tab <?php echo ( $tab == 'style' ) ? 'nav-tab-active' : '' ?>">
						<?php echo __( 'Appearance &amp; Styles', $this->plugin_name ); ?>
					</a>
					<a href="<?php echo ( 'edit.php?post_type=slideshow&page=settings&tab=link') ?>" class="nav-tab <?php echo ( $tab == 'link' ) ? 'nav-tab-active' : '' ?>">
						<?php echo __( 'Links &amp; Images Overlay', $this->plugin_name ); ?>
					</a>
				</h2>
				<div class="inner-sidebar">
				</div>
				<form action="<?php echo $_SERVER['REQUEST_URI']; //echo $this -> url; ?>" name="post" id="post" method="post">
					<div id="poststuff" class="metabox-holder">			
						<div id="post-body">
					<?php
					//$this->settings_page_sidebar();
					 
					switch ( $tab ) {
						case 'general':
							$this -> Template -> settings_general();
						break;
						case 'slide':
							$this -> Template -> settings_slides();
						break;
						case 'style':
							$this -> Template -> settings_styles();
						break;	
						case 'link':
							$this -> Template -> settings_linksimages();
						break;
					}
					?>
							<div id="save-box">
								<?php $this -> Template -> settings_submit(); ?>
							</div>
						</div>
						<br class="clear" />
					</div>
				</form>
			</div> <!-- .metabox-holder -->
			<!-- ... -->
		</div>
		<?php
	}
	function admin_head_slideshow_settings() {		
		add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($this -> Template, "settings_submit"), $this -> menus['slideshow'], 'side', 'core');
		add_meta_box('generaldiv', __('General Settings', $this -> plugin_name), array($this -> Template, "settings_general"), $this -> menus['slideshow'], 'normal', 'core');
		add_meta_box('stylesdiv', __('Appearance &amp; Styles', $this -> plugin_name), array($this -> Template, "settings_styles"), $this -> menus['slideshow'], 'normal', 'core');
		add_meta_box('linksimagesdiv', __('Links &amp; Images Overlay', $this -> plugin_name), array($this -> Template, "settings_linksimages"), $this -> menus['slideshow'], 'normal', 'core');
		
		do_action('do_meta_boxes', $this -> menus['slideshow'], 'normal');
		do_action('do_meta_boxes', $this -> menus['slideshow'], 'side');	
	}
	
	function admin_notices() {
		//$this -> check_uploaddir();
	
		if (!empty($_GET[$this -> pre . 'message'])) {		
			$msg_type = (!empty($_GET[$this -> pre . 'updated'])) ? 'msg' : 'err';
			call_user_method('render_' . $msg_type, $this, $_GET[$this -> pre . 'message']);
		}
	}
	
	function mce_buttons($buttons) {
		array_push($buttons, "separator", "slideshow");
		return $buttons;
	}
	
	function mce_external_plugins($plugins) {
		//$plugins['slideshow'] = CMBSLD_PLUGIN_URL . '/js/tinymce/editor_plugin.js';
		$plugins['slideshow'] = plugins_url( '/js/tinymce/editor_plugin.js', __FILE__ );
		return $plugins;
	}
	
	function current_screen() {
		$screen = get_current_screen();
		if($screen->post_type != 'slideshow'){
			$this -> add_filter('mce_external_plugins');
			$this -> add_filter('mce_buttons');
		}
	}
	function parse_temp_options($args) {
		$caption = $args['caption'];
		$auto = $args['auto'];
		$thumbs = $args['thumbs'];
		$nolink = $args['nolink'];
		$slides = $this -> get_option('slides');
		//$general = $this -> get_option('general');
		$general = array();
		$temps = array();
		
		$temps['information_temp'] = $slides['information'];
		$temps['thumbnails_temp'] = $slides['thumbnails'];
		$temps['autoslide_temp'] = $slides['autoslide'];
		
		if (!empty($caption)) { 
			if ($slides('information')=='Y' && $caption == 'off') {
				$temps['information_temp'] = 'N';
			} elseif ($slides('information')=='N' && $caption == 'on') {
				$temps['information_temp'] = 'Y';
			}
		}
		if (!empty($thumbs)) { 
			if ($slides('thumbnails')=='Y' && $thumbs == 'off') {
				$temps['thumbnails_temp'] = 'N';
			} elseif ($slides('thumbnails')=='N' && $thumbs == 'on') {
				$temps['thumbnails_temp'] = 'Y';
			}
		}
		if (!empty($auto)) { 
			if ($slides('autoslide')=='Y' && $auto == 'off') {
				$temps['autoslide_temp'] = 'N';
			} elseif ($slides('autoslide')=='N' && $auto == 'on') {
				$temps['autoslide_temp'] = 'Y';
			}
		}
		if (!empty($temps)) { 
			foreach($temps as $option => $value) { 
				$slides[$option] = $value; 			
			}
			$this -> update_option('slides', $slides); 
		}
		
		$links = $this -> get_option('links'); 
		if (!empty($nolink))			
			$links['imagesbox_temp'] = 'N';
		else
			$links['imagesbox_temp'] = $links['imagesbox'];
		$this -> update_option('links', $links); 
		
		return array('general'=>$general,'slides'=>$slides,'links'=>$links);
	}
	
	function get_slide_content($post, $custom, $w, $h, $exclude, $include, $size){ 
		$post_id_orig = $post -> ID;
		if (!empty($custom)) {
			if(is_bool($custom) === true) { 
				$general = $this -> get_option('general');
				$pid = $general['slide_gallery'];
				$custom = $pid;
			} elseif(is_numeric($custom))
				$pid = intval($custom);
			elseif(is_string($custom)) {
				$slideshow = get_page_by_path($custom, '', 'slideshow');
				$pid = $slideshow->ID;
			}
		} elseif (empty($slug)) {
			$pid = (empty($post_id)) ? $post -> ID : $post_id;
		} else {
			$page = get_page_by_path('$slug');
			if ($page) {
				$pid = $page->ID;
			} else {
				$page = get_page_by_path($slug, '', 'post');
				if ($page) {
					$pid = $page->ID;
				} else {
					$pid = (empty($post_id)) ? $post -> ID : $post_id;
				}
			}
		}
		$general = $this -> get_option('general');
		if ($general['postlimit'] != null && empty($limit))
			$limit = $general['postlimit'];
		$content = '';
		//if (!empty($pid) && $post = get_post($pid)) {
			if ($attachments = get_children("post_parent=" . $pid . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC")) {
					if ($limit != null)
						$attachments = array_slice($attachments,0,$limit);
					$content = $this->exclude_ids($attachments, $exclude, $include, $w, $h, $custom, $size);
			}
		//}
		$post -> ID = $post_id_orig;
		return $content;
	}
	function slideshow($output = true, $post_id = null, $exclude = null, $include = null, $custom = null, $width = null, $height = null, $thumbs = null, $caption = null, $auto = null, $nolink = null, $slug = null, $limit = null, $size = null) {
		global $wpdb, $post;
		$args = func_get_args();
		
		$opt_args = array('caption' => $caption, 'thumbs' => $thumbs, 'auto' => $auto, 'nolink' => $nolink);
		$options = $this -> parse_temp_options($opt_args);
		if (empty($w) && !empty($width))
			$w = $width;
		if (empty($h) && !empty($height))
			$h = $height;		
/*
		if ( ((! empty($width)) || (! empty($height))) ) {
		      if (CMBSLD_PRO)
			require CMBSLD_PLUGIN_DIR . 'pro/custom_sizing.php';
		}
*/
		$content = $this -> get_slide_content($post, $custom, $w, $h, $exclude, $include, $size);
		if ($output) { echo $content; } else { return $content; }
	}
	
	function embed($atts = array(), $content = null) {
		//global variables
		global $wpdb, $post;
		$defaults = array('post_id' => null, 'exclude' => null, 'include' => null, 'custom' => null, 'caption' => null, 'auto' => null, 'w' => null, 'h' => null, 'nolink' => null, 'slug' => null, 'thumbs' => null, 'limit' => null, 'size' => null, 'width' => null, 'height' => null);
		extract(shortcode_atts($defaults, $atts));
		
		$opt_args = array('caption' => $caption, 'thumbs' => $thumbs, 'auto' => $auto, 'nolink' => $nolink);
		$options = $this -> parse_temp_options ($opt_args);
		if (empty($w) && !empty($width))
			$w = $width;
		if (empty($h) && !empty($height))
			$h = $height;	
		$content = $this -> get_slide_content($post, $custom, $w, $h, $exclude, $include, $size);
		return $content;
	}
	
	function exclude_ids( $attachments, $exclude, $include, $width, $height, $custom, $size ) {
		if ( !empty( $exclude )) {
			$exclude = array_map('trim', explode(',', $exclude));
/*			echo("<script type='text/javascript'>alert('exclude! ".$exclude[0]."');</script>");*/
			foreach ( $attachments as $index => $attachment ) {
				if (in_array( $attachment->ID, $exclude )) {
					unset( $attachments[$index] );
				}
			}
		}
		elseif (!empty($include)) {
			$include = array_map('trim', explode(',', $include));
/*			echo("<script type='text/javascript'>alert('include!".$include[0]."');</script>");*/
			foreach ($attachments as $index => $attachment) {
				if (in_array($attachment->ID, $include)) {}
				else { unset($attachments[$index]); }
			}
		}
/*
		foreach ($attachments as $indexatt => $attachment) {
			//$styles = $this -> get_option('styles');
			//$combowidth = $styles['width'];
			//$comboheight = $styles['height'];
			$att_info = wp_get_attachment_image_src( $attachment->ID, 'comboslide' );
			if(!empty($att_info[1]) && $att_info[1]>=560)
			    $img_width[] = $att_info[1];
			else unset($attachments[$indexatt]);
			if(!empty($att_info[2]) && $att_info[2]>=120)
			    $img_height[] = $att_info[2];
			else unset($attachments[$indexatt]);
		}
*/

		if(empty($custom))
			$custom = false;
		if(!empty($attachments)&&count($attachments)>1)
			$content = $this -> render('gallery', array('slides' => $attachments, 'custom' => $custom, 'width' => $width, 'height' => $height, 'size' => $size), false, 'default');
		elseif(!empty($attachments)&&count($attachments)==1){
			$first = reset($attachments);
			$content = '<div class="slider-wrapper">';
			$content .= wp_get_attachment_image( $first->ID, $size );
			$content .= '</div>';
		}
		return $content;
	}	
	
}
//initialize a Gallery object
$CMBSLD_Gallery = new CMBSLD_Gallery();
?>