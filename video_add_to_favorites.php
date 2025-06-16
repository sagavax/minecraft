<?php
include "includes/dbconnect.php";

$video_id = intval($_POST['video_id']);
$video_name = mysqli_real_escape_string($link, $_POST['video_name']);
$sql = "UPDATE videos SET is_favorite = 1 WHERE video_id = $video_id";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: " . mysqli_error($link));

// Create entry in application log
$diary_text = "Minecraft IS: video s nazvom $video_name bolo pridane medzi oblubene videa";
$sql = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: " . mysqli_error($link));

