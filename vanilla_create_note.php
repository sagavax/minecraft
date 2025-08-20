<?php
include("includes/dbconnect.php");
    //var_dump($_POST);
    //$diary_text =mysqli_real_escape_string($db,$_GET['note_text']);
    $note_text =mysqli_real_escape_string($link,$_POST['note_text']);
    $note_title =mysqli_real_escape_string($link,$_POST['note_title']);
    $base_id = $_POST['base_id'];
    $sql="INSERT INTO vanila_base_notes (base_id, note_title, note_text,added_date) VALUES ($base_id, '$note_title','$note_text',now())";
    $result=mysqli_query($link,$sql) or die("MySQL ERROR: ".mysqli_error($link));