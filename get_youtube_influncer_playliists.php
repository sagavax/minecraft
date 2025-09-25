<?php
// Nastavte svoj YouTube Data API v3 kľúč
$apiKey = 'AIzaSyAC_XmxuN31PHNDUX2ghzRcOAr80PFOfBU';
$channelId = $_GET['channelId'] ?? '';

if (empty($channelId)) {
    echo json_encode(['error' => 'Channel ID is required']);
    exit;
}

// Validácia Channel ID formátu
if (!preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $channelId)) {
    echo json_encode(['error' => 'Invalid Channel ID format. Must start with UC and be 24 characters long.']);
    exit;
}

function get_channel_playlists($channelId, $apiKey) {
    $playlists = [];
    $nextPageToken = '';
    
    do {
        $url = "https://www.googleapis.com/youtube/v3/playlists" . 
               "?part=snippet,contentDetails" .
               "&channelId=" . $channelId .
               "&key=" . $apiKey . 
               "&maxResults=50";
               
        if ($nextPageToken) {
            $url .= "&pageToken=" . $nextPageToken;
        }
        
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 15,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200 || !$response) {
            break;
        }
        
        $data = json_decode($response, true);
        
        if (empty($data['items'])) {
            break;
        }
        
        foreach ($data['items'] as $item) {
            $playlists[] = [
                'id' => $item['id'],
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
                'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? $item['snippet']['thumbnails']['default']['url'],
                'videoCount' => $item['contentDetails']['itemCount'],
                'url' => "https://www.youtube.com/playlist?list=" . $item['id'],
                'published' => $item['snippet']['publishedAt'],
                'channelTitle' => $item['snippet']['channelTitle']
            ];
        }
        
        $nextPageToken = $data['nextPageToken'] ?? '';
        
    } while ($nextPageToken);
    
    return $playlists;
}

// Hlavná logika
$playlists = get_channel_playlists($channelId, $apiKey);

if (empty($playlists)) {
    echo json_encode(['error' => 'No playlists found or API error']);
    exit;
}

// Výsledok
$result = [
    'channelId' => $channelId,
    'totalPlaylists' => count($playlists),
    'playlists' => $playlists
];

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>