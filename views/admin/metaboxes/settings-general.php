<?php $styles = $this -> get_option('styles');
	$generaloptions = $this -> get_option('general'); ?>
<table class="form-table">
	<tbody>

<tr valign="top">
        <th scope="row"><?php _e('Javascript Framework', $this -> plugin_name); ?></th>
        <td>
	      <label>
	<?php $js_framework = $generaloptions['jsframe']; ?>
		<select name="general[jsframe]" id="jsframe">
		  <option onclick="jQuery('.jquery-powered').show();jQuery('.mootools-powered').hide();" value="jquery" <?php if($js_framework == 'jquery') echo 'selected="selected"'; ?>>jQuery + Nivo Slider</option>
		  <option onclick="jQuery('.jquery-powered').hide();jQuery('.mootools-powered').show();" value="mootools" <?php if($js_framework == 'mootools') echo 'selected="selected"'; ?> >MooTools + SlideShow</option>
		</select>
	      </label>
	</td>
	</tr>
    </tbody>
</table>
<div id="nivotheme_div">
   <table class="form-table">
	<tbody>    
<tr valign="top">
        <th scope="row"><?php _e('Slideshow Theme', $this -> plugin_name); ?></th>
        <td>
	      <label>
	<?php $use_themes = $generaloptions['slide_theme']; ?>
		<select name="general[slide_theme]" id="slide_theme">
		  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="0" <?php if($use_themes == '0') echo 'selected="selected"'; ?> ><?php _e('no theme', $this -> plugin_name); ?></option>
		  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="default" <?php if($use_themes == 'default') echo 'selected="selected"'; ?> ><?php _e('default', $this -> plugin_name); ?></option>
		  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="orman" <?php if($use_themes == 'orman') echo 'selected="selected"'; ?> >orman</option>
		  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="pascal" <?php if($use_themes == 'pascal') echo 'selected="selected"'; ?> >pascal</option>
		  <option onclick="jQuery('#nivocustomtheme_div').show();" value="custom" <?php if($use_themes == 'custom') echo 'selected="selected"'; ?> ><?php _e('custom CSS', $this -> plugin_name); ?></option>
		</select>
	      </label>
	</td>
	</tr>
    </tbody>
</table>
</div>
<div id="nivocustomtheme_div" style="display:<?php echo ($generaloptions['slide_theme'] == "custom") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
	<tr valign="top">
        <th scope="row"><?php _e('Custom Theme CSS location', $this -> plugin_name); ?></th>
	<td>
        <label>
        <input type="text" name="general[customtheme]" id="customtheme" size="8" value="<?php echo $generaloptions['customtheme']; ?>" />
        </label>
	<span class="howto"><?php _e('name of both the current theme sub-folder and the CSS file', $this -> plugin_name); ?><br/><?php _e('e.g. use "custom" for /mytheme/custom/custom.css', $this -> plugin_name); ?></span>
	</td>
	</tr>
    </tbody>
