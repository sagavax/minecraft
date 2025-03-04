<?php
		include("includes/dbconnect.php");
		$current_page = $_POST['page'];


		$itemsPerPage = 10;

        //$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $itemsPerPage;  

  	    $get_all_tags = "SELECT * from tags_list ORDER BY tag_name ASC LIMIT $itemsPerPage OFFSET $offset";
  	 	//echo $get_tags;
		$result=mysqli_query($link, $get_all_tags);

		while ($row = mysqli_fetch_array($result)) {
			   $tag_id= $row['tag_id'];
			   $tag_name= $row['tag_name'];

			   echo "<button class='modal_tag' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			   
			   }
	
	//return $tags;