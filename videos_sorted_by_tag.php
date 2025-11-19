<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      $tag_id = $_POST['tag_id'];


      $get_videos_by_tag = "SELECT * FROM videos a, video_tags b, tags_list c WHERE b.tag_id = $tag_id AND a.video_id = b.video_id AND b.tag_id = c.tag_id";
      //echo $get_videos_by_source;
         $result=mysqli_query($link, $get_videos_by_tag) or die("MySQLi ERROR: ".mysqli_error($link));
         while ($row = mysqli_fetch_array($result)) {
          $video_id=$row['video_id'];
          $video_name=$row['video_title'];
          $video_url=$row['video_url'];
          //$mod_id=$row['cat_id'];
          //$modpack_id=$row['modpack_id'];
          $is_favorite=$row['is_favorite'];
          $see_later=$row['watch_later'];
          $video_thumb = $row['video_thumbnail'];

            echo "<div class='video' video-id=$video_id>";
                    echo "<div class='video_thunb'><img src='$video_thumb'></div>";
                    echo "<div class='video_list_details'>"; // video details start here
                       echo "<div class='video_name'><span>$video_name</span></div>";
                       echo "<div class='video_action'>";
                         if($see_later==0) {
                          echo "<button name='watch_later' type='button' title='Watch later' class='button app_badge' video-id='$video_id'><i class='far fa-clock'></i></button>";
                        } 

                        if($see_later==1) {
                          echo "<button name='remove_watch_later' type='button' title='Remove Watch later' class='button app_badge' video-id='$video_id'><i class='fas fa-clock'></i></button>";
                        }

                        if($is_favorite==0) {
                          echo "<button name='add_to_favorites' type='button' title='add to favorites' class='button small_button app_badge' video-id='$video_id'><i class='far fa-star'></i></button>";
                        } 

                        if ($is_favorite==1) {
                          echo "<button name='remove_from_favorites' type='button' title='remove from favorites' class='button app_badge' video-id='$video_id'><i class='fas fa-star'></i></button>";
                        }

                        echo "<button name='add_note' title='add note' class='button app_badge open-button' video-id=$video_id><i class='fa fa-comment'></i></button><button name='edit_video' type='button' class='button app_badge' video-id='$video_id' ><i class='far fa-edit'></i></button><button name='delete_video' type='button' class='button app_badge' video-id='$video_id'><i class='fas fa-times'></i></button>";
                       echo "</div>";//video actiom 
                       echo "<div class='videos_tags' video-id=$video_id>";
                          echo GetVideoTagList($video_id);
                          echo "<button class='button small_button' name='new_tag' video-id=$video_id title='Add new tag(s)'><i class='fa fa-plus'></i></button>";
                      echo "</div>";                        
                      echo "<div class='video_modpack_information_wrap'><div class='video_modpack_info'>".GetVideoModpack($video_id)."<button class='button blue_button' name='change_modpack' title='change modpack'><i class='fa fa-edit'></i></button></div><div class='video_mods'>".GetVideoMods($video_id)."<button class='button blue_button' name='add_mod' title='add mod(a)'><i class='fa fa-plus'></i></button></div></div>";             
                    echo "</div>";// video details ends here

                   echo "<div class='video_banner_list'></div>";
                   echo "<div class='video_action_play'>";
                    echo "<div class='video_play_button'><div><a href='video.php?video_id=$video_id'><i class='fas fa-play'></i></a></div></div>";
                   echo "</div>"; 
                                                   
          echo "</div>"; //video
          
        }        
?>