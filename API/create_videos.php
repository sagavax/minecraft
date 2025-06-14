<?php
include("includes/dbconnect.php");
include("includes/functions.php");
header('Content-Type: application/json');

// Načítaj JSON dáta z tela požiadavky
$data = json_decode(file_get_contents('php://input'), true);

// Kontrola JSON dekódovania
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Neplatný JSON formát']);
    exit;
}

// Kontrola povinných polí
if (
    !$data ||
    !isset($data['title']) || empty(trim($data['title'])) ||
    !isset($data['url']) || empty(trim($data['url'])) ||
    !isset($data['description']) || empty(trim($data['description'])) ||
    !isset($data['source']) || empty(trim($data['source'])) ||
    !isset($data['modpack_id'])
) {
    http_response_code(400);
    echo json_encode(['error' => 'Neplatné alebo neúplné dáta']);
    exit;
}

// Validácia URL
if (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(['error' => 'URL nie je v platnom formáte']);
    exit;
}

// Validácia modpack_id (musí byť kladné číslo)
if (!is_numeric($data['modpack_id']) || (int)$data['modpack_id'] <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'modpack_id musí byť kladné číslo']);
    exit;
}

// Priradenie hodnôt s escape a trim
$title = $link->real_escape_string(trim($data['title']));
$url = $link->real_escape_string(trim($data['url']));
$description = $link->real_escape_string(trim($data['description']));
$source = $link->real_escape_string(trim($data['source']));
$modpack_id = (int)$data['modpack_id'];

$sql = "INSERT INTO videos (title, url, description, source, modpack_id) VALUES ('$title', '$url', '$description', '$source', $modpack_id)";

if ($link->query($sql) === TRUE) {
    $video_id = $link->insert_id;
    http_response_code(201);
    echo json_encode([
        'success' => 'Video bolo úspešne uložené',
        'video_id' => $video_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Chyba pri ukladaní videa: ' . $link->error]);
}
?>