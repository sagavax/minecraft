<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $new_seed = isset($_POST['create_new_seed']) ? $_POST['create_new_seed'] : '';

    //check if seed already exists
    $check_seed = "SELECT seed FROM modpack_seeds WHERE seed='$new_seed'";
    $seed_result = mysqli_query($link, $check_seed) or die("MySQLi ERROR: ".mysqli_error($link));
    if (mysqli_num_rows($seed_result) > 0) {
        json_encode(array("status" => "info", "message" => "Seed already exists."));
        exit;
    } else {
        //create new seed
        $create_new_seed = "INSERT INTO modpack_seeds (seed) VALUES ('$new_seed')";
        $result=mysqli_query($link, $create_new_seed) or die("MySQLi ERROR: ".mysqli_error($link));
    }

    json_encode(array("status" => "success", "message" => "New seed created successfully."));