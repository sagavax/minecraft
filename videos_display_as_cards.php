
<?php include "includes/dbconnect.php";
      include "includes/functions.php";		
?>
	<?php
			echo "<div class='videos_grid'>";
			    $sql="SELECT * from videos ORDER BY video_id DESC";
				$result=mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result)) {
					$video_id=$row['video_id'];
					$video_name=$row['video_title'];
					$video_url=$row['video_url'];
					$is_favorite=$row['is_favorite'];
					$see_later=$row['watch_later'];
					$video_thumb = $row['video_thumbnail'];

					echo "<div class='video_card'>";	
						echo "<div class='video_card_thumb'><img src='$video_thumb' alt='' loading='lazy'></div>";
						echo "<div class='video_card_name'>$video_name</div>";
						echo "<div class='video_card_footer'>";
							echo "<div class='video_card_actions' data-id='$video_id'>";
								echo "<button type='button' name='play'> <i class='fas fa-play'></i></button>";
								echo "<button type='button' name='video_comments'><i class='fas fa-comment-alt'></i></button>";
								echo "<button type='button' name='video_favorite'><i class='far fa-star'></i></button>";
								echo "<button type='button' name='video_watch_later'><i class='far fa-clock'></i></button>";
								echo "<button type='button' name='video_remove'><i class='fa fa-times'></i></button>";
							echo "</div>";
						echo "</div>";//footer
					echo "</div>";//card
			  }
			echo "</div>";//grid	
		?>


	