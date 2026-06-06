<?php 
include "includes/dbconnect.php";
include "includes/functions.php";

$sql = "SELECT * FROM videos ORDER BY video_id DESC LIMIT 1";
$result = mysqli_query($link, $sql);

// Initialize an array to hold the video data
$videoData = array();

// Fetch the latest video record
if ($row = mysqli_fetch_assoc($result)) {
    $videoData = array(
        'video_id' => $row['video_id'],
        'video_title' => $row['video_title'],
        'video_url' => $row['video_url'],
        'is_favorite' => $row['is_favorite'],
        'watch_later' => $row['watch_later'],
        'video_thumbnail' => $row['video_thumbnail'],
        'video_edition' => $row['edition'] 
    );
}

// Set header to output JSON content
header('Content-Type: application/json');

// Output the video data as JSON
echo json_encode($videoData);