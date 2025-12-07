<?php
include "includes/dbconnect.php";
include "includes/functions.php";

//show all modapacks

    echo "<div class='show_as_list'>";
     $get_modpacks="SELECT * from modpacks where is_active=1 and modpack_id not in (1) UNION ALL 
                SELECT * from modpacks where is_active=0";
                $result=mysqli_query($link, $get_modpacks) or die(mysqli_error($link));
                while (
                    $row = mysqli_fetch_array($result)){
                        $modpack_id=$row['modpack_id'];
                        $modpack_name=$row['modpack_name'];
                        $modpack_image=$row['modpack_image'];
                        $is_active = $row['is_active'];

                       echo "<div class='modpack_list_item'>
                        <div class='modpack_thumb_pic'><img src='" . $modpack_image . "'></div>
                        <div class='modpack_list_item_details_wrap'>
                            <div class='modpack_thumb_name'>$modpack_name</div>
                               <div class='modpack_list_item_action_wrap'>
                                    <div class='modpack_list_description' title='Description'><div class='list_item_action_title'>Description</div><div class='list_item_action_logo'><i class='fa-solid fa-pen-to-square'></i></div></div>
                                    <div class='modpack_list_seeds' title='Seeds'><div class='list_item_action_title'>Seed</div><div class='list_item_action_logo'><i class='fa-solid fa-seedling'></i></div></div>
                                    <div class='modpack_list_images' title='Images'><div class='list_item_action_title'>Images</div><div class='list_item_action_logo'><i class='fa-regular fa-image'></i></div></div>
                                    <div class='modpack_list_bases' title='Bases'><div class='list_item_action_title'>Bases</div><div class='list_item_action_logo'><i class='fa-solid fa-house'></i></div></div>
                                    <div class='modpack_list_mods' title='Mods'><div class='list_item_action_title'>Mods</div><div class='list_item_action_logo'><i class='fa-solid fa-gear'></i></div></div>
                                    <div class='modpack_list_notes' title='Notes'><div class='list_item_action_title'>Notes</div><div class='list_item_action_logo'><i class='fa-solid fa-pen'></i></div></div>
                                    <div class='modpack_list_tasks' title='Tasks'><div class='list_item_action_title'>Tasks</div><div class='list_item_action_logo'><i class='fa-solid fa-list-check'></i></div></div>
                                    <div class='modpack_list_videos' title='Videos'><div class='list_item_action_title'>Videos</div><div class='list_item_action_logo'><i class='fa-solid fa-video'></i></div></div>
                                </diiv>
                            </div>
                        </div> 
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