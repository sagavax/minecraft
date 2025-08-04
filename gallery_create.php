<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$gallery_name = mysqli_real_escape_string($link, $_POST['gallery_name']);
$gallery_decription = mysqli_real_escape_string($link, $_POST['gallery_description']); //$_POST['gallery_description'];
$gallery_category = mysqli_real_escape_string($link, $_POST['gallery_category']); //$_POST['gallery_category'];

$create_gallery = "INSERT INTO picture_galleries (gallery_name, gallery_description, gallery_category,added_date) VALUES ('$gallery_name', '$gallery_decription', '$gallery_category',now())";
$result = mysqli_query($link, $create_gallery) or die("MySQLi ERROR: ".mysqli_error($link));

//get max id
$getmax_id = "SELECT max(gallery_id) as max_id from picture_galleries";
$result = mysqli_query($link, $getmax_id) or die("MySQLi ERROR: ".mysqli_error($link));
$row = mysqli_fetch_array($result);   
$max_id = $row['max_id'];

//add to log
$diary_text="Bola vytvorena gallery s menom $gallery_name";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

?>