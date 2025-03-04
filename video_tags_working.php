<?php 
	include("includes/dbconnect.php");

    $video_id  = $_GET['video_id'];
	$tags = array();

	$get_tags = "SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id";
	//echo $get_tags;
    $result=mysqli_query($link, $get_tags);
	while ($row = mysqli_fetch_array($result)) {
		array_push($tags,$row['tag_name']);
	}
	
	//$tags_json = json_encode($video_tags);

	echo json_encode($tags);