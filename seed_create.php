<?php

    include("includes/dbconnect.php");

    header("Content-Type: application/json; charset=utf-8");

    if (!isset($_POST['seed']) || !is_string($_POST['seed']) || trim($_POST['seed']) === '') {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Seed is required."]);
        exit;
    }

    $new_seed = trim($_POST['seed']);
    $escaped_seed = mysqli_real_escape_string($link, $new_seed);

    $check_seed = mysqli_query($link, "SELECT seed FROM modpack_seeds WHERE seed = '$escaped_seed'");
    if (!$check_seed) {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Unable to check whether the seed already exists."]);
        exit;
    }
    if (mysqli_num_rows($check_seed) > 0) {
        mysqli_free_result($check_seed);
        echo json_encode(["success" => false, "info" => true, "message" => "Seed already exists."]);
        exit;
    }
    mysqli_free_result($check_seed);

    $create_new_seed = mysqli_query($link, "INSERT INTO modpack_seeds (seed, added_date) VALUES ('$escaped_seed', NOW())");
    if (!$create_new_seed) {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Unable to create the seed."]);
        exit;
    }

    echo json_encode(["success" => true, "message" => "New seed created successfully."]);
