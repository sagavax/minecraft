<?php
    include("includes/dbconnect.php");

    $search_modpack = mysqli_real_escape_string($link, $_GET['search']);

    $search_modpack = "SELECT * from modpacks WHERE modpack_name LIKE '%$search_modpack%'";
    mysqli_query($link, $search_modpack) or die(mysqli_error($link));

    $result=mysqli_query($link, $search_modpack);
    while (
        $row = mysqli_fetch_array($result)){
            $modpack_id=$row['modpack_id'];
            $modpack_name=$row['modpack_name'];
            $modpack_image=$row['modpack_image'];
            $is_active = $row['is_active'];

            echo "<div class='modpack_thumb' draggable='true'>
                <div class='modpack_thumb_pic'><img src='".$modpack_image."'></div>
                <div class='modpack_thumb_name'>$modpack_name</div>
                <div class='modpack_thumb_action'>
                  <a href='modpack.php?modpack_id=$modpack_id' class='white_outlined_button'>Enter</a>
                   <a href='modpack_edit.php?modpack_id=$modpack_id' class='white_outlined_button'>Edit</a>";
                      ?>
                   <button type="button" data-id="<?php echo $modpack_id ?>" class="white_outlined_button is_active<?php echo $is_active==1 ? ' active' : ' inactive' ?>"><?php echo $is_active==1 ?  "<i class='fa fa-check'></i>" :  "<i class='fa fa-times'></i>" ?></button>
                    
           </div>
               
            </div>
          <?php
        }
    
?>