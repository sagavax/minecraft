<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $modpack_id = $_POST['modpack_id'];
    $modpack_description = mysqli_real_escape_string($link, $_POST['modpack_description']); //$_POST['modpack_description'];

    $update_change_description = "UPDATE modpacks SET modpack_description = '$modpack_description' WHERE modpack_id = $modpack_id";
    $result = mysqli_query($link, $update_change_description) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to log
    $modpack_name = GetModpackName($modpack_id);
    $diary_text="Bol upraveny description modpacku $modpack_name";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


