<?php 

	include(include "../includes/dbconnect.php");

	$image_id = $_GET['image_id'];

	$get_image = "SELECT * from vanila_base_images WHERE img_id=$image_id";
	$result = mysqli_query($link, $get_image) or die(mysqli_error($link));
    while($row = mysqli_fetch_array($result)) {
    	$image_name=$row['image_name'];
    }

   echo $image_name;
