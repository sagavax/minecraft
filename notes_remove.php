<?php include "includes/dbconnect.php";
      include "includes/functions.php";


      $note_id = $_POST['note_id'];

      //remove attachements
      $delete_attachements = "DELETE from notes_file_attachements where note_id = $note_id";
      $result=mysqli_query($link, $delete_attachements) or die(mysqli_error($link));
      
      $delete_note = "DELETE from notes where note_id = $note_id";
      $result=mysqli_query($link, $delete_note) or die(mysqli_error($link));


      //add to log
        
      $diary_text="Minecraft IS: Bol vymazana poznamka s id <strong>$note_id</strong> v Minecraft IS";
       
      $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
      $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

?>