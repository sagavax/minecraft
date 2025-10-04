<?php
include "includes/dbconnect.php";
include "includes/functions.php";



// Nastav svoj YouTube Data API v3 kľúč
$apiKey = 'AIzaSyAC_XmxuN31PHNDUX2ghzRcOAr80PFOfBU';

// Vstup z POST
$channelInput = $_POST['influencer-id'] ?? '';
$channelInput = trim($channelInput);

if ($channelInput === '') {
    http_response_code(400);
    exit('Channel ID alebo @handle je povinné');
}

// Helper: zavolá API a vráti JSON
function http_get_json(string $url): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 10,
    ]);
    $res = curl_exec($ch);
    if ($res === false) {
        throw new RuntimeException(curl_error($ch));
    }
    curl_close($ch);
    $data = json_decode($res, true);
    if (!is_array($data)) {
        throw new RuntimeException('Invalid JSON');
    }
    if (isset($data['error']['message'])) {
        throw new RuntimeException($data['error']['message']);
    }
    return $data;
}

// Získa channelId z @handle alebo UC…
function resolve_channel_id(string $input, string $apiKey): string {
    if (preg_match('~^UC[0-9A-Za-z_-]{22}$~', $input)) {
        return $input; // už je to channelId
    }
    if (preg_match('~youtube\.com/(?:channel/)(UC[0-9A-Za-z_-]{22})~i', $input, $m)) {
        return $m[1];
    }
    if (preg_match('~youtube\.com/@([A-Za-z0-9._-]+)~i', $input, $m)) {
        $input = '@'.$m[1];
    }

    $handle = ltrim($input, '@');
    $search = http_get_json('https://www.googleapis.com/youtube/v3/search?' . http_build_query([
        'part' => 'snippet',
        'type' => 'channel',
        'q' => '@'.$handle,
        'maxResults' => 1,
        'key' => $apiKey
    ]));
    $channelId = $search['items'][0]['id']['channelId'] ?? null;
    if (!$channelId) {
        throw new RuntimeException('Channel nenájdený pre ' . htmlspecialchars($input));
    }
    return $channelId;
}

// Načíta všetky playlisty
function get_channel_playlists(string $channelId, string $apiKey): array {
    $out = [];
    $token = null;
    do {
        $url = 'https://www.googleapis.com/youtube/v3/playlists?' . http_build_query([
            'part' => 'snippet,contentDetails',
            'channelId' => $channelId,
            'maxResults' => 50,
            'pageToken' => $token,
            'key' => $apiKey
        ]);
        $data = http_get_json($url);
        foreach ($data['items'] ?? [] as $it) {
            $thumbs = $it['snippet']['thumbnails'] ?? [];
            $thumb  = $thumbs['maxres']['url']
                   ?? $thumbs['standard']['url']
                   ?? $thumbs['high']['url']
                   ?? $thumbs['default']['url']
                   ?? '';
            $out[] = [
                'id' => $it['id'],
                'title' => $it['snippet']['title'],
                'thumb' => $thumb,
                'count' => $it['contentDetails']['itemCount'] ?? 0,
                'url' => 'https://www.youtube.com/playlist?list='.$it['id']
            ];
        }
        $token = $data['nextPageToken'] ?? null;
    } while ($token);
    return $out;
}

// -- hlavná logika --
try {
    $channelId = resolve_channel_id($channelInput, $apiKey);
    $playlists = get_channel_playlists($channelId, $apiKey);
} catch (Throwable $e) {
    http_response_code(400);
    exit('Chyba: '.$e->getMessage());
}

// Render HTML
foreach ($playlists as $pl) {
    $title = htmlspecialchars($pl['title'], ENT_QUOTES, 'UTF-8');
    $thumb = htmlspecialchars($pl['thumb'], ENT_QUOTES, 'UTF-8');
    $href  = htmlspecialchars($pl['url'], ENT_QUOTES, 'UTF-8');

   $add_to_db = "INSERT IGNORE INTO influencer_playlists (influencer_id, playlist_id, playlist_title, playlist_thumb, added_date) VALUES ('$channelInput', '{$pl['id']}','{$pl['title']}','{$pl['thumb']}', NOW())";    
   $result = mysqli_query($link, $add_to_db) or die(mysqli_error($link));

    echo "<div class='playlist_item' data-id='{$pl['id']}'>
              <img src='{$thumb}' alt='{$title}'>
              <div class='playlist_title'>{$title}</div>
          </div>";
}
