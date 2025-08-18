<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $mod_id = $_GET['mod_id'];

        $get_mod_videos = "SELECT * from mod_videos WHERE mod_id = $mod_id";
        $result_videos=mysqli_query($link, $get_mod_videos) or die(mysqli_error(($link)));
        while($row_videos = mysqli_fetch_array($result_videos)){

                $video_id = $row_videos['video_id'];
                $video_title = $row_videos['video_title'];
                $video_url = $row_videos['video_url'];

                echo "div class='mod_video' video-id=$video_id>";
                        echo "<iframe src='$video_url' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                echo "</div>"; //mod_video 
        }
?>
