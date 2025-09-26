<?php
// Nastavte svoj YouTube Data API v3 kľúč
$apiKey = 'AIzaSyAC_XmxuN31PHNDUX2ghzRcOAr80PFOfBU';

$channelInput = $_POST['influencer-id'] ?? '';

if (empty($channelInput)) {
    echo json_encode(['error' => 'Channel ID or handle is required']);
    exit;
}

function get_channel_id_from_handle($handle, $apiKey) {
    // Metóda 1: Použijeme YouTube API search
    $searchUrl = "https://www.googleapis.com/youtube/v3/search" .
                "?part=snippet" .
                "&type=channel" .
                "&q=" . urlencode($handle) .
                "&key=" . $apiKey;
    
    $ch = curl_init($searchUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 10,
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $data = json_decode($response, true);
        if (!empty($data['items'])) {
            // Overíme či je to presný match
            foreach ($data['items'] as $item) {
                if (strtolower($item['snippet']['customUrl'] ?? '') === strtolower('@' . $handle) || 
                    strtolower($item['snippet']['title']) === strtolower($handle)) {
                    return $item['snippet']['channelId'];
                }
            }
            // Ak nenájdeme presný match, berieme prvý výsledok
            return $data['items'][0]['snippet']['channelId'];
        }
    }
    
    // Metóda 2: Scraping ako backup
    $ch = curl_init("https://www.youtube.com/@" . $handle);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    $html = curl_exec($ch);
    curl_close($ch);
    
    if ($html && preg_match('/"channelId":"(UC[^"]+)"/', $html, $matches)) {
        return $matches[1];
    }
    
    return null;
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

// Ak je to handle (@username), konvertujeme na Channel ID
if (strpos($channelInput, '@') === 0 || !preg_match('/^UC[a-zA-Z0-9_-]{22}$/', $channelInput)) {
    $handle = ltrim($channelInput, '@');
    $channelId = get_channel_id_from_handle($handle, $apiKey);
    
    if (!$channelId) {
        echo json_encode(['error' => 'Could not find Channel ID for handle: ' . $handle]);
        exit;
    }
} else {
    $channelId = $channelInput;
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

//echo <div class=""$result['totalPlaylists'] . " playlists found.";

foreach ($playlists as $pl) {
    echo "<div class='playlist_item'>
                <img src='{$pl['thumbnail']}' alt='Thumbnail'>
                <div class='playlist_info'>
                    <div class='playlist_title'>{$pl['title']}</div>
                </div>
          </div>";
}
//echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
/* <div class='playlist_video_count'>{$pl['videoCount']} videos</div> */
?>