<?php 
include "includes/dbconnect.php";
include "includes/functions.php";

$modpack_id = $_GET['modpack_id'];

if (isset($_GET['modpack_id'])) { // mod is not empty
    $modpack_id = $_GET['modpack_id'];
    $get_mods = "SELECT mod_id FROM modpack_mods WHERE modpack_id = $modpack_id ORDER BY cat_name ASC";
}

$result = mysqli_query($link, $get_mods);

while ($row = mysqli_fetch_array($result)) {
    $cat_id = $row['cat_id'];
    $cat_name = $row['cat_name'];
    $cat_description = $row['cat_description'];
    
    echo "<div class='category' data-id='$cat_id'>";
    echo "<div class='cat_name'>$cat_name</div>";
    echo "<div class='cat_action'>";

    if ($cat_description == "") {
        echo "<div class='cat_description'><i class='fas fa-plus-circle'></i></div>";  
    }

    echo "<div class='cat_delete'><i class='fas fa-times-circle'></i></div>";
    echo "</div>"; // div class cat action
    echo "</div>"; // div class category
}
?>
