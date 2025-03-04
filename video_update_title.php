<?php

        include "includes/dbconnect.php";
        include "includes/functions.php";

        $new_video_title = $_POST['video_title'];
        $video_id = $_POST['video_id'];

        $update_video_ttile = "UPDATE videos SET video_title = '$new_video_title' WHERE video_id=$video_id";
        $result = mysqli_query($link, $update_video_ttile) or die(mysqli_error($link));

        $diary_text="Minecraft IS: Video name has been update to <b>$new_video_title<b>";
        $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
        $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));