<?php
    include_once "includes/dbconnect.php";
    include_once "includes/functions.php";

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
