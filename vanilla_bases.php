<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      header("Access-Control-Allow-Origin: *");
/*      SELECT x, y, z,
    SQRT(POW(x - :given_x, 2) + POW(z - :given_z, 2)) AS distance
        FROM your_table_name
        ORDER BY distance
        LIMIT 1;
*/       
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="js/vanila_bases.js"></script>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  <body>
  <?php include("includes/header.php") ?>
  <div class="main_wrap">
    <div class="tab_menu">
        <?php include("includes/vanila_menu.php");

        ?>
    </div>
    <div class="content">

        <div class="list">

          <div class="fab fab-icon-holder" onclick="window.location.href='vanilla_add_base.php';">
            <i class="fa fa-plus"></i>
        </div>   

        <!--<div id="add_new_base"><a href="vanilla_add_base.php" class="button small_button">Add New Base</a></div>-->

        <div class="search_wrap">
            <input type="text" name="search" autocomplete="off" placeholder="Search coordinates ..." onkeyup="live_search(this.value)" id="search"> <button type="button" title="clear search" class="button small_button clear_button tooltip>"><i class="fa fa-times"></i></button>
        </div>


        <div class="tab_view">
            <button type="button" class="button small_button rounded_button" name="reload_bases">Reload</button>
        </div>


        <div id="vanilla_bases">

            <?php 
            $sql="SELECT * from vanila_bases_new";
            $result=mysqli_query($link, $sql);
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
                //$base_screen_thumb = $row['zakladna_screen_thumb'];

                echo "<div class='vanilla-base' base-id=$base_id>";
                echo "<div class='base_name'>$zakladna_meno</div>";
                echo "<div class='base_details'>";
                //echo "<div class='base_screen_thumb'><img src='gallery/base_" . $base_id."/".$base_screen_thumb . "'></div>";
                echo "<div class='coordinates'>";
                echo "<div class='base_coord'><div class='coord tooltip' title='X'>$x</div><div class='coord tooltip' title='Y'>$y</div><div class='coord tooltip'  title='Z'>$z</div></div>";
                echo "<div class='nether_coord'><div class='coord tooltip_2'  title='X'>$nether_x</div><div class='coord tooltip_2' title='Y'>$nether_y</div><div class='coord tooltip_2'  title='Z'>$nether_z</div></div>
                </div>";    
                echo "<div class='base_nr_notes'><span class='tooltip' title='Notes'>".GetCountBaseNotes($base_id)."</span></div>
                <div class='base_nr_tasks'><span class='tooltip' title='Tasks'>". GetCountBaseTasks($base_id)."</span></div>
                <div class='base_nr_ideas'><span class='tooltip' title='Ideas'>". GetCountBaseIdeas($base_id)."</span></div>";   
                echo "<div class='base_actions'><input type='hidden' name='base_id' value='$base_id'><ul class='base_action'><li><button class='button small_button' name='edit_base' title='Upravit' onclick='base_details($base_id)'><i class='fas fa-edit'></i></button></li><li><button class='button small_button' type='button' title='Zmazat' onclick='delete_base($base_id);' ><i class='fas fa-times'></i></button></li></div>";
                        echo "</div>"; //base_details
                     echo "</div>";   
                             }   
                 ?>
                             
                </div><!-- vanilla bases -->

            </div><!-- list -->
         </div><!-- content -->
     </div><!-- main wrapp -->
   


    <div id="modal_new_note_wrap">
        <form action="" method="post">
            <input type="hidden" name="base_id" value="<?php echo $base_id?>">
            <!-- <div id="new_note_text"> -->
            <textarea name="note_text" placeholder="type some text..."></textarea>
            <!-- </div> -->
            <div id="new_note_action">
                <button class="button small_button" type="submit" name="new_note">add new note </button>
                <button class="button small_button" type="button" onclick="hide_new_note()">X</button>
            </div>
        </form>
    </div>
  

  </body>