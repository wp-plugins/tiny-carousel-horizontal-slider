<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_tch_display']) && $_POST['frm_tch_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$tch_success = '';
	$tch_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".TinyCarouselTable."
		WHERE `tch_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'tiny-carousel-horizontal-slider'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('tch_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".TinyCarouselTable."`
					WHERE `tch_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$tch_success_msg = TRUE;
			$tch_success = __('Selected record was successfully deleted.', 'tiny-carousel-horizontal-slider');
		}
	}
	
	if ($tch_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $tch_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Tiny carousel horizontal slider', 'tiny-carousel-horizontal-slider'); ?>
	<a class="add-new-h2" href="<?php echo TinyCarousel_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'tiny-carousel-horizontal-slider'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".TinyCarouselTable."` order by tch_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo TinyCarousel_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_tch_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('Short code', 'tiny-carousel-horizontal-slider'); ?></th>
			<!--<th scope="col"><?php //_e('Slider width', 'tiny-carousel-horizontal-slider'); ?></th>-->
            <th scope="col"><?php _e('Image folder', 'tiny-carousel-horizontal-slider'); ?></th>
			<th scope="col"><?php _e('Image width', 'tiny-carousel-horizontal-slider'); ?></th>
			<th scope="col"><?php _e('Image height', 'tiny-carousel-horizontal-slider'); ?></th>
			<!--<th scope="col"><?php //_e('Display', 'tiny-carousel-horizontal-slider'); ?></th>-->
			<th scope="col"><?php _e('Controls', 'tiny-carousel-horizontal-slider'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('Short code', 'tiny-carousel-horizontal-slider'); ?></th>
			<!--<th scope="col"><?php //_e('Slider width', 'tiny-carousel-horizontal-slider'); ?></th>-->
            <th scope="col"><?php _e('Image folder', 'tiny-carousel-horizontal-slider'); ?></th>
			<th scope="col"><?php _e('Image width', 'tiny-carousel-horizontal-slider'); ?></th>
			<th scope="col"><?php _e('Image height', 'tiny-carousel-horizontal-slider'); ?></th>
			<!--<th scope="col"><?php //_e('Display', 'tiny-carousel-horizontal-slider'); ?></th>-->
			<th scope="col"><?php _e('Controls', 'tiny-carousel-horizontal-slider'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td>[tiny-carousel-slider id="<?php echo $data['tch_id']; ?>"]
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo TinyCarousel_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['tch_id']; ?>"><?php _e('Edit', 'tiny-carousel-horizontal-slider'); ?></a> | </span>
							<span class="trash"><a onClick="javascript:tch_delete('<?php echo $data['tch_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'tiny-carousel-horizontal-slider'); ?></a></span> 
						</div>
						</td>
						<!--<td><?php //echo $data['tch_viewport']; ?></td>-->
						<td><?php echo $data['tch_folder']; ?></td>
						<td><?php echo $data['tch_width']; ?></td>
						<td><?php echo $data['tch_height']; ?></td>
						<!--<td><?php //echo $data['tch_display']; ?></td>-->
						<td><?php echo $data['tch_controls']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="5" align="center"><?php _e('No records available.', 'tiny-carousel-horizontal-slider'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('tch_form_show'); ?>
		<input type="hidden" name="frm_tch_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo TinyCarousel_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'tiny-carousel-horizontal-slider'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo TinyCarousel_FAV; ?>"><?php _e('Help', 'tiny-carousel-horizontal-slider'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', 'tiny-carousel-horizontal-slider'); ?></h3>
	<ol>
		<li><?php _e('Add the plugin in the posts or pages using short code.', 'tiny-carousel-horizontal-slider'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'tiny-carousel-horizontal-slider'); ?></li>
	</ol>
	<p class="description">
	<?php _e('Check official website for more information', 'tiny-carousel-horizontal-slider'); ?>
	<a target="_blank" href="<?php echo TinyCarousel_FAV; ?>"><?php _e('click here', 'tiny-carousel-horizontal-slider'); ?></a><br />
	<?php _e('Dont upload your original images into plug-in folder. if you upload the images into plug-in folder, you may lose the images when you update the plug-in to next version.', 'tiny-carousel-horizontal-slider'); ?>
	</p>
	</div>
</div>