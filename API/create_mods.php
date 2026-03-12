<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');

$video_id = $_POST['video_id'];
$mod = mysqli_real_escape_string($link, $_POST['mod']);
//get_modpack_id
$get_mod_id = "SELECT cat_id from mods where cat_name='$modpack'";
$result = mysqli_query($link, $get_mod_id);
if ($result && $row = mysqli_fetch_array($result)) {
    $mod_id = $row['cat_id'];
}

$create_mod = "INSERT INTO videos_mods (video_id, cat_id) VALUES ($video_id, $mod_id)";
$result = mysqli_query($link, $create_mod) or die("MySQLi ERROR: ".mysqli_error($link)); 