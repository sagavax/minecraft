<?php include "includes/dbconnect.php";


$mod = mysqli_real_escape_string($link, $_GET['mod']);

echo "<ul>";
$get_mod = "SELECT * from mods where cat_name='$mod'";
$result=mysqli_query($link, $get_mod);
  while ($row = mysqli_fetch_array($result)) {
                            $cat_id=$row['cat_id'];
                            $cat_name=$row['cat_name'];
                            $cat_description=$row['cat_description'];
                        
                            echo "<div class='category' data-id=$cat_id><div class='cat_name'>$cat_name</div><div class='cat_action'>";

                              if($cat_description==""){
                                echo "<div class='cat_description'><i class='fas fa-plus-circle'></i></div>";  
                              }

                              echo "<div class='cat_delete'><i class='fas fa-times-circle'></i></div>";
                              echo "</div>"; //div class cat action
                            echo "</div>"; //div class cat category
                        }    
  echo "</ul>";               
 ?>