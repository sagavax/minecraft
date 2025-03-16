<?php
   include("includes/dbconnect.php");
   include("includes/functions.php");


   $char = $_POST['char'];


   $sort_by_char = "SELECT * FROM tags WHERE tag_name LIKE '$char%' ORDER BY tag_name ASC";
   $result = mysqli_query($link, $sort_by_char) or die(mysqli_error($link));

   
   while($row = mysqli_fetch_array($result)){
      $mod_name = $row['tag_name'];
      $mod_id = $row['tag_id'];
      echo "<button tag-id-$tag_id class='button small_button'>$tag_name</button>";
   }
   
?>
