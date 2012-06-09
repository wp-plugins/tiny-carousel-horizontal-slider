/**
 *     Tiny Carousel Horizontal Slider
 *     Copyright (C) 2012  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *	
 */

function tch_submit()
{
	if((document.tch_form.tch_viewport.value=="") || (isNaN(document.tch_form.tch_viewport.value)))
	{
		alert("Please enter slider width. only number.")
		document.tch_form.tch_viewport.focus();
		return false;
	}
	else if((document.tch_form.tch_width.value=="") || (isNaN(document.tch_form.tch_width.value)))
	{
		alert("Please enter the image width. only number.")
		document.tch_form.tch_width.focus();
		return false;
	}
	else if((document.tch_form.tch_height.value=="") || (isNaN(document.tch_form.tch_height.value)))
	{
		alert("Please enter the image height. only number.")
		document.tch_form.tch_height.focus();
		return false;
	}
	else if((document.tch_form.tch_display.value=="") || (isNaN(document.tch_form.tch_display.value)))
	{
		alert("Please enter the display. only number.")
		document.tch_form.tch_display.focus();
		return false;
	}
	else if((document.tch_form.tch_intervaltime.value=="") || (isNaN(document.tch_form.tch_intervaltime.value)))
	{
		alert("Please enter the interval time. only number.")
		document.tch_form.tch_intervaltime.focus();
		return false;
	}
	else if((document.tch_form.tch_duration.value=="") || (isNaN(document.tch_form.tch_duration.value)))
	{
		alert("Please enter the duration. only number.")
		document.tch_form.tch_duration.focus();
		return false;
	}
	else if(document.tch_form.tch_folder.value=="")
	{
		alert("Please select the image folder location.\n Example: wp-content/plugins/tiny-carousel-horizontal-slider/images/")
		document.tch_form.tch_folder.focus();
		return false;
	}
}

function tch_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_tch_display.action="options-general.php?page=tiny-carousel-horizontal-slider/tiny-carousel-horizontal-slider.php&AC=DEL&DID="+id;
		document.frm_tch_display.submit();
	}
}	

function tch_redirect()
{
	window.location = "options-general.php?page=tiny-carousel-horizontal-slider/tiny-carousel-horizontal-slider.php";
}

function tch_help()
{
	window.open("http://www.gopiplus.com/work/2012/05/26/tiny-carousel-horizontal-slider-wordpress-plugin/");
}