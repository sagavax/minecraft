<?php include "includes/dbconnect.php";
include "includes/functions.php";

$comm_id=$_GET['comm_id'];
$comment = mysqli_real_escape_string($link, $_GET['comment']);

$sql="UPDATE picture_comments SET picture_comment = '$comment' WHERE comm_id=$comm_id";
echo $sql;
$result_comments = mysqli_query($link, $sql) or die(mysqli_error($link));