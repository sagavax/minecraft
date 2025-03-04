<?php

include "includes/dbconnect.php";

     $picture_id = $_GET['picture_id'];
     $sql ="SELECT COUNT(*) as nr_of_comments from picture_comments where pic_id=".$picture_id;
    	 $result=mysqli_query($link, $sql);
	 $row = mysqli_fetch_array($result);
	 $nr_of_comments=$row['nr_of_comments'];	

     echo $nr_of_comments;
	 