<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $base_id = $_POST['base_id'];
    $modpack_id = $_POST['modpack_id'];
    $base_description = $_POST['base_description'];


    $update_base_description = "UPDATE modpack_bases SET base_description='$base_description' WHERE base_id=$base_id and modpack_id=$modpack_id";
    $result = mysqli_query($link, $update_base_description) or die("MySQLi ERROR: ".mysqli_error($link));


    $modpack_name = GetModPackName($modpack_id);

    $diary_text="Bol zmeneny description bazy s id $base_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));