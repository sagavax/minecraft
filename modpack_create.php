<?php include "includes/dbconnect.php";
      include "includes/functions.php";

          $modpack_name=mysqli_real_escape_string($link, $_POST['modpack_name']);
          $modpack_version=mysqli_real_escape_string($link,$_POST['modpack_version']);
          $modpack_author=mysqli_real_escape_string($link,$_POST['modpack_author']);
          $modpack_image=mysqli_real_escape_string($link, $_POST['modpack_image']);
          $modpack_description=mysqli_real_escape_string($link, $_POST['modpack_description']);
          $modpack_url=mysqli_real_escape_string($link, $_POST['modpack_url']);

          
          //ziskam poslednu najvyssiu hodnotu pre load order 
          $sql="SELECT MAX(load_order) as max_load_order from modpacks";
          $result=mysqli_query($link, $sql);
           $row = mysqli_fetch_array($result);
           $max_load_order=intval($row['max_load_order']);
            
          $max_load_order=$max_load_order += 1;    
          $sql="INSERT INTO modpacks (modpack_name,  modpack_version, modpack_author,modpack_image, modpack_description, modpack_url, load_order,is_active) VALUES ('$modpack_name','$modpack_version','$modpack_author','$modpack_image','$modpack_description','$modpack_url',$max_load_order,1)";
          //echo $sql;
          $result=mysqli_query($link, $sql) or die(mysqli_error(($link)));
   
          $diary_text="Minecraft IS: Bol pridany novy modpack s nazvom <strong>$modpack_name</strong>";
          $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
          

       // header('location:modpacks.php',301, true);


?>     