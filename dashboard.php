<?php 
      session_start();
     
      include "includes/dbconnect.php";
      include "includes/functions.php";

  ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <script src="js/dashboard.js" defer></script>
    <script src="js/timer.js" defer></script>
    <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
  <?php
    echo "<script>sessionStorage.setItem('current_module','dashboard')</script>";
      include("includes/header.php") ?>
          <!-- <div class="main_wrap"> -->
            <div class="content">            
              <div class="dashboard_wrap">
                  <div class="dashboard">  
                      <div class="dashboard_header">Choose where you want to go:</div>
                          <div class="tile_list">
                          <div class="tile" tile-id='notes'><div class='tile_title'><i class="fa fa-sticky-note"></i>Notes</div><div class="tile_info"><span><?php echo GetCountNotes() ?> notes, <?php echo GetCountNewestNotes(); ?> the newest </span></div></div>
                          <div class="tile" tile-id='tasks'><div class='tile_title'><i class="fa fa-tasks"></i>Tasks</div><div class="tile_info"><span><?php echo GetCountTasks()?> tasks, <?php echo GetCountNewestTasks(); ?> the newest</span></div></div>
                          <div class="tile" tile-id='modpacks';><div class='tile_title'><i class="fa fa-cubes"></i>Modpacks</div><div class="tile_info"><span><?php echo GetCountModpacks(); ?> modpacks, <?php echo GetCountActiveModpacks() ?> are active, <?php echo GetCountInactiveModpacks() ?> are inactive</span></div></div>
                          <div class="tile" tile-id='mods';><div class='tile_title'><i class="fa fa-puzzle-piece"></i>Mods</div><div class="tile_info"><span><?php echo GetCountMods(); ?> mods</div></div>
                          <div class="tile" tile-id='tags';><div class='tile_title'><i class="fa fa-tags"></i>Tags</div><div class="tile_info"><span><?php echo GetCountTags(); ?> tags</div></div>
                          <div class="tile" tile-id='videos'><div class='tile_title'><i class="fa fa-video-camera"></i>Videos</div><div class="tile_info"><span><?php echo GetCountVideos();?> videos, <?php echo GetCountNewestVideos(); ?> the newest</span></div></div>
                          <div class="tile" tile-id='gallery'><div class='tile_title'><i class="fa fa-image"></i>Gallery</div><div class="tile_info"><span><?php echo GetCountImages(); ?> images</span></div></div>
                          <div class="tile" tile-id='influencers'><div class='tile_title'><i class="fa fa-user"></i>Influencers</div><div class="tile_info"><span><?php //echo GetCountInfluencers(); ?> influencers</span></div></div>
                          <div class="tile"  tile-id='vanilla'><div class='tile_title'><i class="fa fa-cube"></i>Vanilla</div><div class="tile_info"><span><?php echo GetCountBases()." bases ,".GetCountVanilaVideos()." videos,".GetCountVanilaNotes()." notes"; ?></span></div></div>
                          <div class="tile" tile-id='admin'><div class='tile_title'><i class="fa fa-cog"></i>Administration</div><div class="tile_info">Ideas, bugs, logs, maintenance, settings<span></span></div></div>
                        </div><!-- tile list -->
                      
                                  
                    </div><!-- dashboard -->  
                </div><!-- dashboard wrap --> 
              </div><!-- content -->
            <!-- </div> --><!-- main wrap -->
     
  </body> 