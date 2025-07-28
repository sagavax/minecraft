<?php

include("includes/dbconnect.php");
include("includes/functions.php");

$new_image_name = mysqli_real_escape_string($link, $_POST['new_image_name']); 
$image_id = intval($_POST['image_id']);

$update_image_name="UPDATE pictures SET picture_title='$new_image_name' WHERE picture_id=$image_id";
$result = mysqli_query($link, $update_image_name) or die(mysqli_error($link));

//add to log
$diary_text="Bol upraveny nazov obrazka s ID $image_id na $new_image_name";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";   
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));