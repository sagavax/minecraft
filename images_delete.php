<?php

    include ("includes/dbconnect.php");
    include("includes/functions.php");


    $image_id = $_POST['image_id'];


    $remove_images = "DELETE FROM pictures WHERE id = '$image_id'";
    mysqli_query($link, $remove_images) or die(mysqli_error($link));

    echo json_encode(("success" => true, "message" => "Image removed successfully."));
