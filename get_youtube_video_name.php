<?php

$apiKey = 'AIzaSyAC_XmxuN31PHNDUX2ghzRcOAr80PFOfBU';

$url = $_GET['videoUrl'];



function get_youtube($url) {
    $youtube = "https://www.youtube.com/oembed?url=" . $url . "&format=json";
    //echo $youtube;

    $curl = curl_init($youtube);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
    }

    curl_close($curl);
    
    return (json_decode($return, true));
    
}


 $data = get_youtube($url); 
 //print_r($data);
 echo $data['title'];

// "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=7bvocbK7CaI&format=json"