<?php

include("includes/dbconnect.php");
include("includes/functions.php");


$letter = mysqli_real_escape_string($link, $_POST['letter']); //$_POST['char'];

//echo $char;
$get_tags = "SELECT * FROM tags_list WHERE tag_name LIKE '$letter%' ORDER BY tag_name ASC";
$result=mysqli_query($link, $get_tags) or die(mysqli_error($link));
while ($row = mysqli_fetch_array($result)) {
    $tag_id= $row['tag_id'];
    $tag_name= $row['tag_name'];
    echo "<div class='tag' data-id=$tag_id><div class='tag_name'>$tag_name</div><div class='tag_action'><i class='fas fa-times-circle' title='Delete tag'></i></div></div>";
}