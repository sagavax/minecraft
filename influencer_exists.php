<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";


    $influecener_name = $_POST['influecener_name'];

//check if the influencer already exists
    $check_if_influencer_exists = "SELECT * FROM influencers WHERE influencer_name = '$influecener_name'";
    $result = mysqli_query($link, $check_if_influencer_exists);
    if(mysqli_num_rows($result) == 1) {
        //send true
        echo "true";
    } else {
        echo "false";
    }