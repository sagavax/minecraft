<?php

include("includes/dbconnect.php");  

$picture_id = $_POST['picture_id'];

$remove_picture = "DELETE from pictures WHERE picture_id=$picture_id";  
$result = mysqli_query($link, $remove_picture) or die(mysqli_error($link));

$remove_picture_tags = "DELETE from tags_list WHERE picture_id=$picture_id";  
$result = mysqli_query($link, $remove_picture_tags) or die(mysqli_error($link));

//remove comments
$remove_comments = "DELETE from picture_comments WHERE pic_id=$picture_id";
$result = mysqli_query($link, $remove_comments) or die(mysqli_error($link));


//add to log
$diary_text="Minecraft IS: Bol vymazany obrazok s ID $picture_id";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";   
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));