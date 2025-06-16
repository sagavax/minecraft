<?php

include("includes/dbconnect.php");
include("includes/functions.php");


$search = $_POST['search_text'];
$get_tags="SELECT * from tags_list where tag_name like '%".$search."%'";
$result=mysqli_query($link, $get_tags) or die("MySQLi ERROR: ".mysqli_error($link));

while ($row = mysqli_fetch_array($result)) {
    $tag_id= $row['tag_id'];
    $tag_name= $row['tag_name'];
   echo "<div class='tag' data-id=$tag_id><div class='tag_name'>$tag_name</div><div class='tag_action'><i class='fas fa-times-circle' title='Delete tag'></i></div></div>";
}
?>