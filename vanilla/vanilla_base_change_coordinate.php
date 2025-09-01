<?php

	include("../includes/dbconnect.php");

$location = $_POST['location'];
$base_id = $_POST['base_id'];
$coord = $_POST['coordinate'];

//var_dump($_POST);


if ($coord == "outworld_x") {
    $update_coord = "UPDATE vanila_bases SET x=".$_POST['coordinate']." WHERE base_id=$base_id";
} else if ($location== "outworld_y") {
    $update_coord = "UPDATE vanila_bases SET y=".$_POST['coordinate']." WHERE base_id=$base_id";
} else if ($location == "outworld_z") {
    $update_coord = "UPDATE vanila_bases SET z=".$_POST['coordinate'] ."WHERE base_id=$base_id";
} else if ($location == "nether_x") {
    $update_coord = "UPDATE vanila_bases SET nether_x=".$_POST['coordinate']." WHERE base_id=$base_id";
} else if ($location == "nether_y") {
    $update_coord = "UPDATE vanila_bases SET nether_y=".$_POST['coordinate']." WHERE base_id=$base_id";
} else if ($location == "nether_z") {
    $update_coord = "UPDATE vanila_bases SET nether_z=".$_POST['coordinate']." WHERE base_id=$base_id";
}

//echo $update_coord;
$result = mysqli_query($link, $update_coord) or die("MySQLi ERROR: " . mysqli_error($link));