<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");

    $currAddress = $_SERVER['SERVER_NAME'];
      if($currAddress == 'localhost') {
          $api_host = "http://localhost/tagsphere/";
      } else {
          $api_host = "https://tagsphere.tmisura.sk";
      }

      $new_tag = mysqli_real_escape_string($link, $_POST['tag_name']);
      $application_name = mysqli_real_escape_string($link, $_POST['application_name']);
      
      $apiUrl = $api_host.'/api/api.php?application_name=' . urlencode($application_name);
      $postData = json_encode(['tag_name' => $new_tag, 'application_name' => $application_name]);

      $ch = curl_init();

          curl_setopt_array($ch, [
              CURLOPT_URL => $apiUrl,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_TIMEOUT => 10,
              CURLOPT_POST => true,
              CURLOPT_POSTFIELDS => $postData,
              CURLOPT_HTTPHEADER => [
                  "Content-Type: application/json",
                  "Accept: application/json"
              ],
          ]);

          $response = curl_exec($ch);
          $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
          $curlError = curl_error($ch);

          $data = null;
          $errorMessage = null;

          if ($response === false || $curlError !== '') {
              $errorMessage = 'Nepodarilo sa spojiť s API.';
          } elseif ($httpCode !== 200) {
              $errorMessage = 'API vrátilo HTTP kód: ' . $httpCode;
          } else {
              $data = json_decode($response, true);

              if (json_last_error() !== JSON_ERROR_NONE) {
                  $errorMessage = 'Odpoveď z API nie je validný JSON.';
              }
          }



?>

