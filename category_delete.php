<?php include "includes/dbconnect.php";

$id=$_POST['cat_id'];
$sql="DELETE from mods where cat_id=$id";
$result=mysqli_query($link, $sql);

$diary_text="Minecraft IS: Bolo bol bol vymazany mod s id $cat_id";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

