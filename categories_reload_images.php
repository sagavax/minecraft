<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $mod_id = $_GET['mod_id'];

       $show_info_mod = "SELECT * from mod_images WHERE mod_id=$mod_id";
       $result = mysqli_query($link, $show_info_mod) or die(mysqli_error($link));

       while ($row_images = mysqli_fetch_array($result)) {
           $image_id = $row_images['image_id'];
           $image_title = $row_images['image_title'];
           $image_url = $row_images['image_url'];

          echo "<div class='mod_image' image-id=$image_id>";
                echo "<button name='delete_image' title='Delete image' class='button small_button'><i class='fa fa-times'></i></button>";
                echo "<img src='$image_url' alt='$image_title'>";
          echo "</div>"; //mod_image 
       }
?>
