<?php

    include("includes/dbconnect.php");
    $image_id=$_POST['image_id'];
    $comment = mysqli_real_escape_string($link, $_POST['comment_text']);

    //echo $image_id;
 $sql="INSERT INTO picture_comments (pic_id, comment, comment_date) VALUES ($image_id,'$comment', now())";
  $result=mysqli_query($link, $sql) or die(mysqli_error($link));


$diary_text="Minecraft IS: Bolo pridane novy kommentar k obrazku id <b>$image_id</b>";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
?>    
