                         <?php     
                               echo "<div class='video'>";
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

                                        echo "<button name='edit_video' type='button' class='button app_badge' video-id='$video_id' ><i class='far fa-edit'></i></button><button name='delete_video' type='submit' class='button app_badge' video-id='$video_id'><i class='fas fa-times'></i></button>";
                                       echo "</div>";//video actiom 
                                       echo "<div class='videos_tags'>";
                                          echo GetVideoTags($video_id);
                                      echo "</div>";                                     
                                    echo "</div>";

                                   echo "<div class='video_banner_list'></div>";
                                   echo "<div class='video_action_play'>";
                                    echo "<div class='video_play_list'><div><a href='video.php?video_id=$video_id'><i class='fas fa-play'></i></a></div></div>";
                                   echo "</div>";
                                                                   
                          echo "</div>"; //video
                        ?>