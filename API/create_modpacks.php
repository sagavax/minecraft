<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');

$video_id = $_POST['video_id'];
$modpack = mysqli_real_escape_string($link, $_POST['modpack']);
//get_modpack_id
$get_modpack_id = "SELECT modpack_id from modpacks where modpack_name='$modpack'";
$result = mysqli_query($link, $get_modpack_id);
if ($result && $row = mysqli_fetch_array($result)) {
    $modpack = $row['modpack_id'];
}

$create_mod = "INSERT INTO videos_modpacks (video_id, modpack_id) VALUES ($video_id, $modpack_id)";
$result = mysqli_query($link, $create_mod) or die("MySQLi ERROR: ".mysqli_error($link)); 