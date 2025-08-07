<?php
include "includes/dbconnect.php";
include "includes/functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS influncers</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/message.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet'
        type='text/css'>
    <script defer src="js/influnencers.js?<?php echo time() ?>"></script>
     <script defer src="js/message.js?<?php echo time() ?>"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">

</head>
<body>
        <?php include("includes/header.php") ?>
         <div class="main_wrap">
        <div class="tab_menu">
            <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">
            <div class='list'>
                <div id="new_influencer">
                    <div class="influencer_top_bar">
                        <button type="button" class="close_modal" title="hide"><i class="fa fa-times"></i></button>
                    </div>

                    <form action="influencer_save.php" enctype="multipart/form-data" method="post">
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

                <div class="influencer_list">
                    <?php
                        //GetAllInfluencer();
                    ?>
                </div>
            </div><!-- list -->
         </div><!--content-->
        </div><!-- main_wrap-->   

    
</body>
</html>