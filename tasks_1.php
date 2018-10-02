<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      function GetTaskCatName($id){
        global $link;
        $sql="SELECT cat_name from category where cat_id = $id";
          $result=mysqli_query($link, $sql);
        while ($row = mysqli_fetch_array($result)){
        $category_name=$row['cat_name'];
        }
        return $category_name;	
      }

      if(isset($_POST['complete_task'])){
        $task_id=int($_POST['task_id']);
        $sql="UPDATE tasks set is_completed=1 where task_id=$task_id";
        $result=mysqli_query($link, $sql);
        global $link;

      }

      if(isset($_POST['task_add'])){
        
        if(empty($_POST['task_text'])){
          echo "<script>alert('Prazdny text !!!')</script>
          window.location='index.php?view=tasks';
          ";
        } else {
        global $link;
        $task_text=mysqli_real_escape_string($link, $_POST['task_text']);
		
        $cat_id=$_POST['category'];
        $modpack_id=$_POST['modpack'];
        $added_date=date('Y-m-d');
        $query="INSERT into  to_do (cat_id,modpack_id, task_text, added_date) VALUES ($cat_id, $modpack_id, '$task_text', '$added_date')";
        mysqli_query($link, $query);
        
        $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
        //$link1=mysqli_connect("localhost", "root", "", "brick_wall");
        $curr_date=date('Y-m-d H:i:s');
        $diary_text="Minecraft IS: Bol vytvoreny novy task s nazvom <strong>$task_text</strong>";
        $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$diary_text','$curr_date','',0,0)";
        $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
        mysqli_close($link1);

        
        
        header('location:tasks.php');
        }
      }

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
            <li><a href="index.php?view=notes">Notes</a></li>
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
                <option value=0>-- Select mod pack -- </option>     
                <?php
                        $sql="SELECT * from modpacks ORDER BY modpack_id ASC";
                        $result=mysqli_query($link, $sql);
                          while ($row = mysqli_fetch_array($result)) {
                            $modpack_id=$row['modpack_id'];
                            $modpack_name=$row['modpack_name'];
                        echo "<option value=$modpack_id>$modpack_name</option>";
                        }	
                      ?>
                   </select>   
                </div>
                <div class="new_task_action"><button name="task_add" type="submit" class="button middle_button pull-right"><i class="fa fa-check"></i></button></div>
              </form>
            </div><!-- div new task -->
           
            <div id='task_list'>
            <?php
                $sql="SELECT * from to_do where parent_task=0 ORDER BY  task_id  DESC";
                $result=mysqli_query($link, $sql);
                        
                while ($row = mysqli_fetch_array($result)) {
                  $task_text=$row['task_text'];
                  $task_id=$row['task_id'];
					        $task_category_id=$row['cat_id'];
                  $is_completed=$row['is_completed'];
                  
                  $task_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);    
                          
                  echo "<div class='task' id='$task_id'>"; //task 
                  echo "<div class='task_id'>Task id: $task_id</div>"; 
                  echo "<div class='task_text'>$task_text</div>";
                   
                   if($task_category_id<>0)
                   {
                    $task_action_style='task_action';
                    $category_name=GetTaskCatName($task_category_id);
                    echo "<div class='task_category'>$category_name</div>";
                   } else {
                     $task_action_style='task_action_no_cat';
                   }
                   
                   if($is_completed==0){
                    echo "<div class='$task_action_style'><form action='' method='post'><input type='hidden' name='task_id'  value='$task_id'><button type='submit' name='edit_task' class='button small_button pull-right'><i class='fa fa-pencil'></i></button><button type='submit' name='comnplete_task' class='button small_button pull-right'><i class='fa fa-check'></i></button></form></div>";
                  }
                  echo "</div>";//task
                }
               
               ?>       
            </div><!--task list-->
            <div style="clear:both"></div>
        </div><!--list -->
       </div><!--content -->? 
    </body>    