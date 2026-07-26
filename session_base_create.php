<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $session_id = intval($_POST['session_id']);
    $coord_x = mysqli_real_escape_string($link, $_POST['coord_x']);
    $coord_y = mysqli_real_escape_string($link, $_POST['coord_y']);
    $coord_z = mysqli_real_escape_string($link, $_POST['coord_z']);

    $base_name = GetNextSessionBaseName($session_id);

    $sql="INSERT INTO game_sessions_bases (session_id, base_name, coord_x, coord_y, coord_z, created_at) VALUES ($session_id, '$base_name', '$coord_x', '$coord_y', '$coord_z', now())";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    $base_id = mysqli_insert_id($link);

    echo json_encode(["base_id" => $base_id, "base_name" => $base_name]);
?>
