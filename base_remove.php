<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";
    header("Access-Control-Allow-Origin: *");


    $base_id = $_POST['base_id'];


    $remove_base = "DELETE FROM modpack_bases WHERE base_id=$base_id";
    $result = mysqli_query($link, $remove_base) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to log
    $diary_text="Baza s id $base_id bola vymazana";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));