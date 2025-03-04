<?php include "includes/dbconnect.php";
      include "includes/functions.php";

    error_reporting(E_ERROR | E_PARSE);
  
           if(isset($_POST['add_new_video'])){
          //var_dump($_POST);
          $video_name=mysqli_real_escape_string($link, $_POST['video_title']);
          $video_url=mysqli_real_escape_string($link, $_POST['video_url']);
          $mod_id=mysqli_real_escape_string($link, $_POST['category']);
          $modpack=99;
          $video_source = mysqli_real_escape_string($link, $_POST['video_source']);
          $mod_id = 0;
          $video_id_th = getYouTubeVideoId($video_url);
          $video_thumb = "https://img.youtube.com/vi/".$video_id_th."/0.jpg";



          $sql="INSERT INTO videos (video_title,video_url,cat_id,video_thumbnail ,modpack_id,video_source,added_date) VALUES ('$video_name','$video_url',$mod_id,'$video_thumb',$modpack,'$video_source',now())";
          //echo "<div>$sql</div>";
          $result=mysqli_query($link, $sql);

              
        $diary_text="Minecraft IS: Bolo pridane nove video s nazvom <strong>$video_name</strong>";
        $add_to_diary="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $add_to_diary) or die("MySQLi ERROR: ".mysqli_error($link));
        

        echo "<script>alert('Video s nazvom $video_name bolo pridane');
        /window.location.href='videos.php';
        </script>";

      }
        
?>      
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <!--<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">   
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="https://use.fontawesome.com/be937f19da.js"></script>
    <script defer src="./js/videos.js"></script>
    <script defer src="./js/videos_action.js"></script>
    <script defer src="./js/video_get_yt_name.js"></script>

  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>

  <body>
  <?php include("includes/header.php") ?>   
      <div class="main_wrap">
      <div class="tab_menu">
                <?php include("includes/vanila_menu.php") ?>
      </div>
        <div class="content">
          <div class='list'>
            <div id="new_video">
             <form action="" enctype="multipart/form-data" method="post">    
                  <input type="text" name="video_title" placeholder='Video title' autocomplete=off id="video_title">
                  <input type="text" name="video_url" placeholder='Video url' id="video_url"  autocomplete=off id="video_url">
                 <!--<textarea name="video_url" placeholder='video url'></textarea>-->
                    <select name="video_source">
                        <option value="Youtube">YouTube</option>
                        <option value="Tiktok">Tiktok</option>
                     </select>
                      
                  
                  <div class="new_video_submit_wrap"><button type="submit" name="add_new_video" class="button pull-right"><i class="fa fa-plus"></i></button></div>
                            
               </form> 

            </div><!-- new video -->

            <div class="search_wrap">
                <input type="text" name="search" onkeyup="search_the_video(this.value);" id="search_string" autocomplete="off" placeholder="search videos here">
                <button type="button" title="clear search" class="button small_button clear_button tooltip>"><i class="fa fa-times"></i></button>
            </div><!-- Search wrap-->
 
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
                        $sql="SELECT * from videos where see_later=1 and modpack_id=99";
                      } elseif ($view=="favorite_videos") {
                        //echo "<script>alert('favorite videos')</script>";
                        $sql="SELECT * from videos where is_favorite=1  and modpack_id=99";
                      } else{
                        $sql="SELECT * from videos ORDER BY video_id  and modpack_id=99 DESC";    
                      }
                    } elseif(isset($_GET['mod_id'])){
                      $mod_id=$_GET['mod_id'];
                         $sql="SELECT * from videos where cat_id=$mod_id ORDER by video_id DESC";
                      } elseif (isset($_GET['search'])){
                      $search=$_GET['search'];
                      $sql="SELECT * from videos where video_title like '%".$search."%'";
                    } else {
                    $sql="SELECT * from videos WHERE modpack_id=99 ORDER BY video_id DESC LIMIT $itemsPerPage OFFSET $offset";
                    }
                                      
                        $result=mysqli_query($link, $sql);
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
                    echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
             ?> 
            </div><!-- div list-->    
        </div><!-- div content -->
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

         <div class="message hidden">
           <div class="message_text"></div>
         </div>
        </div>
      </body>  