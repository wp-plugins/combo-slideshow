<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
	
$pre = 'Gallery';
$tabs = array( 
		'general' => $general, 
		'slides' => $slides, 
		'slidestyles' => $slidestyles, 
		'styles' => $styles, 
		'links' => $links );
foreach($tabs as $name => $tab)
	delete_option($pre.$name, $tab);
?>