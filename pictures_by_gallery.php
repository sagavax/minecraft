<?php

    include("includes/dbconnect.php");
    include("includes/functions.php");


    $gallery_id = $_GET['gallery_id'];

    $get_images = "SELECT a.picture_id, a.gallery_id, b.picture_path, b.picture_title, b.picture_description  FROM pictures_gallery_images a, pictures b WHERE a.gallery_id=$gallery_id and b.picture_id = a.picture_id";

    //echo $get_images;
    $result = mysqli_query($link, $get_images) or die("MySQLi ERROR: ".mysqli_error($link));
    
     while ($row = mysqli_fetch_array($result)) {
        print_r($row);
        $picture_id = $row['picture_id'];
        $picture_title = $row['picture_title'];
        $picture_description = $row['picture_description']; 
        $picture_path = htmlspecialchars($row['picture_path'], ENT_QUOTES, 'UTF-8');
        $modpack_name = GetImageModpack($picture_id);
        $image_gallery = GetImageGalleryName($picture_id);

        $picture_tags = GetImageTags($picture_id);

        echo "<div class='picture' image-id='{$picture_id}'>
                <div class='picture_name' placeholder='image name here...'>{$picture_title}</div>
                <div class='pic' image-id='{$picture_id}'>
                    <img src='{$picture_path}'>";
                if($image_gallery != "") {
                    echo "<button class='button small_button jade_button'>{$image_gallery}</butt0n>";
                }
        echo       "</div>
                <div class='picture_footer'>
                        <div class='picture_tags_main_view'>{$picture_tags}</div>
                        <div class='picture_action' image-id='{$picture_id}'>
                        
                        {$modpack_name}
                            <button name='add_comment' type='button' class='button small_button' title='Add new comment'>
                            <i class='fa fa-comment'></i>
                        </button>
                        <button name='view_image' type='button' class='button small_button' title='View image'>
                            <i class='fa fa-eye'></i>
                        </button>
                        <button name='delete_image' type='button' class='button small_button' title='Delete picture'>
                            <i class='fa fa-times'></i>
                        </button>
                    </div>
                </div>
            </div>";
    }
?>