<?php
     include("includes/dbconnect.php");
     include("includes/functions.php");

     $video_id = $_POST['video_id'];
     $tag_id = $_POST['tag_id'];
     
     $save_tag = "INSERT into video_tags (video_id, tag_id) VALUES($video_id, $tag_id)";
     $result=mysqli_query($link, $save_tag) or die(mysqli_error($link));

     $diary_text="bol pridany tag id <b>$tag_id<b> do videa s id <b>$tag_id<b>";
     $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
     $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
