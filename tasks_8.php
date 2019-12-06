<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      
      if(isset($_POST['complete_task'])){
        
        $task_id=intval($_POST['task_id']);
            $query="UPDATE to_do SET is_completed=1 WHERE task_id=$task_id";
          //  echo $query;
            mysqli_query($link, $query)  or die(mysqli_error($link));
            
         //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
         $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
          $curr_date=date('Y-m-d H:i:s');
        $diary_text="Task s id <strong>$task_id</strong> bol oznaceny ako hotovy";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
            
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
      <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
      </div>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("menu.php"); ?>
        </div>
        <div class="content">
          <div class='list'>
            <div class="tasks_view">
              <form action=""><input type='radio' name='status' id="active" value="active"><label for="active">Active</label><input type='radio' name='status' id="completed" value="completed"><label for="completed" name="status" value="completed">Completed</label><input type='radio' name='status' value="all" id="all"><label for="all">All</label><button type='submit' class='button small_button pull-right'>OK</button></form>
            </div> 
            <div class="action_add_task">
              <form action="" method="post"><button name="add_task" type="submit" class="button small_button pull-right"><i class="fas fa-plus"></i></button></form>
            </div>
            <div class="tasks">
              <?php
                  if(!isset($_GET['status'])){
                    $sql="SELECT * from to_do where parent_task=0 ORDER BY  task_id  DESC"; 
                  }  elseif($_GET['status']){
                    $status=$_GET['status'];
                    if($status=='completed'){
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
                    $task_category_id=$row['cat_id'];
                    $task_modpack_id=$row['modpack_id'];
                    $is_completed=$row['is_completed'];
                    
                    $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
                            
                    echo "<div class='task' id='$task_id'>"; //task 
                    echo "<div class='task_id'>Task id: $task_id</div>"; 
                    echo "<div class='task_text'>$task_text</div>";

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
                    
                    echo "</div>";//task
                  }
                
                ?>       
             <div style="clear:both"></div>    
            </div><!--tasks -->
        </div><!--list -->
      
       </div><!--content -->? 
    </body>    