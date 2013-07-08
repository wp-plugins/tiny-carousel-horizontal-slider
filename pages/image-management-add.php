<div class="wrap">
<?php
$tch_errors = array();
$tch_success = '';
$tch_error_found = FALSE;

// Preset the form fields
$form = array(
	'tch_viewport' => '',
	'tch_width' => '',
	'tch_height' => '',
	'tch_display' => '',
	'tch_controls' => '',
	'tch_interval' => '',
	'tch_intervaltime' => '',
	'tch_duration' => '',
	'tch_folder' => '',
	'tch_random' => '',
	'tch_id' => ''
);

// Form submitted, check the data
if (isset($_POST['tch_form_submit']) && $_POST['tch_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('tch_form_add');
	
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
		$sql = $wpdb->prepare(
			"INSERT INTO `".TinyCarouselTable."`
			(`tch_viewport`, `tch_width`, `tch_height`, `tch_display`, `tch_controls`, `tch_interval`, `tch_intervaltime`, `tch_duration`, `tch_folder`, `tch_random`)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			array($form['tch_viewport'], $form['tch_width'], $form['tch_height'], $form['tch_display'], $form['tch_controls'], $form['tch_interval'], $form['tch_intervaltime'], $form['tch_duration'], $form['tch_folder'], $form['tch_random'])
		);
		$wpdb->query($sql);
		
		$tch_success = __('New details was successfully added.', TinyCarousel_UNIQUE_NAME);
		
		// Reset the form fields
		$form = array(
			'tch_viewport' => '',
			'tch_width' => '',
			'tch_height' => '',
			'tch_display' => '',
			'tch_controls' => '',
			'tch_interval' => '',
			'tch_intervaltime' => '',
			'tch_duration' => '',
			'tch_folder' => '',
			'tch_random' => '',
			'tch_id' => ''
		);
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
      <h3>Add details</h3>
      
		<label for="tag-title">Slider width</label>
		<input name="tch_viewport" type="text" id="tch_viewport" value="" maxlength="4" />
		<p>Enter your galley width. (Ex: 500)</p>
		
		<label for="tag-title">Image width</label>
		<input name="tch_width" type="text" id="tch_width" value="" maxlength="4" />
		<p>Enter your image width, We should upload the same size images in the folder. (Ex: 200)</p>
		
		<label for="tag-title">Image height</label>
		<input name="tch_height" type="text" id="tch_height" value="" maxlength="4" />
		<p>Enter your image height, We should upload the same size images in the folder. (Ex: 150)</p>
	  
	  	<label for="tag-title">Image display</label>
		<input name="tch_display" type="text" id="tch_display" value="1" maxlength="4" />
		<p>Enter how many images you want to move at a time. (Ex: 1)</p>
		
		<label for="tag-title">Controls</label>
		<select name="tch_controls" id="tch_controls">
			<option value='true'>True</option>
			<option value='false'>False</option>
		</select>
		<p>Want to use the Left, Right arrow button in your gallery?</p>
		
		<label for="tag-title">Auto interval</label>
		<select name="tch_interval" id="tch_interval">
			<option value='true'>True</option>
			<option value='false'>False</option>
		</select>
		<p>Want to add auto interval to move one image from another?</p>
		
		<label for="tag-title">Interval time</label>
		<input name="tch_intervaltime" type="text" id="tch_intervaltime" value="1500" maxlength="4" />
		<p>Auto interval time in millisecond. (Ex: 1500)</p>
		
		<label for="tag-title">Duration</label>
		<input name="tch_duration" type="text" id="tch_duration" value="1000" maxlength="4" />
		<p>Animation duration in millisecond. (Ex: 1000)</p>
		
		<label for="tag-title">Random display</label>
		<select name="tch_random" id="tch_random">
			<option value='YES'>YES</option>
			<option value='NO'>NO</option>
		</select>
		<p>Do you want to display images in random order?</p>
		
		<label for="tag-title">Image folder location</label>
		<input name="tch_folder" type="text" id="tch_folder" value="" size="100" maxlength="1024" />
		<p>Example: wp-content/plugins/tiny-carousel-horizontal-slider/images/</p>
	  
      <input name="tch_id" id="tch_id" type="hidden" value="">
      <input type="hidden" name="tch_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="Insert Details" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="tch_redirect()" value="Cancel" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="tch_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('tch_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo TinyCarousel_LINK; ?></p>
</div>