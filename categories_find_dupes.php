<?php include "includes/dbconnect.php";

$get_dupes ="SELECT * FROM mods WHERE cat_name IN ( SELECT cat_name FROM mods GROUP BY cat_name HAVING COUNT(*) > 1)";

$result = mysqli_query($link,$get_dupes);
while ($row = mysqli_fetch_array($result)) {
    $cat_id = $row['cat_id'];
    $cat_name = $row['cat_name'];
                        
    echo "<div class='category'><div class='cat_name'>$cat_name</div><div class='cat_delete' data-id=$cat_id><i class='fas fa-times-circle'></i></div></div>";
}
?>
