<?php

	include("includes/dbconnect.php");

    //var_dump($_POST);

    $base_name = mysqli_real_escape_string($link, $_POST['base_name']);
    $base_id = mysqli_real_escape_string($link, $_POST['base_id']);
    
    $update_name = "UPDATE vanila_bases SET base_name='$base_name' WHERE zakladna_id=$base_id";
    $result=mysqli_query($link, $update_name);