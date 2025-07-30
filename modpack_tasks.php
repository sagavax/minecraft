 <?php 
      include("includes/dbconnect.php");
      include("includes/functions.php");

      if(isset($_POST['complete_task'])){
        
        $task_id=intval($_POST['task_id']);
            $query="UPDATE tasks SET is_completed=1 WHERE task_id=$task_id";
          //  echo $query;
            mysqli_query($link, $query)  or die(mysqli_error($link));
            
         //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
         $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          
        $diary_text="Task s id <strong>$task_id</strong> bol oznaceny ako hotovy";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
            
        echo "<script>
        alert('Task s id $task_id bol dokonceny');
        window.location.href='tasks.php';
       </script>";
          }

     if(isset($_POST['edit_task'])){
        header('location:task_edit.php?task_id='.$_POST['task_id']);
     }

?>      
       <div class="fab fab-icon-holder" onclick="document.getElementById('new_task').style.display='flex';">
            <i class="fas fa-plus"></i>
        </div>
          

         <div class='modlist_mods_title'><h3><?php echo "Tasks for the modpack ".GetModPackName($_GET['modpack_id']); ?></h3></div>
          
          <!-- new task form -->
          <div id='new_task'>
                <div class="task_top_bar"><button type="button" class="button app_badge" title="hide"><i class="fa fa-times"></i></button></div>
                <form action='task_add.php' method='post'>
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
                      <div class="new_task_action">
                         <form action="" method="post"> 
                            <button name="task_add" type="submit" class="button" title="add new task"> <i class="fa fa-check"></i></button>
                        </form>
                         
                      </div>   
                    </form>
            </div> 
         
            
          <!-- Search wrap-->
          <div class="search_wrap">
            <input type="text" name="search" onkeyup="searchTask(this.value);" id="search_string" autocomplete="off" placeholder="search tasks here..."><button type="button" title="clear search" class="button small_button tooltip>"><i class="fa fa-times"></i></button>
          </div><!-- Search wrap-->

          
           <div id="tasks_wrap">  

            <div class="task_view_wrap">
              <div class="task_view">
                <button type="button" name="active" class="button small_button">Active</button>
                <button type="button" name="completed" class="button small_button">Completed</button>
                <button type="button" name="all" class="button small_button">All</button>
              </div>  
          </div>
           
            <div class="tasks" id="tasks">

            <?php

                    $modpack_id = $_GET['modpack_id'];

                   $sql="SELECT * from tasks WHERE modpack_id=$modpack_id ORDER BY task_id DESC";
                   $result=mysqli_query($link, $sql) or die("MySQL ERROR: ".mysqli_error($link));
                          
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
                            $category_name="<span class='span_mod'>".$category_name."</span>";
                          }
                          /* if ($modpack_name<>""){
                            $modpack_name="<span class='span_modpack'>".$modpack_name."</span>";
                          } */
                          
                          //$mod_modpack.="".$category_name." ".$modpack_name."</div>";
                          

                          $button_edit="<button type='submit' name='edit_task' class='button small_button pull-right' task-id=$task_id><i class='fas fa-edit'></i></button>";
                            $button_task_complete="<button type='submit' name='complete_task' class='button small_button pull-right'  task-id=$task_id><i class='fa fa-check'></i></button>";

                            $mod_modpack="<div class='task_modpacks'>".$category_name." ".$modpack_name."</div>";
                          
                          if($is_completed==1){
                            
                            echo $mod_modpack;
                            $task_completed="<div class='task_completed'>Complete</div>";
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
           </div>  <!--tasks wrap-->