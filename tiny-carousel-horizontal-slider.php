<?php

/*
Plugin Name: Tiny Carousel Horizontal Slider
Description: This is Jquery based image horizontal slider plugin, it is using tiny carousel light weight jquery script to the slideshow.
Author: Gopi.R
Version: 5.1
Plugin URI: http://www.gopiplus.com/work/2012/05/26/tiny-carousel-horizontal-slider-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2012/05/26/tiny-carousel-horizontal-slider-wordpress-plugin/
Donate link: http://www.gopiplus.com/work/2012/05/26/tiny-carousel-horizontal-slider-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("TinyCarouselTable", $wpdb->prefix . "TinyCarousel");

add_shortcode( 'tiny-carousel-slider', 'TinyCarousel_shortcode' );

function TinyCarousel( $atts ) 
{
	$arr = array();
	$arr["id"]=$atts;
	echo TinyCarousel_shortcode($arr);
}

function TinyCarousel_shortcode( $atts ) 
{
	global $wpdb;
	// [tiny-carousel-slider id="1"]

	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$id = $atts['id'];
	
	
	$sSql = "select * from ".TinyCarouselTable." where 1=1";
	if(is_numeric(@$id)) 
	{
		$sSql = $sSql . " and tch_id=$id";
	}

	$sSql = $sSql . " LIMIT 0,1";
	$tch = "";
	$imageli = "";
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		$data = $data[0];
		$tch_id = stripslashes($data->tch_id);
		$tch_viewport = stripslashes($data->tch_viewport);
		$tch_width = stripslashes($data->tch_width);
		$tch_height = stripslashes($data->tch_height);
		$tch_display = stripslashes($data->tch_display);
		$tch_controls = stripslashes($data->tch_controls);
		$tch_interval = stripslashes($data->tch_interval);
		$tch_intervaltime = stripslashes($data->tch_intervaltime);
		$tch_duration = stripslashes($data->tch_duration);
		$tch_folder = stripslashes($data->tch_folder);
		if (substr($tch_folder , -1) !== '/') 
		{
			$tch_folder = $tch_folder ."/";
		}
		$tch_random = stripslashes($data->tch_random);
	}
	
	if(is_dir($tch_folder))
	{
		$siteurl = get_option('siteurl');
		if (substr($siteurl , -1) !== '/') 
		{
			$siteurl = $siteurl ."/";
		}
		$tch_dirhandle = opendir($tch_folder);
		while ($tch_file = readdir($tch_dirhandle)) 
		{
			$tch_file_nocaps = $tch_file;
			$tch_file = strtoupper($tch_file);
			if(!is_dir($tch_file) && ((strpos($tch_file, '.JPG')>0) or (strpos($tch_file, '.GIF')>0) or (strpos($tch_file, '.PNG')>0) or (strpos($tch_file, '.JPEG')>0)))
			{
				$imageli = $imageli . '<li><img src="'.$siteurl . $tch_folder . $tch_file_nocaps .'" /></li>';
			}
		} 
	}
	else
	{
		$tch = "folder not found<br />" . $tch_folder;
	}
	
	if($imageli <> "")
	{

$buttonurl = $siteurl . "wp-content/plugins/tiny-carousel-horizontal-slider/buttons.png";
$buttonsmargin = ($tch_height/2);
$tch = $tch . "<style type='text/css' media='screen'>
#tiny-carousel-slider1 { height: 1%; overflow:hidden; position: relative; padding: 0 0 10px;   }
#tiny-carousel-slider1 .viewport { float: left; width: ".$tch_viewport."px; height: ".$tch_height."px; overflow: hidden; position: relative; }
#tiny-carousel-slider1 .buttons { background:url('$buttonurl') no-repeat scroll 0 0 transparent; display: block; margin: ".$buttonsmargin."px 10px 0 0; background-position: 0 -38px; text-indent: -999em; float: left; width: 39px; height: 37px; overflow: hidden; position: relative; }
#tiny-carousel-slider1 .next { background-position: 0 0; margin: ".$buttonsmargin."px 0 0 10px; }
#tiny-carousel-slider1 .disable { visibility: hidden; }
#tiny-carousel-slider1 .overview { list-style: none; position: absolute; width: ".$tch_width."px; left: 0 top: 0; }
#tiny-carousel-slider1 .overview li{ float: left; margin: 0 20px 0 0; padding: 1px; height: ".$tch_height."px; width: ".$tch_width."px;}
</style>";
		$tch = $tch . '<div id="tiny-carousel-slider1">';
			$tch = $tch . '<a class="buttons prev" href="#">left</a>';
			$tch = $tch . '<div class="viewport">';
				$tch = $tch . '<ul class="overview">';
					$tch = $tch . $imageli;
				$tch = $tch . '</ul>';
			$tch = $tch . '</div>';
			$tch = $tch . '<a class="buttons next" href="#">right</a>';
		$tch = $tch . '</div>';
		
		$tch = $tch . '<script type="text/javascript">';
		$tch = $tch . 'jQuery(document).ready(function(){';
			$tch = $tch . "jQuery('#tiny-carousel-slider1').tinycarousel({ start: 1, display: ".$tch_display.", controls: ".$tch_controls.", interval: ".$tch_interval.", intervaltime: ".$tch_intervaltime.", duration: ".$tch_duration." });";
		$tch = $tch . '});';
		$tch = $tch . '</script>';
	}
	
	return $tch;
}

function TinyCarousel_install() 
{
	global $wpdb, $wp_version;
	if($wpdb->get_var("show tables like '". TinyCarouselTable . "'") != TinyCarouselTable) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". TinyCarouselTable . "` (";
		$sSql = $sSql . "`tch_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`tch_viewport` int(11) NOT NULL default '473' ,";
		$sSql = $sSql . "`tch_width` int(11) NOT NULL default '200' ,";
		$sSql = $sSql . "`tch_height` int(11) NOT NULL default '150' ,";
		$sSql = $sSql . "`tch_display` int(11) NOT NULL default '1' ,";
		$sSql = $sSql . "`tch_controls` VARCHAR( 5 ) NOT NULL default 'true',";
		$sSql = $sSql . "`tch_interval` VARCHAR( 5 ) NOT NULL default 'true',";
		$sSql = $sSql . "`tch_intervaltime` int(11) NOT NULL default '1500' ,";
		$sSql = $sSql . "`tch_duration` int(11) NOT NULL default '1000' ,";
		$sSql = $sSql . "`tch_folder` VARCHAR( 255 ) NOT NULL,";
		$sSql = $sSql . "`tch_random` VARCHAR( 3 ) NOT NULL default 'NO',";
		$sSql = $sSql . "PRIMARY KEY ( `tch_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". TinyCarouselTable . "` (`tch_folder`)"; 
		$sSql = $IsSql . " VALUES ('wp-content/plugins/tiny-carousel-horizontal-slider/images/');";
		$wpdb->query($sSql);
	}
}

function TinyCarousel_deactivation() 
{
		// No action required.
}

function TinyCarousel_admin()
{
	include_once("image-management.php");
}

function TinyCarousel_add_to_menu() 
{
	add_options_page('Tiny carousel', 'Tiny carousel', 'manage_options', __FILE__, 'TinyCarousel_admin' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'TinyCarousel_add_to_menu');
}

function TinyCarousel_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery.tinycarousel.min', get_option('siteurl').'/wp-content/plugins/tiny-carousel-horizontal-slider/inc/jquery.tinycarousel.min.js');
	}
}   

add_action('wp_enqueue_scripts', 'TinyCarousel_add_javascript_files');
register_activation_hook(__FILE__, 'TinyCarousel_install');
register_deactivation_hook(__FILE__, 'TinyCarousel_deactivation');
?>