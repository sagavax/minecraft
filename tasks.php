<?php include "includes/dbconnect.php";
include "includes/functions.php";
/* 

if(isset($_POST['complete_task'])){

  $task_id=intval($_POST['task_id']);
  $query="UPDATE to_do SET is_completed=1 WHERE task_id=$task_id";
          //  echo $query;
  mysqli_query($link, $query)  or die(mysqli_error($link));

   ///$link1=mysqli_connect("localhost", "root", "", "brick_wall");
  //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
  
  $diary_text="Task s id <strong>$task_id</strong> bol oznaceny ako hotovy";
  $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
  $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
  

  echo "<script>
  alert('Task s id $task_id bol dokonceny');
  window.location.href='tasks.php';
  </script>";
}

if(isset($_POST['edit_task'])){
  header('location:task.php?task_id='.$_POST['task_id']);
} */
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
    <script defer src="js/tasks.js"></script>
    <!-- <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script> -->
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
    <?php include("includes/header.php");
    echo "<script>sessionStorage.setItem('current_module','tasks')</script>"; 
    ?>
    <div class="main_wrap">
      <div class="tab_menu">
        <?php include("includes/menu.php"); ?>
      </div>
      <div class="content">
        <div class='list'>

          <div class="fab fab-icon-holder" onclick="document.getElementById('new_task').style.display='flex';">
            <i class="fas fa-plus"></i>
          </div>

            <div id='new_task'>
                <div class="task_top_bar"><button type="button" class="button app_badge" title="hide"><i class="fa fa-times"></i></button></div>
                <form action='' method='post'>
                    <textarea name='task_text' placeholder="enter text here..."></textarea>
                          <select name='category'>
                            <option value=0>-- Select category -- </option>
                                <?php
                                  $sql="SELECT * from mods ORDER BY cat_name ASC";
                                  $result=mysqli_query($link, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                      $cat_id=$row['cat_id'];
                                      $cat_name=$row['cat_name'];
                                  echo "<option value=$cat_id>$cat_name</option>";
                                  } 
                                ?>  
                          </select>
                          <select name="modpack">
                              <?php 
                              //echo "modpack:".$modpack_id;
                            
                              if($modpack_id==0){
                                  echo "<option value=0> -- Select modpack -- </option>";
                              } else {
                          
                          echo "<option value=$modpack_id selected='selected' >$modpack_name</option>";
                          }
                      

                          $sql="SELECT * from modpacks WHERE is_active=1 ORDER BY modpack_id ASC";
                          $result=mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                              $modpack_id=$row['modpack_id'];
                              $modpack_name=$row['modpack_name'];
                          echo "<option value=$modpack_id>$modpack_name</option>";
                          } 
                        ?>
                        </select> 
                      <div class="new_task_action">
                         <form action="" method="post"> 
                            <button name="task_add" type="submit" class="button" title="add new task"> <i class="fa fa-check"></i></button>
                        </form>
                         
                      </div>   
                    </form>
            </div>  

          
          <div class="search_wrap">
            <input type="text" name="search" id="search_string" autocomplete="off" placeholder="search tasks here..."><button type="button" title="clear search" class="button small_button tooltip>"><i class="fa fa-times"></i></button>
          </div><!-- Search wrap-->
          
          <div id="tasks_wrap">   
           
           <div class="task_view_wrap">
               <div class="tab_view">
                <button type="button" name="vanilla" class="button small_button">Vanilla</button>
                <button type="button" name="modded" class="button small_button">Modded</button>
                <button type="button" name="all" class="button small_button">All</button>
              </div>

              <div class="task_view">
                <button type="button" name="active" class="button small_button">Active</button>
                <button type="button" name="completed" class="button small_button">Completed</button>
                <button type="button" name="all" class="button small_button">All</button>
              </div>  
          </div>
          
          <!-- filter tasks by modpack vanilla-->
          <div class="modpack_view">
              <?php
                  $get_modpacks = "SELECT a.modpack_id, b.modpack_id, b.modpack_name from to_do a, modpacks b WHERE a.modpack_id=b.modpack_id GROUP BY a.modpack_id";
                  $result = mysqli_query($link, $get_modpacks) or die(mysqli_error($link));
                  while($row_modpacks = mysqli_fetch_array($result)){
                    $modpack_id =$row_modpacks ['modpack_id'];
                    $modpack_name =$row_modpacks ['modpack_name'];
                    echo "<button type='button' name='modpack' modpack-id=$modpack_id>$modpack_name</button>";
                  }

              ?>
          </div>
        </div>  
        
        <div class="tasks" id="tasks">

          <?php

          $itemsPerPage = 10;

          $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
          $offset = ($current_page - 1) * $itemsPerPage;
          
          $sql="SELECT * from to_do ORDER BY task_id DESC LIMIT $itemsPerPage OFFSET $offset";
          
          $result=mysqli_query($link, $sql);
          
          while ($row = mysqli_fetch_array($result)) {
            $task_text=$row['task_text'];
            $task_id=$row['task_id'];
            $task_category_id=$row['cat_id'];
            $task_modpack_id=$row['modpack_id'];
            $is_completed=$row['is_completed'];
            
            $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
            
              echo "<div class='task' id='$task_id'>"; //task 
              echo "<div class='task_body'>$task_text</div>";
              echo "<div class='task_footer'>";
              
              $category_name=GetModName($task_category_id);
              $modpack_name=GetModpackName($task_modpack_id);
              
              if($category_name<>""){
                $category_name="<button class='span_mod' type='button'>".$category_name."</button>";
              }
              if ($modpack_name<>""){
                $modpack_name="<button class='span_modpack' type='button'>".$modpack_name."</button>";
              }
              
                    //$mod_modpack.="".$category_name." ".$modpack_name."</div>";
              
              $button_edit="<button type='button' name='edit_task' class='button small_button pull-right'><i class='fas fa-edit'></i></button>";
              $button_task_complete="<button type='button' name='complete_task' class='button small_button pull-right'><i class='fa fa-check'></i></button>";

              $mod_modpack="<div class='task_modpacks'>".$category_name." ".$modpack_name."</div>";
              
              if($is_completed==1){
                
                echo $mod_modpack;
                $task_completed="<span class='button small_button'>Complete</span>";
                echo $task_completed;
                      //$mod_modpack="<div class='mod_modpack'>".$mod_modpack." ".$task_completed."</div>";
                      //echo $mod_modpack;
                
                
              } elseif($is_completed==0){

                echo $mod_modpack;
                echo "<div class='task_action'>".$button_edit." ".$button_task_complete."</div>";
              }
              
              echo "</div>";//task_footer_wrap;  
              echo "</div>";//task
            }
            
            ?>       
          </div><!--tasks -->
          
          <?php
          // Calculate the total number of pages
          $count_tasks = "SELECT COUNT(*) as total FROM to_do";
          $result=mysqli_query($link, $count_tasks);
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
        
      </div><!--content -->? 

     <!--  <dialog class="modpacks">
        <div class="inner_modpacks_layer">
          <?php 
            echo GetListModpacks();
          ?>
        </div>
      </div> -->
</body>    