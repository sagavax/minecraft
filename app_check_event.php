<?php 

include("includes/dbconnect.php");


$get_latest_event = "SELECT * from application_events ORDER BY event_id DESC LIMIT 1";
$result = mysqli_query($link, $get_latest_event) or die(mysqli_error($link));
$row = mysqli_fetch_array($result);
$event_date = $row['event_date'];

echo $event_date;

