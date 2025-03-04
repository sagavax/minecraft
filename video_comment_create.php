<?php

		include("includes/dbconnect.php");

		$video_id = $_POST['video_id'];
		$comment = $_POST['comment'];

		//var_dump($_POST);

		$add_comment = "INSERT INTO video_comments (video_id, video_comment, comment_date) VALUES ($video_id,'$comment',now())";
		$result_comments = mysqli_query($link, $add_comment);

		$diary_text="Minecraft IS: Bolo pridane novy kommentar k videu id <b>$video_id</b>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));