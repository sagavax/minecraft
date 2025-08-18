<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $mod_id = $_POST['mod_id'];
       $video_url = mysqli_real_escape_string($link, $_POST['video_url']);
       $video_title = mysqli_real_escape_string($link, $_POST['video_title']);


       $add_video = "INSERT INTO mod_videos (mod_id, video_title, video_url, added_date) VALUES ($mod_id, '$video_title','$video_url', now())";
       mysqli_query($link, $add_video) or die(mysqli_error($link));

       // aktualizuje denník
       $diary_text = "Pre mod s id $mod_id: bolp pridane video";
       $update_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
       //echo $update_diary;
       mysqli_query($link, $update_diary) or die("MySQLi ERROR: " . mysqli_error($link));