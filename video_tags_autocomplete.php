<?php
	include("includes/dbconnect.php");
	$tag="";
	$tag = $_GET['tag'];
	$get_tags = "SELECT tag_name from tags_list WHERE tag_name LIKE '%$tag%'";
	//echo $get_tags;
	$result = mysqli_query($link, $get_tags);

	// Check if the query was successful
	if($result) {
	    $rows = array(); // Initialize an empty array to store rows
	    
	    // Fetch each row from the result set
	    while($row = mysqli_fetch_assoc($result)) {
	        $rows[] = $row; // Add the row to the array
	    }
	    
	    // Convert the array of rows into JSON format
	    $json = json_encode($rows);
	    
	    // Print or return the JSON data
	    echo $json;
	} else {
	    // Handle the case where the query fails
	    echo "Error executing query: " . mysqli_error($link);
	}



	