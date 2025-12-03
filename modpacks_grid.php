<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    echo "<div class='show_as_grid'>";
     $get_modpacks="SELECT * from modpacks where is_active=1 and modpack_id not in (1) UNION ALL 
                SELECT * from modpacks where is_active=0";
                $result=mysqli_query($link, $get_modpacks) or die(mysqli_error($link));
                while (
                    $row = mysqli_fetch_array($result)){
                        $modpack_id=$row['modpack_id'];
                        $modpack_name=$row['modpack_name'];
                        $modpack_image=$row['modpack_image'];
                        $is_active = $row['is_active'];

                       echo "<div class='modpack_thumb'>
                        <div class='modpack_thumb_pic'><img src='" . $modpack_image . "'></div>
                        <div class='modpack_thumb_name'>$modpack_name</div>
                        <div class='modpack_thumb_action'>
                            <button type='button' name='enter_modpack' class='white_outlined_button' data-id='$modpack_id'>Enter</button>
                            <button type='button' name='modpack_status' data-id='$modpack_id' class='white_outlined_button is_active" . ($is_active == 1 ? ' active' : ' inactive') . "'>" .
                                ($is_active == 1 ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>") .
                            "</button>
                        </div>
                    </div>";
                    }
    echo "</div>";//show_as_grid                

    ?>