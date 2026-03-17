<?php

    include '../../includes/dbconnect.php';
     
    $idea_title = mysqli_real_escape_string($link,$_POST['idea_title']) ?? '';
    $idea_text = mysqli_real_escape_string($link,$_POST['idea_text']);   

    $idea_priority = mysqli_real_escape_string($link,$_POST['idea_priority'] );
    $idea_status = mysqli_real_escape_string($link,$_POST['idea_status']);
     

    $data = [
    'idea_title' => $idea_title,
    'idea_text' => $idea_text,
    'idea_priority' => $idea_priority,
    'idea_status' => $idea_status,
    'idea_application' => 'minecraft'
];

$api_host = (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost') ? 'http://localhost/bugbuster' : 'https://bugbuster.sk';


$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $api_host."/api/api.php?endpoint=ideas",
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

if ($errno) {
    http_response_code(500);
    die(json_encode(['error' => "cURL Error: $error"]));
} else {
    echo $response; // Vráť odpoveď z API
}