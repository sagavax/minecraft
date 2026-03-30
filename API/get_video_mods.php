<?php

    include('../includes/dbconnect.php');
include('../includes/functions.php');



    $video_id = $_GET['minecraft_is_id'];

    $get_modpack = "SELECT cat_name from videos_mods where video_id = $video_id";
    $result = mysqli_query($link, $get_modpack) or die(mysqli_error($link));
    $modpacks = []; 
    while($row = mysqli_fetch_array($result)) {
        $mods[] = $row['cat_name'];
    }

    echo json_encode($mods);