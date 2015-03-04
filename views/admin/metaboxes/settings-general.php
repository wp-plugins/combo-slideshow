<?php $generaloptions = $this -> get_option('general'); ?>
<input type="hidden" name="general[version]" value="1.91" id="version" />
<table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e('Javascript Framework', $this -> plugin_name); ?></th>
			<td>
				<?php $js_framework = $generaloptions['jsframe']; ?>
				<select name="general[jsframe]" id="jsframe">
				  <option onclick="jQuery('.jquery-powered').show();jQuery('.mootools-powered').hide();" value="jquery" <?php if($js_framework == 'jquery') echo 'selected="selected"'; ?>>jQuery + Nivo Slider</option>
				  <option onclick="jQuery('.jquery-powered').hide();jQuery('.mootools-powered').show();" value="mootools" <?php if($js_framework == 'mootools') echo 'selected="selected"'; ?> >MooTools + SlideShow</option>
				</select>
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
				<?php $use_themes = $generaloptions['slide_theme']; ?>
				<select name="general[slide_theme]" id="slide_theme">
				  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="0" <?php if($use_themes == '0') echo 'selected="selected"'; ?> ><?php _e('no theme', $this -> plugin_name); ?></option>
				  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="default" <?php if($use_themes == 'default') echo 'selected="selected"'; ?> ><?php _e('default', $this -> plugin_name); ?></option>
				  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="orman" <?php if($use_themes == 'orman') echo 'selected="selected"'; ?> >orman</option>
				  <option onclick="jQuery('#nivocustomtheme_div').hide();" value="pascal" <?php if($use_themes == 'pascal') echo 'selected="selected"'; ?> >pascal</option>
				  <option onclick="jQuery('#nivocustomtheme_div').show();" value="custom" <?php if($use_themes == 'custom') echo 'selected="selected"'; ?> ><?php _e('custom CSS', $this -> plugin_name); ?></option>
				</select>
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
					<input type="text" name="general[customtheme]" id="customtheme" size="8" value="<?php echo $generaloptions['customtheme']; ?>" />
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
			  <input <?php echo ($generaloptions['wpns_home'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_home]" value="N" id="wpns_homeN" /> <?php _e('No', $this -> plugin_name); ?>
			  <input <?php echo ($generaloptions['wpns_home'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_home]" value="Y" id="wpns_homeY" /> <?php _e('Blog', $this -> plugin_name); ?>
			  <input <?php echo ($generaloptions['wpns_home'] == "C") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_home]" value="C" id="wpns_homeC" /> <?php _e('Custom Slides', $this -> plugin_name); ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Auto insert in post / page', $this -> plugin_name); ?></th>
			<td>
			  <input <?php echo ($generaloptions['wpns_auto'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto]" value="N" id="wpns_autoN" /> <?php _e('No', $this -> plugin_name); ?>
			  <input <?php echo ($generaloptions['wpns_auto'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto]" value="Y" id="wpns_autoY" /> <?php _e('Gallery', $this -> plugin_name); ?>
			  <input <?php echo ($generaloptions['wpns_auto'] == "C") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto]" value="C" id="wpns_autoC" /> <?php _e('Custom Slides', $this -> plugin_name); ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Auto slideshow position', $this -> plugin_name); ?></th>
			<td>
			  <input <?php echo ($generaloptions['wpns_auto_position'] == "B") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto_position]" value="B" id="wpns_positionB" /> <?php _e('Before the content', $this -> plugin_name); ?>
			  <input <?php echo ($generaloptions['wpns_auto_position'] == "A") ? 'checked="checked"' : ''; ?> type="radio" name="general[wpns_auto_position]" value="A" id="wpns_positionA" /> <?php _e('After the content', $this -> plugin_name); ?>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Post Types', $this -> plugin_name); ?></th>
			<td>
				<i><?php _e('if nothing selected, alteration of the default query parameter - in most cases "post" - would not occur', $this -> plugin_name); ?></i><br />
				<select name="general[wpns_post_types][]" id="wpns_post_types" multiple> 
				<?php 
					if(isset($generaloptions['wpns_post_types']))
						$types = $generaloptions['wpns_post_types'];
					else $types = array();
					$type_args = array(
							//'_builtin' => false,
							'public'   	=> true,
							'show_ui'	=> true
						);
					$post_types = get_post_types($type_args, 'names'); 
					//echo '<option value="">'.__('select a category', $this -> plugin_name).'</option>';
					foreach ($post_types as $post_type) {
						$option = '<option value="'.$post_type.'"';
						if (in_array($post_type,$types)||$types == $post_type) 
							$option .= ' selected="selected">';
						else { $option .= '>'; }
						$option .= $post_type;
						$option .= '</option>';
						echo $option;
					}
				?>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Taxonomy', $this -> plugin_name); ?></th>
			<td>
				<select name="general[wpns_taxonomies][]" id="wpns_taxonomies" multiple> 
				<?php 
					if(isset($generaloptions['wpns_taxonomies']))
						$tax = $generaloptions['wpns_taxonomies'];
					else $tax = array();
					$tax_args = array(
							//'_builtin' => false,
							'public'   => true
						);
					$taxonomies = get_taxonomies($tax_args, 'objects'); 
					//echo '<option value="">'.__('select a category', $this -> plugin_name).'</option>';
					foreach ($taxonomies as $taxonomy) {
						$option = '<option value="'.$taxonomy->rewrite['slug'].'"';
						if (in_array($taxonomy->rewrite['slug'],$tax)||$tax == $taxonomy->rewrite['slug']) 
							$option .= ' selected="selected">';
						else { $option .= '>'; }
						$option .= $taxonomy->name;
						$option .= '</option>';
						echo $option;
					}
				?>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Terms', $this -> plugin_name); ?></th>
			<td>
			<i><?php _e('select the taxonomies above and save to refresh', $this -> plugin_name); ?></i><br />
			<?php 
				if(isset($generaloptions['wpns_taxonomies']))
					$taxonomies = $generaloptions['wpns_taxonomies'];
				else $taxonomies = array();
				if(isset($generaloptions['wpns_terms']))
					$selected = $generaloptions['wpns_terms'];
				else $selected = array();
	
				$terms = array();
				$disabled = '';
				if(!empty($taxonomies))
					foreach($taxonomies as $tax){
						$tax_terms = get_terms($tax);
						if(!is_wp_error($tax_terms)&&!empty($tax_terms))
							foreach($tax_terms as $tax_term)
								$terms[$tax_term->term_id] = $tax_term;
					}
				else $disabled = 'disabled'; ?>
				<select name="general[wpns_terms][]" id="wpns_terms" multiple <?php echo $disabled;?>> 	
				<?php
					//echo '<option value="">'.__('select a category', $this -> plugin_name).'</option>';
					if(!empty($terms))
						foreach ($terms as $term) {
							$option = '<option value="'.$term->term_id.'"';
							if (in_array($term->term_id,$selected)||$selected == $term->term_id) 
								$option .= ' selected="selected">';
							else { $option .= '>'; }
							$option .= $term->name;
							$option .= ' ('.$term->count.')';
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
				<input type="text" name="general[postlimit]" id="postlimit" size="7" value="<?php echo $generaloptions['postlimit']; ?>" />
			</td>
		</tr>
		</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Exclude', $this -> plugin_name); ?></th>
			<td>
				<input type="text" name="general[exclude]" id="exclude" size="7" value="<?php echo $generaloptions['exclude']; ?>" />
			</td>
		</tr>
		</tr>
			<tr valign="top">
			<th scope="row"><?php _e('Offset', $this -> plugin_name); ?></th>
			<td>
				<input type="text" name="general[offset]" id="offset" size="7" value="<?php echo $generaloptions['offset']; ?>" />
			</td>
		</tr>
    </tbody>
  </table>