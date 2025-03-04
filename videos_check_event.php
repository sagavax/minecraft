<?php 

include("includes/dbconnect.php");


$get_latest_event = "SELECT event_date from videos_events";
$result = mysqli_query($link, $get_latest_event) or die(mysqli_error($link));
$row = mysqli_fetch_array($result);
$event_date = $row['event_date'];


echo $event_date;

