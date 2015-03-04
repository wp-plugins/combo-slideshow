<?php $slides = $this -> get_option('slides');
$generaloptions = $this -> get_option('general'); ?>
<div id="nivotransition_div" class="jquery-powered" style="display:<?php echo ($generaloptions['jsframe'] == "jquery") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>      
        <tr valign="top">
        <th scope="row"><?php _e('Type of Animation', $this -> plugin_name); ?></th>
        <td>
        <label>
        <?php $effect = $slides['wpns_effect']; ?>
        <select name="slides[wpns_effect]" id="wpns_effect">
        	<option value="random" <?php if($effect == 'random') echo 'selected="selected"'; ?>>Random</option>
        	<option value="sliceDown" <?php if($effect == 'sliceDown') echo 'selected="selected"'; ?> >sliceDown</option>
        	<option value="sliceDownLeft" <?php if($effect == 'sliceDownLeft') echo 'selected="selected"'; ?> >sliceDownLeft</option>
        	<option value="sliceUp" <?php if($effect == 'sliceUp') echo 'selected="selected"'; ?> >sliceUp</option>
        	<option value="sliceUpLeft" <?php if($effect == 'sliceUpLeft') echo 'selected="selected"'; ?> >sliceUpLeft</option>
        	<option value="sliceUpDown" <?php if($effect == 'sliceUpDown') echo 'selected="selected"'; ?> >sliceUpDown</option>
        	<option value="sliceUpDownLeft" <?php if($effect == 'sliceUpDownLeft') echo 'selected="selected"'; ?> >sliceUpDownLeft</option>
        	<option value="fold" <?php if($effect == 'fold') echo 'selected="selected"'; ?> >fold</option>
        	<option value="fade" <?php if($effect == 'fade') echo 'selected="selected"'; ?> >fade</option>
		<option value="slideInRight" <?php if($effect == 'slideInLeft') echo 'selected="selected"'; ?> >slideInRight</option>
		<option value="slideInLeft" <?php if($effect == 'slideInLeft') echo 'selected="selected"'; ?> >slideInLeft</option>
        	<option value="boxRandom" <?php if($effect == 'boxRandom') echo 'selected="selected"'; ?> >boxRandom</option>
        	<option value="boxRain" <?php if($effect == 'boxRain') echo 'selected="selected"'; ?> >boxRain</option>
        	<option value="boxRainReverse" <?php if($effect == 'boxRainReverse') echo 'selected="selected"'; ?> >boxRainReverse</option>
        </select>
        </label>
	</td>
	</tr>
	</tbody>
    </table>
</div>
<div id="nivoslices_div" class="jquery-powered" style="display:<?php echo ($generaloptions['jsframe'] == "jquery") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>      
        <tr valign="top">
        <th scope="row"><?php _e('Number of slices', $this -> plugin_name); ?></th>
	    <td>
		<label>
		    <input type="text" name="slides[wpns_slices]" id="wpns_slices" size="7" value="<?php echo $slides['wpns_slices']; ?>" />
		</label>
	    </td>
	</tr>
    </tbody>
  </table>
