<?php $styles = $this -> get_option('styles');
	$generaloptions = $this -> get_option('general');
	$crop =  $styles['crop']; ?>
<span class="howto"><strong><?php _e('* Tip: make the best use of the slideshow by loading always content of the same dimensions', $this -> plugin_name); ?>
<br />
<?php _e('and setting the size of the frame (as well as the CSS rules) accordingly.', $this -> plugin_name); ?></strong>
<br />
<?php _e('Pay attention when using slideshow themes as you could have to adjust the image size.', $this -> plugin_name); ?>
<br />
<?php _e('Feel free play around with values but sorry, no support is provided on this matter.', $this -> plugin_name); ?></span>
<div id="resizeimages_div">
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="styles.resizeimages"><?php _e('Resize Images (width)', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#ryanfimgsize_div').show();" <?php echo (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages]" value="Y" id="styles.resizeimages_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#ryanfimgsize_div').hide();" <?php echo ($styles['resizeimages'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages]" value="N" id="styles.resizeimages_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Should images be resized proportionally to fit the width of the slideshow area', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <?php if ( CMBSLD_PRO ) { $resize2 = "type='radio'"; } else { 
			//$resize2 = "type='radio' disabled";
			$resize2 = "type='radio'"; 
			//$styles['resizeimages2'] = "N";
			}?>        
		<tr>
			<th><label for="styles.resizeimages2"><?php _e('Resize Images (height)', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#ryanfimgsize_div').show();" <?php echo ($styles['resizeimages2'] == "Y") ? 'checked="checked"' : ''; ?> <?php echo ($resize2); ?> name="styles[resizeimages2]" value="Y" id="styles.resizeimages_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#ryanfimgsize_div').hide();" <?php echo (empty($styles['resizeimages2']) || $styles['resizeimages2'] == "N") ? 'checked="checked"' : ''; ?>  <?php echo ($resize2); ?> name="styles[resizeimages2]" value="N" id="styles.resizeimages2_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Should images be resized proportionally to fit the height of the slideshow area. ', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="crop_thumbs"><?php _e('Crop Images', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($crop == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[crop]" value="Y" id="crop_thumbs_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo (empty($crop) || $crop == "N") ? 'checked="checked"' : ''; ?>  type="radio" name="styles[crop]" value="N" id="crop_thumbs_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Should images be cropped to fit the height of the slideshow area. ', $this -> plugin_name); ?></span>
			</td>
		</tr>
    </tbody>
</table>
</div>
<div id="ryanfimgsize_wrapper">
<div id="ryanfimgsize_div" style="display:<?php echo ($styles['resizeimages'] == "Y" || $styles['resizeimages2'] == "Y" ) ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody> 
		<tr> 
			<th><label for="styles.height"><?php _e('Slide Images Dimensions', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.wpns_width" type="text" name="styles[wpns_width]" value="<?php echo $styles['wpns_width']; ?>" /> x 
				<input style="width:45px;" id="styles.wpns_height" type="text" name="styles[wpns_height]" value="<?php echo $styles['wpns_height']; ?>" /> 
				<?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('width and height of the sliding img elements', $this -> plugin_name); ?></span>
				<span class="howto jquery-powered" style="display:<?php echo ($generaloptions['jsframe'] == "jquery") ? 'inline' : 'none'; ?>;">
				<?php _e('with jQuery Nivo Slider this setting will only force the frame to crop the slide (as its background image)', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
    </table>
</div>
</div>
   <table class="form-table">
	<tbody>
		<tr>
			<th><label for="styles.width"><?php _e('Gallery Dimensions', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.width" type="text" name="styles[width]" value="<?php echo $styles['width']; ?>" /> x 
				<input style="width:45px;" id="styles.height" type="text" name="styles[height]" value="<?php echo $styles['height']; ?>" /> 
				<?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('width and height of the slideshow gallery', $this -> plugin_name); ?></span>
				<span class="howto jquery-powered" style="display:<?php echo ($generaloptions['jsframe'] == "jquery") ? 'inline' : 'none'; ?>;">
				<?php _e('jQuery Nivo Slider does not resize images so make sure the source files have the same size otherwise the frame will be enlarged accordingly', $this -> plugin_name); ?></span>
			</td>
		</tr>  
		<tr>
			<th><label for="styles.background"><?php _e('Slideshow Background', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[background]" value="<?php echo $styles['background']; ?>" id="styles.background" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infobackground"><?php _e('Caption Background', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[infobackground]" value="<?php echo $styles['infobackground']; ?>" id="styles.infobackground" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infocolor"><?php _e('Caption Text Color', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[infocolor]" value="<?php echo $styles['infocolor']; ?>" id="styles.infocolor" style="width:65px;" />
			</td>
		</tr>
	</tbody>
</table>