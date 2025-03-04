<?php 
		  include "includes/dbconnect.php";

		  $video_id=intval($_POST['video_id']);
		  $is_favorite = $_POST['is_favorite'];

          $sql="UPDATE videos set is_favorite=$is_favorite where video_id=$video_id";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));