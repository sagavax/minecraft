<?php
       include("includes/dbconnect.php");
       include("includes/functions.php");

       $modId = $_POST['modId'];
       $videoId = $_POST['videoId'];

       //check if mod is associated with video, if not insert, if yes update
        $check_mod = "SELECT cat_id FROM videos_mods WHERE video_id=$videoId";
        $check_mod_result = mysqli_query($link, $check_mod) or die("MySQLi ERROR: ".mysqli_error($link));
        if (mysqli_num_rows($check_mod_result) == 0) {
            $insert_mod = "INSERT INTO videos_mods (video_id, cat_id) VALUES ($videoId, $modId)";
            $insert_mod_result = mysqli_query($link, $insert_mod) or die("MySQLi ERROR: ".mysqli_error($link));
            echo json_encode(["success" => true, "message" => "Mod has been changed successfully", "modId" => $modId]);
            exit();
        } else {
            //duplicate
            echo json_encode(["success" => false, "error" => "duplicate", "message" => "for video id $videoId mod id $modId already exists", "modId" => $modId]);
            exit();            
        }


       $add_mod_to_video = "INSERT INTO videos_mods (video_id, cat_id) VALUES ($videoId, $modId)";
       $result=mysqli_query($link, $add_mod_to_video) or die("MySQLi ERROR: ".mysqli_error($link));
       echo json_encode(["success" => true, "message" => "Mod has been changed successfully", "modId" => $modId]);

        //add to diary
        $diary_text="Minecraft IS: Bolo pridane mod <strong>".GetModName($modId)."</strong> k videu id <b>$videoId</b>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));


?>