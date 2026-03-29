<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');
   
    $data = json_decode(file_get_contents('php://input'), true);

    //print_r($data);

    $video_id = $data['minecraft_is_id'];
    $video_mod = mysqli_real_escape_string($link, $data['mod_name']);

    //get mod id from mods table
    $get_mod_id_query = "SELECT cat_id FROM mods WHERE cat_name='$video_mod'";
    $get_mod_id_result = mysqli_query($link, $get_mod_id_query) or die("MySQLi ERROR: ".mysqli_error($link));
    $mod_id = mysqli_fetch_assoc($get_mod_id_result);

   //check if mod is associated with video, if not insert, if yes update
    $is_mod_set = "SELECT cat_id FROM videos_mods WHERE video_id=$video_id";
    $is_mod_set_result = mysqli_query($link, $is_mod_set) or die("MySQLi ERROR: ".mysqli_error($link));
    if (mysqli_num_rows($is_mod_set_result) == 0) {
        $insert_mod = "INSERT INTO videos_mods (video_id, cat_id) VALUES ($video_id, {$mod_id['cat_id']})";
        $insert_mod_result = mysqli_query($link, $insert_mod) or die("MySQLi ERROR: ".mysqli_error($link));
    } else {
        //update mod id for the video   
      $update_video_mod = "UPDATE videos_mods SET cat_id={$mod_id['cat_id']} where video_id=$video_id";
    $result = mysqli_query($link, $update_video_mod) or die("MySQLi ERROR: ".mysqli_error($link));
    }