</div>
<div id="ryanftransitions" class="mootools-powered" style="display:<?php echo ($generaloptions['jsframe'] == "mootools") ? 'block' : 'none'; ?>;">
<div id="ryanftransition_div" style="display:<?php echo ($slides['csstransform'] == "N") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>      
        <tr valign="top">
        <th scope="row"><?php _e('Type of Animation', $this -> plugin_name); ?></th>
        <td>
        <label>
        <?php $m_effect = $slides['wprfss_effect']; ?>
        <select name="slides[wprfss_effect]" id="wprfss_effect">
        	<option value="fade" <?php if($m_effect == 'fade') echo 'selected="selected"'; ?>>fade</option>
        	<option value="crossFade" <?php if($m_effect == 'crossFade') echo 'selected="selected"'; ?> >crossFade</option>
        	<option value="fadeThroughBackground" <?php if($m_effect == 'fadeThroughBackground') echo 'selected="selected"'; ?> >fadeThroughBackground</option>
        	<option value="pushLeft" <?php if($m_effect == 'pushLeft') echo 'selected="selected"'; ?> >pushLeft</option>
        	<option value="pushRight" <?php if($m_effect == 'pushRight') echo 'selected="selected"'; ?> >pushRight</option>
        	<option value="pushUp" <?php if($m_effect == 'pushUp') echo 'selected="selected"'; ?> >pushUp</option>
        	<option value="pushDown" <?php if($m_effect == 'pushDown') echo 'selected="selected"'; ?> >pushDown</option>

        	<option value="blindLeft" <?php if($m_effect == 'blindLeft') echo 'selected="selected"'; ?> >blindLeft</option>
        	<option value="blindRight" <?php if($m_effect == 'blindRight') echo 'selected="selected"'; ?> >blindRight</option>
        	<option value="blindUp" <?php if($m_effect == 'blindUp') echo 'selected="selected"'; ?> >blindUp</option>
        	<option value="blindDown" <?php if($m_effect == 'blindDown') echo 'selected="selected"'; ?> >blindDown</option>

        	<option value="slideLeft" <?php if($m_effect == 'slideLeft') echo 'selected="selected"'; ?> >slideLeft</option>
        	<option value="slideRight" <?php if($m_effect == 'slideRight') echo 'selected="selected"'; ?> >slideRight</option>
        	<option value="slideUp" <?php if($m_effect == 'slideUp') echo 'selected="selected"'; ?> >slideUp</option>
        	<option value="slideDown" <?php if($m_effect == 'slideDown') echo 'selected="selected"'; ?> >slideDown</option>

        	<option value="blindLeftFade" <?php if($m_effect == 'blindLeftFade') echo 'selected="selected"'; ?> >blindLeftFade</option>
        	<option value="blindRightFade" <?php if($m_effect == 'blindRightFade') echo 'selected="selected"'; ?> >blindRightFade</option>
        	<option value="blindUpFade" <?php if($m_effect == 'blindUpFade') echo 'selected="selected"'; ?> >blindUpFade</option>
        	<option value="blindDownFade" <?php if($m_effect == 'blindDownFade') echo 'selected="selected"'; ?> >blindDownFade</option>
        </select>
        </label>
	</td>
	</tr>
	</tbody>
    </table>
</div>
<div id="ryanftransitioncss_div" style="display:<?php echo ($slides['csstransform'] == "Y") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>      
        <tr valign="top">
        <th scope="row"><?php _e('Type of CSS Animation', $this -> plugin_name); ?></th>
        <td>
        <label>
        <?php $m_effect = $slides['wprfss_cssfx']; ?>
        <select name="slides[wprfss_cssfx]" id="wprfss_cssfx">
        	<option value="pushLeftCSS" <?php if($m_effect == 'pushLeftCSS') echo 'selected="selected"'; ?> >pushLeftCSS</option>
        	<option value="pushRightCSS" <?php if($m_effect == 'pushRightCSS') echo 'selected="selected"'; ?> >pushRight</option>
        	<option value="pushUpCSS" <?php if($m_effect == 'pushUpCSS') echo 'selected="selected"'; ?> >pushUpCSS</option>
        	<option value="pushDownCSS" <?php if($m_effect == 'pushDownCSS') echo 'selected="selected"'; ?> >pushDownCSS</option>

        	<option value="blindLeftCSS" <?php if($m_effect == 'blindLeftCSS') echo 'selected="selected"'; ?> >blindLeftCSS</option>
        	<option value="blindRightCSS" <?php if($m_effect == 'blindRightCSS') echo 'selected="selected"'; ?> >blindRightCSS</option>
        	<option value="blindUpCSS" <?php if($m_effect == 'blindUpCSS') echo 'selected="selected"'; ?>>blindUpCSS</option>
        	<option value="blindDownCSS" <?php if($m_effect == 'blindDownCSS') echo 'selected="selected"'; ?> >blindDownCSS</option>

        	<option value="slideLeftCSS" <?php if($m_effect == 'slideLeftCSS') echo 'selected="selected"'; ?> >slideLeftCSS</option>
        	<option value="slideRightCSS" <?php if($m_effect == 'slideRightCSS') echo 'selected="selected"'; ?> >slideRightCSS</option>
        	<option value="slideUpCSS" <?php if($m_effect == 'slideUpCSS') echo 'selected="selected"'; ?> >slideUpCSS</option>
        	<option value="slideDownCSS" <?php if($m_effect == 'slideDownCSS') echo 'selected="selected"'; ?> >slideDownCSS</option>
        </select>
        </label>
	</td>
	</tr>
	</tbody>
    </table>
