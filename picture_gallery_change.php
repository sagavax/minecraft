<?php

    include ("includes/dbconnect.php");
    include ("includes/functions.php");

    $image_id = (int)$_POST['image_id'];
    $gallery_id = (int)$_POST['gallery_id'];
    $gallery_name = mysqli_real_escape_string($link, $_POST['gallery_name']);

    $change_gallery = "INSERT INTO pictures_gallery_images (picture_id, gallery_id, added_date)
                    VALUES ($image_id, $gallery_id, NOW())
                    ON DUPLICATE KEY UPDATE
                        gallery_id = VALUES(gallery_id),
                        added_date = VALUES(added_date)";

    $result = mysqli_query($link, $change_gallery) or die("MySQLi ERROR: ".mysqli_error($link));

    // log
    $diary_text = "Bol pridany obrazok s ID $image_id do gallery <b>$gallery_name</b>";
    $sql = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', NOW())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

?>