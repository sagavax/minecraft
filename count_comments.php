<?php

include "includes/dbconnect.php";

     $video_id = $_GET['video_id'];
     $sql ="SELECT COUNT(*) as nr_of_comments from video_comments where video_id=".$video_id;
	 $result=mysqli_query($link, $sql);
	 $row = mysqli_fetch_array($result);
	 $nr_of_comments=$row['nr_of_comments'];	

     echo $nr_of_comments;
	 