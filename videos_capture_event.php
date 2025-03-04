<?php

	include("includes/dbconnect.php");

	$event = $_POST['event'];
	
	$write_event = "INSERT into videos_events (event,event_date ) VALUES ('$event',now())";
	mysqli_query($link, $write_event) or die(mysqli_error($link));