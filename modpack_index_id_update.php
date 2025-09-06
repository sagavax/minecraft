<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


     $modpack_id = $_POST['modpack_id'];
     $modpack_index_id = $_POST['modpack_index_id'];


     $update_modpack_index_id = "UPDATE modpacks SET modpack_index_id=$modpack_index_id WHERE modpack_id=$modpack_id";
     $result = mysqli_query($link, $update_modpack_index_id) or die("MySQLi ERROR: ".mysqli_error($link));


     //add to log
     $diary_text="Bol zmeneny index modpacku s id $modpack_id na $modpack_index_id";
     $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
     $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
