<?php
          header("Access-Control-Allow-Origin: *");
          header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
          header("Access-Control-Allow-Headers: Content-Type, Authorization");

          if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
              http_response_code(200);
              exit();
          }

          include "includes/dbconnect.php";
          include "includes/functions.php";

?>


<div class="modpack_seeds_wrap">
    <div class='modpack_seeds'>
        <?php
            $modpack_id = $_GET['modpack_id'];
            $get_seeds="SELECT * from modpack_seeds where modpack_id=$modpack_id";
            $result = mysqli_query($link, $get_seeds) or die("MySQLi ERROR: ".mysqli_error($link));
            if(mysqli_num_rows($result) == 0){
                echo "<div class='no_seeds'>No seeds added yet. Would you like to add some? <button type='button' name='add_seed' class='button small_button' title='Add new seed'><i class='fa fa-plus'></i></button></div>";
            }

            while ($row = mysqli_fetch_array($result)) {
                $seed_id = $row['seed_id'];
                $modpack_id = $row['modpack_id'];
                $seed = $row['seed'];
                $seed_description = $row['seed_description'];
                $added_date = $row['added_date'];
                  echo "<div class='modpack_seed_wrap' data-id='".$seed_id."'>";  
                    echo "<div class='modpack_seed'>".$seed."</div>";
                    echo "<button class='button small_button' title='Delete seed'><i class='fa fa-times'></i></button>";
                  echo "</div>";// modpack_seed_wrap
          };
    ?>
</div>

