<?php
class Template extends CMBSLD_GalleryPlugin {
	var $name = 'Template';
	
	function Template() {
		$url = explode("&", $_SERVER['REQUEST_URI']);
		$this -> url = $url[0];
	}
	function settings_submit() {
		$this -> render('metaboxes' . DS . 'settings-submit', false, true, 'admin');
	}
	
	function settings_general() {
		$this -> render('metaboxes' . DS . 'settings-general', false, true, 'admin');
	}
	
	function settings_linksimages() {
		$this -> render('metaboxes' . DS . 'settings-linksimages', false, true, 'admin');	
	}
	
	function settings_styles() {
		$this -> render('metaboxes' . DS . 'settings-styles', false, true, 'admin');
	}
	
	function settings_slides() {
		$this -> render('metaboxes' . DS . 'settings-slides', false, true, 'admin');
	}
}
?>