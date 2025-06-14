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

$sql = "SELECT * FROM videos ORDER BY video_id DESC";

$result = mysqli_query($link, $sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Chyba pri načítavaní videí: ' . mysqli_error($link)]);
    exit;
}

$videos = [];

while ($row = mysqli_fetch_array($result)) {
    $video_id = $row['video_id'];
    
    $video = [
        'video_id' => $video_id,
        'video_name' => $row['video_title'],
        'video_url' => $row['video_url'],
        'is_favorite' => (bool)$row['is_favorite'],
        'watch_later' => (bool)$row['watch_later'],
        'video_thumbnail' => $row['video_thumbnail'],
        'edition' => $row['edition'],
        'tags' => GetVideoTagList($video_id),
        'modpack' => GetVideoModpack($video_id),
        'mods' => GetVideoMods($video_id),
        'actions' => [
            'watch_later' => [
                'available' => true,
                'current_state' => (bool)$row['watch_later']
            ],
            'favorite' => [
                'available' => true,
                'current_state' => (bool)$row['is_favorite']
            ],
            'can_edit' => true,
            'can_delete' => true,
            'can_add_note' => true,
            'can_add_tag' => true,
            'can_change_modpack' => true,
            'can_add_mod' => true
        ],
        'play_url' => "video.php?video_id=$video_id"
    ];
    
    $videos[] = $video;
}

// Úspešná odpoveď
http_response_code(200);
echo json_encode([
    'success' => true,
    'count' => count($videos),
    'videos' => $videos
]);
?>