<?php 

include("includes/dbconnect.php");

$get_video_url = "SELECT video_id, video_url FROM videos WHERE video_source='YouTube'";
//echo $get_video_url;
$result = mysqli_query($link, $get_video_url);

while ($row = mysqli_fetch_array($result)) {
    $url = $row['video_url'];
    $video_id = $row['video_id'];

    $query = parse_url($url, PHP_URL_QUERY);

    parse_str($query, $params);

    // Check if the 'v' parameter (video ID) exists
    if (isset($params['v'])) {
        // Return the video ID
        $video_id_th = $params['v'];
        $video_thumb = "https://img.youtube.com/vi/".$video_id_th."/0.jpg";

        // Insert or update the thumbnail in the database
        $update_thumb = "UPDATE videos SET video_thumbnail='$video_thumb' WHERE video_id=$video_id";
        echo $update_thumb;
        $result_update_thumb = mysqli_query($link, $update_thumb);

        if (!$result_update_thumb) {
            // Handle the error if the query fails
            //echo "Error updating thumbnail: " . mysqli_error($link);
        }
    }
}

echo "Done...";
?>
