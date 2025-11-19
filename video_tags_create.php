<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $tag_name = mysqli_real_escape_string($link, $_POST['tag_name']);

    $create_tag = "INSERT INTO tags_list (tag_name) VALUES ('$tag_name')";
    $result=mysqli_query($link, $create_tag) or die("MySQLi ERROR: " . mysqli_error($link));

?>