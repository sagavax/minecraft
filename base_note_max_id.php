<?php

	<?php include("includes/dbconnect.php");

	$base_id = $_POST['base_id'];
	$getmax_id = "SELECT max(note_id) as max_id from vanila_base_notes WHERE base_id=$base_id";
	$result = mysqli_query($link, $getmax_id) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);   
    $max_id = $row['max_id'];

    echo $max_id;
