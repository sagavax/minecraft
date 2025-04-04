<?php

include("includes/dbconnect.php");
include("includes/functions.php");

$reload_bases = "SELECT * from vanila_bases ORDER BY zakladna_id ASC";
$result = mysqli_query($link, $reload_bases) or die("MySQLi ERROR: " . mysqli_error($link));
while ($row = mysqli_fetch_array($result)) {
    $base_id=$row['zakladna_id'];
    $zakladna_meno=$row['zakladna_meno'];
    $zakladna_popis=$row['zakladna_popis'];
    $x=$row['X'];
    $y=$row['Y'];
    $z=$row['Z'];     
    $nether_x=$row['nether_X'];   
    $nether_y=$row['nether_Y'];   
    $nether_z=$row['nether_Z'];   


    echo "<div class='vanilla-base' base-id=$base_id>";
    echo "<div class='base_name'>$zakladna_meno</div>";
    echo "<div class='base_details'>";
    echo "<div class='coordinates'>";
    echo "<div class='base_coord'><div class='coord'>X: $x</div><div class='coord'>Y: $y</div><div class='coord'>Z:$z</div></div>";
    echo "<div class='nether_coord'><div class='coord'>X: $nether_x</div><div class='coord'>Y: $nether_y</div><div class='coord'>Z:$nether_z</div></div>
    </div>";    
    echo "<div class='base_nr_notes'><span class='tooltip' title='Notes'>".GetCountBaseNotes($base_id)."</span></div>
    <div class='base_nr_tasks'><span class='tooltip' title='Tasks'>". GetCountBaseTasks($base_id)."</span></div>
    <div class='base_nr_tasks'><span class='tooltip' title='Ideas'>". GetCountBaseIdeas($base_id)."</span></div>";   
    echo "<div class='base_actions'><input type='hidden' name='base_id' value='$base_id'><ul class='base_action'><li><button class='button small_button' name='edit_base' title='Upravit' onclick='base_details($base_id)'><i class='fas fa-edit'></i></button></li><li><button class='button small_button' type='button' title='Zmazat' onclick='delete_base($base_id);' ><i class='fas fa-times'></i></button></li></div>";
    echo "</div>"; //base_details
    echo "</div>";   
}     
