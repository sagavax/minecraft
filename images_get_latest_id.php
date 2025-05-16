<?php

include "includes/dbconnect.php";

$latest_id = "SELECT MAX(picture_id) as latest_id FROM pictures";
$result = mysqli_query($link, $latest_id) or die(mysqli_error($link));
$row = mysqli_fetch_array($result);
echo $row['latest_id'];
?>