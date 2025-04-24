<?php 
include "includes/dbconnect.php";
include "includes/functions.php";

$modpack_id = $_GET['modpack_id'];
?>

<h3><?php echo GetModPackName($modpack_id); ?> images</h3>

<!-- Upload Form -->
<div id="new_image">
    <form action="modpack_external_image" method="POST">
        <input type="hidden" name="modpack_id" value="<?php echo htmlspecialchars($modpack_id); ?>"> 

        <input 
            type="text" 
            name="image_name" 
            id="upload_local_image"
            placeholder="Add image title here..." 
            autocomplete="off">

        <input 
            type="text" 
            name="image_path" 
            id="upload_external_image" 
            placeholder="Add image URL here..." 
            autocomplete="off">

        <div class="image_action">
            <button type="submit" name="submit" class="button">Upload</button>
        </div>
    </form>
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
        $picture_id     = $row['picture_id'];
        $picture_title  = !empty($row['picture_title']) ? $row['picture_title'] : $row['picture_name'];
        $picture_path   = $row['picture_path'];

        echo "<div class='picture' image-id='$picture_id'>";
            echo "<div class='picture_name'>" . htmlspecialchars($picture_title) . "</div>";

            // Obrázok
            echo "<div class='pic' image-id='$picture_id'>";
                if (!empty(parse_url($picture_path, PHP_URL_SCHEME))) {
                    echo "<img src='" . htmlspecialchars($picture_path) . "' title='" . htmlspecialchars($picture_title) . "' loading='lazy'>";
                } else {
                    echo "<img src='gallery/" . htmlspecialchars($picture_path) . "' title='" . htmlspecialchars($picture_title) . "' loading='lazy'>";
                }
            echo "</div>"; // .pic

            // Footer s akciami
            echo "<div class='picture_footer'>";
                echo "<div class='picture_action' image-id='$picture_id'>";
                    echo GetImageModpack($picture_id);
                    echo "<button name='add_tag' type='button' class='button small_button' title='Add tag'><i class='fas fa-tag'></i></button>";
                    echo "<button name='add_comment' type='button' class='button small_button' title='Add new comment'><i class='fa fa-comment'></i></button>";
                    echo "<button name='view_image' type='button' class='button small_button' title='View image'><i class='fa fa-eye'></i></button>";
                    echo "<button name='delete_image' type='button' class='button small_button' title='Delete picture'><i class='fa fa-times'></i></button>";
                echo "</div>"; // .picture_action
            echo "</div>"; // .picture_footer
        echo "</div>"; // .picture
    }
    ?>
</div>

