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
    <script defer src="js/influencers.js?<?php echo time() ?>"></script>
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
                <h4>Add new minecraft influencer</h4>
                <div id="new_influencer">
                     <form action="influencer_save.php" enctype="multipart/form-data" method="post">
                         <input type="text" name="influencer_name" placeholder="influencer name" autocomplete="off"
                       value="">
                        <input type="text" name="influencer_url" autocomplete="off" title="Influencer url" placeholder="Influencer url" value="">

                        <textarea name="influencer_description" placeholder="Influencer description"></textarea>

                        <input type="text" name="influencer_image" autocomplete="off" title="Influencer image" placeholder="Influencer image" value="">

                        <div class="new_influencer_submit_wrap">
                            <button type="submit" name="add_new_influencer" class="button small_button">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="influencer_list">
                    <?php
                        GetAllInfluencers();
                        echo "<div class='influencer_modpacks'></div>"; //influencer_modpacks
                    ?>
                </div>
            </div><!-- list -->
         </div><!--content-->
        </div><!-- main_wrap-->   
        
         <dialog class="modal_change_modpack">
             <div class='inner_change_modpack_layer'>
                <button type="button" class='close_inner_modal'><i class='fa fa-times'></i></button>  
                <div class='change_modpack_list'>
                <?php
                   $get_modpacks = "SELECT * from modpacks ORDER BY modpack_name ASC";
                    $result=mysqli_query($link, $get_modpacks);

                    while ($row = mysqli_fetch_array($result)) {                   
                        $modpack_name = $row['modpack_name'];
                        $modpack_id = $row['modpack_id']; 
                        echo "<button modpack-id=$modpack_id class='button small_button' name='add_modpack'>$modpack_name</button>";
                        }
                ?>
              </div>
         </dialog>
</body>
</html>