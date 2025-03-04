<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";
 
    $video_id = $_POST['video_id'];

    $delete_video= "DELETE from videos WHERE video_id=$video_id";
    $result=mysqli_query($link, $delete_video);

    echo "removed_video";


    
