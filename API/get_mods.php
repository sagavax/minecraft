<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');

if(isset($_GET['char'])){ //mod is not empty
   $char = $_GET['char'];
    $get_mods = "SELECT * from mods where LEFT(cat_name, 1) = '$char'";
} else {
    $get_mods = "SELECT * from mods ORDER BY cat_name ASC LIMIT 20";
}

//echo $get_mods;

$result = mysqli_query($link, $get_mods) or die(mysqli_error($link));
while ($row = mysqli_fetch_array($result)) {
    $mod_id = $row['cat_id'];
    $mod_name = $row['cat_name'];
    echo "<button class='blue_button' name='mod' mod-id=$mod_id>$mod_name</button>";
}