<?php


$url = "https://www.tiktok.com/@fortressgames/video/6957711024975793414?is_from_webapp=1&sender_device=pc&web_id=7159114764323522053";

 $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
    }


    curl_close($curl);

     json_decode($return, true);

     echo $return;

