<?php
include("includes/dbconnect.php");
include("includes/functions.php");


$tag_name=trim(mysqli_real_escape_string($link, $_POST['tag_name']));

$sql="INSERT INTO tags_list (tag_name, tag_modified) VALUES ('$tag_name',now())";
       //echo $sql;
$result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

$response = ['success' => true, 'message' => 'Tag created successfully!'];

// Make sure to return a JSON response
header('Access-Control-Allow-Origin: *'); // Allow all domains
header('Content-Type: application/json');
echo json_encode($response);