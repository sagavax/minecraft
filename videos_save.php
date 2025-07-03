<?php
         include("includes/dbconnect.php");
         include("includes/functions.php");
 
          //var_dump($_POST);
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          
          if (!isset($_POST['category'])) {
            $mod_id = 0;
          } else {
            $mod_id = mysqli_real_escape_string($link, $_POST['category']);
          }
          
          if (!isset($_POST['modpack'])) {
            $modpack_id = 0;
          } else {
            $modpack_id = mysqli_real_escape_string($link, $_POST['modpack']);
          }
          
          //echo $modpack_id;
          //$modpack=mysqli_real_escape_string($link, $_POST['modpack']);

          //$modpack_vanilla = mysqli_real_escape_string($link, $_POST['modpack_vanilla']);
          
          $video_source = mysqli_real_escape_string($link, $_POST['video_source']);
          $edition = $_POST['edition'];
          
          $video_id_th = getYouTubeVideoId($video_url);
          $video_thumb = "https://img.youtube.com/vi/".$video_id_th."/0.jpg";


          //saving basic information
          $save_video="INSERT INTO videos (video_title,video_url,edition,video_thumbnail ,video_source,added_date) VALUES ('$video_name','$video_url','$edition','$video_thumb','$video_source',now())";
          //echo $save_video;
          $result=mysqli_query($link, $save_video) or die("MySQLi ERROR: ".mysqli_error($link));

              
        $diary_text="Minecraft IS: Bolo pridane nove video s nazvom <strong>$video_name</strong>";
        $add_to_diary="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $add_to_diary) or die("MySQLi ERROR: ".mysqli_error($link));
        
          
        //get newest video
        $get_newest_video = "SELECT MAX(video_id) as newest from videos";
        $result_newest = mysqli_query($link, $get_newest_video) or die("MySQLi ERROR: ".mysqli_error($link));  
        $row_newest = mysqli_fetch_array($result_newest);
        $newest_video_id = $row_newest['newest'];

        //add to mods 
        $add_video_mod = "INSERT INTO videos_mods (video_id, cat_id) VALUES ($newest_video_id,$mod_id)";
        mysqli_query($link, $add_video_mod) or die("MySQLi ERROR: ".mysqli_error($link));    

       //add to modpacks
       $add_video_modpack = "INSERT INTO videos_modpacks (video_id, modpack_id) VALUES ($newest_video_id,$modpack_id)";
        mysqli_query($link, $add_video_modpack) or die("MySQLi ERROR: ".mysqli_error($link));    

       


  $response = ['success' => true, 'message' => 'Video added successfully!'];

        // Make sure to return a JSON response
        header('Access-Control-Allow-Origin: *'); // Allow all domains
        header('Content-Type: application/json');
        echo json_encode($response);