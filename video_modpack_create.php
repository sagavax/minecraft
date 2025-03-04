<?php

	include("includes/dbconnect.php");
	include("includes/functions.php");

	$modpack_name = $_POST['modpack_name'];

	$add_modpack = "INSERT INTO modpacks (modpack_name) VALUES ('$modpack_name')";
	//echo $add_modpack;	
	$result=mysqli_query($link, $add_modpack);
	echo GetModpacks();