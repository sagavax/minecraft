<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $modpack_id = $_GET['modpack_id'] ?? null;


    $get_modpacks_query = "SELECT * from videos, videos_modpacks WHERE videos.video_id = videos_modpacks.video_id AND videos_modpacks.modpack_id = $modpack_id ORDER BY videos.video_id DESC";
    $modpacks_result = mysqli_query($link, $get_modpacks_query);
   while ($row = mysqli_fetch_array($modpacks_result)) {        
        $video_id=$row['video_id'];
        $video_name=$row['video_title'];
        $video_url=$row['video_url'];
        $is_favorite=$row['is_favorite'];
        $see_later=$row['watch_later'];
        $video_thumb = $row['video_thumbnail'];
        $video_edition = $row['edition'];

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

                    echo "<button name='add_note' title='add note' class='button app_badge open-button' video-id=$video_id><i class='fa fa-comment'></i></button><button name='delete_video' type='button' class='button app_badge' video-id='$video_id'><i class='fas fa-times'></i></button><button class='button app_badge video_edition' name='change_edition' title ='Video minecraft edition'>$video_edition</button>";
                    echo "</div>";//video actiom 
                    echo "<div class='video_tags_wrap' video-id=$video_id>";
                        
                        echo "<div class='videos_tags'>";
                            echo GetVideoTagList($video_id);
                        echo "</div>";
                        
                        echo "<button class='button small_button' name='new_tag' title='Add new tag(s)'><i class='fa fa-plus'></i></button>";
                    echo "</div>";                        
                    echo "<div class='video_modpack_information_wrap'><div class='video_modpack_info'>".GetVideoModpack($video_id)."</div><div class='video_mods'>".GetVideoMods($video_id)."</div></div>";             
                echo "</div>";// video details ends here

                echo "<div class='video_banner_list'></div>";
                echo "<div class='video_action_play'>";
                echo "<div class='video_play_button'><div><a href='video.php?video_id=$video_id'><i class='fas fa-play'></i></a></div></div>";
                echo "</div>"; 
                                                
        echo "</div>"; //video
        
    } 
