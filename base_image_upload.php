<?php include("includes/dbconnect.php");
      include ("includes/functions.php");


$base_id = $_POST['base_id'];
var_dump($_POST);


$folderPath = "gallery/base_".$base_id; // Change this to the desired folder path



if (!file_exists($folderPath) && !is_dir($folderPath)) {
    // Create the directory if it doesn't exist
    mkdir($folderPath, 0755, true);
}



    $targetDir = "gallery/base_".$base_id."/"; // upload target
    //echo $targetDir;
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    //echo $targetFile;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
       //echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES["file"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is OK, try to upload the file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }



//image save to database
$save_to_base = "INSERT into vanila_base_images (base_id, image_name, added_date) VALUES ($base_id,'".basename($_FILES["file"]["name"])."',now())";
//echo $save_to_base;
$result = mysqli_query($link, $save_to_base) or die("MySQLi ERROR: ".mysqli_error($link));
 
 $url = "vanilla_base.php?base_id=".$base_id;
 header("location:".$url);
