<?php
include("includes/dbconnect.php");
    //var_dump($_POST);
    $idea_title =mysqli_real_escape_string($link,$_POST['idea_title']);
    $idea_text =mysqli_real_escape_string($link,$_POST['idea_text']);
    $base_id = $_POST['base_id'];
    $sql="INSERT INTO vanila_base_ideas (base_id,idea_title, idea_text,added_date) VALUES ($base_id,'$idea_title','$idea_text',now())";
    $result=mysqli_query($link,$sql) or die("MySQL ERROR: ".mysqli_error($link));

    //get max id
    $getmax_id = "SELECT max(idea_id) as max_id from vanila_base_ideas";
    $result = mysqli_query($link, $getmax_id) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);   
    $max_id = $row['max_id'];

    //vlozit do wallu 
    $diary_text="Bola vytvorena nova idea s id $max_id pre base <b>".GetbaseNameById($base_id)." </b>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
    