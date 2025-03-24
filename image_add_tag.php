<?php
      include("includes/dbconnect.php");

      $tag_id = $_POST['tag_id'];
      $image_id = $_POST['image_id'];
      
      
      $assign_tag_for_image = "INSERT INTO pictures_tags (image_id,tag_id,created_date) VALUES($image_id,$tag_id,now())";
      $result=mysqli_query($link, $assign_tag_for_image) or die(mysqli_error($link));

      //add to log
      $diary_text="Tag s id <strong>$tag_id</strong> bol pridany k obrazku s id <strong>$image_id</strong>";
      $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
      $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
         
?>