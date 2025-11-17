<?php 
	include("includes/dbconnect.php");

	$search_tag = $_POST['search_tag'];
	$tags = "";

	if (!empty($search_tag)) {
		$get_all_tags = "SELECT * FROM tags_list WHERE tag_name LIKE '%$search_tag%'";
	} else {
		$itemsPerPage = 10;
		$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
		$offset = ($current_page - 1) * $itemsPerPage;  
		$get_all_tags = "SELECT * FROM tags_list LIMIT $offset, $itemsPerPage";
	}

	// Execute the SQL query
	$result = mysqli_query($link, $get_all_tags);

	while ($row = mysqli_fetch_array($result)) {
		$tag_id = $row['tag_id'];
		$tag_name = $row['tag_name'];

		$tags .= "<button class='modal_tag' name='$tag_name' tag-id='$tag_id'>$tag_name</button>";
	}

	echo $tags;
?>
