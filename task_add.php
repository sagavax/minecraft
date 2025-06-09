<?php
include("includes/dbconnect.php");
include("includes/functions.php");


       $task_text=mysqli_real_escape_string($link, $_POST['task_text']);
      $modpack_id=$_POST['modpack_id'];

      
        
        if(!isset($_POST['category'])){
            $cat_id=0;
        }
        
        
        $query="INSERT into  to_do (cat_id,modpack_id, task_text, added_date) VALUES ($cat_id, $modpack_id, '$task_text', now())";
        mysqli_query($link, $query) or die("MySQLi ERROR: ".mysqli_error($link));

        $sql="SELECT LAST_INSERT_ID() as last_id from to_do";
        $result=mysqli_query($link, $sql);
        while ($row = mysqli_fetch_array($result)) {          
          $last_task=$row['last_id'];
        }   

        $diary_text="Minecraft IS: Bol vytvoreny novy task s nazvom <strong>$task_text</strong>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
?>        