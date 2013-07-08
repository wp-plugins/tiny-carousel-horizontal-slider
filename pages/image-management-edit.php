<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

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
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$tch_errors = array();
	$tch_success = '';
	$tch_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".TinyCarouselTable."`
		WHERE `tch_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'tch_viewport' => $data['tch_viewport'],
		'tch_width' => $data['tch_width'],
		'tch_height' => $data['tch_height'],
		'tch_display' => $data['tch_display'],
		'tch_controls' => $data['tch_controls'],
		'tch_interval' => $data['tch_interval'],
		'tch_intervaltime' => $data['tch_intervaltime'],
		'tch_duration' => $data['tch_duration'],
		'tch_folder' => $data['tch_folder'],
		'tch_random' => $data['tch_random'],
		'tch_id' => $data['tch_id']
	);
}
// Form submitted, check the data
if (isset($_POST['tch_form_submit']) && $_POST['tch_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('tch_form_edit');
	
	$form['tch_viewport'] = isset($_POST['tch_viewport']) ? $_POST['tch_viewport'] : '';
	if ($form['tch_viewport'] == '')
	{
		$tch_errors[] = __('Please enter slider width. only number.', TinyCarousel_UNIQUE_NAME);
		$tch_error_found = TRUE;
	}

	$form['tch_width'] = isset($_POST['tch_width']) ? $_POST['tch_width'] : '';
	if ($form['tch_width'] == '')
	{
		$tch_errors[] = __('Please enter the image width. only number.', TinyCarousel_UNIQUE_NAME);
		$tch_error_found = TRUE;
	}
	
	$form['tch_height'] = isset($_POST['tch_height']) ? $_POST['tch_height'] : '';
	if ($form['tch_height'] == '')
	{
		$tch_errors[] = __('Please enter the image height. only number.', TinyCarousel_UNIQUE_NAME);
		$tch_error_found = TRUE;
	}
	
	$form['tch_display'] = isset($_POST['tch_display']) ? $_POST['tch_display'] : '';
	if ($form['tch_display'] == '')
	{
		$tch_errors[] = __('Please enter the display. only number.', TinyCarousel_UNIQUE_NAME);
		$tch_error_found = TRUE;
	}
	
	$form['tch_controls'] = isset($_POST['tch_controls']) ? $_POST['tch_controls'] : '';
	$form['tch_interval'] = isset($_POST['tch_interval']) ? $_POST['tch_interval'] : '';
	$form['tch_intervaltime'] = isset($_POST['tch_intervaltime']) ? $_POST['tch_intervaltime'] : '';
	$form['tch_duration'] = isset($_POST['tch_duration']) ? $_POST['tch_duration'] : '';
	$form['tch_folder'] = isset($_POST['tch_folder']) ? $_POST['tch_folder'] : '';
	if ($form['tch_folder'] == '')
	{
		$tch_errors[] = __('Please select the image folder location.', TinyCarousel_UNIQUE_NAME);
		$tch_error_found = TRUE;
	}
	
	$form['tch_random'] = isset($_POST['tch_random']) ? $_POST['tch_random'] : '';

	//	No errors found, we can add this Group to the table
	if ($tch_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".TinyCarouselTable."`
				SET `tch_viewport` = %s,
				`tch_width` = %s,
				`tch_height` = %s,
				`tch_display` = %s,
				`tch_controls` = %s,
				`tch_interval` = %s,
				`tch_intervaltime` = %s,
				`tch_duration` = %s,
				`tch_folder` = %s,
				`tch_random` = %s
				WHERE tch_id = %d
				LIMIT 1",
				array($form['tch_viewport'], $form['tch_width'], $form['tch_height'], $form['tch_display'], $form['tch_controls'], $form['tch_interval'], $form['tch_intervaltime'], $form['tch_duration'], $form['tch_folder'], $form['tch_random'], $did)
			);
		$wpdb->query($sSql);
		
		$tch_success = 'Details was successfully updated.';
	}
}

if ($tch_error_found == TRUE && isset($tch_errors[0]) == TRUE)
{
?>
  <div class="error fade">
    <p><strong><?php echo $tch_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($tch_error_found == FALSE && strlen($tch_success) > 0)
{
?>
  <div class="updated fade">
    <p><strong><?php echo $tch_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=tiny-carousel-horizontal-slider">Click here</a> to view the details</strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/tiny-carousel-horizontal-slider/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo TinyCarousel_TITLE; ?></h2>
	<form name="tch_form" method="post" action="#" onsubmit="return tch_submit()"  >
      <h3>Update details</h3>
	  
	  	<label for="tag-title">Slider width</label>
		<input name="tch_viewport" type="text" id="tch_viewport" value="<?php echo $form['tch_viewport']; ?>" maxlength="4" />
		<p>Enter your galley width. (Ex: 450)</p>
		
		<label for="tag-title">Image width</label>
		<input name="tch_width" type="text" id="tch_width" value="<?php echo $form['tch_width']; ?>" maxlength="4" />
		<p>Enter your image width, We should upload the same size images in the folder. (Ex: 200)</p>
		
		<label for="tag-title">Image height</label>
		<input name="tch_height" type="text" id="tch_height" value="<?php echo $form['tch_height']; ?>" maxlength="4" />
		<p>Enter your image height, We should upload the same size images in the folder. (Ex: 150)</p>
	  
	  	<label for="tag-title">Image display</label>
		<input name="tch_display" type="text" id="tch_display" value="<?php echo $form['tch_display']; ?>" maxlength="4" />
		<p>Enter how many images you want to move at a time. (Ex: 1)</p>
		
		<label for="tag-title">Controls</label>
		<select name="tch_controls" id="tch_controls">
			<option value='true' <?php if($form['tch_controls'] == 'true') { echo "selected='selected'" ; } ?>>True</option>
			<option value='false' <?php if($form['tch_controls'] == 'false') { echo "selected='selected'" ; } ?>>False</option>
		</select>
		<p>Do you like to use the Left, Right arrow button in your gallery?</p>
		
		<label for="tag-title">Auto interval</label>
		<select name="tch_interval" id="tch_interval">
			<option value='true' <?php if($form['tch_interval'] == 'true') { echo "selected='selected'" ; } ?>>True</option>
			<option value='false' <?php if($form['tch_interval'] == 'false') { echo "selected='selected'" ; } ?>>False</option>
		</select>
		<p>Do you like to add auto interval to move one image from another?</p>
		
		<label for="tag-title">Interval time</label>
		<input name="tch_intervaltime" type="text" id="tch_intervaltime" value="<?php echo $form['tch_intervaltime']; ?>" maxlength="4" />
		<p>Auto interval time in millisecond. (Ex: 1500)</p>
		
		<label for="tag-title">Duration</label>
		<input name="tch_duration" type="text" id="tch_duration" value="<?php echo $form['tch_duration']; ?>" maxlength="4" />
		<p>Animation duration in millisecond. (Ex: 1000)</p>
		
		<label for="tag-title">Random display</label>
		<select name="tch_random" id="tch_random">
			<option value='YES' <?php if($form['tch_random'] == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($form['tch_random'] == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p>Do you want to display images in random order?</p>
		
		<label for="tag-title">Image folder location</label>
		<input name="tch_folder" type="text" id="tch_folder" value="<?php echo $form['tch_folder']; ?>" size="100" maxlength="1024" />
		<p>Example: wp-content/plugins/tiny-carousel-horizontal-slider/images/</p>
	  
      <input name="tch_id" id="tch_id" type="hidden" value="<?php echo $form['tch_id']; ?>">
      <input type="hidden" name="tch_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Update Details" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="tch_redirect()" value="Cancel" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="tch_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('tch_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo TinyCarousel_LINK; ?></p>
</div>