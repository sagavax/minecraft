<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";
    

    
    $coord_x = $_POST['coord_x'];
    $coord_y = $_POST['coord_y'];
    $coord_z = $_POST['coord_z'];


    if(isset($_POST['modpack_id'])) {
        $modpack_id = $_POST['modpack_id'];
        $create_modpack_base = "INSERT INTO modpack_bases (modpack_id, coord_x, coord_y, coord_z, added_date) VALUES ($modpack_id,'$coord_x', '$coord_y', '$coord_z',now())";
        $result = mysqli_query($link, $create_modpack_base) or die(mysqli_error($link));
    } else {
        $create_vanilla_base = "INSERT INTO vanilla_bases (coord_x, coord_y, coord_z, added_date)  VALUES ($modpack_id,'$coord_x', '$coord_y', '$coord_z',now())";
        $result = mysqli_query($link, $create_modpack_base) or die(mysqli_error($link));
    }


    if(isset($_POST['modpack_id'])) {
        $modpack_name = GetModpackName($modpack_id);
        $diary_text="Bola pridana nova baza s koordinatami X: $coord_x, Y: $coord_y, Z: $coord_z do modpacku $modpack_name";
    } else {
        $diary_text="Nova baza s koordinatami X: $coord_x, Y: $coord_y, Z: $coord_z bola vytvorena";
    }

    $new_base="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $new_base) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to log
    