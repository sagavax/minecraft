<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');

$data = json_decode(file_get_contents('php://input'), true);

//print_r($data); 

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Neplatný JSON formát']);
    exit;
}

//$modpack_id = (int)$data['modpack_id'];
$modpackDescription = mysqli_real_escape_string($link, $data['modpack_description']);
$modpackVersion = mysqli_real_escape_string($link, $data['modpack_version']);
$modpackImage = mysqli_real_escape_string($link, $data['modpack_image']);
$modpackName = mysqli_real_escape_string($link, $data['modpack_name']);
$modpack_id = (int)$data['modpack_id'];

$update_modpack = "UPDATE modpacks SET modpack_description='$modpackDescription', modpack_version='$modpackVersion', modpack_image='$modpackImage', modpack_name='$modpackName' WHERE modpack_id='$modpack_id'";
    $result = mysqli_query($link, $update_modpack) or die("MySQLi ERROR: ".mysqli_error($link));
    echo json_encode(['success' => true, 'modpack_id' => $modpack_id]);

?>