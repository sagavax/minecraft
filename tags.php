<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['add_new_tag'])){
        $tag_name=trim(mysqli_real_escape_string($link, $_POST['new_tag_name']));
        
        if($tag_name==""){
            echo "<script>alert('Nic si nevlozil !!!');
            window.lotagion.href='tags.php';
            </script>";
        } else {
        
        $sql="SELECT * from tags_list where tag_name='$tag_name'";    
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        $num_now=mysqli_num_rows($result);
        if($num_now>0){
            echo "<script>alert('Pozor duplikat !!!');
            window.lotagion.href='tags.php';
            </script>";
            
        }
        else {


        $sql="INSERT INTO tags_list (tag_name, tag_modified) VALUES ('$tag_name',now())";
       //echo $sql;
        $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));;

      
        
        $diary_text="Minecraft IS: Bolo bol pridany tag s nazvom <b>$tag_name</b>";
        $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
        $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
        
      
       echo "<script>
            alert('Novy mod $tag_name bol pridany');
            window.lotagion.href='tags_list.php';
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
    <title>Minecraft IS - tags</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="js/tags.js" defer></script>
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
                          echo "<button type='button'>$char</button>";

                        }
                          echo "<button type='button' name='all''>All</button>";
                          echo "<button type='button' name='dupes'>Find dupes</a></li>";
                          ?>  
                                             
                </div><!--letter list --> 
                
                <div id='tags_list'>
                      
                      <?php

                        $itemsPerPage = 30;

                      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                      $offset = ($current_page - 1) * $itemsPerPage;  


                        if(isset($_GET['alphabet'])){
                            $char=$_GET['alphabet'];
                            if($char=="dupes"){
                              $sql="SELECT tag_name,  COUNT(*) AS count FROM tags_list GROUP BY tag_name HAVING count > 1";
                            } else if($char=="all"){
                              $sql="SELECT * from tags_list ORDER BY tag_name ASC LIMIT $itemsPerPage OFFSET $offset";
                            } else {
                              $sql="SELECT * from tags_list where left(tag_name,1)='$char' ORDER BY tag_name ASC";  
                            }
                         } else {
                          $sql="SELECT * from tags_list ORDER BY tag_name ASC LIMIT $itemsPerPage OFFSET $offset";
                         }  
                        //echo $sql;   
                        $result=mysqli_query($link, $sql) or die(mysqli_error($link));
                        while ($row = mysqli_fetch_array($result)) {
                            $tag_id=$row['tag_id'];
                            $tag_name=$row['tag_name'];
                            //$tag_description=$row['tag_description'];
                        
                            echo "<div class='tag' data-id=$tag_id><div class='tag_name'>$tag_name</div><div class='tag_action'><i class='fas fa-times-circle' title='Delete tag'></i>";

                             /*  if($tag_description==""){
                                echo "<div class='tag_description'><i class='fas fa-plus-circle'></i></div>";  
                              }
 */
                              echo "</div>"; //div class tag action
                            echo "</div>"; //div class tag tagegory
                        }  

                      ?>
                      
                  </div><!-- tagegories / tags_list list -->
                     <?php
                    // Calculate the total number of pages
                    $count_tags_list = "SELECT COUNT(*) as total FROM tags_list";
                    $result=mysqli_query($link, $count_tags_list);
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
</body>
