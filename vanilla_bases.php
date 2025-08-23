<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      header("Access-Control-Allow-Origin: *");     
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="js/vanila_bases.js" defer></script>
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

          <div class="fab fab-icon-holder" onclick="document.getElementById('modal_new_base').showModal();">
            <i class="fa fa-plus"></i>
        </div>   

        <!--<div id="add_new_base"><a href="vanilla_add_base.php" class="button small_button">Add New Base</a></div>-->

        <div class="search_wrap">
            <input type="text" name="search" autocomplete="off" placeholder="Search coordinates ..." id="search"> <button type="button" title="clear search" class="button small_button clear_button tooltip>"><i class="fa fa-times"></i></button>
        </div>


        <div class="tab_view">
            <button type="button" class="button small_button rounded_button" name="reload_bases" title="Reload bases">Reload</button>
            <button type="button" class="button small_button rounded_button" name="add_new_base" title="Add new base">Add New Base <i class="fa fa-plus"></i></button>
            <button type="button" class="button small_button rounded_button" name="show_list" title ="Display as list">Show as list <i class="fa-solid fa-list"></i></button>
            <button type="button" class="button small_button rounded_button" name="show_grid" title="Display as grid">Show as grid</button>
        </div>


        <div id="vanilla_bases">

            <?php 
            $sql="SELECT * from vanila_bases";
            $result=mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
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

                echo "<div class='base_actions'><button class='button small_button' name='edit_base' title='Edit the base'><i class='fas fa-edit'></i></button><button class='button small_button' type='button' title='Zmazat' name ='delete_base'><i class='fas fa-times'></i></button></div>";
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
  
    <dialog id = modal_new_base>                         
        <div class="new_base_inner_layer">
            <input type="text" name="base_name" placeholder="name of the base ...." autocomplete="off">
            <textarea name="base_description" placeholder="description of the base ...."></textarea>
             <div class="base_location">
                <div id="base_location_outworld"><h4>Outworld:</h4>
                    <div class="base_coord"><span>X:</span><input type="text" placeholder="X" name="over_x" required></div>
                    <div class="base_coord"><span>Y:</span><input type="text" placeholder="Y" name="over_y" required></div>
                    <div class="base_coord"><span>Z:</span><input type="text" placeholder="Z" name="over_z" required></div>
                </div><!-- base location outworld -->
            </div>   
            <div class="action">
                <button type="button" class="button small_button" name="return_to_vanilla">Back</button>
                <button type="button" class="button small_button" name="add_base">Add base</button>
            </div>
        </div>
    </dialog>                         

  </body>