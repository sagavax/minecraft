<?php include "includes/dbconnect.php";
      include "includes/functions.php";

?>      
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="js/app_log.js" defer></script>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
         <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
          <div class='list'>
              <div id="app_log">
                  <input type='text' name='new_cat_name' autocomplete="off" placeholder="Search in app log..." spellcheck="false" oninput="search_log(this.value)">
               </div>   
               
                  <div id='applog_list'>
                      <ul>
                      <?php

                      //reparatio for paging
                      $itemsPerPage = 10;

                      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                      $offset = ($current_page - 1) * $itemsPerPage;

                      $sql="SELECT * FROM app_log ORDER BY id  DESC LIMIT $itemsPerPage OFFSET $offset";
                          //echo $sql;   
                      $result=mysqli_query($link, $sql);
                      while ($row = mysqli_fetch_array($result)) {
                        $id=$row['id'];
                        $text= $row['diary_text'];
                        
                        echo "<div class='log_record'><div class='log_text'>$text</div></div>";

                      }    
                      ?>
                      </ul>
                  </div>
                    <?php
                        // Calculate the total number of pages
                        $sql = "SELECT COUNT(*) as total FROM app_log";
                        $result=mysqli_query($link, $sql);
                        $row = mysqli_fetch_array($result);
                        $totalItems = $row['total'];
                        $totalPages = ceil($totalItems / $itemsPerPage);

                        // Display pagination links
                        echo '<div class="pagination">';
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                        }
                       echo "</div>";
                     ?> 
                </div>
              </div><!--list -->
        </div><!--content -->      