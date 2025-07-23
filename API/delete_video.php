<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$video_url = mysqli_real_escape_string($link, $_POST['video_url']); //$_POST['video_url'];


//get video id from list of videos
$sql = "SELECT video_id FROM videos WHERE video_url = '$video_url'";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
$row = mysqli_fetch_array($result);
$video_id = $row['video_id'];

//delete video
$sql = "DELETE FROM videos WHERE video_id = '$video_id'";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


//remoov from list of favorites
$sql = "UPDATE videos SET is_favorite = 0 WHERE video_id = '$video_id'";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

//remove from watch later
$sql = "UPDATE videos SET watch_later = 0 WHERE video_id = '$video_id'";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

//remove from video tags
$sql = "DELETE FROM video_tags WHERE video_id = '$video_id'";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));