<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";


    $get_latest_note = "SELECT * FROM notes ORDER BY note_id DESC LIMIT 1";
    $result = mysqli_query($link, $get_latest_note) or die("MySQLi ERROR: " . mysqli_error($link));

    while ($row = mysqli_fetch_array($result)) {
        $last_note = $row['note_id'];
    }

    echo $last_note;