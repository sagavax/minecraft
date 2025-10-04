<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");

    $seed_number = mysqli_real_escape_string($link,$_POST['seed_number']);
    $modpack_id = $_POST['modpack_id'];


    $add_seed = "INSERT INTO modpack_seeds (seed,modpack_id,added_date) VALUES ('$seed_number',$modpack_id,now())";
    //echo $add_seed;
    $result = mysqli_query($link, $add_seed) or die("MySQLi ERROR: " . mysqli_error($link));


    //add to log
    $diary_text="Bol pridany seed cislo $seed_number";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));