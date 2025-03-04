<?php

	include "includes/dbconnect.php";
	include "includes/functions.php";

	$video_id=$_POST['video_id'];

	echo GetVideoTags($video_id);