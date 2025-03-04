<?php
include "includes/dbconnect.php";
include "includes/functions.php";

$filter = $_GET['filter'];
if ($filter == "active") {
    $filter_modpacks = "SELECT * FROM modpacks WHERE is_active = 1 ORDER BY modpack_id DESC";
} elseif ($filter == "inactive") {
    $filter_modpacks = "SELECT * FROM modpacks WHERE is_active = 0 ORDER BY modpack_id DESC";
} elseif ($filter == "all") {
    $filter_modpacks = "SELECT * from modpacks where is_active=1 UNION ALL 
                SELECT * from modpacks where is_active=0";
}

$result = mysqli_query($link, $filter_modpacks) or die(mysqli_error($link));

while ($row = mysqli_fetch_array($result)) {
    $modpack_id = $row['modpack_id'];
    $modpack_name = $row['modpack_name'];
    $modpack_image = $row['modpack_image'];
    $is_active = $row['is_active'];

    echo "<div class='modpack_thumb' draggable='true'>
            <div class='modpack_thumb_pic'><img src='$modpack_image'></div>
            <div class='modpack_thumb_name'>$modpack_name</div>
            <div class='modpack_thumb_action'>
                <a href='modpack.php?modpack_id=$modpack_id' class='white_outlined_button'>Enter</a>
                <a href='modpack_edit.php?modpack_id=$modpack_id' class='white_outlined_button'>Edit</a>
                <button type='button' data-id='$modpack_id' class='white_outlined_button is_active" . ($is_active == 1 ? " active" : " inactive") . "'>" . ($is_active == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>") . "</button>
            </div>
          </div>";
}
?>
