<?php

include("includes/dbconnect.php");
include("includes/functions.php");


$currAddress = $_SERVER['SERVER_NAME'];
      if($currAddress == 'localhost') {
          $api_host = "http://localhost/tagsphere/";
      } else {
          $api_host = "https://tagsphere.tmisura.sk";
      }

      $letter = mysqli_real_escape_string($link, $_GET['letter']);
      $apiUrl = $api_host.'/api/api.php?application_name=minecraft&letter=' . urlencode($letter);

      //echo "<p style='color: #fff; text-align: center;'>$apiUrl</p>";

      $ch = curl_init();

          curl_setopt_array($ch, [
              CURLOPT_URL => $apiUrl,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_TIMEOUT => 10,
              CURLOPT_HTTPGET => true,
          ]);

          $response = curl_exec($ch);
          $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
          $curlError = curl_error($ch);

          $data = null;
          $errorMessage = null;

          if ($response === false || $curlError !== '') {
              echo "<p style='color:red'>Nepodarilo sa spojiť s API.</p>";
          } elseif ($httpCode !== 200) {
              echo "<p style='color:red'>API vrátilo HTTP kód: $httpCode</p>";
          } else {
              $data = json_decode($response, true);

              if (json_last_error() !== JSON_ERROR_NONE) {
                  echo "<p style='color:red'>Odpoveď z API nie je validný JSON.</p>";
              } elseif ($data) {
                  foreach ($data as $tag) {
                      echo "<div class='tag' data-tag-id='{$tag['tag_id']}'>";
                      echo "<span class='tag_name'>{$tag['tag_name']}</span>";
                      echo "<div class='tag_actions'>";
                      echo "<button class='delete_button'><i class='fa fa-trash'></i></button>";
                      echo "</div>";
                      echo "</div>";
                  }
              }
          }