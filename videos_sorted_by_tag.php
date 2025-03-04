<?php include "includes/dbconnect.php";
      include "includes/functions.php";

      $tag_id = $_GET['sort_by'];


      $get_videos_by_tag = "SELECT * from video_tags WHERE tag_id ='$tag_id'";
      //echo $get_videos_by_source;
         $result=mysqli_query($link, $get_videos_by_tag);
                        while ($row = mysqli_fetch_array($result)) {
                          $video_id=$row['video_id'];

                       $get_videos_by_id = "SELECT * from videos WHERE video_id=$video_id";
                       $result_videos=mysqli_query($link, $get_videos_by_id);
                       while($row_videos = mysqli_fetch_array($result_videos)){

                          $video_name=$row_videos['video_title'];
                          $video_url=$row_videos['video_url'];
                          $mod_id=$row_videos['cat_id'];
                          $modpack_id=$row_videos['modpack_id'];
                          $is_favorite=$row_videos['is_favorite'];
                          $see_later=$row_videos['watch_later'];
                          $video_thumb = $row_videos['video_thumbnail'];

                            echo "<div class='video' video-id=$video_id>";
                                    echo "<div class='video_thunb'><img src='$video_thumb'></div>";
                                    echo "<div class='video_list_details'>";
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
                                          echo GetVideoTags($video_id);
                                      echo "</div>";                                     
                                    echo "</div>";

                                   echo "<div class='video_banner_list'></div>";
                                   echo "<div class='video_action_play'>";
                                    echo "<div class='video_play_button'><div><a href='video.php?video_id=$video_id'><i class='fas fa-play'></i></a></div></div>";
                                   echo "</div>";
                                                                   
                          echo "</div>"; //video
                       }
        }     
?>