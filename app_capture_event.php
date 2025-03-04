<?php

	include("includes/dbconnect.php");

	$event = $_POST['event'];
	$curr_module = $_POST['current_module'];

	$write_event = "INSERT into application_events (event,module, event_date ) VALUES ('$event','$curr_module',now())";
	mysqli_query($link, $write_event) or die(mysqli_error($link));