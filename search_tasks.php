<?php include "includes/dbconnect.php";
      include "includes/functions.php";

     $search_string=$_GET['search'];
      $sql="SELECT * from to_do where task_text LIKE'%".$search_string."%'";

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
              
              /*echo "<div class='task_id'>Task id: $task_id</div>"; 
              echo "<div class='task_text'>$task_text</div>";*/
              
              $category_name=GetModName($task_category_id);
              $modpack_name=GetModpackName($task_modpack_id);
              
              if($category_name<>""){
                $category_name="<span class='span_mod'>".$category_name."</span>";
              }
              if ($modpack_name<>""){
                $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
              }
              
              //$mod_modpack.="".$category_name." ".$modpack_name."</div>";
              
              
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
        
                //echo $mod_modpack;
                //echo "<div class='task_action'><form action='' method='post'><input type='hidden' name='task_id'  value='$task_id'>".$button_edit." ".$button_task_complete."</form></div>";
              }
              $mod_modpack="<div class='mod_modpack'>".$category_name." ".$modpack_name." ".$task_completed."</div>";
              echo $mod_modpack;
              echo "<div class='task_action'><form action='' method='post'><input type='hidden' name='task_id'  value='$task_id'>".$button_edit." ".$button_task_complete."</form></div>";
        echo "</div>";//task_footer_wrap;  
        echo "</div>";//task
       }   