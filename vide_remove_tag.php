<?php

	include("includes/dbconnect.php");


	$tag =$_POST['tag'];
	$video_id = $_POST['video_id'];
	//var_dump($_POST);

	$delete_tag = "DELETE from video tags where tag_id = '$tag_id' and video_id = '$video_id'";
	$result=mysqli_query($link, $delete_tag);

  $diary_text="Tag s id <strong>$tag_id</strong> pre video s id <a href='video.php?video_id=$video_id'>$video_id</a> bol vymazany";
  $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
  $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
  
