<?php
	include("includes/dbconnect.php");

	$image_id = $_POST['image_id'];
	$base_id = $_POST['base_id'];


	//get image name by id;
	$get_image_name = "SELECT image_name from vanila_base_images WHERE img_id = $image_id";
	$result = mysqli_query($link, $get_image_name) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$image_name = $row['image_name'];

	//remove all comments
	$remove_comments = "DELETE from vanila_base_images_comments WHERE img_id=$image_id";
	$result = mysqli_query($link, $remove_comments) or die("MySQLi ERROR: ".mysqli_error($link));


	//remove from the database;
	$remove_image = "DELETE from vanila_base_images where img_id=$image_id";
	$result = mysqli_query($link, $get_image_name) or die("MySQLi ERROR: ".mysqli_error($link));

	//remove image from file system
    unlink($image_name);

    $diary_text="Minecraft IS: Image <b>$image_name<b> bol vymazany";
    $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
