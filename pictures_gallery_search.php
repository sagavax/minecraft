<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");


    $search_gallery = mysqli_real_escape_string($link,$_POST['search_text']);


    $search_gallery = "SELECT * FROM picture_galleries WHERE gallery_name LIKE '%$search_gallery%'";
    $result = mysqli_query($link, $search_gallery) or die("MySQLi ERROR: ".mysqli_error($link));
    $count = mysqli_num_rows($result);

    if($count > 0) {
        while($row = mysqli_fetch_array($result)) {
            $gallery_id = $row['gallery_id'];
            $gallery_name = $row['gallery_name'];
            
            echo "<button type='button' name='change_gallery' gallery-id='" . $row['gallery_id'] . "' class='button small_button'>" . htmlspecialchars($row['gallery_name']) . "</button>";
        }   
        } else {
            echo "<div class='no_gallery_found'>Such gallery not found. What about creating new one? <button type='button' name='create_gallery' class='button small_button' title='Add to gallery'><i class='fa fa-plus'></i></button></div>";
        }