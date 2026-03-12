<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $data = [
    'bug_title' => $bug_title,
    'bug_text' => $bug_text,
    'bug_priority' => $bug_priority,
    'bug_status' => $bug_status,
    'bug_application' => 'mineccraft'
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $api_host."/api/api.php?endpoint=bugs",
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
