<?php 

include("includes/dbconnect.php");

$get_video_url = "SELECT video_id, video_url FROM videos WHERE video_source='TikTok'";
$result = mysqli_query($link, $get_video_url);
while ($row = mysqli_fetch_array($result)) {
    $url = $row['video_url'];
    $video_id = $row['video_id'];

    $tiktok = "https://www.tiktok.com/oembed?url=".$url;

    $curl = curl_init($tiktok);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        $data = json_decode($return, true);

        curl_close($curl);

        $tiktok_thumbain_url=$data['thumbnail_url'];

        $update_thumb = "UPDATE videos SET video_thumbnail='$tiktok_thumbain_url' WHERE video_id=$video_id";
        //echo $update_thumb;
        $result_update_thumb = mysqli_query($link, $update_thumb);
}    

echo "Done!";