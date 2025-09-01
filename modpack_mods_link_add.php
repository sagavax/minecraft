<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");

    $modpack_id = $_POST['modpack_id'];
    $mods_link = mysqli_real_escape_string($link,$_POST['link']);

    $add_link = "INSERT INTO modpack_mods_links (modpack_id,  modpack_mods_url, added_date) VALUES ($modpack_id, '$mods_link', now())";
    $result = mysqli_query($link, $add_link) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to log
    $diary_text="Bol pridany link na modpack s id $modpack_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));