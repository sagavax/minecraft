<?php

	include("includes/dbconnect.php");


	$tag =$_POST['tag'];
	$video_id = $_POST['video_id'];

	//var_dump($_POST);




	/*$get_tag_id="SELECT tag_id from tags_list WHERE tag_name='$tag'";
	$result=mysqli_query($link, $get_tag_id);
	$row = mysqli_fetch_array($result);
	$tag_id = $row['tag_id'];
*/
	//echo $tag_id;

	$delete_tag = "DELETE from video_tags where tag_id = $tag and video_id = $video_id";
	//echo $delete_tag;
	$result=mysqli_query($link, $delete_tag);

   $diary_text = "Tag s id <strong>$tag</strong> bol odtraneny z videa id  <a href='video.php?video_id=$video_id'>$video_id</a>";
   $diary_text=mysqli_real_escape_string($link,$diary_text);
  $add_to_log="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
  $result = mysqli_query($link, $add_to_log) or die("MySQLi ERROR: ".mysqli_error($link));
  	