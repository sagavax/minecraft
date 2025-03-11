<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      session_start();



      if(isset($_POST['save_bug'])){
        $bug_title = $_POST['bug_title'] ?? '';
        $bug_text = $_POST['bug_text'] ?? '';
        $bug_priority = $_POST['bug_priority'] ?? 'medium';
        $bug_status = $_POST['bug_status'] ?? 'new';
        $is_fixed = 0;
    
        // Použitie pripraveného SQL dotazu na bezpečné vloženie
        $save_bug = "INSERT INTO bugs (bug_title, bug_text, priority, status, is_fixed, added_date) 
                     VALUES (?, ?, ?, ?, ?, now())";
        
        $stmt = mysqli_prepare($link, $save_bug);
        mysqli_stmt_bind_param($stmt, "ssssi", $bug_title, $bug_text, $bug_priority, $bug_status, $is_fixed);
        mysqli_stmt_execute($stmt);
        
        // Získanie posledného ID bezpečne
        $max_id = mysqli_insert_id($link);
    
        // Logovanie do app_log
        $diary_text = "Minecraft IS: Bol zaznamenaný nový bug s ID $max_id";
        $log_sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, now())";
        
        $log_stmt = mysqli_prepare($link, $log_sql);
        mysqli_stmt_bind_param($log_stmt, "s", $diary_text);
        mysqli_stmt_execute($log_stmt);
    }


      if(isset($_POST['see_bug_details'])){
        $bug_id = $_POST['bug_id'];
        $_SESSION['bug_id']=$bug_id;
        $_SESSION['is_fixed']=$is_fixed;
        header("location:bug.php");
      }

      if (isset($_POST['bug_remove'])) {
        $bug_id = intval($_POST['bug_id']); // Ošetrenie vstupu
    
        if ($bug_id > 0) {
            // Spustiť transakciu
            mysqli_begin_transaction($link);
    
            try {
                // Odstrániť bug
                $remove_bug = "DELETE FROM bugs WHERE bug_id=?";
                $stmt = mysqli_prepare($link, $remove_bug);
                mysqli_stmt_bind_param($stmt, "i", $bug_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
                // Odstrániť komentáre k bugom
                $delete_comments = "DELETE FROM bugs_comments WHERE bug_id=?";
                $stmt = mysqli_prepare($link, $delete_comments);
                mysqli_stmt_bind_param($stmt, "i", $bug_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
                // Logovanie do denníka
                $diary_text = "Minecraft IS: Bol vymazaný bug s ID $bug_id";
                $sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, NOW())";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "s", $diary_text);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
                // Commit transakcie
                mysqli_commit($link);
    
            } catch (Exception $e) {
                mysqli_rollback($link); // Ak niečo zlyhá, vráti zmeny späť
                die("MySQLi ERROR: " . mysqli_error($link));
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
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/bugs.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <script type="text/javascript" defer src="js/bugs.js"></script>
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
              
              <div class="new_bug">
                <form action="" method="post">
                      <input type="text" name="bug_title" placeholder="bug title here" id="bug_title" autocomplete="off">
                      <textarea name="bug_text" placeholder="Put a bug / error text here" id="bug_text"></textarea>
                      <select name="bug_priority">
                        <option value="0">--- choose priority --- </option>
                        <option value = "low">low</option>
                        <option value = "medium">medium</option>
                        <option value = "high">high</option>
                        <option value = "critical">critical</option>
                      </select>

                      <select name="bug_status">
                          <option value="0">--- choose status --- </option>
                          <option value = "new">new</option>
                          <option value = "in progress">in progress</option>
                          <option value = "pending">pending</option>
                          <option value = "fixed">fixed</option>
                          <option value = "reopened">reopened</option>
                      </select>

                      <div class="new_bug_action">
                        <button type="submit" name="save_bug" class="button small_button">Save</button>
                      </div>
               </form>
              </div><!-- new bug-->
              
              <div class="bug_list">
                  <?php

                          $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;


                        $get_bugs = "SELECT * from bugs ORDER BY bug_id DESC LIMIT $itemsPerPage OFFSET $offset";
                        $result=mysqli_query($link, $get_bugs);
                        while ($row = mysqli_fetch_array($result)) {
                              $bug_id = $row['bug_id'];
                              $bug_title = $row['bug_title'];
                              $bug_text = $row['bug_text'];
                              $bug_priority = $row['priority'];
                              $bug_status = $row['status'];
                              $is_fixed = $row['is_fixed'];
                              $added_date = $row['added_date'];
                              

                              echo "<div class='bug'>";
                                    echo "<form action='' method='post'>";
                                    echo "<div class='bug_title'>$bug_title";

                                    if($is_fixed==1){
                                        echo "<div class='span_fixed'>fixed</div>";
                                        $action_buttons = "<button type='submit' name='see_bug_details' class='button small_button'><i class='fa fa-eye'></i></button><button type='submit' name='bug_remove' class='button small_button'><i class='fa fa-times'></i></button>";
                                     } else {
                                      $action_buttons = "<button type='submit' name='see_bug_details' class='button small_button'><i class='fa fa-eye'></i></button><button type='submit' name='to_fixed' class='button small_button'><i class='fa fa-check'></i></button><button type='submit' name='bug_remove' class='button small_button'><i class='fa fa-times'></i></button>";
                                     }
                                      
                                       
                                    
                                     echo "</div>";
                                    echo "<div class='bug_text'>$bug_text</div>";
                                    echo "<div class='bug_footer'>";
                                          echo "<input type='hidden' name='bug_id' value=$bug_id>";
                                          echo "<input type='hidden' name='is_fixed' value=$is_fixed>";
                                            $nr_of_comments = GetCountBugComments($bug_id);
                                          echo "<div class='bug_status $bug_status'>$bug_status</div><div class='bug_priority $bug_priority'>$bug_priority</div>";  
                                          echo "<div class='nr_of_comments'>".$nr_of_comments." comments</div>";
                                            echo $action_buttons;
                                          echo "</form>";      
                                    echo "</div>";
                              echo "</div>"; // bug
                        }      
                  ?>
              </div>
                  <?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) as total FROM bugs";
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
