<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $char = $_GET['char'];

    $modps_by_char = "SELECT * FROM mods WHERE cat_name LIKE '$char%' ORDER BY cat_name ASC";
    $result = mysqli_query($link, $modps_by_char) or die(mysqli_error($link));

    while($row = mysqli_fetch_array($result)){
        $mod_name = $row['cat_name'];
        $mod_id = $row['cat_id'];
        echo "<button data-id-$mod_id class='button blue_button' name='add_mod_to_modpack'>$mod_name</button>";
    }