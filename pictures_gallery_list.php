<?php
    include("includes/dbconnect.php");
    include("includes/functions.php");

    GetAllImageGalleries();
    
    /* $galleries = array();
    while ($row = $result->fetch_assoc()) {
        $galleries[] = $row;
    }
    echo json_encode($galleries); */