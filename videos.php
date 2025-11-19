<?php 
      include "includes/dbconnect.php";
      include "includes/functions.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/message.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet'
        type='text/css'>
    <script defer src="js/videos.js?<?php echo time() ?>"></script>
    <script defer src="js/videos_action.js?<?php echo time() ?>"></script>
    <script defer src="js/message.js?<?php echo time() ?>"></script>

    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
</head>

<body>

    <?php 
 
      include("includes/header.php") ?>
    <div class="main_wrap">
        <div class="tab_menu">
            <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
            <div class='list'>

                <!--<div class="fab fab-icon-holder" onclick="document.getElementById('new_video').style.display='flex'">-->
                <div class="fab fab-icon-holder" onclick="showNewVideoForm()">
                    <i class="fas fa-plus"></i>
                </div>

                <div id="new_video">
                    <div class="video_top_bar"><button type="button" class="close_modal" title="hide"><i
                                class="fa fa-times"></i></button></div>
                    <form action="videos_save.php" enctype="multipart/form-data" method="post">
                        <input type="text" name="video_title" placeholder='Video title' autocomplete=off
                            id="video_title" readonly ondblclick="remove_readonly(this)" onblur="set_readonly(this)">
                        <input type="text" name="video_url" placeholder='Video url' id="video_url" autocomplete="off">

                        <select name="edition">
                            <option value='java'>java edition</option>
                            <option value='bedrock'>bedrock edition</option>
                        </select>


                        <select name="modpack_vanilla">
                            <?php
                                echo "<option value='0'>Vanilla Minecraft</option>";   
                                echo "<option value=1>Modded Minecraft</option>";
                             ?>
                        </select>

                        <div class="modpack_container">

                            <select name="category" disabled>
                                <option value=0>-- Select modification -- </option>
                                <?php
                                    $sql="SELECT * from mods ORDER BY cat_name ASC";
                                    $result=mysqli_query($link, $sql);
                                      while ($row = mysqli_fetch_array($result)) {
                                        $cat_id=$row['cat_id'];
                                        $cat_name=$row['cat_name'];
                                    echo "<option value=$cat_id>$cat_name</option>";
                                    }	
                                  ?>
                            </select>
                            <select name="modpack" disabled>
                                <?php      
                                  $get_modpacks = "SELECT * from modpacks ORDER BY modpack_name ASC";
                                    $result=mysqli_query($link, $get_modpacks);

                                    echo "<option value=1>Custome modpack</option>";
                                    while ($row = mysqli_fetch_array($result)) {                   
                                        $modpack_name = $row['modpack_name'];
                                        $modpack_id = $row['modpack_id']; 
                                        echo "<option value=$modpack_id>$modpack_name</option>";

                                    }      
                                    ?>

                            </select>

                            <button type="button" title="add new modpack" class="button small_button"><i
                                    class="fa fa-plus"></i></button>
                        </div><!-- modpack container -->

                        <div class="brand_radio">
                            <label class="brand_label">
                                <input type="radio" class="brand" name="video_source" value="YouTube" checked>
                                <i class="fab fa-youtube"></i>
                            </label>
                            <label class="brand_label">
                                <input type="radio" class="brand" name="video_source" value="Tiktok">
                                <i class="fab fa-tiktok"></i>
                            </label>
                            <label class="brand_label">
                                <input type="radio" class="brand" name="video_source" value="Pinterest">
                                <i class="fab fa-pinterest"></i>
                            </label>
                        </div>


                        <div class="new_video_submit_wrap"><button type="submit" name="add_new_video"
                                class="button pull-right"><i class="fa fa-plus"></i></button></div>

                    </form>

                </div><!-- new video -->




                <div id="videos_wrap">
                    <div class="search_wrap">
                        <input type="text" name="search" onkeyup="search_the_video(this.value);" id="search_string"
                            autocomplete="off" placeholder="search videos here"><button type="button"
                            title="clear search" class="button small_button clear_button tooltip>"><i
                                class="fa fa-times"></i></button>
                    </div><!-- Search wrap-->
                    <div class="tab_view_wrap">
                        <div class="tab_view">
                            <button type="button" name="vanilla" class="button small_button">Vanilla</button>
                            <button type="button" name="modded" class="button small_button">Modded</button>
                            <button type="button" name="all" class="button small_button">All</button>
                        </div>

                        <div class="tab_view_fav_later">
                            <button type="button" name="videos_favorites" class="button small_button">Favorites</button>
                            <button type="button" name="videos_watch_later" class="button small_button">Watch
                                later</button>
                        </div>

                        <div class="tab_view_source">
                            <button type="button" name="youtube" class="button small_button">Youtube</button>
                            <button type="button" name="tiktok" class="button small_button">TikTok</button>
                            <button type="button" name="pinterest" class="button small_button">Pinterest</button>
                        </div>

                        <div class="tab_view_list_grid">
                            <button type="button" name="cards" class="button small_button">Grid</button>
                            <button type="button" name="list" class="button small_button">List</button>
                        </div>

                        <div class="tab_view_edition">
                            <button type="button" name="java" class="button small_button">java</button>
                            <button type="button" name="bedrock" class="button small_button">bedrock</button>
                        </div>

                        <div class="tab_view_tags">
                            <button type="button" name="tags" class="button small_button">tags</button>
                        </div>
                        <div class="tab_view_export">
                            <button typpe="button" name="eport_to_cvs" class="button small_button"
                                title='export all videos'><i class="fas fa-file-export"></i></button>
                            <button typpe="button" name="eport_farms_cvs" class="button small_button"
                                title='Export farms'><i class="fas fa-file-export"></i></button>
                        </div>
                    </div><!-- wrap -->



                    <div class='video_modpacks'>
                        <header><button type='button' class='button blue_button app_badge'><i
                                    class='fa fa-times'></i></button></header>
                        <main>
                            <?php 
                  //$get_videos_modapcks = "SELECT a.modpack_id,b.modpack_name from videos a, modpacks b WHERE a.modpack_id NOT IN (99) and a.modpack_id = b.modpack_id GROUP BY b.modpack_name ORDER BY b.modpack_name ASC";
                    
                  $get_videos_modapcks = "SELECT a.modpack_id,b.modpack_name from videos_modpacks a, modpacks b WHERE a.modpack_id NOT IN (0) and a.modpack_id = b.modpack_id GROUP BY b.modpack_name ORDER BY b.modpack_name ASC";


                $result_modpacks=mysqli_query($link, $get_videos_modapcks) or die("MySQL ERROR: ".mysqli_error($link));
                 while ($row_modpacks = mysqli_fetch_array($result_modpacks)) {
                        $modpack_id = $row_modpacks['modpack_id'];
                        $modpack_name=$row_modpacks['modpack_name'];

                        echo "<button type='button' class='button small_button app_badge' mdpk-id=$modpack_id>$modpack_name</button>";
                 } 
                 ?>
                        </main>
                    </div>

                    <div class="video_tags_map_wrap">
                        <input type="text" name="search_tag" placeholder="Search a tag" autocomplete="off">
                        <div class="video_tags_map">
                            <?php 
                                $get_videos_tags = "SELECT a.tag_id,b.tag_name from video_tags a, tags_list b WHERE a.tag_id NOT IN (0) and a.tag_id = b.tag_id GROUP BY b.tag_name ORDER BY b.tag_name ASC";
                                $result_tags=mysqli_query($link, $get_videos_tags);
                                while ($row_tags = mysqli_fetch_array($result_tags)) {
                                    $tag_id = $row_tags['tag_id'];
                                    $tag_name=$row_tags['tag_name'];
                                    echo "<button type='button' class='button small_button' name='tag'  tag-id=$tag_id>$tag_name</button>";
                                }
                            ?>
                        </div><!-- video_tags_map -->    
                    </div><!-- video_tags_map_wrap -->

                    <div class='videos_list' id='videos_list'>

                        <?php

                     //reparatio for paging
                     $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;


                    if(isset($_GET['view'])){
                      $view=$_GET['view'];
                      if($view=='see_later_videos'){
                        //echo "<script>alert('See laster videos')</script>";
                        $sql="SELECT * from videos where see_later=1";
                      } elseif ($view=="favorite_videos") {
                        //echo "<script>alert('favorite videos')</script>";
                        $sql="SELECT * from videos where is_favorite=1";
                      } else{
                        $sql="SELECT * from videos ORDER BY video_id DESC";    
                      }
                    } elseif(isset($_GET['mod_id'])){
                      $mod_id=$_GET['mod_id'];
                          $sql="SELECT * from videos a, videos_mods b  where b.cat_id=$mod_id and a.video_id = b.video_id ORDER BY a.video_id DESC"; 
                         //$sql="SELECT * from videos_mods where cat_id=$mod_id ORDER by video_id DESC";
                      } elseif (isset($_GET['search'])){
                      $search=$_GET['search'];
                      $sql="SELECT * from videos where video_title like '%".$search."%'";
                    } else {
                    $sql="SELECT * from videos ORDER BY video_id DESC LIMIT $itemsPerPage OFFSET $offset";
                    }
                                      
                    $result=mysqli_query($link, $sql) or die("MySQL ERROR: ".mysqli_error($link));
                        while ($row = mysqli_fetch_array($result)) {
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

                                        echo "<button name='add_note' title='add note' class='button app_badge open-button' video-id=$video_id><i class='fa fa-comment'></i></button><button name='delete_video' type='button' class='button app_badge' video-id='$video_id'><i class='fas fa-times'></i></button><button class='button app_badge video_edition'>$video_edition</button>";
                                       echo "</div>";//video actiom 
                                       echo "<div class='video_tags_wrap' video-id='$video_id'>";
                                          
                                          echo "<div class='videos_tags'>";
                                             echo GetVideoTagList($video_id);
                                          echo "</div>";
                                          
                                          echo "<button class='button small_button' name='new_tag' title='Add new tag(s)'><i class='fa fa-plus'></i></button>";
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

                    </div><!-- div videos list-->
                    <?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) as total FROM videos";
                $result=mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '"">' . $i . '</a>';
                      //echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
             ?>
                </div>
                <!--video wrap -->
            </div><!-- div list-->
        </div><!-- div content -->


        <dialog class="modal_video_tags">
            <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>
            <div class="video_tags"></div>
        </dialog>

        <dialog class="modal_new_tags">
            <div class="inner_layer">
                <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>
                <input type="text" name="tag_name" placeholder="tag name ...." autocomplete="off">
                <div class="video_tags_alphabet">
                    <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<button type='button' class='button small_button' name='letter'>$char</button>";
                        }
                        echo "<button type='button' class='button small_button' name='add_new_tag' title='Add new tag'><i class='fa fa-plus'></i></button>";
                     ?>
                </div>
                <div class="tags_list"><?php echo GetAllUnassignedVideosTags()?></div>
                <!-- <div class="loading" style="display: none;">Loading...</div> -->
            </div>
        </dialog>


        <dialog class="modal_notes">
            <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>
            <textarea name="video_comment" placeholder="type your comment here ...."></textarea>
            <div class="modal_notes_action"><button type="button" class="button small_button">Save</button></div>
        </dialog>

        <dialog class="modal_modpack">
            <div class='inner_modpack_layer'>
                <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>
                <input type="text" name="modpack_name" placeholder="name of the modpack ...." autocomplete="off">
            </div>
        </dialog>


        <!-- <dialog class="modal_new_tags">
           <div class="inner_tags_layer">
              <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button> 
              <div class="search_tag"><input type="text" autocomplete="off" spellcheck="off" placeholder="type modification name here..."></div>
              <div class="tag_map"><?php echo GetAllVideoTagPaginated() ?></div>
              <div class='tag_pagination'><?php echo GetTotalPagesVideosTags()  ?></div>
           </div>   
         </dialog> -->

        <div class="message hidden">
            <div class="message_text"></div>
        </div>
    </div>
