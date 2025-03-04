<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$status = $_GET['status'];

if($status == "active"){
  $sql="SELECT * from to_do where is_completed=0";  
} elseif ($status=="completed") {
  $sql="SELECT * from to_do where is_completed=1";
} elseif($status == "all"){
  $sql="SELECT * from to_do";
}

$result=mysqli_query($link, $sql);
                        
  while ($row = mysqli_fetch_array($result)) {
      $task_text=$row['task_text'];
                    $task_id=$row['task_id'];
                    $task_category_id=$row['cat_id'];
                    $task_modpack_id=$row['modpack_id'];
                    $is_completed=$row['is_completed'];
                    
                    $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
                            
           
                    echo "<div class='task' id='$task_id'>"; //task 
                      //echo "<div class='task_header'><span>Task id: ".$task_id."</span></div>";
                      echo "<div class='task_header'><span></span></div>";
                      echo "<div class='task_body'>$task_text</div>";
                      echo "<div class='task_footer'>";
                          
                        $category_name=GetModName($task_category_id);
                          $modpack_name=GetModpackName($task_modpack_id);
                          
                          if($category_name<>""){
                            $category_name="<span class='span_mod'>".$category_name."</span>";
                          }
                          if ($modpack_name<>""){
                            $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                          }
                          
                          //$mod_modpack.="".$category_name." ".$modpack_name."</div>";
                          

                          $button_edit="<button type='submit' name='edit_task' class='button small_button pull-right' task-id=$task_id><i class='fas fa-edit'></i></button>";
                            $button_task_complete="<button type='submit' name='complete_task' class='button small_button pull-right'  task-id=$task_id><i class='fa fa-check'></i></button>";

                            $mod_modpack="<div class='task_modpacks'>".$category_name." ".$modpack_name."</div>";
                          
                          if($is_completed==1){
                            
                            echo $mod_modpack;
                            $task_completed="<span class='span_task_completed'>Complete</span>";
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
       