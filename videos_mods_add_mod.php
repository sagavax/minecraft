<?php
       include("includes/dbconnect.php");
       include("includes/functions.php");

       $modId = $_POST['modId'];
       $videoId = $_POST['videoId'];

       $add_mod_to_video = "INSERT INTO videos_mods (video_id, cat_id) VALUES ($videoId, $modId)";
       $result=mysqli_query($link, $add_mod_to_video) or die("MySQLi ERROR: ".mysqli_error($link));

        //add to diary
        $diary_text="Minecraft IS: Bolo pridane mod <strong>".GetModName($modId)."</strong> k videu id <b>$videoId</b>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


?>