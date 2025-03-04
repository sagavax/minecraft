<?php
         include("includes/dbconnect.php");
         include("includes/functions.php");

        
          global $link;
          //var_dump($_POST);
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          $mod_id=mysqli_real_escape_string($link, $_POST['category']);
          if(isset($_POST['modpack'])){
            $modpack=mysqli_real_escape_string($link, $_POST['modpack']);
          } else {
            $modpack=0;
          }
          
          $video_source = mysqli_real_escape_string($link, $_POST['video_source']);
          $edition = $_POST['edition'];
          
          $video_id_th = getYouTubeVideoId($video_url);
          $video_thumb = "https://img.youtube.com/vi/".$video_id_th."/0.jpg";



          $save_video="INSERT INTO videos (video_title,video_url,edition,cat_id,video_thumbnail ,modpack_id,video_source,added_date) VALUES ('$video_name','$video_url','$edition',$mod_id,'$video_thumb',$modpack,'$video_source',now())";
          //echo $save_video;
          $result=mysqli_query($link, $save_video) or die("MySQLi ERROR: ".mysqli_error($link));

              
        $diary_text="Minecraft IS: Bolo pridane nove video s nazvom <strong>$video_name</strong>";
        $add_to_diary="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $add_to_diary) or die("MySQLi ERROR: ".mysqli_error($link));
        
  
  $response = ['success' => true, 'message' => 'Video added successfully!'];

        // Make sure to return a JSON response
        header('Access-Control-Allow-Origin: *'); // Allow all domains
        header('Content-Type: application/json');
        echo json_encode($response);