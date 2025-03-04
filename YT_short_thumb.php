<?php 

include("includes/dbconnect.php");

function getYouTubeVideoId($url) {
    $parsedUrl = parse_url($url);
    
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);

        if (isset($queryParams['v'])) {
            return $queryParams['v'];
        }
    } elseif (isset($parsedUrl['path'])) {
        $pathSegments = explode('/', trim($parsedUrl['path'], '/'));

        if (in_array('shorts', $pathSegments) && count($pathSegments) === 2) {
            return $pathSegments[1];
        }
    }

    return false;
}



$get_video_url = "SELECT video_id, video_url FROM videos WHERE video_source='YouTube'";
//echo $get_video_url;
$result = mysqli_query($link, $get_video_url);

while ($row = mysqli_fetch_array($result)) {
    $url = $row['video_url'];
    $video_id = $row['video_id'];

    if( strpos( $url, "/shorts/" ) !== false) { //ak je video shorts
       $video_id_th = getYouTubeVideoId($url);
       $video_thumb = "https://img.youtube.com/vi/".$video_id_th."/0.jpg";
        $update_thumb = "UPDATE videos SET video_thumbnail='$video_thumb' WHERE video_id=$video_id";
        $result_update_thumb = mysqli_query($link, $update_thumb);
    }
}

echo "Done...";
?>
