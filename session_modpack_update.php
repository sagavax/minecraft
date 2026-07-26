<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $session_id = intval($_POST['session_id']);
    $modpack_id = intval($_POST['modpack_id']);

    $sql="UPDATE game_sessions SET modpack_id=$modpack_id WHERE id=$session_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "ok";
?>
