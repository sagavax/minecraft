<?php 

	include("includes/dbconnect.php");

	
	$get_short_url = "SELECT * FROM videos WHERE video_url LIKE '%youtu.be%'";
	$result = mysqli_query($link, $get_short_url);
	while ($row = mysqli_fetch_array($result)) {
		$video_id = $row['video_id'];
		$shortURL = $row['video_url'];

		$videoID =  substr($shortURL, strrpos($shortURL, '/') + 1);

		$new_url = "https://www.youtube.com/watch?v=" . $videoID;

		$set_new_url = "UPDATE videos SET video_url='$new_url' WHERE video_id =$video_id";
		$result_new_url = mysqli_query($link, $set_new_url);
	}
  
  echo "Done...";


