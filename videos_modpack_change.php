<?php
include("includes/dbconnect.php");
include("includes/functions.php");

$modpack_id = $_POST['modpack_id'];
$video_id = $_POST['video_id'];


$change_modpack = "UPDATE videos_modpacks SET modpack_id=$modpack_id WHERE video_id=$video_id";
$result = mysqli_query($link, $change_modpack) or die(mysqli_error($link));


//insert into diary
$diary_text="Minecraft IS: Video <b>".GetVideoName($video_id)."</b> has been moved to <b>".GetModpackName($modpack_id)."</b>";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));