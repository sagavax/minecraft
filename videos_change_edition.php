<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$video_id = $_POST['video_id'] ?? null;
$edition = $_POST['edition'] ?? null;


//update video edition
if ($video_id && $edition) {
    $sql = "UPDATE videos SET edition = '$edition' WHERE video_id = $video_id";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $msg = "Video edition updated successfully.";
    } else {
        $msg = "Error updating video edition: " . mysqli_error($link);
    }

    echo $msg;

    //add to wall
    
}