<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$influncer_name = mysqli_real_escape_string($link,$_POST['influencer_name']);
$influncer_description = mysqli_real_escape_string($link,$_POST['influencer_description']);
$influncer_channel_link = mysqli_real_escape_string($link,$_POST['influencer_url']);
$influncer_image = mysqli_real_escape_string($link,$_POST['influencer_image']);

//$influncer_image = "influencers/$influncer_name"."png";
// Function to write image into file
//file_put_contents($influncer_image, file_get_contents($influncer_image));


$create_new_influncer = "INSERT INTO influencers (influencer_name, influencer_channel_link,influencer_description,influencer_image,added_date) VALUES ('$influncer_name','$influncer_channel_link','$influncer_description','$influncer_image',now())";
$result = mysqli_query($link, $create_new_influncer) or die("MySQLi ERROR: ".mysqli_error($link));

//get max id
/* $getmax_id = "SELECT max(influncer_id) as max_id from influencer";
$result = mysqli_query($link, $getmax_id) or die("MySQLi ERROR: ".mysqli_error($link));
$row = mysqli_fetch_array($result);   
$max_id = $row['max_id']; */

//add to log
$diary_text="Bol vytvoreny novy influencer s menom $influncer_name";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


header("Location: influencers.php");
exit();
?>