<?php

include "includes/dbconnect.php";
include "includes/functions.php";
?>


<div id="new_influencer">
    <div class="influencer_top_bar">
        <button type="button" class="close_modal" title="hide"><i class="fa fa-times"></i></button>
    </div>

    <form action="influencer_save.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="modpack_id" value="<?php echo $_GET['modpack_id'] ?>">
        <input type="text" name="influencer_title" placeholder="influencer name" autocomplete="off"
               id="influencer_title" value="">
         <input type="text" name="influencer_url" autocomplete="off" title="Influencer url" placeholder="Influencer url" value="">

         <textarea name="influencer_description" placeholder="Influencer description"></textarea>

        <div class="new_influencer_submit_wrap">
            <button type="submit" name="add_new_influencer" class="button small_button">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </form>
</div>
