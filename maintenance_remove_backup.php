<?php

		include("includes/dbconnect.php");

		var_dump($_POST);

		$file_name = mysqli_real_escape_String($link, $_POST['file_name']);

		
	    //remove from database		
		$remove_file = "DELETE from backup_files WHERE file_name='$file_name'";
		mysqli_query($link, $remove_file) or die (mysqli_error($link));

	   //remove the file
		unlink("backups/".$file_name);

	$diary_text="Minecraft IS: <b>$fileName</b> bol vymazany ";
	$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
	$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
