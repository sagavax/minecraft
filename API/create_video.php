<?php
include("../includes/dbconnect.php");
include("../includes/functions.php");
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Neplatný JSON formát']);
    exit;
}

if (!filter_var($data['video_url'], FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(['error' => 'URL nie je v platnom formáte']);
    exit;
}

$title = $link->real_escape_string(trim($data['video_title']));
$url   = $link->real_escape_string(trim($data['video_url']));

$check_video = "SELECT * FROM videos WHERE video_url = '$url'";
$result = $link->query($check_video);

if ($result->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['error' => 'Video s týmto URL už existuje']);
    exit;
}

if (strpos($url, 'youtube.com') !== false) {
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    $video_id = $params['v'] ?? null;
} elseif (strpos($url, 'youtu.be') !== false) {
    $video_id = ltrim(parse_url($url, PHP_URL_PATH), '/');
} else {
    $video_id = null;
}

$video_thumb = "https://img.youtube.com/vi/" . $video_id . "/0.jpg";

$edition    = "java";
$source     = "YouTube";
$modpack_id = 2;

$create_video = "
    INSERT INTO videos (video_title, video_url, edition, video_thumbnail, video_source, added_date)
    VALUES ('$title', '$url', '$edition', '$video_thumb', '$source', NOW())
";

if ($link->query($create_video) === TRUE) {
    $video_id = $link->insert_id;
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Chyba pri ukladaní videa: ' . $link->error]);
    exit;
}

$add_to_modpack_list = "
    INSERT INTO videos_modpacks (video_id, modpack_id)
    VALUES ($video_id, $modpack_id)
";

if ($link->query($add_to_modpack_list) === TRUE) {
    http_response_code(201);
    echo json_encode([
        'success'  => 'Video bolo úspešne uložené a pridané do modpacku',
        'video_id' => $video_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Chyba pri pridávaní videa do modpacku: ' . $link->error]);
}
?>