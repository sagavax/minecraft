<?php
include("includes/dbconnect.php");
    //var_dump($_POST);
    $idea_title =mysqli_real_escape_string($link,$_POST['idea_title']);
    $idea_text =mysqli_real_escape_string($link,$_POST['idea_text']);
    $base_id = $_POST['base_id'];
    $sql="INSERT INTO vanila_base_ideas (base_id,idea_title, idea_text,added_date) VALUES ($base_id,'$idea_title','$idea_text',now())";
    $result=mysqli_query($link,$sql) or die("MySQL ERROR: ".mysqli_error($link));