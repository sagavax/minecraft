<?php

include("includes/dbconnect.php");


$image_id = $_POST['image_id'];
$image_description = mysqli_real_escape_string($link, $_POST['description']);


$update_description = "update pictures set picture_description='$image_description' where picture_id='$image_id'";
$result = mysqli_query($link, $update_description) or die(mysqli_error);


//app logi

$diary_text = "Minecraft IS: Bol upravil popis obrazka s ID $image_id";
$add_to_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $add_to_diary) or die(mysqli_error);

?>