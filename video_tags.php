<?php 
	include("includes/dbconnect.php");

$video_id  = $_GET['video_id'];
$tags = array();

$get_tags = "SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id";
$result=mysqli_query($link, $get_tags);

$video_tags = array(); // Initialize the array to store the tags

while ($row = $result->fetch_assoc()) {
    // Create an associative array with tag_id as key and tag_name as value
    $video_tags[$row['tag_id']] = $row['tag_name'];
}

// $video_tags now contains the desired associative array

	$tags_json = json_encode($video_tags);

	print_r($tags_json);
