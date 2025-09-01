<?php

    include("../includes/dbconnect.php");
    include("../includes/functions.php");

    $base_id = $_POST['base_id'];
    $delete_base = "DELETE from vanila_bases WHERE base_id = $base_id";
    $result = mysqli_query($link, $delete_base) or die("MySQLi ERROR: " . mysqli_error($link));


    //remove all base tasks
    $delete_base_tasks = "DELETE from vanila_base_tasks WHERE base_id = $base_id";
    $result = mysqli_query($link, $delete_base_tasks) or die("MySQLi ERROR: " . mysqli_error($link));

    //add to log
    $diary_text="Tasky pre zakladnu s id $base_id bola vymazane";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


    //remove all base notes
    $delete_base_notes = "DELETE from vanila_base_notes WHERE base_id = $base_id";
    $result = mysqli_query($link, $delete_base_notes) or die("MySQLi ERROR: " . mysqli_error($link));

    //add to log
    $diary_text="Poznamky pre zakladnu s id $base_id bola vymazane";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


    //remove all base ideas
    $delete_base_ideas = "DELETE from vanila_base_ideas WHERE base_id = $base_id";
    $result = mysqli_query($link, $delete_base_ideas) or die("MySQLi ERROR: " . mysqli_error($link));
    
    //add to log
    $diary_text="Ideas pre zakladnu s id $base_id bola vymazane";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));



    //add to log
    $diary_text="Zakladna s id $base_id bola vymazana";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
?>