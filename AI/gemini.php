<?php
// Tvoj API kľúč
$apiKey = 'AIzaSyCjaKCtKv3PnJFPoOpon6OSIQdSJNUCd84'; // Zmeň na svoj skutočný API kľúč

// API endpoint
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

// Text, ktorý chceš poslať
$data = [
    "contents" => [
        [
            "parts" => [
                [
                    "text" => "Explain how AI works in a few words"
                ]
            ]
        ]
    ]
];

// Nastavenie HTTP hlavičiek a údajov
$options = [
    "http" => [
        "header"  => "Content-type: application/json\r\nX-goog-api-key: $apiKey\r\n",
        "method"  => "POST",
        "content" => json_encode($data)
    ]
];

$context  = stream_context_create($options);

// Zavolanie API a získanie odpovede
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    die('Chyba pri volaní API!');
}

header("Content-Type: application/json");
echo $result;
?>