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

          <div class="sessions_list_wrap">
            <button class="button small_button" name="modal_new_session" title="Add new session" onclick="document.getElementById('new_session').showModal()"><i class="fa fa-plus"></i></button>

            <div class="dashboard_header">Game sessions</div>

            <div class="sessions_list">
                <?php
                    $sql="SELECT * from game_sessions ORDER BY id DESC";
                    $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

                    if(mysqli_num_rows($result)==0){
                        echo "<div class='info_message'>No game sessions found. Would you like to create a new one?</div>";
                    } else {
                        while ($row = mysqli_fetch_array($result)){
                            $session_id = $row['id'];
                            $modpack_id = $row['modpack_id'];
                            $seed = $row['seed'];
                            $date_created = $row['date_created'];
                            $modpack_name = GetSessionModpackName($modpack_id);

                            echo "<div class='session_card' session-id='$session_id'>";
                                echo "<div class='session_modpack_name'>$modpack_name</div>";
                                echo "<div class='session_seed'><span class='tooltip' title='Seed'>$seed</span></div>";
                                echo "<div class='session_date_created'>".$date_created."</div>";

                                echo "<div class='session_basic_info'>";
                                    echo "<div class='session_nr_notes' title='Notes'><i class='fa fa-sticky-note'></i> ".GetCountSessionNotes($session_id)."</div>";
                                    echo "<div class='session_nr_tasks' title='Tasks'><i class='fa fa-list-check'></i> ".GetCountSessionTasks($session_id)."</div>";
                                echo "</div>"; //session_basic_info

                                echo "<div class='session_actions_card'>";
                                    echo "<button type='button' class='button small_button' name='view_session' title='View session details'><i class='fas fa-eye'></i></button>";
                                    echo "<button type='button' class='button small_button' name='delete_session' title='Delete session'><i class='fas fa-times'></i></button>";
                                echo "</div>"; //session_actions_card
                            echo "</div>"; //session_card
                        }
                    }
                ?>
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
                 <button type="button" name="add_new_session" class="button pull-right"><i class="fa fa-plus"></i></button>
                 <button type="button" name="move_back" class="button pull-right"><i class="fa fa-arrow-left"></i></button>
              </div>
       </dialog>
  </body>
</html>
