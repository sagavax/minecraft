<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";   

    $get_bases="SELECT * from vanila_bases";
    $result=mysqli_query($link, $get_bases) or die("MySQLi ERROR: ".mysqli_error($link));
     while ($row = mysqli_fetch_array($result)) {
        $base_id=$row['base_id'];
        $base_name=$row['base_name'];
        $zakladna_popis=$row['base_description'];
        $x=$row['X'];
        $y=$row['Y'];
        $z=$row['Z'];     
        $nether_x=$row['nether_X'];   
        $nether_y=$row['nether_Y'];   
        $nether_z=$row['nether_Z'];   
        //$base_screen_thumb = $row['zakladna_screen_thumb'];

        echo "<div class='vanilla-base' base-id=$base_id>";
            echo "<div class='base_name'>$base_name</div>";
            
            echo "<div class='base_details'>";
                //echo "<div class='base_screen_thumb'><img src='gallery/base_" . $base_id."/".$base_screen_thumb . "'></div>";
                echo "<div class='coordinates'>";
                echo "<div class='base_coord'><div class='coord tooltip' title='X'>$x</div><div class='coord tooltip' title='Y'>$y</div><div class='coord tooltip'  title='Z'>$z</div></div>";
                echo "<div class='nether_coord'><div class='coord tooltip_2'  title='X'>$nether_x</div><div class='coord tooltip_2' title='Y'>$nether_y</div><div class='coord tooltip_2'  title='Z'>$nether_z</div></div>
                </div>";    
                
                if($zakladna_popis == "") {
                    echo "<div class='base_description' data-placeholder='Enter base description......'></div>";
                } else {
                    echo "<div class='base_description'>$zakladna_popis</div>";
                }
                
                echo "<div class='base_note_tasks_ideas_wrap'>"; //wrap
                    echo "<div class='base_nr_notes'><span class='tooltip' title='Notes'>".GetCountBaseNotes($base_id)."</span></div>";
                    echo "<div class='base_nr_tasks'><span class='tooltip' title='Tasks'>". GetCountBaseTasks($base_id)."</span></div>";
                    echo "<div class='base_nr_ideas'><span class='tooltip' title='Ideas'>". GetCountBaseIdeas($base_id)."</span></div>";
                echo "</div>"; //wrap

                echo "<div class='base_actions'>";
                        echo "<button class='button small_button' name='edit_base' title='Upravit' name='edit_base'><i class='fas fa-edit'></i></button>";
                        echo "<button class='button small_button' type='button' title='Zmazat' name ='delete_base'><i class='fas fa-times'></i></button></div>";
            echo "</div>"; //base_details
       echo "</div>";//vanilla-base   
                        } 
?>