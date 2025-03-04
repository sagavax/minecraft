<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      header("Access-Control-Allow-Origin: *");


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
          <div class='list'>

          <div class="fab fab-icon-holder" onclick="window.location.href='task_add.php';">
            <i class="fas fa-plus"></i>
        </div>

          <div class="search_task_wrap">
              <form action="" method="GET">
                <input type="text" name="search" onkeyup="search_the_string(this.value);" id="search_string" placeholder="Search task here..." autocomplete="off"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
              </form>
            </div> 

            <div class="tasks_view">
              <form action="">
              <div class="task_view_radio_buttons">  
                <input type='radio' name='status' id="active" value="active" checked><label for="active">Active</label><input type='radio' name='status' id="completed" value="completed"><label for="completed" name="status" value="finished">Finished</label><input type='radio' name='status' value="all" id="all"><label for="all">All</label><button type='submit' class='button small_button pull-right'>OK</button> 
              </div>
              
                </form>
              </div>  
           
           
            <div class="tasks" id="tasks">

            <?php
                  if(!isset($_GET['status'])){
                    $sql="SELECT * from vanila_base_tasks where ORDER BY  task_id  DESC"; 
                  }  elseif($_GET['status']){
                    $status=$_GET['status'];
                    if($status=='finished'){
                      $sql="SELECT * from to_do where is_completed=1 ORDER BY task_id DESC";
                    } elseif ($status=='active'){
                      $sql="SELECT * from to_do where is_completed=0 ORDER BY task_id DESC";
                    } elseif($status=="all"){
                        $sql="SELECT * from to_do where parent_task=0 ORDER BY  task_id  DESC";
                      }
                    }   
                
                  $result=mysqli_query($link, $sql);
                          
                  while ($row = mysqli_fetch_array($result)) {
                    $task_text=$row['task_text'];
                    $task_id=$row['task_id'];
                    $zakladna_id=$row['zakladn_id'];
                    $is_completed=$row['is_completed'];
                    
                    $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
                            
                    
                    


                    echo "<div class='task' id='$task_id'>"; //task 
                      echo "<div class='task_body'>$task_text</div>";
                      echo "<div class='task_footer'>";
                          
                          /*echo "<div class='task_id'>Task id: $task_id</div>"; 
                          echo "<div class='task_text'>$task_text</div>";*/
                          
                          if($is_completed==1){
                            
                            $task_completed="<span class='span_task_completed'>Complete</span>";
                            //$mod_modpack="<div class='mod_modpack'>".$mod_modpack." ".$task_completed."</div>";
                          // echo $mod_modpack;
                            $button_edit="";
                            $button_task_complete="";
                            
        
                          } elseif($is_completed==0){

                            $task_completed="";
                          
                            //
                            $button_edit="<button type='submit' name='edit_task' class='button small_button pull-right'><i class='fas fa-edit'></i></button>";
                            $button_task_complete="<button type='submit' name='complete_task' class='button small_button pull-right'><i class='fa fa-check'></i></button>";
                    
                          }
                          $mod_modpack="<div class='task_modpacks'>".$category_name." ".$modpack_name." ".$task_completed."</div>";
                          echo $mod_modpack;
                          echo "<div class='task_action'><form action='' method='post'><input type='hidden' name='task_id'  value='$task_id'>".$button_edit." ".$button_task_complete."</form></div>";
                    echo "</div>";//task_footer_wrap;  
                    echo "</div>";//task
                  }
                
                ?>       
             <div style="clear:both"></div>    
            </div><!--tasks -->
            <div style="clear:both"></div>
        </div><!--list -->
      
       </div><!--content -->? 
       <script>
             function search_the_string(){
             var xhttp = new XMLHttpRequest();
             var search_text=document.getElementById("search_string").value;
             xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tasks").innerHTML =
                    this.responseText;
                       }
                    };
                xhttp.open("GET", "search_tasks.php?search="+search_text, true);
                xhttp.send();
                           
            }
        </script>
    </body>    