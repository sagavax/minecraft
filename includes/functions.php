<?php 
include("includes/dbconnect.php");

function SubtasksQty($task_id){
	global $link;
	$query="SELECT * from to_do where parent_task=$task_id";
	$result=mysqli_query($link, $query);
	$nr_subtasks=mysqli_num_rows($result);
	return $nr_subtasks;
}


function GetSubtasks($task_id){
	global $link;
	$query="SELECT * from to_do WHERE parent_task=$task_id and is_completed=0 ORDER BY task_id DESC";
	//echo $query;
	$result=mysqli_query($link, $query);
	while ($row = mysqli_fetch_array($result)) {
	  		$task_text=$row['task_text'];
	  		$parent_task=$task_id;
	  		$subtask_id=$row['task_id'];
	   		$task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);		
	   		$subtasks="<div class='subtask'><div class='subtask_text'>$task_text</div><form action='' method='post'><input type='hidden' name='subtask_id' value='$subtask_id'><button type='submit' name='close_subtask' class='button small_button small_font pull-right'><i class='fa fa-check'></i></buton></form></div>";
	   		//$subtasks.= "<div class='subtask_action'><form action='' method='post'><input type='text' name='subtask_text' value=''><button type='' name='add_subtask' class='button small_button pull_right'>+</buton></form></div>";
	   		echo $subtasks;
	   	}	
	}

function CheckOpenSubtasks($task_id) {
	global $link;
  	$query="SELECT count(*) as nr_opened_subtasks from to_do where is_completed=0 and parent_task=$task_id";
  	$result=mysqli_query($link, $query);
  	 $row = mysqli_fetch_array($result);
  	 $nr_opened_subtasks=$row['nr_opened_subtasks'];

	if($nr_opened_subtasks>0) {
		$has_opened_subtasks=1;
	} else {
		$has_opened_subtasks=0;
	}
	
 	return $has_opened_subtasks;
		
}


function GetModName($mod_id) {
	global $link;
	$mod_name="";
	if($mod_id==0){
		$cat_name="";
	} else {
	$query="SELECT cat_name from category where cat_id=$mod_id";
	$result=mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
		   $mod_name= $row['cat_name'];

	   }
	}   
	 return $mod_name;
  	
}

function GetModPackName($modpack_id){
	global $link;
	$modpack_name="";
	if($modpack_id==0){
		$modpack_name="";
	} else {
	$query="SELECT modpack_name from modpacks where modpack_id=$modpack_id";
	$result=mysqli_query($link, $query);
   	while ($row = mysqli_fetch_array($result)) {
		$modpack_name= $row['modpack_name'];
		}
	}	
	return $modpack_name;	
}


function GetModList($modpack_id){
	global $link;
	$list="<ul>";
	$sql="SELECT * from modpack_mods where modpack_id=$modpack_id";
	$result=mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$mod_id=$row['cat_id'];
		$mod=GetModName($mod_id);
	    $list=$list."<li><span class='span_mod'>$mod</span></li>";
	   }	
	   $list.="<li><a class='span_mod' title='Add mod to this modpack' href='#'>+</a></li></ul>";
	return $list;
	//   return $mod;
}

function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
{
    $path = $uploadDir . '/' . $image_name;

    $mime = getimagesize($path);

    if($mime['mime']=='image/png') { 
        $src_img = imagecreatefrompng($path);
    }
    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
        $src_img = imagecreatefromjpeg($path);
    }   

    $old_x          =   imageSX($src_img);
    $old_y          =   imageSY($src_img);

    if($old_x > $old_y) 
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $old_y*($new_height/$old_x);
    }

    if($old_x < $old_y) 
    {
        $thumb_w    =   $old_x*($new_width/$old_y);
        $thumb_h    =   $new_height;
    }

    if($old_x == $old_y) 
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $new_height;
    }

    $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


    // New save location
    $new_thumb_loc = $moveToDir . $image_name;

    if($mime['mime']=='image/png') {
        $result = imagepng($dst_img,$new_thumb_loc,8);
    }
    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
        $result = imagejpeg($dst_img,$new_thumb_loc,80);
    }

    imagedestroy($dst_img); 
    imagedestroy($src_img);

    return $result;
}