</body>

<dialog class="modal_modpack_mods">
    <div class="inner_modpack_mods_layer">
        <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>
        <div class="video_mods_alphabet">
            <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<button type='button' class='button small_button' name='char'>$char</button>";
                        }
                        echo "<button type='button' class='button small_button' name='add_new_mod' title='Add new tag'><i class='fa fa-plus'></i></button>";
                     ?>
        </div>
        <div class='video_mods_list'>
            <?php
                    $get_mods = "SELECT * from mods WHERE LEFT(cat_name, 1) = 'A' ORDER BY cat_name ASC";
                    $result=mysqli_query($link, $get_mods);

                    while ($row = mysqli_fetch_array($result)) {                   
                        $mod_name = $row['cat_name'];
                        $mod_id = $row['cat_id']; 
                        echo "<button mod-id=$mod_id class='button small_button'>$mod_name</button>";

                    }

                ?>
        </div>
    </div>
</dialog>

<dialog class="modal_change_modpack">
    <div class='inner_change_modpack_layer'>
        <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>
        <div class='change_modpack_list'>
            <?php
                   $get_modpacks = "SELECT * from modpacks ORDER BY modpack_name ASC";
                    $result=mysqli_query($link, $get_modpacks);

                    while ($row = mysqli_fetch_array($result)) {                   
                        $modpack_name = $row['modpack_name'];
                        $modpack_id = $row['modpack_id']; 
                        echo "<button modpack-id=$modpack_id class='button small_button'>$modpack_name</button>";

                    }
                ?>
        </div>
</dialog>