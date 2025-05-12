<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $image_id = $_POST['image_id'];
    $comment = mysqli_real_escape_string($link,$_POST['comment_text']);

    $add_comment = "INSERT INTO video_comments (video_id, video_comment, comment_date) VALUES ($video_id,'$comment',now())";
    $result_comments = mysqli_query($link, $add_comment) or die(mysqli_error($link));


    //add to log
    $diary_text="Minecraft IS: Bolo pridane novy kommentar k obrazku s id <b>$image_id</b>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));