<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="imagesbox_N"><?php _e('Open Images in...', $this -> plugin_name); ?></label></th>
            <td>
	      <label>
		<select name="imagesbox" id="imagesbox">
                <option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "N") ? 'selected="selected"' : ''; ?> name="imagesbox" value="N" id="imagesbox_N" /> <?php _e('No Link', $this -> plugin_name); ?></option>
                <option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "W") ? 'selected="selected"' : ''; ?> name="imagesbox" value="W" id="imagesbox_W" /> <?php _e('Window', $this -> plugin_name); ?></option>
            	<option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "T") ? 'selected="selected"' : ''; ?> name="imagesbox" value="T" id="imagesbox_T" /> <?php _e('Thickbox', $this -> plugin_name); ?></option>
            	<option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "S") ? 'selected="selected"' : ''; ?> name="imagesbox" value="S" id="imagesbox_S" /> <?php _e('Shadowbox', $this -> plugin_name); ?></option>
            	<option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "P") ? 'selected="selected"' : ''; ?> name="imagesbox" value="P" id="imagesbox_P" /> <?php _e('PrettyPhoto', $this -> plugin_name); ?></option>
		<option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "L") ? 'selected="selected"' : ''; ?> name="imagesbox" value="L" id="imagesbox_L" /> <?php _e('Lightbox', $this -> plugin_name); ?></option>
		<option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "F") ? 'selected="selected"' : ''; ?> name="imagesbox" value="F" id="imagesbox_F" /> <?php _e('Fancybox', $this -> plugin_name); ?></option>
		<option onclick="jQuery('#nivocustombox_div').hide();" <?php echo ($this -> get_option('imagesbox') == "M") ? 'selected="selected"' : ''; ?> name="imagesbox" value="M" id="imagesbox_M" /> <?php _e('Multibox', $this -> plugin_name); ?></option>
		<option onclick="jQuery('#nivocustombox_div').show();" <?php echo ($this -> get_option('imagesbox') == "custom") ? 'selected="selected"' : ''; ?> name="imagesbox" value="custom" id="imagesbox_C" /> <?php _e('custom', $this -> plugin_name); ?></option>
		</select>
	      </label>
	      <span class="howto"><?php _e('Thickbox comes standard with your Wordpress install. Others come only with a specific theme or plugin', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>
<div id="nivocustombox_div" style="display:<?php echo ($this -> get_option('imagesbox') == "custom") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
	<tr valign="top">
        <th scope="row"><?php _e('Custom class', $this -> plugin_name); ?></th>
	<td>
        <label>
        <input type="text" name="custombox" id="custombox" size="8" value="<?php echo $this -> get_option('custombox'); ?>" />
        </label>
	<span class="howto"><?php _e('name of the class used by the lightbox script', $this -> plugin_name); ?></span>
	</td>
	</tr>
    </tbody>
</table>
</div>
   <table class="form-table">
	<tbody>   
		<tr>
			<th><?php _e('Recommendations', $this -> plugin_name); ?></th>
			<td>
				<div><a href="http://wordpress.org/extend/plugins/fancybox-for-wordpress/">FancyBox for Wordpress</a></div>
				<div><a href="http://wordpress.org/extend/plugins/wp-multibox/">WP Multibox</a></div>
			</td>
		</tr>
		<tr>
        	<th><label for="pagelink_N"><?php _e('Page Link Target', $this -> plugin_name); ?></label></th>
		<td>
                <label><input <?php echo ($this -> get_option('pagelink') == "S") ? 'checked="checked"' : ''; ?> type="radio" name="pagelink" value="S" id="pagelink_S" /> <?php _e('Current Tab', $this -> plugin_name); ?></label>
            	<label><input <?php echo ($this -> get_option('pagelink') == "B") ? 'checked="checked"' : ''; ?> type="radio" name="pagelink" value="B" id="pagelink_B" /> <?php _e('New Tab', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Same as setting that <em>target</em> pages are &quot;_self&quot; or &quot;_blank&quot;', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>