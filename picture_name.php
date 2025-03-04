<?php include "includes/dbconnect.php";


$image_name = $_POST['picture_title'];
$image_id = $_POST['image_id'];

$update_title="UPDATE pictures SET picture_title='$image_name' WHERE picture_id=$image_id";
 $result=mysqli_query($link, $update_title);