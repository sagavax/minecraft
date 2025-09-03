<?php

    include("includes/dbconnect.php");
    include ("includes/functions.php");


    $get_vanilla_minecraft_galleries = "SELECT * FROM picture_galleries WHERE gallery_category='vanilla'";
    $result = mysqli_query($link, $get_vanilla_minecraft_galleries) or die("MySQLi ERROR: ".mysqli_error($link));
    while($row = mysqli_fetch_array($result)) {
        echo "<div class='gallery_list_item'><div class='gallery_name'>" . htmlspecialchars($row['gallery_name']) . "</div><div class='gallery_remove'><i class='fa fa-times'></i></div></div>";
    }   