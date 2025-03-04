<?php include "includes/dbconnect.php";
include "includes/functions.php";

$new_name = $_POST['new_name'];
$image_id=$_POST['image_id'];


$save_new_name="UPDATE pictures SET picture_title='$new_name' WHERE picture_id=$image_id";
$result = mysqli_query($link, $save_new_name);

    
  
    $curr_date = date('Y-m-d H:i:s');
    $diary_text = "Minecraft IS: Titulok obrazka s id $image_id bol zmeneny na <b>".$new_name."</b>";
    $sql = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: " . mysqli_error($link1));
    
