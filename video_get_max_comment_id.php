<?php

include("includes/dbconnect.php");

$get_max_id = "SELECT MAX(comm_id) as max_comm_id FROM video_comments";
$result=mysqli_query($link, $get_max_id);
while ($row = mysqli_fetch_array($result)) {
    $max_comm_id = $row['max_comm_id'];
    }
    
    echo $max_comm_id;
