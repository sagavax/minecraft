<?php include "../includes/dbconnect.php";
      include "../includes/functions.php";

       if(isset($_POST['task_create'])) {        
        global $link;
        $task_title=mysqli_real_escape_string($link, $_POST['base_task_title']);
        $task_text=mysqli_real_escape_string($link, $_POST['base_task_text']);
        $base_id = $_POST['vanilla_base'];


        $query="INSERT into  vanila_base_tasks (base_id, task_title, task_text, added_date) VALUES ($base_id, '$task_text',$task_text', now())";
        mysqli_query($link, $query) or die("MySQLi ERROR: ".mysqli_error($link));

        $sql="SELECT LAST_INSERT_ID() as last_id from vanila_base_tasks";
        $result=mysqli_query($link, $sql);
        while ($row = mysqli_fetch_array($result)) {          
          $last_task=$row['last_id'];
        }   

        
        $diary_text="Minecraft IS: Bol vytvoreny novy task s nazvom <b>$task_text</b> pre zakladnu id $base_id";
        $sql="INSERT INTO app_log (diary_text, date_added,location,isMobile,is_read) VALUES ('$task_text',now(),'',0,0)";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                
        echo "<script>alert('Bol vytvoreny novy task s id $last_task');
        window.location.href='vanilla_tasks.php';
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
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/../css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script defer src="../js/base_tasks.js"></script>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php include("../includes/header.php") ?>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("../includes/vanila_menu.php") ?>
        </div>
        <div class="content">
          <div class='list'>
           <div id='new_vanilla_task'>
                <form action='' method='post'>
                    <textarea name='task_text' placeholder="enter text here..."></textarea>
                   <select name="base">
                     <!--<option value="0">------ Chose the base -------</option>-->
                     <option value="1">hlavna zakladna</option>

                     <?php 
                        $get_bases = "SELECT * from vanila_bases";
                        $result_bases = mysqli_query($link, $get_bases) or die("MySQLi ERROR: ".mysqli_error($link));
                        while($row_bases = mysqli_fetch_array($result_bases)){
                            $base_id = $row_bases['base_id'];
                            $base_name =$row_bases['base_name'];
                            echo "<option value='$base_id'>$base_name</option>";
                         }   
                     ?>
                 </select>
                 <div class="new_task_action">

                    <button name="task_create" type="submit" class="button small_button pull-right"><i class="fa fa-plus"></i></button>
                    </div>   
              </form>
            </div>    


          <div class="search_task_wrap">
                    <input type="text" name="search" onkeyup="search_the_string(this.value);" id="search_string" placeholder="Search task here..." autocomplete="off"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
          </div> 

            <div class="task_view">
            <button type="button" name="active" class="button small_button">Active</button>
            <button type="button" name="completed" class="button small_button">Completed</button>
            <button type="button" name="all" class="button small_button">All</button>
          </div>       
           
           
            <div class="tasks" id="tasks">
             <h3>Tasks</h3>  
            <?php
                 
                 $get_bases_tasks="SELECT * from vanila_base_tasks ORDER BY task_id DESC";
                 //echo $get_bases_tasks;
                 
                  $result=mysqli_query($link, $get_bases_tasks);
                  if(mysqli_num_rows($result)==0){
                    echo "<div class='info_message'>No tasks available. Would you like to create a new one?</div>";
                  } else {
                          
                  while ($row = mysqli_fetch_array($result)) {
                    $task_text=$row['task_text'];
                    $base_id=$row['base_id'];
                    $task_id=$row['task_id'];
                    $is_completed=$row['is_completed'];
                    
                    $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
                            
                    echo "<div class='task' id='$task_id'>"; //task 
                      //echo "<div class='task_header'><span>Task id: ".$task_id."</span></div>";
                     //echo "<div class='task_header'><span></span></div>";
                      echo "<div class='task_body'>$task_text</div>";
                      echo "<div class='task_footer'>";
                          echo "<div class='span_modpack'>".GetBanseNameByID($base_id)."</div>";
                          $button_edit="<button type='submit' name='edit_task' class='button small_button pull-right'  task-id=$task_id><i class='fas fa-edit'></i></button>";
                            $button_task_complete="<button type='submit' name='complete_task' class='button small_button pull-right'  task-id=$task_id><i class='fa fa-check'></i></button>";

                                                  
                          if($is_completed==1){
                            
                            $task_completed="<span class='span_task_completed'>Complete</span>";
                            echo $task_completed;
                            //$mod_modpack="<div class='mod_modpack'>".$mod_modpack." ".$task_completed."</div>";
                            //echo $mod_modpack;
                            
        
                          } elseif($is_completed==0){

                          
                          echo "<div class='task_action'>".$button_edit." ".$button_task_complete."</div>";
                          }
                          
                    echo "</div>";//task_footer_wrap;  
                    echo "</div>";//task
                  }
                }
                ?>       
       
            </div><!--tasks -->
       
        </div><!--list -->
      
       </div><!--content --> 
      </div><!-- main wrap--> 
    </body>    