<?php

    include('../includes/dbconnect.php');
include('../includes/functions.php');

    global $link;

    $video_id = $_GET['minecraft_is_id'];
    $mod_name = "";

    $get_mod = "SELECT a.cat_name from mods a, videos_mods b where b.video_id = $video_id and a.mod_id = b.mod_id";
    $result = mysqli_query($link, $get_mod) or die(mysqli_error($link));
     
    while($row = mysqli_fetch_array($result)) {
        $mod_name = $row['cat_name'];
    }

    echo json_encode(['mod_name' => $mod_name]);