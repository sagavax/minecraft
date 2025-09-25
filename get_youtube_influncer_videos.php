<?php

$channelUrl = $_GET['channelUrl'];

function get_channel_id($url) {
    if (preg_match('/channel\/(UC[^\/]+)/', $url, $matches)) {
        return $matches[1];
    } elseif (preg_match('/@([^\/]+)/', $url, $matches)) {
        $username = $matches[1];
        $ch = curl_init("https://www.youtube.com/@$username");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $html = curl_exec($ch);
        curl_close($ch);
        if (preg_match('/"channelId":"(UC[^"]+)"/', $html, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function get_youtube_oembed($url) {
    $oembed_url = "https://www.youtube.com/oembed?url=" . urlencode($url) . "&format=json";
    $ch = curl_init($oembed_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 10,
    ]);
    $res = curl_exec($ch);
    if (curl_errno($ch)) {
        curl_close($ch);
        return null;
    }
    curl_close($ch);
    return json_decode($res, true);
}

$channelId = get_channel_id($channelUrl);
if (!$channelId) {
    echo json_encode(['error' => 'Invalid channel URL']);
    exit;
}

$rssUrl = "https://www.youtube.com/feeds/videos.xml?channel_id=" . $channelId;
$ch = curl_init($rssUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$xml = curl_exec($ch);
curl_close($ch);

if (!$xml) {
    echo json_encode(['error' => 'Failed to fetch RSS']);
    exit;
}

$feed = simplexml_load_string($xml);
$videos = [];
foreach ($feed->entry as $entry) {
    $videoId = (string)$entry->children('yt', true)->videoId;
    $videoUrl = "https://www.youtube.com/watch?v=" . $videoId;
    $oembed = get_youtube_oembed($videoUrl);
    $videos[] = [
        'title' => $oembed['title'] ?? (string)$entry->title,
        'url' => $videoUrl,
        'thumbnail' => $oembed['thumbnail_url'] ?? '',
        'author' => $oembed['author_name'] ?? '',
        'published' => (string)$entry->published,
    ];
}

echo json_encode($videos);