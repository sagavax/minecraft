<?php 
    include("includes/dbconnect.php");
    include("includes/functions.php");
?>

<!-- <div class='modlist_mods_title'>
    <h3><?php echo "Videos for the modpack " . GetModPackName($_GET['modpack_id']); ?></h3>
</div>
 -->
<div id="new_video">
    <div class="video_top_bar">
        <button type="button" class="close_modal" title="hide"><i class="fa fa-times"></i></button>
    </div>

    <form action="videos_save.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="modpack_id" value="<?php echo $_GET['modpack_id'] ?>">
        <input type="text" name="video_title" placeholder="Video title" autocomplete="off"
               id="video_title" readonly value="">
         <input type="text" name="video_url" autocomplete="off" title="Video url" placeholder="Video url" value="">

        <select name="category">
            <option value="0">-- Select modification --</option>
            <?php
                $sql = "SELECT * FROM mods ORDER BY cat_name ASC";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $cat_id = $row['cat_id'];
                    $cat_name = $row['cat_name'];
                    echo "<option value='$cat_id'>$cat_name</option>";
                }
            ?>
        </select>

        <div class="new_video_submit_wrap">
            <button type="submit" name="add_new_video" class="button pull-right">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </form>
</div>

<div class="search_wrap">
    <input type="text" name="search" placeholder="search videos..." autocomplete="off">
</div>

<div class="videos_list">
    <?php 
        $modpack_id = $_GET['modpack_id'];
        $get_modpack_videos = "
            SELECT * FROM videos a 
            JOIN videos_modpacks b ON a.video_id = b.video_id 
            WHERE b.modpack_id = $modpack_id 
            ORDER BY a.video_id DESC
        ";
        $result = mysqli_query($link, $get_modpack_videos);

        while ($row = mysqli_fetch_array($result)) {
            $video_id = $row['video_id'];
            $video_name = $row['video_title'];
            $video_url = $row['video_url'];
            //$mod_id = $row['cat_id'];
            $is_favorite = $row['is_favorite'];
            $see_later = $row['watch_later'];
            $video_thumb = $row['video_thumbnail'];

            echo "<div class='video' video-id='$video_id'>";
                echo "<div class='video_thunb'><img src='$video_thumb'></div>";
                echo "<div class='video_list_details'>";
                    echo "<div class='video_name'><span>$video_name</span></div>";
                    echo "<div class='video_action'>";

                        echo $see_later == 0 
                            ? "<button name='watch_later' title='Watch later' class='button app_badge' video-id='$video_id'><i class='far fa-clock'></i></button>" 
                            : "<button name='remove_watch_later' title='Remove Watch later' class='button app_badge' video-id='$video_id'><i class='fas fa-clock'></i></button>";

                        echo $is_favorite == 0 
                            ? "<button name='add_to_favorites' title='Add to favorites' class='button small_button app_badge' video-id='$video_id'><i class='far fa-star'></i></button>" 
                            : "<button name='remove_from_favorites' title='Remove from favorites' class='button app_badge' video-id='$video_id'><i class='fas fa-star'></i></button>";

                        echo "<button name='add_note' title='Add note' class='button app_badge open-button' video-id='$video_id'><i class='fa fa-comment'></i></button>";
                        echo "<button name='edit_video' title='Edit video' class='button app_badge' video-id='$video_id'><i class='far fa-edit'></i></button>";
                        echo "<button name='delete_video' title='Delete video' class='button app_badge' video-id='$video_id'><i class='fas fa-times'></i></button>";

                    echo "</div>"; // video_action

                    echo "<div class='videos_tags' video-id='$video_id'>";
                        echo GetVideoTagList($video_id);
                        echo "<button class='button small_button' name='new_tag' video-id='$video_id' title='Add new tag(s)'><i class='fa fa-plus'></i></button>";
                    echo "</div>";

                    echo "<div class='video_modpack_information_wrap'>";
                        echo "<div class='video_modpack_info'>" . GetVideoModpack($video_id) . 
                             "<button class='button blue_button' name='change_modpack' title='Change modpack'><i class='fa fa-edit'></i></button></div>";
                        echo "<div class='video_mods'>" . GetVideoMods($video_id) . 
                             "<button class='button blue_button' name='add_mod' title='Add mod(s)'><i class='fa fa-plus'></i></button></div>";
                    echo "</div>";
                echo "</div>"; // video_list_details

                echo "<div class='video_banner_list'></div>";
                echo "<div class='video_action_play'>";
                    echo "<div class='video_play_button'>";
                        echo "<div><a href='video.php?video_id=$video_id'><i class='fas fa-play'></i></a></div>";
                    echo "</div>";
                echo "</div>";

            echo "</div>"; // video
        }
    ?>
</div>

<!-- Dialogs -->
<dialog class="modal">
    <div class="inner_layer">
        <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>
        <input type="text" name="tag_name" placeholder="tag name ...." autocomplete="off">
        <ul></ul>
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
        <div class="search_tag">
            <input type="text" autocomplete="off" spellcheck="off" placeholder="type modification name here...">
        </div>
        <div class="tag_map"><?php echo GetAllVideoTagPaginated(); ?></div>
        <div class='pagination'><?php echo GetTotalPagesVideosTags(); ?></div>
    </div>
</dialog>
