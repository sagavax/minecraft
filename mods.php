<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_new_cat'])){
        $cat_name=trim(mysqli_real_escape_string($link, $_POST['new_cat_name']));
        
        if($cat_name==""){
            echo "<script>alert('Nic si nevlozil !!!');
            window.location.href='categories.php';
            </script>";
        } else {
        
        $sql="SELECT * from mods where cat_name='$cat_name'";    
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        $num_now=mysqli_num_rows($result);
        if($num_now>0){
            echo "<script>alert('Pozor duplikat !!!');
            window.location.href='categories.php';
            </script>";
            
        }
        else {


        $sql="INSERT INTO mods (cat_name, cat_modified) VALUES ('$cat_name',now())";
       //echo $sql;
        $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));;

      
        
        $diary_text="Minecraft IS: Bolo bol nony mod s nazvom <b>$cat_name</b>";
        $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
        $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
        
      
       echo "<script>
            alert('Novy mod $cat_name bol pridany');
            window.location.href='mods.php';
        </script>";
        
        }
      }
     
    }
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="js/categories.js" defer></script>
    <!-- <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script> -->
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php 
   echo "<script>sessionStorage.setItem('current_module','categories')</script>"; 
  include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
         <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
          <div class='list'>
              <div id="new_cat">
                  <h4>Add new category (mode):</h4>
                  <form action='' method='post'>
                      <input type="input" name='new_cat_name' autocomplete="off" placeholder="Add new  category..." spellcheck="false" oninput="search_mods(this.value)">
                      <div class='action'>
                        <button type='submit' name='add_new_cat' class='button small_button pull-right'><i class='fa fa-plus'></i> Add new</button>
                      </div>
                  </form>   
               </div><!-- new cat / mod -->   
               
               <div id="letter_list"><!--letter list -->
                   <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<button type='button'>$char</button>";

                        }
                          echo "<button type='button' name='all''>All</button>";
                          echo "<button type='button' name='dupes'>Find dupes</a></li>";
                          ?>  
                                             
                </div><!--letter list --> 
                
                <div id='categories_list'>
                      
                      <?php

                        $itemsPerPage = 30;

                      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                      $offset = ($current_page - 1) * $itemsPerPage;  


                        if(isset($_GET['alphabet'])){
                            $char=$_GET['alphabet'];
                            if($char=="dupes"){
                              $sql="SELECT cat_name, cat_description COUNT(*) AS count FROM mods GROUP BY cat_name HAVING count > 1";
                            } else if($char=="all"){
                              $sql="SELECT * from mods ORDER BY cat_name ASC LIMIT $itemsPerPage OFFSET $offset";
                            } else {
                              $sql="SELECT * from mods where left(cat_name,1)='$char' ORDER BY cat_name ASC";  
                            }
                         } else {
                          $sql="SELECT * from mods ORDER BY cat_name ASC LIMIT $itemsPerPage OFFSET $offset";
                         }  
                        //echo $sql;   
                        $result=mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $cat_id=$row['cat_id'];
                            $cat_name=$row['cat_name'];
                            $cat_description=$row['cat_description'];
                        
                            echo "<div class='category' data-id=$cat_id><div class='cat_name'>$cat_name</div><div class='cat_action'>";

                              if($cat_description==""){
                                echo "<div class='cat_description'><i class='fas fa-plus-circle' title='Add description'></i></div>";  
                              }

                              echo "<div class='cat_delete'><i class='fas fa-times-circle' title='Delete mod'></i></div>";
                              echo "</div>"; //div class cat action
                            echo "</div>"; //div class cat category
                        }  

                      ?>
                      
                  </div><!-- categories / mods list -->
                     <?php
                    // Calculate the total number of pages
                    $count_mods = "SELECT COUNT(*) as total FROM mods";
                    $result=mysqli_query($link, $count_mods);
                    $row = mysqli_fetch_array($result);
                    $totalItems = $row['total'];
                    $totalPages = ceil($totalItems / $itemsPerPage);

                    // Display pagination links
                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $totalPages; $i++) {
                      echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                    }
                    echo '</div>';
                   ?> 
                </div><!--list -->
        </div><!--content -->      

        <dialog id="mod_description">
          <div class="dialog_inner_container">
            <span class="mod_name"></span>
            <textarea placeholder="mod's description" name="mod_description"></textarea>
            <input type="text" name="mod_url" placeholder="mod's url">
            <input type="text" name="mod_image" placeholder="image's url">
          </div><!-- inner container-->
        
          <div class="action">
            <button name="dialog_close" class="button small_button"><i class="fa fa-times"></i></button>
            <button name="mod_update" class="button small_button"><i class="fa fa-plus"></i></button>
          </div>

        </dialog>

        <div id="mod_info">
          <div class="mod_name"></div>
          <div class="mod_description"></div>
          <div class="mod_url"></div>
          <div class="mod_images"></div>

          <diov class="mod_modpack_list"></diov>
        </div>
</body>
