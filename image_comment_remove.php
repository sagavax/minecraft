<?php

include("includes/dbconnect.php");

    //$video_id = $_POST['video_id'];
$comm_id = $_POST['comm_id'];

$remove_comment = "DELETE from picture_comments WHERE comm_id=$comm_id ";
echo $remove_comment;
$result = mysqli_query($link, $remove_comment);

$diary_text="Komentar s id: <strong>$comm_id</strong> bol vymazany";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));