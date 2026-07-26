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
    <title>Minecraft IS - Game sessions</title>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/sessions.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/sessions.js" defer></script>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  <body>
  <?php include("includes/header.php") ?>
      <div class="main_wrap">
        <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        <div class="content">

          <div class="list sessions_list_wrap">
            <button class="button small_button" name="modal_new_session" title="Add new session" onclick="document.getElementById('new_session').showModal()"><i class="fa fa-plus"></i></button>

            <div class="dashboard_header">Game sessions</div>

            <div class="tab_view_list_grid">
                <button type="button" name="cards" class="button small_button">Grid</button>
                <button type="button" name="list" class="button small_button">List</button>
            </div>

            <div class="sessions_list" id="sessions_list">
                <?php include "game_sessions_display_as_cards.php"; ?>
            </div><!-- sessions_list -->
          </div><!-- sessions_list_wrap -->

        </div><!-- content -->
      </div><!-- main_wrap -->

      <dialog id="new_session">
           <h3>Add new game session:</h3>
              <select name="session_modpack_id">
                  <option value="">-- Select modpack --</option>
                  <?php
                      $sql="SELECT modpack_id, modpack_name from modpacks WHERE is_active=1 ORDER BY modpack_name ASC";
                      $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                      while ($row = mysqli_fetch_array($result)){
                          echo "<option value='".$row['modpack_id']."'>".$row['modpack_name']."</option>";
                      }
                  ?>
              </select>
              <input type="text" name="session_seed" placeholder="Seed" autocomplete="off">
              <div class="action">
                 <button type="button" name="add_new_session" class="button pull-right"><i class="fa fa-plus"></i> Create</button>
                 <button type="button" name="move_back" class="button pull-right"><i class="fa fa-arrow-left"></i></button>
              </div>
       </dialog>
  </body>
</html>
