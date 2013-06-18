<?php
global $post, $post_ID;
$post_ID = 1;
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
?>
<div class="wrap">
	<h2><?php _e('Configuration Settings', CMBSLD_PLUGIN_NAME); ?></h2>
	
	<form action="<?php echo $_SERVER['REQUEST_URI']; //echo $this -> url; ?>" name="post" id="post" method="post">
		<div id="poststuff" class="metabox-holder">			
			<div id="post-body">
					<?php do_meta_boxes($this -> menus['slideshow'], 'normal', $post); ?>
			</div>
			<div id="save-box">		
				<?php do_meta_boxes($this -> menus['slideshow'], 'side', $post); ?>
                <?php do_action('submitpage_box'); ?>
			</div>
			<br class="clear" />
			
		</div>
	</form>
</div>