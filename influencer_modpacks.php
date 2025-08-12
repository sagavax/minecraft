<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";
    
    $influencer_id = $_POST['influencer-id'];

    $influencer_name = GetInfluencerName($influencer_id);    

    echo "<div class='infl_modpacks_header'>";
        echo "<h4>List of modpacks for influencer: $influencer_name</h4>";
    echo "</div>";    



    echo "<div class='infl_modpacks_list'>";
    $get_influencer_modpacks = "SELECT a.modpack_id, a.influencer_id, b.modpack_id, b.modpack_name, b.modpack_image  from influncer_modpacks a, modpacks b  WHERE a.influencer_id = $influencer_id and a.modpack_id = b.modpack_id";
    $result = mysqli_query($link, $get_influencer_modpacks) or die(mysqli_error($link));
    if(mysqli_num_rows($result) == 0) {
        echo "<div class='no_modpacks_found'>No modpacks found/ Would u like to add some? <button type='button' name='add_modpack' class='button small_button' title='Add to gallery'><i class='fa fa-plus'></i></button></div>";
    } else {
        while($row = mysqli_fetch_array($result)) {
        echo "<div class='infl_modpack' modpack_id='".$row['modpack_id']."'>";
            echo "<div class='infl_modpack_image'><img src='".htmlspecialchars($row['modpack_image'], ENT_QUOTES)."'></div>";
            echo "<div class='infl_modpack_name'>".$row['modpack_name']."</div>";
            echo "<div class='infl_modpack_action'>";
                echo "<a href='modpack.php?modpack_id=".$row['modpack_id']."' class='button small_button'>Open modpack</a>";
            echo "</div>";
        echo "</div>";
       }    

       echo "<div class='infl_modpack_add'><button type='button' name='add_modpack' class='button small_button' title='Add modpack to influencer'><i class='fa fa-plus'></i></button></div>";
    }

    echo "</div>";//infl_modpacks_list