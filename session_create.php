<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $modpack_id = intval($_POST['modpack_id']);
    $seed = mysqli_real_escape_string($link, trim($_POST['seed']));

    if ($modpack_id <= 0 || $seed === "") {
        http_response_code(400);
        die("Please select a modpack and enter a seed.");
    }

    $sql="INSERT INTO game_sessions (modpack_id, seed, date_created) VALUES ($modpack_id, '$seed', now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    $session_id = mysqli_insert_id($link);

    $modpack_name = GetSessionModpackName($modpack_id);
    $diary_text="Minecraft IS: Bola vytvorena nova game session pre modpack <strong>$modpack_name</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo $session_id;
?>
