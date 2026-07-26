<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    $session_id = intval($_POST['session_id']);
    $seed = mysqli_real_escape_string($link, $_POST['seed']);

    $sql="UPDATE game_sessions SET seed='$seed' WHERE id=$session_id";
    mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "ok";
?>
