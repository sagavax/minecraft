<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');

//$video_id = $_POST['video_id'];
$data = json_decode(file_get_contents('php://input'), true);

// Kontrola JSON dekódovania
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Neplatný JSON formát']);
    exit;
}

$modpack = mysqli_real_escape_string($link, $data['modpack_name']);
//get_modpack_id
$get_modpack_id = "SELECT modpack_id from modpacks where modpack_name='$modpack'";
$result = mysqli_query($link, $get_modpack_id);
if ($result && $row = mysqli_fetch_array($result)) {
    exit();
} else {
    //create modpack
    $create_modpack = "INSERT INTO modpacks (modpack_name) VALUES ('$modpack')";
    $result = mysqli_query($link, $create_modpack) or die("MySQLi ERROR: ".mysqli_error($link)); 
    $modpack_id = mysqli_insert_id($link);

    echo json_encode([
        'success' => true,
        'modpack_id' => $modpack_id,
        'modpack_name' => $modpack
    ]);
}