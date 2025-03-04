 <?php 
      include("includes/dbconnect.php");
      include("includes/functions.php");

      if(isset($_POST['complete_task'])){
        
        $task_id=intval($_POST['task_id']);
            $query="UPDATE to_do SET is_completed=1 WHERE task_id=$task_id";
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

     if(isset($_POST['add_task'])){
      header('location:task_add.php');
    }
?>      
          <div class="fab fab-icon-holder" onclick="document.getElementById('new_modpack').showModal();">
                <i class="fa fa-plus"></i>
              </div>    
          <div class='modlist_mods_title'><h3><?php echo "Tasks for the modpack ".GetModPackName($_GET['modpack_id']); ?></h3></div>
          <div class="search_task_wrap">
              <input type="text" name="search" onkeyup="search_the_string(this.value);" id="search_string" placeholder="Search task here..." autocomplete="off"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
              
            </div> 

            <div class="task_view">
              <input type='radio' name='status' id="active" value="active" checked="checked"><label for="active">Active</label>
              <input type='radio' name='status' id="completed" value="completed"><label for="completed" name="status" value="completed">Completed</label>
              <input type='radio' name='status' value="all" id="all"><label for="all">All</label>

            </div>     
           

             <div class="tab_view">
                  <button type="button" name="vanilla" class="button small_button">Vanilla</button>
                  <button type="button" name="modded" class="button small_button">Modded</button>
                  <button type="button" name="all" class="button small_button">All</button>
              </div>
           
            <div class="tasks" id="tasks">

            <?php

                    $modpack_id = $_GET['modpack_id'];

                    $sql="SELECT * from to_do WHERE modpack_id=$modpack_id ORDER BY task_id DESC";
                 
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
                
                ?>       
                
              </div><!--tasks -->
  