<?php

	include("includes/dbconnect.php");

	//var_dump($_POST);

    $base_description = mysqli_real_escape_string($link, $_POST['base_description']);
    $base_id = $_POST['base_id'];

    $update_description = "UPDATE vanila_bases SET base_description='$base_description' WHERE base_id=$base_id";
    $result = mysqli_query($link, $update_description);