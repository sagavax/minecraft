<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";
    
    $modpack_id = $_GET['modpack_id'];
?>

<div class="modpack_bases">
    <?php 
        $modpack_id=$_GET['modpack_id'];
        $sql="SELECT * from modpack_bases WHERE modpack_id=$modpack_id";
        $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        if(mysqli_num_rows($result)==0){
             echo "<div class='no_base'><p>No bases found. would you like to create a new one?</p><button type='button' name='modal_new_base' class='button small_button' title='Add the base'><i class='fa fa-plus'></i></button></div>";
        } else {
            while ($row = mysqli_fetch_array($result)) {
                $base_id=$row['base_id'];
                $base_name=$row['base_name'];
                $base_description=$row['base_description'];
                $x=$row['coord_x'];
                $y=$row['coord_y'];
                $z=$row['coord_z'];     
                $nether_x=$row['nether_X'];   
                $nether_y=$row['nether_Y'];   
                $nether_z=$row['nether_Z'];   
                //$base_screen_thumb = $row['zakladna_screen_thumb'];

            echo "<div class='vanilla-base-card' modpack-id=$modpack_id base-id=$base_id>";
                echo "<div class='base_name'>$base_name</div>";
           
                if($base_description == "") {
                    echo "<div class='base_description_card' data-placeholder='Enter base description......'></div>";
                } else {
                    echo "<div class='base_description_card'>$base_description</div>";
                }
            
                echo "<div class='coordinates_card'>";
                    echo "<div class='base_coord_card'><div class='coord tooltip' title='X'>$x</div><div class='coord tooltip' title='Y'>$y</div><div class='coord tooltip'  title='Z'>$z</div></div>";
                    echo "<div class='nether_coord_card'><div class='coord tooltip_2'  title='X'>$nether_x</div><div class='coord tooltip_2' title='Y'>$nether_y</div><div class='coord tooltip_2'  title='Z'>$nether_z</div></div>";
                echo "</div>";  //base coordinates  
            
                echo "<div class='base_basic_info'>";
                    echo "<div class='base_nr_notes'>".GetCountModpackBaseNotes($base_id)."</div>";
                    echo "<div class='base_nr_tasks'>". GetCountModpackBaseTasks($base_id)."</div>";
                    echo "<div class='base_nr_ideas'>".GetCountModpackBaseIdeas($base_id)."</div>";   
                echo "</div>";//base_basic_info

                echo "<div class='base_actions_card'>";
                    echo "<button class='button small_button' name='edit_base' title='Edit the base'><i class='fas fa-edit'></i></button>";
                    echo "<button class='button small_button' name='delete_base' type='button' title='Delete the base'><i class='fas fa-times'></i></button>";
                echo "</div>"; //base_actions_card
                echo "</div>"; //vanilla-base-card  
            }
             echo "<div class='vanilla-base-card'><button type='button' name='modal_new_base' class='button small_button' title='Add the base'><i class='fa fa-plus'></i></button></div>";
        }

       
    ?>
</div><!-- modpack bases -->

    