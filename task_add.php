<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      
      if(isset($_POST['task_add'])){
        
        if(empty($_POST['task_text'])){
          echo "<script>alert('Prazdny text !!!')</script>
          window.location='tasks_add.php';
          ";
        } else {
        global $link;
        $task_text=mysqli_real_escape_string($link, $_POST['task_text']);
		
        $cat_id=$_POST['category'];
        $modpack_id=$_POST['modpack'];
        $added_date=date('Y-m-d');
        $query="INSERT into  to_do (cat_id,modpack_id, task_text, added_date) VALUES ($cat_id, $modpack_id, '$task_text', '$added_date')";
        mysqli_query($link, $query);
        
        //$link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        $link1=mysqli_connect("localhost", "root", "", "brick_wall");
        $curr_date=date('Y-m-d H:i:s');
        $diary_text="Minecraft IS: Bol vytvoreny novy task s nazvom <strong>$task_text</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);
        header('location:tasks.php');
        }
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
            <div id='new_task'>
                <form action='' method='post'>
                    <div class='new_task_textarea'><textarea name='task_text'></textarea></div>
				        <div class='new_task_category'><select name='category'>
					        <option value=0>-- Select category -- </option>
                       <?php
                        $sql="SELECT * from category ORDER BY cat_name ASC";
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $cat_id=$row['cat_id'];
                            $cat_name=$row['cat_name'];
                        echo "<option value=$cat_id>$cat_name</option>";
                        }	
                      ?>  
                </select></div>
                <div class="new_task_modpack"><select name="modpack">
                <?php 
                if(isset($_GET['modpack_id'])){
                                $modpack_id=$_GET['modpack_id'];
                                $modpack_name=GetModPackName($modpack_id);
                          echo "<option value=$modpack_id>$modpack_name</option>";
                              } else{  ?> 
                <option value=0>-- Select mod pack -- </option>     
                <?php
                       $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                        
                        echo "<option value=$modpack_id>$modpack_name</option>";
                            }
                        }	
                      ?>
                   </select>   
                </div>
                <div class="new_task_action"><button name="task_add" type="submit" class="button middle_button pull-right"><i class="fa fa-check"></i></button></div>
              </form>
            </div>    
          </div>  
       </div>  