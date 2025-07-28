<?php
include("includes/dbconnect.php");
include("includes/functions.php");

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Načítaj JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validácia vstupu
if (!isset($input['tag_name']) || empty(trim($input['tag_name']))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Tag name is required.']);
    exit;
}

$tag_name = trim(mysqli_real_escape_string($link, $input['tag_name']));

// Vloženie do databázy
$sql = "INSERT INTO tags_list (tag_name, tag_modified) VALUES ('$tag_name', NOW())";
$result = mysqli_query($link, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($link)]);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Tag created successfully!']);
