<?php 
include "includes/dbconnect.php";
include "includes/functions.php";

$modpack_id = $_GET['modpack_id'];
?>


<!-- Upload Form -->
<div id="new_image">
   <input type="text" name="image_name" placeholder="Picture title" autocomplete="off">
    <input type="text" name="image_url" placeholder="Image URL" autocomplete="off" id="image_url">
    <textarea name="image_description" placeholder="Something about..."></textarea>
    <div class="action">
        <button type="button" name="add_new_ext_pic" class="button pull-right">
            <i class="fa fa-plus"></i>
        </button>
    </div>
</div>

<!-- Image List -->
<div class="image_list">
    <?php
    $dir = "gallery/";
    $itemsPerPage = 10;
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($current_page - 1) * $itemsPerPage;

    // Query obrázkov (POZOR: neprihliada na modpack_id!)
    //$get_modpack_images = "SELECT * FROM pictures a, pictures_modpacks b, modpacks c WHERE b.modpack_id = $modpack_id AND b.modpack_id = c.modpack_id";
    $get_modpack_images = "SELECT a.picture_id, a.picture_name, a.picture_title, a.picture_description, a.picture_path
    FROM pictures a
    JOIN pictures_modpacks b ON a.picture_id = b.image_id
    WHERE b.modpack_id = $modpack_id
    ORDER BY a.picture_id DESC";
    //echo $get_modpack_images;
    $result = mysqli_query($link, $get_modpack_images) or die("MySQLi ERROR: " . mysqli_error($link));

     while ($row = mysqli_fetch_array($result)) {
        $picture_id = $row['picture_id'];
        $picture_title = $row['picture_title'];
        $picture_description = $row['picture_description']; 
        $picture_path = htmlspecialchars($row['picture_path'], ENT_QUOTES, 'UTF-8');
        $modpack_name = GetImageModpack($picture_id);

        echo "<div class='picture' image-id='{$picture_id}'>
                <div class='picture_name' placeholder='image name here...'>{$picture_title}</div>
                <div class='pic' image-id='{$picture_id}'>
                    <img src='{$picture_path}'>
                </div>
                <div class='picture_footer'>
                        <div class='picture_action' image-id='{$picture_id}'>
                        {$modpack_name}
                        <button name='add_tag' type='button' class='button small_button' title='Add tag'>
                            <i class='fas fa-tag'></i>
                        </button>
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
</div>

