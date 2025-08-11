<?php

$apiKey = 'YOUR_YOUTUBE_API_KEY'; // Váš API kľúč
$username = 'YouTuberUsername'; // Meno YouTubera (username)

$url = "https://www.googleapis.com/youtube/v3/channels?part=id,snippet&forUsername=$username&key=$apiKey";

// Načítanie dát z API
$response = file_get_contents($url);
$data = json_decode($response, true);

if (!empty($data['items'])) {
    $channelId = $data['items'][0]['id'];
    // Zostavenie odkazu na channel
    $channelLink = "https://www.youtube.com/channel/" . $channelId;
    //echo "YouTube channel link: " . $channelLink;
} else {
    echo "Kanál pre zadané meno nebol nájdený.";
}

?>