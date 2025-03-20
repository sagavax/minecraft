<?php
    include "includes/dbconnect.php";

    $tag_id = $_POST['tag_id'];


    $remove_tag="DELETE from tags_list WHERE tag_id";
    $result=mysqli_query($link, $remove_tag) or die(mysqli_error); //
    
    
    //add to app log
    $diary_text="Tag s id <strong>$tag_id</strong> bol vymazany";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
