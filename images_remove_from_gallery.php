<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    header("Content-Type: application/json; charset=utf-8");


    $gallery_id = (int)$_POST['gallery_id'];
    $image_id = (int)$_POST['image_id'];


    $remove_image_from_gallery = "DELETE FROM pictures_gallery_images WHERE gallery_id = $gallery_id AND picture_id = $image_id";
    mysqli_query($link, $remove_image_from_gallery) or die("Error removing image from gallery: " . mysqli_error($link));  

    echo json_encode(["success" => true, "message" => "Image removed from gallery successfully."]);
