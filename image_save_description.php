<?php

include("includes/dbconnect.php");


$image_id = $_POST['image_id'];
$imaget_desscription = mysqli_real_escape_string($link, $_POST['imaget_desscription']);


$uppate_description = "update pictures set picture_desscription='$image_description' where image_id='$image_id'";
$result = mysqli_query($link, $uppate_description) or die(mysqli_error);


//app logi

$diary_text = "Minecraft IS: Bol upravil popis obrazka s ID $image_id";
$add_to_diary = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $add_to_diary) or die(mysqli_error);

?>