<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      session_start(); 
      
      

    if(isset($_POST['task_back'])){
      header("location: tasks.php");
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
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
          <div class='list'>
            <div id='new_task'>
                <form action='' method='post'>
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
                          <select name="modpack">
                              <?php 
                              //echo "modpack:".$modpack_id;
                            
                              if($modpack_id==0){
                                  echo "<option value=0> -- Select modpack -- </option>";
                              } else {
                          
                          echo "<option value=$modpack_id selected='selected' >$modpack_name</option>";
                          }
                      

                          $sql="SELECT * from modpacks WHERE is_active=1 ORDER BY modpack_id ASC";
                          $result=mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                              $modpack_id=$row['modpack_id'];
                              $modpack_name=$row['modpack_name'];
                          echo "<option value=$modpack_id>$modpack_name</option>";
                          }	
                        ?>
                        </select> 
                      <div class="new_task_action">
                         <form action="" method="post"> 
                           <button name="task_back" type="submit" class="button small_button pull-right">Back</button> 
                           <button name="task_add" type="submit" class="button small_button pull-right"><i class="fa fa-check"></i></button>
                        </form>
                         
                      </div>   
                    </form>
            </div>    
          </div>  
       </div>  