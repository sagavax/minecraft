<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['task_edit'])){
          var_dump($_POST);
          $task_id=$_POST['task_id'];
          $task_text=mysqli_real_escape_string($link, $_POST['task_text']);
          $task_category=$_POST['category'];
          $task_modpack=$_POST['modpack'];

          $sql="UPDATE to_do SET task_id=$task_id, cat_id=$task_category, modpack_id=$task_modpack, task_text='$task_text' where task_id=$task_id";
          //echo $sql;
          $result=mysqli_query($link, $sql);
          header('location:tasks.php');
      }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft tools</title>
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
            <li><a href="videos.php">Videos</a></li>
            <li><a href="pics.php">Pics</a></li>
          </ul>
        </div>
        <div class="content">
            <div class='list'>
                <?php
                    global $link; 
                    $task_id=$_GET['task_id'];
                    $sql="SELECT modpack_id,cat_id,eis_task_id,task_id, task_text from to_do where task_id=$task_id";
                    //echo $sql;
                    $result=mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($result)){
                        $cat_id=$row['cat_id'];
                        $modpack_id=$row['modpack_id'];
                        $cat_name=GetModName($row['cat_id']);
                        $modpack_name=GetModPackName($row['modpack_id']);
                        $task_text=$row['task_text'];
                  
                     
                    ?>
                 <div id=task_edit>
                     <form action="" method="post">
                         <input type="hidden" name="task_id" value=<?php echo $task_id ?> />
                         <div id="task_text"><textarea name="task_text"><?php echo $task_text ?></textarea></div>
                         <div class="new_task_category">
                             <select name="category">
                                <?php if($cat_id==0){
                                    echo "<option value=0>-- Select category -- </option>";
                                } else {    
                                echo "<option value=$cat_id selected='selected' >$cat_name</option>";
                                }   
                                $sql="SELECT * from category ORDER BY cat_name ASC";
                            
                                $result=mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $cat_id=$row['cat_id'];
                                    $cat_name=$row['cat_name'];
                                echo "<option value=$cat_id>$cat_name</option>";
                                }	
                                ?>  
                            </select>
                        </div>
                        
                        <div class="new_task_modpack">
               
                        
                        <select name="modpack">
                           <?php 
                           //echo "modpack:".$modpack_id;
                            if($modpack_id==0){
                                echo "<option value=0> -- Select modpack -- </option>";
                            } else {
                        
                        echo "<option value=$modpack_id selected='selected' >$modpack_name</option>";
                        }

                        $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                        echo "<option value=$modpack_id>$modpack_name</option>";
                        }	
                      ?>
                   </select> 
                   <?php
                    }
                   ?>
                </div>
                    <div class="edit_task_action"><button name="task_edit" type="submit" class="button middle_button pull-right"><i class="fa fa-pencil"></i></button></div>    
                    </form>    
                 </div><!--task edit -->   
            </div>    
        </div>  
</body>        