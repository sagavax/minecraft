<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      
      if(isset($_POST['complete_task'])){
        //var_dump($_POST);
        $task_id=intval($_POST['task_id']);
           // echo "Vestko zavrete";
            $query="UPDATE to_do SET is_completed=1 WHERE task_id=$task_id";
            mysqli_query($link, $query)  or die(mysqli_error($link));  
            header('location:tasks.php');
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
      <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
      </div>
      <div class="main_wrap">
        <div class="tab_menu">
          <ul>
          <li><a href="index.php">Dashboard</a></li>
            <li><a href="notes.php">Notes</a></li>
            <li><a href="tasks.php">Tasks</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="modpacks.php">Modpacks</a></li>
            <li><a href="videos.php">Videos</a><ul class="submenu"><li><a href="videos.php?view=see_later_videos">See later</a></li><li><a href="videos.php?view=favorite_videos">Favorite</a></li></ul></li>
            <li><a href="pics.php">Pics</a></li>
          </ul>
        </div>
        <div class="content">
          <div class='list'>
            <form action="" method="post"><button name="add_task" type="submit" class="button">+</button></form>
            <?php
                $sql="SELECT * from to_do where parent_task=0 ORDER BY  task_id  DESC";
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
                  
                  echo "<div class='mod_modpack'>".$category_name." ".$modpack_name."</div>";
                  
                  
                   if($is_completed==0){
                    echo "<div class='task_action'><form action='' method='post'><input type='hidden' name='task_id'  value='$task_id'><button type='submit' name='edit_task' class='button small_button pull-right'><i class='fa fa-pencil'></i></button><button type='submit' name='comnplete_task' class='button small_button pull-right'><i class='fa fa-check'></i></button></form></div>";
                  }
                  echo "</div>";//task
                }
               
               ?>       
             <div style="clear:both"></div>    
        </div><!--list -->
      
       </div><!--content -->? 
    </body>    