<?php

    include "includes/dbconnect.php";
      include "includes/functions.php";


      $modpack_id = $_POST['modpack_id'];
      $modpack_name = $_POST['modpack_name'];

      $updateModpackName = "UPDATE modpacks SET modpack_name = '$modpack_name' WHERE modpack_id = '$modpack_id'";
      $result = mysqli_query($link, $updateModpackName) or die("MySQLi ERROR: ".mysqli_error($link));

      echo json_encode(["success" => true, "message" => "Modpack name updated successfully."]);