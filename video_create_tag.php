<?php

	include("includes/dbconnect.php");


	//check if tag already exists
	
	$tag_name = $_POST['tag_name'];
	$video_id = $_POST['video_id'];

	$check_tag = "SELECT tag_name from tags_list WHERE tag_name='$tag_name'";
	$result=mysqli_query($link, $check_tag);
	$rowcount=mysqli_num_rows($result);
	if($rowcount==0){ // not exists
		//create a new tag
		$create_tag = "INSERT INTO tags_list (tag_name) VALUES ('$tag_name')";
		$result=mysqli_query($link, $create_tag);


	//get it's ID
	$getmax_id = "SELECT max(tag_id) as max_id from tags_list";
	$result=mysqli_query($link, $getmax_id);
	 while ($row = mysqli_fetch_array($result)) {
	 	$max_id = $row['max_id'];
	}

	$add_to_video_tags = "INSERT INTO video_tags (video_id, tag_id) VALUES ($video_id,$max_id)";
	$result=mysqli_query($link, $add_to_video_tags);

  $diary_text = "Tag s id <strong>$max_id </strong> bol pridany  do videa <a href='video.php?video_id=$video_id'>$video_id</a>";
  $diary_text=mysqli_real_escape_string($link,$diary_text);
  $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";

  $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));	


   } else { //existuje
   	//get id of existing tags
   	$get_id = "SELECT tag_id from tags_list WHERE tag_name ='$tag_name'";
   	$result=mysqli_query($link, $get_id);
   	$row=mysqli_fetch_array($result);
   	$old_tag_id = $row['tag_id'];	

   		//inset it into database

	$add_to_video_tags = "INSERT INTO video_tags (video_id, tag_id) VALUES ($video_id,$old_tag_id)";
	$result=mysqli_query($link, $add_to_video_tags);

//add to log	
   if(isset($old_tag_id)){
   	$tag_id=$old_tag_id;
   }
   $diary_text = "Tag s id <strong>$tag_id </strong> bol pridany  do videa <a href='video.php?video_id=$video_id'> $video_id</a>";
   $diary_text=mysqli_real_escape_string($link,$diary_text);
  $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
  $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));	

}
   

	
	