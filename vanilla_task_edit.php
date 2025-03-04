<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      if(isset($_POST['task_edit'])){
          
        $task_id=$_POST['task_id'];
          $task_text=mysqli_real_escape_string($link, $_POST['task_text']);
          $base_id = $_POST['base'];

          $sql="UPDATE vanilla_base_tasks SET zakladna_id=$base, task_text='$task_text' where task_id=$task_id";
          //echo $sql;
          $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

           $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
            //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
            
            $diary_text="Minecraft IS: Task <strong>$task_text</strong>";
            $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
            result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
            
            
          echo "<script>
          alert('Task s id $task_id bol upraveny');
          window.location.href='tasks.php';
          </script>";
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
         <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
            <div class='list'>
                <?php
                    global $link; 
                    $task_id=$_GET['task_id'];
                    $sql="SELECT zakladna_id, task_text from vanila_base_tasks where task_id=$task_id";
                    //echo $sql;
                    $result=mysqli_query($link, $sql);
                    while($row = mysqli_fetch_array($result)){
                        $base_id = $row['zakladna_id'];
                        $task_text=$row['task_text'];
                      }  
                    ?>
                 <div id=task_edit>
                     <form action="" method="post">
                         <input type="hidden" name="task_id" value=<?php echo $task_id ?> />
                         <textarea name="task_text"><?php echo $task_text ?></textarea>
                          <select name="base">
                               <?php 
                                echo "<option value='$base_id'>". GetBanseNameByID($base_id)."</option>";
                                $get_bases = "SELECT * from vanila_bases";
                                $result_bases = mysqli_query($link, $get_bases) or die("MySQLi ERROR: ".mysqli_error($link));
                                
                                while($row_bases = mysqli_fetch_array($result_bases)){
                                    $base_id = $row_bases['zakladna_id'];
                                    $base_name =$row_bases['zakladna_meno'];
                                    echo "<option value=$base_id>$base_name</option>";
                                 }   
                             ?>
                         </select>              
                         <div class="edit_task_action"><button name="task_back" type="button" onclick="history.back()" class="button middle_button pull-right">Back</button><button name="task_edit" type="submit" class="button middle_button pull-right"><i class="fa fa-pencil"></i></button></div>    
                    </form>    
                 </div><!--task edit -->   
            </div>    
        </div>  
</body>        