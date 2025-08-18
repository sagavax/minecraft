<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $modpack_id = $_POST['modpack_id'];
    $modpac_status = $_POST['modpack_status'];

    $update_modpack_status = "UPDATE modpacks SET is_active=$modpac_status WHERE modpack_id=$modpack_id";
    $result = mysqli_query($link, $update_modpack_status) or die("MySQLi ERROR: ".mysqli_error($link));

    $diary_text="Bol zmeneny status modpacku s id $modpack_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
    