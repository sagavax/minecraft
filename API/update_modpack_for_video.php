<?php

    include('../includes/dbconnect.php');
    include('../includes/functions.php');
   
    $data = json_decode(file_get_contents('php://input'), true);

    //print_r($data);

    $video_id = $data['minecraft_is_id'];
    $video_modpack = mysqli_real_escape_string($link, $data['modpack_name']);

    //get modpack id from modpacks table
    $get_modpack_id_query = "SELECT modpack_id FROM modpacks WHERE modpack_name='$video_modpack'";
    $get_modpack_id_result = mysqli_query($link, $get_modpack_id_query) or die("MySQLi ERROR: ".mysqli_error($link));
    $modpack_id = mysqli_fetch_assoc($get_modpack_id_result);

   //check if modpack is associated with video, if not insert, if yes update
    $is_modpack_set = "SELECT modpack_id FROM videos_modpacks WHERE video_id=$video_id";
    $is_modpack_set_result = mysqli_query($link, $is_modpack_set) or die("MySQLi ERROR: ".mysqli_error($link));
    if (mysqli_num_rows($is_modpack_set_result) == 0) {
        $insert_modpack = "INSERT INTO videos_modpacks (video_id, modpack_id) VALUES ($video_id, {$modpack_id['modpack_id']})";
        $insert_modpack_result = mysqli_query($link, $insert_modpack) or die("MySQLi ERROR: ".mysqli_error($link));
    } else {
        //update modpack id for the video   
      $update_video_modpack = "UPDATE videos_modpacks SET modpack_id={$modpack_id['modpack_id']} where video_id=$video_id";
    /*$update_video_modpack = "INSERT INTO videos_modpacks (video_id, modpack_id) 
VALUES ($video_id, {$modpack_id['modpack_id']}) ON DUPLICATE KEY UPDATE modpack_id={$modpack_id['modpack_id']}";*/
    $result = mysqli_query($link, $update_video_modpack) or die("MySQLi ERROR: ".mysqli_error($link));
    }