<?php
/*
Plugin Name: Combo Slideshow
Plugin URI: http://www.3dolab.net/en
Author: 3dolab
Author URI: http://www.3dolab.net
Description: The features of the best slideshow javascript effects and WP plugins. Blog posts highlights, image gallery, custom slides!
Version: 1.7
*/
define('DS', DIRECTORY_SEPARATOR);
define( 'CMBSLD_VERSION', '1.6' );
if ( ! defined( 'CMBSLD_PLUGIN_BASENAME' ) )
	define( 'CMBSLD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'CMBSLD_PLUGIN_NAME' ) )
	define( 'CMBSLD_PLUGIN_NAME', trim( dirname( CMBSLD_PLUGIN_BASENAME ), '/' ) );
if ( ! defined( 'CMBSLD_PLUGIN_DIR' ) )
	define( 'CMBSLD_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . CMBSLD_PLUGIN_NAME );
if ( ! defined( 'CMBSLD_PLUGIN_URL' ) )
	define( 'CMBSLD_PLUGIN_URL', WP_PLUGIN_URL . '/' . CMBSLD_PLUGIN_NAME );
if ( ! defined( 'CMBSLD_UPLOAD_URL' ) )
	define( 'CMBSLD_UPLOAD_URL', get_bloginfo('wpurl')."/wp-content/uploads/". CMBSLD_PLUGIN_NAME );
if ( ! file_exists( CMBSLD_PLUGIN_DIR . '/pro/' ) )
	define( 'CMBSLD_PRO', false );
else
	define( 'CMBSLD_PRO', true );
	
require_once CMBSLD_PLUGIN_DIR . '/combo-slideshow-plugin.php';
 add_theme_support('post-thumbnails');
// add_filter( 'the_content', 'auto_combo_slider' );
	
class CMBSLD_Gallery extends CMBSLD_GalleryPlugin {
	function __construct() {
		$url = explode("&", $_SERVER['REQUEST_URI']);
		$this -> url = $url[0];
		
		$this -> register_plugin('combo-slideshow', __FILE__);
		
		//WordPress action hooks
		$this -> add_action('admin_menu');
		$this -> add_action('admin_head');
		$this -> add_action('admin_notices');
		// $this -> add_action('cmbsld_enqueue_styles');
		
		//WordPress filter hooks
		$this -> add_filter('mce_buttons');
		$this -> add_filter('mce_external_plugins');
		$this -> add_filter( 'the_content', 'auto_combo_slider' );
		// $this -> add_theme_support('post-thumbnails');
		$this -> add_filter('attachment_fields_to_edit', 'my_image_attachment_fields_to_edit', null, 2);
		$this -> add_filter('attachment_fields_to_save', 'my_image_attachment_fields_to_save', null, 2);
$styles = $this -> get_option('styles');
$crop = $this -> get_option('thumb_crop') ? true : false;
$combowidth = $styles['width'];
$comboheight = $styles['height'];
		add_image_size( 'comboslide', $combowidth, $comboheight, $crop );
		add_shortcode('slideshow', array($this, 'embed'));
	}
	function auto_combo_slider( $content ) {
	    if ( ( ( is_home() || is_front_page() ) && $this -> get_option('wpns_home') == 'Y' ) ){
		  $comboslidercode = $this -> show_combo_slider();
	    } elseif (  $this -> get_option('wpns_auto') == 'Y' ){
		  $comboslidercode = $this -> embed();
	    } elseif ( ( ( is_home() || is_front_page() ) && $this -> get_option('wpns_home') == 'C' ) || $this -> get_option('wpns_auto') == 'C' ){
		  //$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"), $this -> get_option('postlimit'));
		  //$comboslidercode = $this -> render('gallery', array('slides' => $slides, 'frompost' => false), false, 'default');
		  $slideshow_id = $this -> get_option('slide_gallery');
		  $comboslidercode = $this -> embed(array('custom'=>$slideshow_id));
	    } else {
		  return $content;
	    }
	    if ($this -> get_option('wpns_auto_position') == 'B')
		  $content = $comboslidercode.$content;
	    elseif ($this -> get_option('wpns_auto_position') == 'A')
		  $content = $content.$comboslidercode;
	    return $content;
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
	/*
		add_menu_page(__('Combo Slideshow', $this -> plugin_name), __('Combo Slideshow', $this -> plugin_name), 'edit_others_posts', "slideshow", array($this, 'admin_settings'), CMBSLD_PLUGIN_URL . '/images/icon.png');
		$this -> menus['slideshow'] = add_submenu_page("slideshow", __('Configuration', $this -> plugin_name), __('Configuration', $this -> plugin_name), 'manage_options', "slideshow", array($this, 'admin_settings'));
		$this -> menus['slideshow-slides'] = add_submenu_page("slideshow", __('Manage Slides', $this -> plugin_name), __('Manage Slides', $this -> plugin_name), 'edit_others_posts', "slideshow-slides", array($this, 'admin_slides'));		
	*/
		//$this -> menus['slideshow'] = add_submenu_page('options-general.php', __('Combo Slideshow', $this -> plugin_name), __('Combo Slideshow', $this -> plugin_name), 'edit_others_posts', 'slideshow', array($this, 'admin_settings'));
		$this -> menus['slideshow'] = add_submenu_page('edit.php?post_type=slideshow', __('Combo Slideshow Settings', $this -> plugin_name), __('Settings', $this -> plugin_name), 'edit_others_posts', 'settings', array($this, 'admin_settings'));
		//$this -> menus['slideshow'] = add_menu_page(__('Combo Slideshow', $this -> plugin_name), __('Combo Slideshow', $this -> plugin_name), 'edit_others_posts', "slideshow", array($this, 'admin_settings'), CMBSLD_PLUGIN_URL . '/images/icon.png');
		add_action('admin_head-' . $this -> menus['slideshow'], array($this, 'admin_head_slideshow_settings'));
	}
	
	function admin_head() {
		$this -> render('head', false, true, 'admin');
	}
	
	function admin_head_slideshow_settings() {		
		add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($this -> Metabox, "settings_submit"), $this -> menus['slideshow'], 'side', 'core');
		add_meta_box('generaldiv', __('General Settings', $this -> plugin_name), array($this -> Metabox, "settings_general"), $this -> menus['slideshow'], 'normal', 'core');
		add_meta_box('stylesdiv', __('Appearance &amp; Styles', $this -> plugin_name), array($this -> Metabox, "settings_styles"), $this -> menus['slideshow'], 'normal', 'core');
		add_meta_box('linksimagesdiv', __('Links &amp; Images Overlay', $this -> plugin_name), array($this -> Metabox, "settings_linksimages"), $this -> menus['slideshow'], 'normal', 'core');
		
		do_action('do_meta_boxes', $this -> menus['slideshow'], 'normal');
		do_action('do_meta_boxes', $this -> menus['slideshow'], 'side');	
	}
	
	function admin_notices() {
		$this -> check_uploaddir();
	
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
		$plugins['slideshow'] = CMBSLD_PLUGIN_URL . '/js/tinymce/editor_plugin.js';
		return $plugins;
	}

	function slideshow($output = true, $post_id = null, $exclude = null, $include = null, $custom = null, $width = null, $height = null, $thumbs = null, $caption = null, $auto = null, $nolink = null, $slug = null, $limit = null, $size = null) {
//	function slideshow() {
	
		$args = func_get_args();
		global $wpdb, $post;
		$post_id_orig = $post -> ID;

		if ($this -> get_option('information')=='Y') { $this -> update_option('information_temp', 'Y'); }
		elseif ($this -> get_option('information')=='N') { $this -> update_option('information_temp', 'N'); }
		if ($this -> get_option('thumbnails')=='Y') { $this -> update_option('thumbnails_temp', 'Y'); }
		elseif ($this -> get_option('thumbnails')=='N') { $this -> update_option('thumbnails_temp', 'N'); }
		if ($this -> get_option('autoslide')=='Y') { $this -> update_option('autoslide_temp', 'Y'); }
		elseif ($this -> get_option('autoslide')=='N') { $this -> update_option('autoslide_temp', 'N'); }

		if (!empty($caption)) { 
			if (($this -> get_option('information')=='Y') && ($caption == 'off')) {
				$this -> update_option('information_temp', 'N');	
			} elseif (($this -> get_option('information')=='N') && ($caption == 'on')) {
				$this -> update_option('information_temp', 'Y');
			}
		}
		if (!empty($thumbs)) { 
			if (($this -> get_option('thumbnails')=='Y') && ($thumbs == 'off')) {
				$this -> update_option('thumbnails_temp', 'N');
			} elseif (($this -> get_option('thumbnails')=='N') && ($thumbs == 'on')) {
				$this -> update_option('thumbnails_temp', 'Y');
			}
		}
		if (!empty($auto)) { 
			if (($this -> get_option('autoslide')=='Y') && ($auto == 'off')) {
				$this -> update_option('autoslide_temp', 'N');	
			} elseif (($this -> get_option('autoslide')=='N') && ($auto == 'on')) {
				$this -> update_option('autoslide_temp', 'Y');
			}
		} elseif ($this -> get_option('autoslide') == 'Y') { 
			$this -> update_option('autoslide_temp', 'Y'); 
		} else {
			$this -> update_option('autoslide_temp', 'N'); 
		}
		if (!empty($nocaption)) { $this -> update_option('information', 'N'); }
		if (!empty($nolink)) { $this -> update_option('linker', 'N'); }
			else { $this -> update_option('linker', 'Y'); }

		if ( ((! empty($width)) || (! empty($height))) ) {
		      if (CMBSLD_PRO)
			require CMBSLD_PLUGIN_DIR . '/pro/custom_sizing.php';
		}
//		$this -> add_action( 'wp_print_styles', 'gs_enqueue_styles' );

/*
		if (!empty($custom) && empty($post_id) && empty($slug)) {
		//elseif ( ! empty( $custom ) ){
			if ($limit != null)
			  $slides = $this -> Slide -> find_all(null, null, array('order', "ASC"), $limit);
			else
			  $slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));
			$content = $this -> render('gallery', array('slides' => $slides, 'frompost' => false, 'width' => $width, 'height' => $height, 'size' => $size), false, 'default');
		} else {
*/
			if (!empty($custom)) {
				if(is_bool($custom) === true) {
					$pid = $this -> get_option('slide_gallery');
					$custom = $pid;
				} elseif(is_numeric($custom))
					$pid = int($custom);
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

		//if ( ! empty($post_id) && $post = get_post($post_id)) {
			if ($attachments = get_children("post_parent=" . $pid . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC")) {
				if ($limit != null)
					$attachments = array_slice($attachments,0,$limit);
				$content = $this -> exclude_ids($attachments, $exclude, $include, $width, $height, $custom, $size);
			}
		//}
/*		elseif ( ! empty( $custom ) && is_numeric($custom) ) {
			$slides = $this -> Slide -> find_all(array('section'=>(int) stripslashes($custom)), null, array('order', "ASC"));
			$content = $this -> render('gallery', array('slides' => $slides, 'frompost' => false), false, 'default');
		}*/
		
		$post -> ID = $post_id_orig;
		if ($output) { echo $content; } else { return $content; }
	}
	function embed($atts = array(), $content = null) {
		//global variables
		global $wpdb;
		$defaults = array('post_id' => null, 'exclude' => null, 'include' => null, 'custom' => null, 'caption' => null, 'auto' => null, 'w' => null, 'h' => null, 'nolink' => null, 'slug' => null, 'thumbs' => null, 'limit' => null, 'size' => null, 'width' => null, 'height' => null);
		extract(shortcode_atts($defaults, $atts));
		// This section allows for using _temp variable only (esp in gallery.php)
		if ($this -> get_option('information')=='Y') { $this -> update_option('information_temp', 'Y'); }
		elseif ($this -> get_option('information')=='N') { $this -> update_option('information_temp', 'N'); }
		if ($this -> get_option('thumbnails')=='Y') { $this -> update_option('thumbnails_temp', 'Y'); }
		elseif ($this -> get_option('thumbnails')=='N') { $this -> update_option('thumbnails_temp', 'N'); }
		if ($this -> get_option('autoslide')=='Y') { $this -> update_option('autoslide_temp', 'Y'); }
		elseif ($this -> get_option('autoslide')=='N') { $this -> update_option('autoslide_temp', 'N'); }
		if ($this -> get_option('postlimit') != null && empty($limit))
			$limit = $this -> get_option('postlimit');
		if (empty($w) && !empty($width))
			$w = $width;
		if (empty($h) && !empty($height))
			$h = $height;
		if (!empty($caption)) { 
			if (($this -> get_option('information')=='Y') && ($caption == 'off')) {
				$this -> update_option('information_temp', 'N');	
			} elseif (($this -> get_option('information')=='N') && ($caption == 'on')) {
				$this -> update_option('information_temp', 'Y');
			}
		}
		if (!empty($thumbs)) { 
			if (($this -> get_option('thumbnails')=='Y') && ($thumbs == 'off')) {
				$this -> update_option('thumbnails_temp', 'N');
			} elseif (($this -> get_option('thumbnails')=='N') && ($thumbs == 'on')) {
				$this -> update_option('thumbnails_temp', 'Y');
			}
		}
		if (!empty($auto)) { 
			if (($this -> get_option('autoslide')=='Y') && ($auto == 'off')) {
				$this -> update_option('autoslide_temp', 'N');	
			} elseif (($this -> get_option('autoslide')=='N') && ($auto == 'on')) {
				$this -> update_option('autoslide_temp', 'Y');
			}
		} elseif ($this -> get_option('autoslide') == 'Y') { 
			$this -> update_option('autoslide_temp', 'Y'); 
		} else {
			$this -> update_option('autoslide_temp', 'N'); 
		}
		/******** PRO ONLY **************/
		if ( CMBSLD_PRO ) {
			require CMBSLD_PLUGIN_DIR . '/pro/custom_sizing.php';
		}
		//$this -> add_action(array($this, 'pro_custom_wh'));
		/******** END PRO ONLY **************/
		if (!empty($nocaption)) { $this -> update_option('information', 'N'); }
		if (!empty($nolink)) { $this -> update_option('linker', 'N'); }
			else { $this -> update_option('linker', 'Y'); }
/*
		if (!empty($custom) && empty($post_id) && empty($slug)) {
			  if ($limit != null)
			  $slides = $this -> Slide -> find_all(null, null, array('order', "ASC"), $limit);
			  else
			  $slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));
			  $content = $this -> render('gallery', array('slides' => $slides, 'frompost' => false, 'width' => $w, 'height' => $h, 'size' => $size), false, 'default');
//			} 
		} else }
*/
			global $post;
			$post_id_orig = $post -> ID;
			if (!empty($custom)) {
				if(is_bool($custom) === true) { 
					$pid = $this -> get_option('slide_gallery');
					$custom = $pid;
				} elseif(is_numeric($custom))
					$pid = int($custom);
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
			//if (!empty($pid) && $post = get_post($pid)) {
				if ($attachments = get_children("post_parent=" . $pid . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC")) {
						if ($limit != null)
							$attachments = array_slice($attachments,0,$limit);
						$content = $this->exclude_ids($attachments, $exclude, $include, $w, $h, $custom, $size);
				}
			//}
			$post -> ID = $post_id_orig;
		//}
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
		if(!empty($attachments))
			$content = $this -> render('gallery', array('slides' => $attachments, 'custom' => $custom, 'width' => $width, 'height' => $height, 'size' => $size), false, 'default');
		return $content;
	}	
	
	function admin_slides() {	
		switch ($_GET['method']) {
			case 'delete'			:
				if (!empty($_GET['id'])) {
					if ($this -> Slide -> delete($_GET['id'])) {
						$msg_type = 'message';
						$message = __('Slide has been removed', $this -> plugin_name);
					} else {
						$msg_type = 'error';
						$message = __('Slide cannot be removed', $this -> plugin_name);	
					}
				} else {
					$msg_type = 'error';
					$message = __('No slide was specified', $this -> plugin_name);
				}
				
				$this -> redirect($this -> referer, $msg_type, $message);
				break;
			case 'save'				:
				if (!empty($_POST)) {
					if ($this -> Slide -> save($_POST, true)) {
						$message = __('Slide has been saved', $this -> plugin_name);
						$this -> redirect($this -> url, "message", $message);
					} else {
						$this -> render('slides' . DS . 'save', false, true, 'admin');
					}
				} else {
					$this -> Db -> model = $this -> Slide -> model;
					$this -> Slide -> find(array('id' => $_GET['id']));
					$this -> render('slides' . DS . 'save', false, true, 'admin');
				}
				break;
			case 'mass'				:
				if (!empty($_POST['action'])) {
					if (!empty($_POST['Slide']['checklist'])) {						
						switch ($_POST['action']) {
							case 'delete'				:							
								foreach ($_POST['Slide']['checklist'] as $slide_id) {
									$this -> Slide -> delete($slide_id);
								}
								
								$message = __('Selected slides have been removed', $this -> plugin_name);
								$this -> redirect($this -> url, 'message', $message);
								break;
						}
					} else {
						$message = __('No slides were selected', $this -> plugin_name);
						$this -> redirect($this -> url, "error", $message);
					}
				} else {
					$message = __('No action was specified', $this -> plugin_name);
					$this -> redirect($this -> url, "error", $message);
				}
				break;
			case 'order'			:
				$slides = $this -> Slide -> find_all(null, null, array('order', "ASC"));
				$this -> render('slides' . DS . 'order', array('slides' => $slides), true, 'admin');
				break;
			default					:
				$data = $this -> paginate('Slide');				
				$this -> render('slides' . DS . 'index', array('slides' => $data[$this -> Slide -> model], 'paginate' => $data['Paginate']), true, 'admin');
				break;
		}
	}
	
	function admin_settings() {
		switch ($_GET['method']) {
			case 'reset'			:
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
			default					:
				if (!empty($_POST)) {
					foreach ($_POST as $pkey => $pval) {					
						$this -> update_option($pkey, $pval);
					}
					
					$message = __('Configuration has been saved', $this -> plugin_name);
					$this -> render_msg($message);
				}	
				break;
		}
				
		$this -> render('settings', false, true, 'admin');
	}
	
}
//initialize a Gallery object
$CMBSLD_Gallery = new CMBSLD_Gallery();
?>