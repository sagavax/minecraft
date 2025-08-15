<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $mod_id = $_POST['mod_id'];
    $modpack_id = $_POST['modpack_id'];

    $rmeove_from_modpack = "DELETE FROM modpack_mods WHERE modpack_id=$modpack_id AND mod_id=$mod_id";
    $result = mysqli_query($link, $rmeove_from_modpack) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text= "Mod s id $mod_id bol vymazany z modpacku s id $modpack_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
