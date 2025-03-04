<?php

    include("includes/dbconnect.php");

    $modpack_name = mysqli_real_escape_string($link, $_GET['modpack']);

    $check_modpack = "SELECT count(*) as nr_modpacks from modpacks WHERE modpack_name='$modpack_name'";
    $result = mysqli_query($link, $check_modpack) or die(mysqli_error($link));
    $row = mysqli_fetch_array($result);
    $nr_modpacks = $row['nr_modpacks'];

    echo $nr_modpacks;
