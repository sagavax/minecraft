<?php include "includes/dbconnect.php";
      include "includes/functions.php";
 $currAddress = $_SERVER['SERVER_NAME'];
      if($currAddress == 'localhost') {
          $api_host = "http://localhost/tagsphere/";
      } else {
          $api_host = "https://tagsphere.tmisura.sk";
      }

      $apiUrl = $api_host.'/api/api.php?application_name=minecraft';
    
      echo "<p style='color: #fff; text-align: center;'>$apiUrl</p>";

    
      // Požiadavka na API
     
    
      // Inicializácia cURL pro požiadavku na API
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS - tags</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="js/tags.js?<?php echo time() ?>" defer></script>
    <!-- <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script> -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php 
   echo "<script>sessionStorage.setItem('current_module','tagegories')</script>"; 
  include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
         <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
          <div class='list'>
              <div id="new_tag">
                  <h4>Add new tag(s):</h4>
                  <form action='' method='post'>
                      <input type="input" name='new_tag_name' autocomplete="off" placeholder="Add new tag..." spellcheck="false" oninput="search_tags(this.value)">
                      <div class='action'><button type='submit' name='add_new_tag' class='button small_button pull-right'><i class='fa fa-plus'></i> Add new</button></div>
                  </form>   
               </div><!-- new tag / mod -->   
               
               <div id="letter_list"><!--letter list -->
                   <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<button type='button' class='button yellow_button rounded_button' name='letter'>$char</button>";

                        }
                          echo "<button type='button' class='button yellow_button rounded_button' name='all''>All</button>";
                          echo "<button type='button' class='button yellow_button rounded_button' name='dupes'>Find dupes</a></li>";
                          ?>  
                                             
                </div><!--letter list --> 
                
                <div id='tags_list'>
                     <?php
                        if ($errorMessage) {
                            echo "<p style='color: red; text-align: center;'>$errorMessage</p>";
                        } elseif ($data) {
                            // Zobrazit data z API
                            foreach ($data as $tag) {
                                echo "<div class='tag' data-tag-id='{$tag['tag_id']}'>";
                                echo "<span class='tag_name'>{$tag['tag_name']}</span>";
                                echo "<div class='tag_actions'>";
                                //echo "<button class='edit_button'><i class='fa fa-edit'></i></button>";
                                echo "<button class='delete_button'><i class='fa fa-trash'></i></button>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p style='color: red; text-align: center;'>Žádná data k zobrazení.</p>";
                        }

                  ?>
                      
                  </div><!-- tagegories / tags_list list -->
                     <?php
                   
                   ?> 
                </div><!--list -->
        </div><!--content -->      
</body>