</div>
<div id="ryanfcsstransform_div" class="mootools-powered" style="display:<?php echo ($generaloptions['jsframe'] == "mootools") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>      
        <tr valign="top">
		<th><label for="csstransformN"><?php _e('CSS3 transitions', $this -> plugin_name); ?></label></th>
		<td>
			<label><input onclick="jQuery('#ryanftransition_div').hide();jQuery('#ryanftransitioncss_div').show();" <?php echo ($slides['csstransform'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[csstransform]" value="Y" id="csstransformY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
			<label><input onclick="jQuery('#ryanftransitioncss_div').hide();jQuery('#ryanftransition_div').show();" <?php echo ($slides['csstransform'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[csstransform]" value="N" id="csstransformN" /> <?php _e('No', $this -> plugin_name); ?></label>
		</td>
	</tr>
	</tbody>
    </table>
</div>
</div>
<div id=nivopause_div">
   <table class="form-table">
	<tbody>      
		<tr>
			<th><label for="pausehoverY"><?php _e('Pause on hover', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($slides['pausehover'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[pausehover]" value="Y" id="pausehoverY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($slides['pausehover'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[pausehover]" value="N" id="pausehoverN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
    </table>
</div>
   <table class="form-table">
	<tbody>  
		<tr>
			<th><label for="autoslideY"><?php _e('Auto Slide', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#autoslide_div').show();" <?php echo ($slides['autoslide'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[autoslide]" value="Y" id="autoslideY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#autoslide_div').hide();" <?php echo ($slides['autoslide'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[autoslide]" value="N" id="autoslideN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>
<div id="autoslide_div" style="display:<?php echo ($slides['autoslide'] == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="autospeed"><?php _e('Auto Speed', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" style="width:45px;" name="slides[autospeed]" value="<?php echo $slides['autospeed']; ?>" id="autospeed" /> <?php _e('ms', $this -> plugin_name); ?>
					<span class="howto"><?php _e('default:3000', $this -> plugin_name); ?><br/><?php _e('lower number for shorter interval between images', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<table class="form-table">
	<tbody>
<tr>
			<th><label for="informationY"><?php _e('Display Caption', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#captionopacity_div').show();" <?php echo ($slides['information'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[information]" value="Y" id="informationY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#captionopacity_div').hide();" <?php echo ($slides['information'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[information]" value="N" id="informationN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>
<?php $slidestyles = $this -> get_option('slidestyles'); ?>
<div id="captionopacity_div" style="display:<?php echo ($slides['information'] == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
		<tr>
			<th><label for="styles.offsetcap"><?php _e('Caption Offset', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.offsetcap" type="text" name="slidestyles[offsetcap]" value="<?php echo $slidestyles['offsetcap']; ?>" />  
				<?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('fine tune the caption Y position from the bottom', $this -> plugin_name); ?><br />
				<?php _e('(positive values mean going up)', $this -> plugin_name); ?></span>
			</td>
			</tr>
			<tr>
			<th><label for="captionopacity"><?php _e('Caption Opacity', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="slides[captionopacity]" value="<?php echo $slides['captionopacity']; ?>" id="captionopacity" style="width:45px;" /> <?php _e('&#37; <!-- percentage -->', $this -> plugin_name); ?>
				<span class="howto"><?php _e('opacity of the caption', $this -> plugin_name); ?></span>
			</td>
		</tr>
		</tbody>
	</table>
</div>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="fadespeed"><?php _e('Image Fading Speed', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" type="text" name="slides[fadespeed]" value="<?php echo $slides['fadespeed']; ?>" id="fadespeed" /> <?php _e('ms', $this -> plugin_name); ?>
				<span class="howto"><?php _e('default:500 recommended:100-1000', $this -> plugin_name); ?><br/><?php _e('lower number for quicker fading of images', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="controlnavY"><?php _e('Navigation Control', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#navtips_div').show();jQuery('#navnumbers_div').show();" <?php echo ($slides['controlnav'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[controlnav]" value="Y" id="controlnavY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#navtips_div').hide();jQuery('#navnumbers_div').hide();" <?php echo ($slides['controlnav'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[controlnav]" value="N" id="controlnavN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('1, 2, 3...', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="thumbnailsN"><?php _e('Show Thumbnails', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($slides['thumbnails'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[thumbnails]" value="Y" id="thumbnailsY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($slides['thumbnails'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[thumbnails]" value="N" id="thumbnailsN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
    </table>
<div id="navoffset_div">
   <table class="form-table">
	<tbody>
		<tr>
			<th><label for="styles.offsetnav"><?php _e('Navigation Offset', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.offsetnav" type="text" name="slidestyles[offsetnav]" value="<?php echo $slidestyles['offsetnav']; ?>" />  
				<?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('fine tune the navigation control margin-bottom / Y position', $this -> plugin_name); ?><br />
				<?php _e('(negative values mean going up)', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div id="navnumbers_div" style="display:<?php echo ($slides['controlnav'] == "Y") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
		<tr>
			<th><label for="styles.controlnumbersN"><?php _e('Control Numbers', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($slidestyles['controlnumbers'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slidestyles[controlnumbers]" value="Y" id="styles.controlnumbersY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($slidestyles['controlnumbers'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slidestyles[controlnumbers]" value="N" id="styles.controlnumbersN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Control Bullets', $this -> plugin_name); ?></th>
			<td>
				<label>
				<?php $nav_bullet = $slidestyles['navbullets']; ?>
				<select name="slidestyles[navbullets]" id="styles.navbullets">
					<option onclick="jQuery('#navbullet_div').hide();" value="0" <?php if($nav_bullet == '0') echo 'selected="selected"'; ?>>no style</option>
					<option onclick="jQuery('#navbullet_div').hide();" value="default" <?php if($nav_bullet == 'default') echo 'selected="selected"'; ?> >default</option>
					<option onclick="jQuery('#navbullet_div').hide();" value="orman" <?php if($nav_bullet == 'orman') echo 'selected="selected"'; ?> >orman</option>
					<option onclick="jQuery('#navbullet_div').hide();" value="pascal" <?php if($nav_bullet == 'pascal') echo 'selected="selected"'; ?> >pascal</option>
					<option onclick="jQuery('#navbullet_div').show();" value="custom" <?php if($nav_bullet == 'custom') echo 'selected="selected"'; ?> >custom</option>
				</select>
				</label>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div id="navbullet_div" style="display:<?php echo ($nav_bullet == "custom") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e('Custom Bullets', $this -> plugin_name); ?></th>
			<td>
				<label>
        <input type="text" name="slidestyles[custombul]" id="styles.custombul" size="8" value="<?php echo $slidestyles['custombul']; ?>" />
        </label>
	<span class="howto"><?php _e('name of the current theme sub-folder', $this -> plugin_name); ?><br/><?php _e('e.g. use "custom" for /mytheme/custom/bullet.png', $this -> plugin_name); ?></span>
	</td>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div id="navtips_wrap" class="mootools-powered" style="display:<?php echo ($generaloptions['jsframe'] == "mootools") ? 'block' : 'none'; ?>;">
<div id="navtips_div" style="display:<?php echo ($slides['controlnav'] == "Y") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
		<tr>
			<th><label for="wprfss_tipsN"><?php _e('Navigation Tips', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($slides['wprfss_tips'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[wprfss_tips]" value="Y" id="wprfss_tipsY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($slides['wprfss_tips'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[wprfss_tips]" value="N" id="wprfss_tipsN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>
</div>
</div>
<div id="keynav_div"  class="jquery-powered" style="display:<?php echo ($generaloptions['jsframe'] == "jquery") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
		<tr>
			<th><label for="keyboardnavY"><?php _e('Keyboard Navigation', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($slides['keyboardnav'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[keyboardnav]" value="Y" id="keyboardnavY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($slides['keyboardnav'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[keyboardnav]" value="N" id="keyboardnavN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('use left & right arrows', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div id="navigation_div">
   <table class="form-table">
	<tbody>
		<tr>
			<th><label for="navigationY"><?php _e('Navigation Direction Buttons', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#navarrows_div').show();jQuery('#navhover_div').show();" <?php echo ($slides['navigation'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[navigation]" value="Y" id="navigationY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#navarrows_div').hide();jQuery('#navhover_div').hide();" <?php echo ($slides['navigation'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[navigation]" value="N" id="navigationN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
		</tr>
	</tbody>
</table>
</div>
<div id="navarrows_div"  style="display:<?php echo ($slides['navigation'] == "Y") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e('Direction Arrows', $this -> plugin_name); ?></th>
			<td>
				<label>
				<?php $nav_effect = $slidestyles['navbuttons']; ?>
				<select name="slidestyles[navbuttons]" id="styles.navbuttons">
					<option onclick="jQuery('#navcustom_div').hide();" value="0" <?php if($nav_effect == '0') echo 'selected="selected"'; ?>>no style</option>
					<option onclick="jQuery('#navcustom_div').hide();" value="default" <?php if($nav_effect == 'default') echo 'selected="selected"'; ?> >default</option>
					<option onclick="jQuery('#navcustom_div').hide();" value="orman" <?php if($nav_effect == 'orman') echo 'selected="selected"'; ?> >orman</option>
					<option onclick="jQuery('#navcustom_div').hide();" value="pascal" <?php if($nav_effect == 'pascal') echo 'selected="selected"'; ?> >pascal</option>
					<option onclick="jQuery('#navcustom_div').show();" value="custom" <?php if($nav_effect == 'custom') echo 'selected="selected"'; ?> >custom</option>
				</select>
				</label>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div id="navcustom_div" style="display:<?php echo ($slidestyles['navbuttons'] == "custom") ? 'block' : 'none'; ?>;">
   <table class="form-table">
	<tbody>
		<tr valign="top">
			<th scope="row"><?php _e('Custom Direction Arrows', $this -> plugin_name); ?></th>
			<td>
				<label>
        <input type="text" name="slidestyles[customnav]" id="styles.customnav" size="8" value="<?php echo $slidestyles['customnav']; ?>" />
        </label>
	<span class="howto"><?php _e('name of the current theme sub-folder', $this -> plugin_name); ?><br/><?php _e('e.g. use "custom" for /mytheme/custom/arrow.png', $this -> plugin_name); ?></span>
	</td>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div id="navhover_div" style="display:<?php echo ($slides['navigation'] == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="navhoverY"><?php _e('Navigation Hover', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($slides['navhover'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="slides[navhover]" value="Y" id="navhoverY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input <?php echo ($slides['navhover'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="slides[navhover]" value="N" id="navhoverN" /> <?php _e('No', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('show navigation buttons only on hover', $this -> plugin_name); ?></span>
				</td>
			</tr>			
		</tbody>
	</table>
</div>