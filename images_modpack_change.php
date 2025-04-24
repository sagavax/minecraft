<?php
include("includes/dbconnect.php");
include("includes/functions.php");

$modpack_id = $_POST['modpack_id'];
$image_id = $_POST['image_id'];


$change_modpack = "UPDATE pictures_modpacks SET modpack_id=$modpack_id WHERE image_id=$image_id";
echo $change_modpack;
$result = mysqli_query($link, $change_modpack) or die(mysqli_error($link));


//insert into diary
$diary_text="Minecraft IS: image with id <b>$image_id</b>  has been moved to <b>".GetModpackName($modpack_id)."</b>";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));