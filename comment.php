<?php

    include("includes/dbconnect.php");
    $text = mysqli_real_escape_string($link,$_POST['video_comment']);
    $video_id=$_POST['video_id'];
    
   
   $sql="INSERT into video_comments (video_id,video_comment, comment_date ) VALUES ($video_id, '$text', now())";
   $result=mysqli_query($link, $sql);

   $diary_text="Minecraft IS: Bolo bol novy kommentar k videu s id $video_id";
   $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
?>    