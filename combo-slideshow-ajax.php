<?php
if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
$root = __FILE__;
for ($i = 0; $i < 4; $i++) $root = dirname($root);
require_once($root . DS . 'wp-config.php');
require_once(ABSPATH . 'wp-admin' . DS . 'admin-functions.php');
class CMBSLD_Ajax extends CMBSLD_GalleryPlugin {
	var $safecommands = array('slides_order');
	function CMBSLD_Ajax($cmd) {
		$this -> register_plugin('combo-slideshow', __FILE__);
		if (!empty($cmd)) {		
			if (in_array($cmd, $this -> safecommands) || current_user_can('edit_plugins')) {			
				if (method_exists($this, $cmd)) {
					$this -> $cmd();
				}
			}
		}
	}
	function slides_order() {
		if (!empty($_REQUEST['item'])) {
			foreach ($_REQUEST['item'] as $order => $slide_id) {
				$this -> Slide -> save_field('order', $order, array('id' => $slide_id));
			}
		
			?><br/><div style="color:red;"><?php _e('Slides have been ordered', $this -> plugin_name); ?></div><?php
		}
	}
}
$CMBSLD_Ajax = new CMBSLD_Ajax($_GET['cmd']);
?>