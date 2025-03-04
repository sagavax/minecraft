 <?php 
      include("includes/dbconnect.php");
      include("includes/functions.php");
?>
                  <div class='modlist_mods_title'><h3><?php echo "Videos for the modpack ".GetModPackName($_GET['modpack_id']); ?></h3></div>
                  <div class="search_wrap">
                                  <input type="text" name="search" placeholder="search videos..." autocomplete="off"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
                   </div> 
                       
                        <div class="videos_list">

                          <?php 
                              $modpack_id = $_GET['modpack_id'];
                              $get_modpack_videos = "SELECT * from videos WHERE modpack_id=$modpack_id";
                               $result=mysqli_query($link, $get_modpack_videos);
                                while ($row = mysqli_fetch_array($result)) {
                                  $video_id=$row['video_id'];
                                  $video_name=$row['video_title'];
                                  $video_url=$row['video_url'];
                                  $mod_id=$row['cat_id'];
                                  $modpack_id=$row['modpack_id'];
                                  $is_favorite=$row['is_favorite'];
                                  $see_later=$row['watch_later'];
                                  $video_thumb = $row['video_thumbnail'];

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

                                                echo "<button name='add_note' title='add note' class='button app_badge' video-id=$video_id><i class='fa fa-comment'></i></button><button name='edit_video' type='button' class='button app_badge' video-id='$video_id' ><i class='far fa-edit'></i></button><button name='delete_video' type='button' class='button app_badge' video-id='$video_id'><i class='fas fa-times'></i></button>";
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
                          ?>
                        </div>
                             <dialog class="modal">
                                <div class="inner_layer">
                                    <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>  
                                    <input type="text" name="tag_name" placeholder="tag name ...." autocomplete="off">
                                    <ul></ul> <!-- Move ul inside inner_layer -->
                                </div>
                              </dialog>  
                            

                              <dialog class="modal_notes">
                                      <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>  
                                     <input type="text" name="video_comment" placeholder="type your comment here ...." autocomplete="off"> 
                                </dialog>

                               <dialog class="modal_modpack">
                                  <div class='inner_modpack_layer'>
                                      <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>  
                                      <input type="text" name="modpack_name" placeholder="name of the modpack ...." autocomplete="off"> 
                                  </div>  
                               </dialog>   


                               <dialog class="modal_video_tags">
                                 <div class="inner_tags_layer">
                                    <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button> 
                                    <div class="search_tag"><input type="text" autocomplete="off" spellcheck="off" placeholder="type modification name here..."></div>
                                    <div class="tag_map"><?php echo GetAllVideoTagPaginated() ?></div>
                                    <div class='pagination'><?php echo GetTotalPagesVideosTags()  ?></div>
                                 </div>   
                               </dialog>
                       
                       <script async src="./js/modpack_videos.js?<?php echo time() ?>"></script>
                       <script async src="./js/modpack_videos_action.js?<?php echo time() ?>"></script>