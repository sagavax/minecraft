<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";
    

    $sql="SELECT * from vanila_bases";
    $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
      while ($row = mysqli_fetch_array($result)) {
        $base_id=$row['base_id'];
        $base_name=$row['base_name'];
        $base_description=$row['base_description'];
        $x=$row['X'];
        $y=$row['Y'];
        $z=$row['Z'];     
        $nether_x=$row['nether_X'];   
        $nether_y=$row['nether_Y'];   
        $nether_z=$row['nether_Z'];   
        //$base_screen_thumb = $row['zakladna_screen_thumb'];

        echo "<div class='vanilla-base-card' base-id=$base_id>";
        echo "<div class='base_name'>$base_name</div>";
       
        if($base_description == "") {
            echo "<div class='base_description_card' data-placeholder='Enter base description......'></div>";
        } else {
            echo "<div class='base_description_card'>$base_description</div>";
        }
       
        echo "<div class='coordinates_card'>";
            echo "<div class='base_coord_card'><div class='coord tooltip' title='X'>$x</div><div class='coord tooltip' title='Y'>$y</div><div class='coord tooltip'  title='Z'>$z</div></div>";
            echo "<div class='nether_coord_card'><div class='coord tooltip_2'  title='X'>$nether_x</div><div class='coord tooltip_2' title='Y'>$nether_y</div><div class='coord tooltip_2'  title='Z'>$nether_z</div></div>
        </div>";    
        
        
        echo "<div class='base_basic_info'>";
            echo "<div class='base_nr_notes'>".GetCountBaseNotes($base_id)."</div>";
            echo "<div class='base_nr_tasks'>". GetCountBaseTasks($base_id)."</div>";
            echo "<div class='base_nr_ideas'>".GetCountBaseIdeas($base_id)."</div>";   
        echo "</div>";

        echo "<div class='base_actions_card'>";
             echo "<button class='button small_button' name='edit_base' title='Edit the base'><i class='fas fa-edit'></i></button>";
             echo "<button class='button small_button' name='delete_base' type='button' title='Delete the base'><i class='fas fa-times'></i></button>";
        echo "</div>";

       /*  echo "<div class='base_actions'><input type='hidden' name='base_id' value='$base_id'><ul class='base_action'><li><button class='button small_button' name='edit_base' title='Upravit' onclick='base_details($base_id)'><i class='fas fa-edit'></i></button></li><li><button class='button small_button' type='button' title='Zmazat' onclick='delete_base($base_id);' ><i class='fas fa-times'></i></button></li></div>"; */
                echo "</div>"; //base_details
                echo "</div>";   
     }   
?>