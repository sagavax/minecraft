<?php

include("includes/dbconnect.php");
include("includes/functions.php");

$image_url = mysqli_real_escape_string($link, $_GET['image_url']);


$check_image = "SELECT count(*) as nr_images FROM pictures WHERE picture_path='$image_url'";
$result = mysqli_query($link, $check_image) or die(mysqli_error($link));
$row = mysqli_fetch_array($result);
if($row['nr_images'] > 0) {
    echo "true";
} else {
    echo "false";
}