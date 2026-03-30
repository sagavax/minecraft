<?php

    include('../includes/dbconnect.php');
    include('../includes/functions.php');

    global $link;

    $modpack_name = "";
    $video_id = $_GET['minecraft_is_id'];

    $get_modpack = "SELECT a.modpack_name, b.modpack_id from modpacks a, videos_modpacks b where video_id = $video_id AND a.modpack_id = b.modpack_id";
    //echo $get_modpack;
    $result = mysqli_query($link, $get_modpack) or die(mysqli_error($link));
    while($row = mysqli_fetch_array($result)) {
        $modpack_name = $row['modpack_name'];
    }

    echo json_encode($modpack_name);