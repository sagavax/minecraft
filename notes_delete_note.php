<?php include "includes/dbconnect.php";
      include "includes/functions.php";


      $note_id = $_POST['note_id'];

      $delete_note = "DELETE from notes where note_id = $note_id";
      $result=mysqli_query($link, $delete_note);

?>