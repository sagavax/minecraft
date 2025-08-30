<?php
   include("includes/dbconnect.php");
   include("includes/functions.php");


   $char = $_POST['char'];


   $sort_by_char = "SELECT * FROM mods WHERE cat_name LIKE '$char%' ORDER BY cat_name ASC";
   $result = mysqli_query($link, $sort_by_char) or die(mysqli_error($link));

   
   while($row = mysqli_fetch_array($result)){
      $mod_name = $row['cat_name'];
      $mod_id = $row['cat_id'];
      echo "<button mod-id=$mod_id class='button small_button'>$mod_name</button>";
   }
   
?>
