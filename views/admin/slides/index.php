<div class="wrap">
	<h2><?php _e('Manage Slides', CMBSLD_PLUGIN_NAME); ?> <?php echo $this -> Html -> link(__('Add New'), $this -> url . '&amp;method=save', array('class' => "button add-new-h2")); ?></h2>
	<?php if (!empty($slides)) : ?>	
		<form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
			<ul class="subsubsub">
				<li><?php echo $paginate -> allcount; ?> <?php _e('slides', CMBSLD_PLUGIN_NAME); ?></li>
			</ul>
		</form>
	<?php endif; ?>
	
	<?php if (!empty($slides)) : ?>
		<form onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected slides?', CMBSLD_PLUGIN_NAME); ?>')) { return false; }" action="<?php echo $this -> url; ?>&amp;method=mass" method="post">
			<div class="tablenav">
				<div class="alignleft actions">
					<a href="<?php echo $this -> url; ?>&amp;method=order" title="<?php _e('Order all your slides', CMBSLD_PLUGIN_NAME); ?>" class="button"><?php _e('Order Slides', CMBSLD_PLUGIN_NAME); ?></a>
				
					<select name="action" class="action">
						<option value="">- <?php _e('Bulk Actions', CMBSLD_PLUGIN_NAME); ?> -</option>
						<option value="delete"><?php _e('Delete', CMBSLD_PLUGIN_NAME); ?></option>
					</select>
					<input type="submit" class="button" value="<?php _e('Apply', CMBSLD_PLUGIN_NAME); ?>" name="execute" />
				</div>
				<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
			</div>
		
			<table class="widefat">
				<thead>
					<tr>
						<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></th>
						<th><?php _e('Image', CMBSLD_PLUGIN_NAME); ?></th>
						<th><?php _e('Title', CMBSLD_PLUGIN_NAME); ?></th>
                        <th><?php _e('Link', CMBSLD_PLUGIN_NAME); ?></th>
						<th><?php _e('Date', CMBSLD_PLUGIN_NAME); ?></th>
                        <th><?php _e('Section', CMBSLD_PLUGIN_NAME); ?></th>
						<th><?php _e('Order', CMBSLD_PLUGIN_NAME); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" value="checkboxall" /></th>
						<th><?php _e('Image', CMBSLD_PLUGIN_NAME); ?></th>
						<th><?php _e('Title', CMBSLD_PLUGIN_NAME); ?></th>
                        <th><?php _e('Link', CMBSLD_PLUGIN_NAME); ?></th>
						<th><?php _e('Date', CMBSLD_PLUGIN_NAME); ?></th>
                        <th><?php _e('Section', CMBSLD_PLUGIN_NAME); ?></th>
						<th><?php _e('Order', CMBSLD_PLUGIN_NAME); ?></th>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($slides as $slide) : ?>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th class="check-column"><input type="checkbox" name="Slide[checklist][]" value="<?php echo $slide -> id; ?>" id="checklist<?php echo $slide -> id; ?>" /></th>
							<td style="width:75px;">
								<?php $image = $slide -> image; ?>
								<a href="<?php echo $this -> Html -> image_url($image); ?>" title="<?php echo $slide -> title; ?>" class="thickbox"><img src="<?php echo $this -> Html -> image_url($this -> Html -> thumbname($image, "thumb")); ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" /></a>
							</td>
							<td>
                            	<a class="row-title" href="<?php echo $this -> url; ?>&amp;method=save&amp;id=<?php echo $slide -> id; ?>" title=""><?php echo $slide -> title; ?></a>
                                <div class="row-actions">
                                	<span class="edit"><?php echo $this -> Html -> link(__('Edit', CMBSLD_PLUGIN_NAME), "?page=gallery-slides&amp;method=save&amp;id=" . $slide -> id); ?> |</span>
                                    <span class="delete"><?php echo $this -> Html -> link(__('Delete', CMBSLD_PLUGIN_NAME), "?page=gallery-slides&amp;method=delete&amp;id=" . $slide -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to permanently remove this slide?', CMBSLD_PLUGIN_NAME) . "')) { return false; }")); ?></span>
                                </div>
                            </td>
                            <td>
                            	<?php if (!empty($slide -> uselink) && $slide -> uselink == "Y") : ?>
                                	<span style="color:green;"><?php _e('Yes', CMBSLD_PLUGIN_NAME); ?></span>
                                <?php else : ?>
                                	<span style="color:red;"><?php _e('No', CMBSLD_PLUGIN_NAME); ?></span>
                                <?php endif; ?>
                            </td>
							<td><abbr title="<?php echo $slide -> modified; ?>"><?php echo date("Y-m-d", strtotime($slide -> modified)); ?></abbr></td>
							<td><?php echo ((int) $slide -> section); ?></td>
							<td><?php echo ((int) $slide -> order + 1); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
			<div class="tablenav">
				
				<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
			</div>
		</form>
	<?php else : ?>
		<p style="color:red;"><?php _e('No slides found', CMBSLD_PLUGIN_NAME); ?></p>
	<?php endif; ?>
</div>