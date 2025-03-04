<?php
	include("includes/dbconnect.php");

		$video_id = $_GET['video_id'];

		    //get total numbers of records
  	    $count_all ="SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id and a.video_id=$video_id";
  	    
  	    $count_result=mysqli_query($link, $count_all);
  	    $total = mysqli_num_rows($count_result);

  	    $tags ="";
  	 	$get_tags = "SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id LIMIT 6";
  	 	//echo $get_tags;
		$result=mysqli_query($link, $get_tags);

		while ($row = mysqli_fetch_array($result)) {
			   $tag_id= $row['tag_id'];
			   $tag_name= $row['tag_name'];

			   $tags .= "<button class='button' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			   }
			   if($total>6){
			   	 $remain = intval($total) - 6;
			   	  $tags.="<button class='button'>+ $remain tags</button>";
			   }

	$tags .= "<button class='button app_badge' name='new_tag' video-id=$video_id><i class='fa fa-plus'></i></button>";  

	echo $tags;
