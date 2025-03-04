<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      $image_name = mysqli_real_escape_string($link, $_POST['image_name']);
      $image_url = mysqli_real_escape_string($link, $_POST['image_url']);
      $image_description = mysqli_real_escape_string($link, $_POST['image_description']);
      $modpack_id = $_POST['modpack_id'];
      $cat_id=0;
      
      $sql="INSERT INTO pictures (picture_title, picture_description, picture_name, picture_path, cat_id, modpack_id, added_date) VALUES ('$image_name', '$image_description','$image_url','$image_url',$cat_id, $modpack_id,now())";
     // echo $sql;
      $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link)); 
    
      ////vlozim do wallu 
      $diary_text="Minecraft IS: Bol pridany novy obrazok s nazvom <strong>$image_name</strong>";
      $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
      $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
      