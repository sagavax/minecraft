<?php
 session_start();

 ?>     
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <style>
    
            
  </style>
  </head>
  
  <body>
   <body>
    <?php include("includes/header.php");
    echo "<script>sessionStorage.setItem('current_module','tasks')</script>"; 
    ?>
    <div class="main_wrap">
      <div class="tab_menu">
        <?php include("includes/menu.php"); ?>
      </div>
      <div class="content">
        <div class='list'>
            <div id="minecraft_is_info_wrap">

            <h3>About the information system</h3>

            <p>The Minecraft Information System (MIS) is an innovative and comprehensive tool designed to enhance the gaming experience of Minecraft players. It serves as a digital library, meticulously curated with a wide array of resources including inspirational images, instructional videos, gameplay notes, and task lists.</p>

            <p>The MIS is divided into various sections, each dedicated to a specific type of content. The Image Gallery stores a collection of inspirational images that can spark creativity and aid in building impressive structures. The Video Archive is a repository of video tutorials showcasing different farm designs, redstone contraptions, and more, aimed at improving gameplay strategies.</p>

            <p>The Notes Section is a personal diary of the player’s Minecraft journey, capturing discoveries, ideas, and experiences in the game. The Task List is a dynamic to-do list that helps players keep track of their objectives, ensuring they never miss out on any in-game tasks or goals.</p>

            The system is equipped with a robust categorization and tagging system, making it easy for users to navigate through the vast amount of information. A powerful search functionality enables quick retrieval of data, saving valuable gaming time.
          </div>
        </div><!--list -->
        </div><!--content -->
     </div><!-- main wrap-->  


  </body> 
