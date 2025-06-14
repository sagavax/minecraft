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

$get_videos_tags = "SELECT a.tag_id, b.tag_name FROM video_tags a, tags_list b WHERE a.tag_id NOT IN (0) AND a.tag_id = b.tag_id GROUP BY b.tag_name ORDER BY b.tag_name ASC";

$result_tags = mysqli_query($link, $get_videos_tags);
if (!$result_tags) {
    http_response_code(500);
    echo json_encode(['error' => 'Chyba pri načítavaní tagov: ' . mysqli_error($link)]);
    exit;
}

$tags = [];

while ($row_tags = mysqli_fetch_array($result_tags)) {
    $tag = [
        'tag_id' => (int)$row_tags['tag_id'],
        'tag_name' => $row_tags['tag_name']
    ];
    
    $tags[] = $tag;
}

// Úspešná odpoveď
http_response_code(200);
echo json_encode([
    'success' => true,
    'count' => count($tags),
    'tags' => $tags
]);
?>