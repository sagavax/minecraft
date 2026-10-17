<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $modpack_id = intval($_POST['modpack_id']);
    $seed = mysqli_real_escape_string($link, $_POST['seed']);
    $spawn_x = isset($_POST['spawn_x']) && $_POST['spawn_x'] !== '' ? intval($_POST['spawn_x']) : "NULL";
    $spawn_y = isset($_POST['spawn_y']) && $_POST['spawn_y'] !== '' ? intval($_POST['spawn_y']) : "NULL";
    $spawn_z = isset($_POST['spawn_z']) && $_POST['spawn_z'] !== '' ? intval($_POST['spawn_z']) : "NULL";

    $sql="INSERT INTO game_sessions (modpack_id, seed, session_spavn_x, session_spavn_y, session_spavn_z, date_created)
          VALUES ($modpack_id, '$seed', $spawn_x, $spawn_y, $spawn_z, now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    $session_id = mysqli_insert_id($link);

    $modpack_name = GetSessionModpackName($modpack_id);
    $diary_text="Minecraft IS: Bola vytvorena nova game session pre modpack <strong>$modpack_name</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo $session_id;
?>
