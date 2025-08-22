<?php

    include ("includes/dbconnect.php");
    include ("includes/functions.php");

    $mod_id = $_POST['mod_id'];
    $note_id = $_POST['note_id'];


    $add_mod_to_note = "INSERT INTO notes_mods (note_id, mod_id, added_date) VALUES ($note_id,$mod_id,now())";
    $result = mysqli_query($link, $add_mod_to_note) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to log
    $diary_text="Mod s id $mod_id bol pridany do poznamky s id $note_id";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


?>