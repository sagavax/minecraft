<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');


$get_latest_video_id = "SELECT video_id FROM videos ORDER BY video_id DESC LIMIT 1";
$result = mysqli_query($link, $get_latest_video_id) or die(mysqli_error($link));
while ($row = mysqli_fetch_array($result)) {
    $video_id = $row['video_id'];
    echo $video_id;
}