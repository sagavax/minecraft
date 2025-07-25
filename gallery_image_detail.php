<?php

include("includes/dbconnect.php");
include("includes/functions.php");


$picture_id = $_GET['image_id'];     

$get_imag_details="SELECT picture_id, picture_name,picture_title, picture_description, picture_path from pictures where picture_id=$picture_id";
//echo $sql;

$result = mysqli_query($link, $get_imag_details) or die(mysqli_error($link));

$images = array(); // Pole, do ktorého uložíme všetky obrázky

while ($row = mysqli_fetch_array($result)) {
    $images[] = array(
        'picture_id' => $row['picture_id'],
        'picture_title' => $row['picture_title'],
        'picture_description' => $row['picture_description'],
        'picture_name' => $row['picture_name'],
        'picture_path' => $row['picture_path']
    );
}

// Nastavenie hlavičky, aby výstup bol JSON
header('Content-Type: application/json');
echo json_encode($images);
?>