//https://www.9lessons.info/2014/07/ajax-upload-and-resize-image-with-php.html

function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth)
{

if($ext=="jpg" || $ext=="jpeg" )
{
$src = imagecreatefromjpeg($uploadedfile);
}
else if($ext=="png")
{
$src = imagecreatefrompng($uploadedfile);
}
else if($ext=="gif")
{
$src = imagecreatefromgif($uploadedfile);
}
else
{
$src = imagecreatefrombmp($uploadedfile);
}

list($width,$height)=getimagesize($uploadedfile);
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
$filename = $path.$newwidth.'_'.$actual_image_name; //PixelSize_TimeStamp.jpg
imagejpeg($tmp,$filename,100);
imagedestroy($tmp);
return $filename;
}

function is_category_in_sync($cat_id){
	//connect 
}

function get_nr_base_notes($base_id){
	global $link;
	$sql="SELECT count(*) as nr_of_notes from vanila_base_info_note where zakladna_id=$base_id";
	$result=mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$nr_of_notes=$row['nr_of_notes'];

	return $nr_of_notes;
}


function modpacks ($module){
	global $link;
	echo "<ul>";
	if($module=="tasks"){

		$sql="SELECT DISTINCTROW a.modpack_id, b.modpack_name from to_do a, modpacks b where a.modpack_id=b.modpack_id";
	} elseif ($module=="notes"){
		$sql="SELECT DISTINCTROW a.modpack_id, b.modpack_name from notes a, modpacks b where a.modpack_id=b.modpack_id";
	}

	$result=mysqli_query($link, $sql);
	while($row = mysqli_fetch_array($result)) {
		$modpack_name=$row['modpack_name'];
		$modpack_id=$row['modpack_id'];
		echo "<li class='span_modpack'><a href='$module.php?modpack_id=$modpack_id'>$modpack_name</a></li>";
	}
   echo "<ul>";	
}

/**
 * Generates a Universally Unique IDentifier, version 4.
 *
 * RFC 4122 (http://www.ietf.org/rfc/rfc4122.txt) defines a special type of Globally
 * Unique IDentifiers (GUID), as well as several methods for producing them. One
 * such method, described in section 4.4, is based on truly random or pseudo-random
 * number generators, and is therefore implementable in a language like PHP.
 *
 * We choose to produce pseudo-random numbers with the Mersenne Twister, and to always
 * limit single generated numbers to 16 bits (ie. the decimal value 65535). That is
 * because, even on 32-bit systems, PHP's RAND_MAX will often be the maximum *signed*
 * value, with only the equivalent of 31 significant bits. Producing two 16-bit random
 * numbers to make up a 32-bit one is less efficient, but guarantees that all 32 bits
 * are random.
 *
 * The algorithm for version 4 UUIDs (ie. those based on random number generators)
 * states that all 128 bits separated into the various fields (32 bits, 16 bits, 16 bits,
 * 8 bits and 8 bits, 48 bits) should be random, except : (a) the version number should
 * be the last 4 bits in the 3rd field, and (b) bits 6 and 7 of the 4th field should
 * be 01. We try to conform to that definition as efficiently as possible, generating
 * smaller values where possible, and minimizing the number of base conversions.
 *
 * @copyright  Copyright (c) CFD Labs, 2006. This function may be used freely for
 *              any purpose ; it is distributed without any form of warranty whatsoever.
 * @author      David Holmes <dholmes@cfdsoftware.net>
 *
 * @return  string  A UUID, made up of 32 hex digits and 4 hyphens.
 */

function uuid() {
  
	// The field names refer to RFC 4122 section 4.1.2
 
	return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
		mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
		mt_rand(0, 65535), // 16 bits for "time_mid"
		mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
		bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
		mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node" 
	); 
 }
