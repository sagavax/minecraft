<?php 

    include("includes/dbconnect.php");

    $tag_id = $_POST['tag_id'];
    $new_name = $_POST['tag_new_name'];

    $update_tag_name = "UPDATE tags_list SET tag_name='$new_name' WHERE tag_id=$tag_id";
    $result=mysqli_query($link, $update_tag_name) or die(mysqli_error);

    //add to log    
    $diary_text="Minecraft IS: Tag with id $tag_id has been renamed to $new_name";
    $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

?>