</table>
</div>
   <table class="form-table">
	<tbody>
        <tr valign="top">
        <th scope="row"><?php _e('Auto insert in Home page', $this -> plugin_name); ?></th>
        <td>
	      <label><input <?php echo ($generaloptions['wpns_home'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_home]" value="N" id="wpns_homeN" /> <?php _e('No', $this -> plugin_name); ?></label>
	      <label><input <?php echo ($generaloptions['wpns_home'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_home]" value="Y" id="wpns_homeY" /> <?php _e('Blog', $this -> plugin_name); ?></label>
	      <label><input <?php echo ($generaloptions['wpns_home'] == "C") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_home]" value="C" id="wpns_homeC" /> <?php _e('Custom Slides', $this -> plugin_name); ?></label>
	</td>
	</tr>
	<tr valign="top">
        <th scope="row"><?php _e('Auto insert in post / page', $this -> plugin_name); ?></th>
        <td>
	      <label><input <?php echo ($generaloptions['wpns_auto'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto]" value="N" id="wpns_autoN" /> <?php _e('No', $this -> plugin_name); ?></label>
	      <label><input <?php echo ($generaloptions['wpns_auto'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto]" value="Y" id="wpns_autoY" /> <?php _e('Gallery', $this -> plugin_name); ?></label>
	      <label><input <?php echo ($generaloptions['wpns_auto'] == "C") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto]" value="C" id="wpns_autoC" /> <?php _e('Custom Slides', $this -> plugin_name); ?></label>
	</td>
	</tr>
	<tr valign="top">
        <th scope="row"><?php _e('Auto slideshow position', $this -> plugin_name); ?></th>
        <td>
	      <label><input <?php echo ($generaloptions['wpns_auto_position'] == "B") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto_position]" value="B" id="wpns_positionB" /> <?php _e('Before the content', $this -> plugin_name); ?></label>
	      <label><input <?php echo ($generaloptions['wpns_auto_position'] == "A") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto_position]" value="A" id="wpns_positionA" /> <?php _e('After the content', $this -> plugin_name); ?></label>
	</td>
	</tr>
	<tr valign="top">
        <th scope="row"><?php _e('Category', $this -> plugin_name); ?></th>
        <td>
        <select name="general[wpns_category][]" id="wpns_category" multiple> 
 			<?php 
 				$category = $generaloptions['wpns_category'];
  				$categories=  get_categories(); 
				//echo '<option value="">'.__('select a category', $this -> plugin_name).'</option>';
  				foreach ($categories as $cat) {
  					$option = '<option value="'.$cat->term_id.'"';
  					if (in_array($cat->term_id,$category)||$category == $cat->term_id) 
						$option .= ' selected="selected">';
  					else { $option .= '>'; }
					$option .= $cat->cat_name;
					$option .= ' ('.$cat->category_count.')';
					$option .= '</option>';
					echo $option;
  				}
 			?>
	</select>
	</td>
	</tr>
	<tr valign="top">
        <th scope="row"><?php _e('Custom Slideshow selection', $this -> plugin_name); ?></th>
        <td>
        <select name="general[slide_gallery]" id="slide_gallery"> 
			<option value=""><?php _e('select a gallery', $this -> plugin_name); ?></option> 
 			<?php 
 				$gallery = $generaloptions['slide_gallery'];
  				$galleries =  get_posts(array('post_type'=>'slideshow'));
  				foreach ($galleries as $gall) {
					$gallery_count = count(get_children("post_parent=" . $gall->ID . "&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC"));
  					$option = '<option value="'.$gall->ID.'"';
  					if ($gallery == $gall->ID) $option .= ' selected="selected">';
  					else { $option .= '>'; }
					$option .= $gall->post_title;
					$option .= ' ('.$gallery_count.')';
					$option .= '</option>';
					echo $option;
  				}
 			?>
	</select>
	</td>
	</tr>
    	<tr valign="top">
        <th scope="row"><?php _e('Post limit', $this -> plugin_name); ?></th>
	    <td>
		<label>
		    <input type="text" name="general[postlimit]" id="postlimit" size="7" value="<?php echo $generaloptions['postlimit']; ?>" />
		</label>
	    </td>
	</tr>
	</tr>
    	<tr valign="top">
        <th scope="row"><?php _e('Exclude', $this -> plugin_name); ?></th>
	    <td>
		<label>
		    <input type="text" name="general[exclude]" id="exclude" size="7" value="<?php echo $generaloptions['exclude']; ?>" />
		</label>
	    </td>
	</tr>
	</tr>
    	<tr valign="top">
        <th scope="row"><?php _e('Offset', $this -> plugin_name); ?></th>
	    <td>
		<label>
		    <input type="text" name="general[offset]" id="offset" size="7" value="<?php echo $generaloptions['offset']; ?>" />
		</label>
	    </td>
	</tr>
    </tbody>
  </table>