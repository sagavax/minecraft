<?php include "includes/dbconnect.php";
      include "includes/functions.php";

  
      $text=$_GET['note_text']; 
      $base_id=$_GET['base_id'];
      $sql="update vanila_suradnice set zakladna_popis='$text' where zakladna_id=$base_id";
      //echo $sql;
      $result=mysqli_query($link, $sql);
      mysqli_close($link);