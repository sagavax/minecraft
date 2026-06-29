<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");

    $seed_id = $_POST['seed_id'];
    
    $delete_seed = "DELETE FROM modpack_seeds WHERE seed_id = $seed_id";
    $result = mysqli_query($link, $delete_seed) or die("MySQLi ERROR: ".mysqli_error($link));
    echo json_encode(["success" => true, "message" => "Seed has been deleted successfully"]);
    ?>