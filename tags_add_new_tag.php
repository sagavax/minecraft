<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $new_tag = mysqli_real_escape_string($link, $_POST['new_tag']);
    $add_tag = "INSERT INTO tags (tag_name, tag_modified) VALUES ('$new_tag', now())";
    $result = mysqli_query($link, $add_tag) or die("MySQLi ERROR: " . mysqli_error($link));

?>

