<?php
      session_start();

      include "includes/dbconnect.php";
      include "includes/functions.php";

      $session_id = intval($_GET['session_id']);

      $sql="SELECT * from game_sessions where id=$session_id";
      $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
      $session = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS - Game session</title>
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
          <div class="session" session-id="<?php echo $session_id; ?>">

            <div id="basic_session_info">
                <select name="session_modpack_id">
                    <option value="">-- Select modpack --</option>
                    <?php
                        $sql="SELECT modpack_id, modpack_name from modpacks WHERE is_active=1 ORDER BY modpack_name ASC";
                        $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                        while ($row = mysqli_fetch_array($result)){
                            $selected = ($row['modpack_id'] == $session['modpack_id']) ? " selected" : "";
                            echo "<option value='".$row['modpack_id']."'".$selected.">".$row['modpack_name']."</option>";
                        }
                    ?>
                </select>
                <input name="session_seed" type="text" placeholder="Seed" value="<?php echo $session['seed']; ?>" autocomplete="off">
                <div class="session_date_created">Created: <?php echo $session['date_created']; ?></div>
                <div class="session_action"><a class="button small_button" href="game_sessions.php">Back</a></div>
            </div><!-- basic_session_info -->

            <div class="session_wall">
                <div class="session_wall_tabs">
                    <button data-tab="Notes" class="button small_button">Notes</button>
                    <button data-tab="Tasks" class="button small_button">Tasks</button>
                    <button data-tab="Bases" class="button small_button">Bases</button>
                </div><!-- session_wall_tabs -->

                <div id="notes">
                    <div class="new_session_note">
                        <input type="text" id="session_note_header" value="" autocomplete="off" spellcheck="false" placeholder="note title...">
                        <textarea id="session_note_text" placeholder="note text..."></textarea>
                        <button class="button rounded_button" name="new_session_note">New note</button>
                    </div>
                    <div class="session_notes_list">
                        <?php
                            $sql="SELECT * from game_session_notes WHERE session_id=$session_id ORDER BY id DESC";
                            $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

                            if(mysqli_num_rows($result)==0){
                                echo "<div class='info_message'>No notes available....</div>";
                            } else {
                                while($row = mysqli_fetch_array($result)){
                                    $note_id = $row['id'];
                                    $note_header = $row['note_header'];
                                    $note_text = $row['note_text'];

                                    echo "<div class='session_note' note-id='$note_id'>";
                                        echo "<div class='session_note_header'>".$note_header."</div>";
                                        echo "<div class='session_note_text'>".$note_text."</div>";
                                        echo "<div class='session_note_act'><button class='button small_button' name='remove_note' type='button'><i class='fa fa-times' title='Delete note'></i></button></div>";
                                    echo "</div>";
                                }
                            }
                        ?>
                    </div><!-- session_notes_list -->
                </div><!-- notes -->

                <div id="tasks">
                    <div class="new_session_task">
                        <textarea id="session_task_text" placeholder="task text..."></textarea>
                        <select id="session_task_priorita">
                            <option value="low">Low</option>
                            <option value="normal" selected>Normal</option>
                            <option value="high">High</option>
                        </select>
                        <button class="button rounded_button" name="new_session_task">New task</button>
                    </div>
                    <div class="session_tasks_list">
                        <?php
                            $sql="SELECT * from game_session_tasks where session_id=$session_id ORDER BY task_id DESC";
                            $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                            if(mysqli_num_rows($result)==0){
                                echo "<div class='info_message'>No tasks available....</div>";
                            } else {
                                while($row = mysqli_fetch_array($result)){
                                    $task_id = $row['task_id'];
                                    $task_text = $row['task_text'];
                                    $priorita = $row['priorita'];
                                    $status = $row['status'];
                                    $task_text = preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $task_text);

                                    echo "<div class='session_task priorita_$priorita' task-id='$task_id'>";
                                        echo "<div class='task_body'>$task_text</div>";
                                        echo "<div class='task_footer'>";
                                            echo "<div class='task_priorita'>$priorita</div>";
                                            echo "<div class='task_action'>";
                                                if($status=='done'){
                                                    echo "<span class='span_task_completed'>done</span>";
                                                } else {
                                                    echo "<button type='button' name='complete_task' class='button small_button pull-right' title='Mark as done'><i class='fa fa-check'></i></button>";
                                                }
                                                echo "<button type='button' name='remove_task' class='button small_button pull-right' title='Delete task'><i class='fa fa-times'></i></button>";
                                            echo "</div>";
                                        echo "</div>"; //task_footer
                                    echo "</div>"; //session_task
                                }
                            }
                        ?>
                    </div><!-- session_tasks_list -->
                </div><!-- tasks -->

                <div id="bases">
                    <div class="new_session_base">
                        <input type="text" id="session_base_coord_x" placeholder="X" autocomplete="off">
                        <input type="text" id="session_base_coord_y" placeholder="Y" autocomplete="off">
                        <input type="text" id="session_base_coord_z" placeholder="Z" autocomplete="off">
                        <button class="button rounded_button" name="new_session_base">New base</button>
                    </div>
                    <div class="session_bases_list">
                        <?php
                            $sql="SELECT * from game_sessions_bases where session_id=$session_id ORDER BY base_id DESC";
                            $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                            if(mysqli_num_rows($result)==0){
                                echo "<div class='info_message'>No bases available....</div>";
                            } else {
                                while($row = mysqli_fetch_array($result)){
                                    $base_id = $row['base_id'];
                                    $base_name = $row['base_name'];
                                    $x = $row['coord_x'];
                                    $y = $row['coord_y'];
                                    $z = $row['coord_z'];

                                    echo "<div class='session_base' base-id='$base_id'>";
                                        echo "<div class='session_base_name'>$base_name</div>";
                                        echo "<div class='base_coord_card'><div class='coord tooltip' title='X'>$x</div><div class='coord tooltip' title='Y'>$y</div><div class='coord tooltip' title='Z'>$z</div></div>";
                                        echo "<div class='session_base_act'><button class='button small_button' name='remove_base' type='button'><i class='fa fa-times' title='Delete base'></i></button></div>";
                                    echo "</div>"; //session_base
                                }
                            }
                        ?>
                    </div><!-- session_bases_list -->
                </div><!-- bases -->

            </div><!-- session_wall -->

          </div><!-- session -->
        </div><!-- content -->
      </div><!-- main_wrap -->
  </body>
</html>
