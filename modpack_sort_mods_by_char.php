<?php

include "includes/dbconnect.php";

$char = $_GET['char'];

$get_mods = "SELECT * from mods WHERE cat_name LIKE '$char%'";
$result=mysqli_query($link, $get_mods);
while ($row = mysqli_fetch_array($result)) {  
   $id = $row['cat_id'];
   $cat_name = $row['cat_name'];
    echo "<button class='button blue_button' data-id=$id onclic='add_mod_to_modpack($id)'>$cat_name</button>";
  } 