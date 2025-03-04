<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      session_start();


      if(isset($_POST['to_apply'])){
            $idea_id = $_POST['idea_id'];

            $to_apply = "UPDATE ideas SET is_applied=1 WHERE idea_id=$idea_id";
            $result=mysqli_query($link, $to_apply);

          
            $diary_text="Minecraft IS: Ideas s id $idea_id bola aplikovana do IS ";
            $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
            $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
            

            echo "<script>alert('Minecraft IS: Ideas s id $idea bola aplikovana do IS');
              window.location.href='ideas.php';
              </script>";
      }


      if(isset($_POST['see_idea_details'])){
        $idea_id = $_POST['idea_id'];
        $_SESSION['idea_id']=$idea_id;
        $_SESSION['is_applied']=$is_applied;
        header("location:idea.php");
      }


      if(isset($_POST['delete_idea'])){
       
        $idea_id = $_POST['idea_id'];

        //remove idea
        $delete_idea = "DELETE from ideas WHERE idea_id=$idea_id";
        $result = mysqli_query($link, $delete_idea) or die("MySQLi ERROR: ".mysqli_error($link));

        //remove comments
        $delete_comments = "DELETE from ideas_comments WHERE idea_id=$idea_id";
        $result = mysqli_query($link, $delete_comments) or die("MySQLi ERROR: ".mysqli_error($link));


        $diary_text="Minecraft IS: Ideas s id $idea_id bola vymazana ";
            $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
            $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

         echo "<script>alert('Minecraft IS: Ideas s id $idea_id vratend komentarov bola vymazana');
              window.location.href='ideas.php';
              </script>";

      }

?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <script type="text/javascript" defer src="js/ideas.js"></script>
    <script type="text/javascript" defer src="js/message.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">

  </head>
  <body>
        <?php include("includes/header.php") ?>   
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>    
        <div class="main_wrap">
         <div class="content">
              <div class="list">
              
              <h3>Ideas for the informating system</h3>
              <div class="new_idea">
                <form action="ideas_save.php" method="post">
                      <input type="text" name="idea_title" placeholder="idea title here" id="idea_title" autocomplete="off">
                      <textarea name="idea_text" placeholder="Put a your idea(s) here..." id="idea_text"></textarea>
                      <div class="new_idea_action">
                        <button type="submit" name="save_idea" class="button small_button">Save</button>
                      </div>
               </form>
              </div><!-- new idea-->
              
              <div class="ideas_list">
                  <?php

                          $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;


                        $get_ideas = "SELECT * from ideas ORDER BY idea_id DESC LIMIT $itemsPerPage OFFSET $offset";
                        $result=mysqli_query($link, $get_ideas);
                        while ($row = mysqli_fetch_array($result)) {
                              $idea_id = $row['idea_id'];
                              $idea_title = $row['idea_title'];
                              $idea_text = $row['idea_text'];
                              $is_applied = $row['is_applied'];
                              $added_date = $row['added_date'];

                              echo "<div class='idea'>";
                                    echo "<form action='' method='post'>";
                                    echo "<div class='idea_title'>$idea_title</div>";
                                    echo "<div class='idea_text'>$idea_text</div>";
                                    echo "<div class='idea_footer'>";
                                    
                                      echo "<input type='hidden' name='idea_id' value=$idea_id>";
                                      echo "<input type='hidden' name='is_applied' value=$is_applied>";
                                      $nr_of_comments = GetCountIdeaComments($idea_id);
                                      echo "<div class='span_modpack'>$nr_of_comments comment(s)</div>";
                                      
                                      echo "<button type='submit' name='see_idea_details' class='button small_button'><i class='fa fa-eye'></i></button>";
                                      

                                   if($is_applied==0){
                                      echo "<button type='submit' name='delete_idea' class='button small_button'><i class='fa fa-times'></i></button>";
                                        echo "<button type='submit' name='to_apply' class='button small_button'><i class='fa fa-check'></i></button>";
                                          
                                    } else {

                                          echo "<div class='span_modpack'>applied</div>";
                                    }        


                                    echo "</form>";      
                                    echo "</div>";
                              echo "</div>"; // idea
                        }      
                  ?>
              </div>
             <?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) as total FROM ideas";
                $result=mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '"">' . $i . '</a>';
                      //echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
             ?>
            </div><!-- list-->

        </div><!--content-->
      </div><!--main_wrap-->
  </body>
  </html> 
