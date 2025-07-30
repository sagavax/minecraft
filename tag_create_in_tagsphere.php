<?php

include("includes/dbconnect.php");
include("includes/functions.php");

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

  

    //send a new tag to tagsspere 

    $data = [
    'tag_name' => $tag_name,
    'tag_application ' => 'minecraft'
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "http://localhost/tagsphere/api/api.php?endpoint=tags",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Accept: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode($data),
    ]);

    $response = curl_exec($curl);
    $errno = curl_errno($curl);
    $error = curl_error($curl);
    curl_close($curl);

    if ($errno) {
        http_response_code(500);
        die(json_encode(['error' => "cURL Error: $error"]));
    } else {
        echo $response; // Vráť odpoveď z API
    }