<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      session_start();
           
           $idea_title = $_POST['idea_title'];
            $idea_text = $_POST['idea_text'];
            $is_applied = 0;

           //var_dump($_POST);

            $save_idea = "INSERT INTO ideas (idea_title, idea_text, is_applied, added_date) VALUES ('$idea_title','$idea_text', $is_applied,now())";
            $result=mysqli_query($link, $save_idea);

            
      
        $diary_text="Minecraft IS: Bola vytvorena nova idea ";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
        echo "<script>alert('Minecraft IS: Bola vtytvorena nova idea');
        window.location.href='ideas.php';
        </script>";