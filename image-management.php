<!--
 *     Tiny Carousel Horizontal Slider
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 *     http://www.gopiplus.com/work/2012/05/26/tiny-carousel-horizontal-slider-wordpress-plugin/
 * 
 *     License: GPLv2 or later
 *     License URI: http://www.gnu.org/licenses/gpl-2.0.html *	
 *     
-->

<div class="wrap">
  <?php
  	global $wpdb;
    $mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=tiny-carousel-horizontal-slider/tiny-carousel-horizontal-slider.php";
    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
    $submittext = "Insert Slider";
	if($AC <> "DEL" and trim(@$_POST['tch_viewport']) <>"")
    {
			if($_POST['tch_id'] == "" )
			{
					$sql = "insert into ".TinyCarouselTable
					. " set `tch_viewport` = '" . mysql_real_escape_string(trim($_POST['tch_viewport']))
					. "', `tch_width` = '" . mysql_real_escape_string(trim($_POST['tch_width']))
					. "', `tch_height` = '" . mysql_real_escape_string(trim($_POST['tch_height']))
					. "', `tch_display` = '" . mysql_real_escape_string(trim($_POST['tch_display']))
					. "', `tch_controls` = '" . mysql_real_escape_string(trim($_POST['tch_controls']))
					. "', `tch_interval` = '" . mysql_real_escape_string(trim($_POST['tch_interval']))
					. "', `tch_intervaltime` = '" . mysql_real_escape_string(trim($_POST['tch_intervaltime']))
					. "', `tch_duration` = '" . mysql_real_escape_string(trim($_POST['tch_duration']))
					. "', `tch_folder` = '" . mysql_real_escape_string(trim($_POST['tch_folder']))
					. "', `tch_random` = '" . mysql_real_escape_string(trim($_POST['tch_random']))
					. "'";	
			}
			else
			{
					$sql = "update ".TinyCarouselTable
					. " set `tch_viewport` = '" . mysql_real_escape_string(trim($_POST['tch_viewport']))
					. "', `tch_width` = '" . mysql_real_escape_string(trim($_POST['tch_width']))
					. "', `tch_height` = '" . mysql_real_escape_string(trim($_POST['tch_height']))
					. "', `tch_display` = '" . mysql_real_escape_string(trim($_POST['tch_display']))
					. "', `tch_controls` = '" . mysql_real_escape_string(trim($_POST['tch_controls']))
					. "', `tch_interval` = '" . mysql_real_escape_string(trim($_POST['tch_interval']))
					. "', `tch_intervaltime` = '" . mysql_real_escape_string(trim($_POST['tch_intervaltime']))
					. "', `tch_duration` = '" . mysql_real_escape_string(trim($_POST['tch_duration']))
					. "', `tch_folder` = '" . mysql_real_escape_string(trim($_POST['tch_folder']))
					. "', `tch_random` = '" . mysql_real_escape_string(trim($_POST['tch_random']))
					. "' where `tch_id` = '" . @$_POST['tch_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".TinyCarouselTable." where tch_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".TinyCarouselTable." where tch_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) 
		{
			$tch_id_x = $data->tch_id; 
			$tch_viewport_x = $data->tch_viewport; 
			$tch_width_x = $data->tch_width; 
			$tch_height_x = $data->tch_height; 
			$tch_display_x = $data->tch_display; 
			$tch_controls_x = $data->tch_controls; 
			$tch_interval_x = $data->tch_interval; 
			$tch_intervaltime_x = $data->tch_intervaltime; 
			$tch_duration_x = $data->tch_duration; 
			$tch_folder_x = $data->tch_folder; 
			$tch_random_x = $data->tch_random;
		}
        $submittext = "Update Slider";
    }
    ?>
  <h2>Tiny Carousel Horizontal Slider</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/tiny-carousel-horizontal-slider/setting.js"></script>
  <form name="tch_form" method="post" action="<?php echo @$mainurl; ?>" onsubmit="return tch_submit()"  >
    <table width="600" border="0" cellspacing="0" cellpadding="0">
      <tr align="left" valign="middle" style="height:20px;">
        <td width="252">Slider Width:</td>
        <td width="348">Image Width:</td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td><input name="tch_viewport" type="text" id="tch_viewport" value="<?php echo @$tch_viewport_x; ?>" size="20" maxlength="4" /></td>
        <td><input name="tch_width" type="text" id="tch_width" value="<?php echo @$tch_width_x; ?>" size="20" maxlength="4" /></td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td>Image Height:</td>
        <td>Display:</td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td><input name="tch_height" type="text" id="tch_height" value="<?php echo @$tch_height_x; ?>" size="20" maxlength="4" /></td>
        <td><input name="tch_display" type="text" id="tch_display" value="<?php echo @$tch_display_x; ?>" size="20" maxlength="4" /></td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td>Controls:</td>
        <td>Interval:</td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td><select name="tch_controls" id="tch_controls">
            <option value='true' <?php if(@$tch_controls_x=='true') { echo 'selected' ; } ?>>True</option>
			<option value='false' <?php if(@$tch_controls_x=='false') { echo 'selected' ; } ?>>False</option>
          </select></td>
        <td><select name="tch_interval" id="tch_interval">
            <option value='true' <?php if(@$tch_interval_x=='true') { echo 'selected' ; } ?>>True</option>
			<option value='false' <?php if(@$tch_interval_x=='false') { echo 'selected' ; } ?>>False</option>
          </select>
        </td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td>Interval Time:</td>
        <td>Duration:</td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td><input name="tch_intervaltime" type="text" id="tch_intervaltime" value="<?php echo @$tch_intervaltime_x; ?>" size="20" maxlength="4" /></td>
        <td><input name="tch_duration" type="text" id="tch_duration" value="<?php echo @$tch_duration_x; ?>" size="20" maxlength="4" /></td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td>Random Display:</td>
        <td>&nbsp;</td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td colspan="2"><select name="tch_random" id="tch_random">
            <option value='NO' <?php if(@$tch_random_x=='NO') { echo 'selected' ; } ?>>No</option>
            <option value='YES' <?php if(@$tch_random_x=='YES') { echo 'selected' ; } ?>>Yes</option>
          </select>
        </td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td>Image Folder Location</td>
        <td>&nbsp;</td>
      </tr>
      <tr align="left" valign="middle" style="height:20px;">
        <td colspan="2"><input name="tch_folder" type="text" id="tch_folder" value="<?php echo @$tch_folder_x; ?>" size="90" maxlength="255" />
		<br />Example: wp-content/plugins/tiny-carousel-horizontal-slider/images/</td>
      </tr>
      <tr>
        <td><input name="tch_id" id="tch_id" type="hidden" value="<?php echo @$tch_id_x; ?>"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
          <input name="publish" lang="publish" class="button-primary" onclick="tch_redirect()" value="Cancel" type="button" />
		  <input name="Help" lang="publish" class="button-primary" onclick="tch_help()" value="Help" type="button" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".TinyCarouselTable." order by tch_id desc");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_tch_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th align="left" scope="col">Slider Width
              </th>
            <th align="left" scope="col">Short Code
              </th>
            <th align="left" scope="col">Folder
              </th>
            <th align="left" scope="col">Action
              </th>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->tch_viewport)); ?></td>
            <td align="left" valign="middle">[tiny-carousel-slider id="<?php echo(stripslashes($data->tch_id)); ?>"]</td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->tch_folder)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=tiny-carousel-horizontal-slider/tiny-carousel-horizontal-slider.php&DID=<?php echo($data->tch_id); ?>">Edit</a> &nbsp; <a onClick="javascript:tch_delete('<?php echo($data->tch_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
      </table>
    </form>
  </div>
  <br />
  Check official website for more details <a href="http://www.gopiplus.com/work/2012/05/26/tiny-carousel-horizontal-slider-wordpress-plugin/" target="_blank">click here</a>
</div>

