<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $base_id = intval($_POST['base_id']);

    $sql="DELETE FROM game_sessions_bases WHERE base_id=$base_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "ok";
?>
