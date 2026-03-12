<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');


$get_modpacks = "SELECT * from modpacks";
$result = mysqli_query($link, $get_modpacks);
while ($row = mysqli_fetch_array($result)) {
    $modpack_id = $row['modpack_id'];
    $modpack_name = $row['modpack_name'];
    echo "<button class='blue_button' name='modpack' modpack-id=$modpack_id>$modpack_name</button>";
}