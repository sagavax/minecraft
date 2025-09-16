<?php

    include("includes/dbconnect.php");
    include ("includes/functions.php");


    $get_gallery = "SELECT gallery_id, gallery_name FROM picture_galleries";
    $result = mysqli_query($link, $get_gallery) or die(mysqli_error($link));
    while($row = mysqli_fetch_array($result)) {
        echo  "<div gallery-id='" . $row['gallery_id'] . "' class='gallery_list_item button small_button'><div class='gallery_name'>" . htmlspecialchars($row['gallery_name']) . "</div><div class='gallery_remove'><i class='fa fa-times'></i></div></div>";        
    }            