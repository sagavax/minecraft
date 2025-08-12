<?php 

    include("includes/dbconnect.php");
    include("includes/functions.php");

    $influencer_id = $_POST['influencer_id'];
    $modpack_id = $_POST['modpack_id'];
    $modpck_name = mysqli_real_escape_string($link, $_POST['modpack_name']);

    $add_modpack = "INSERT INTO influncer_modpacks (influencer_id, modpack_id, added_date) VALUES ($influencer_id, $modpack_id, now())";
    $result=mysqli_query($link, $add_modpack) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to log
    $diary_text="Bol pridany modpack <strong>".$modpck_name."</strong> k influenceru <strong>".GetInfluencerName($influencer_id)."</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
