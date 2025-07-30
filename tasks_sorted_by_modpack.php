<?php
	include("includes/dbconnect.php");
	include("includes/functions.php");
    
	$sort_by = $_GET['sort_by'];

		
		$get_tasks = "SELECT * from tasks WHERE modpack_id=$sort_by ORDER BY task_id DESC";
    //echo $get_tasks;		
	
	                
                  $result=mysqli_query($link, $get_tasks);
                          
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

              if($task_modpack_id==0) {
                $modpack_name="<button class='button small_button' type='button' title='add modpack'><i class='fa fa-plus'></i></button>";
              } else {
                $modpack_name=GetModpackName($task_modpack_id);  
                $modpack_name="<button class='span_modpack' type='button'>".$modpack_name."</button>";
              }
              
              
              /* 
              if($category_name<>""){
                $category_name="<button class='span_mod' type='button'>".$category_name."</button>";
              } */
              $mod_modpack="<div class='task_modpacks'>".$category_name." ".$modpack_name."</div>";
              
              $button_edit="<button type='button' name='edit_task' class='button small_button pull-right'><i class='fas fa-edit'></i></button>";
              $button_task_complete="<button type='button' name='complete_task' class='button small_button pull-right'><i class='fa fa-check'></i></button>";
              
              
              
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
                   

