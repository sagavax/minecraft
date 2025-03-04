<?php
include("includes/dbconnect.php");
    //var_dump($_POST);
    //$diary_text =mysqli_real_escape_string($db,$_GET['note_text']);
    $note_text =mysqli_real_escape_string($link,$_POST['note_text']);
    $note_title =mysqli_real_escape_string($link,$_POST['note_title']);
    $zakladna_id = $_POST['base_id'];
    $sql="INSERT INTO vanila_base_notes (zakladna_id, note_title, note_text,added_date) VALUES ($zakladna_id, '$note_title','$note_text',now())";
    $result=mysqli_query($link,$sql) or die("MySQL ERROR: ".mysqli_error($link));


    $getmax_id = "SELECT max(note_id) as max_id from vanila_base_notes";
	$result = mysqli_query($link, $getmax_id) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);   
    $max_id = $row['max_id'];

    echo $max_id;

    $diary_text="Minecraft IS: Bolo vytvorena base note s id $max_id";";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

