  <?php include "includes/dbconnect.php";
      include "includes/functions.php";

      $modpack_id=$_GET['modpack_id'];
?>

   <h3><?php echo GetModPackName($modpack_id); ?> images</h3>
                        
                       <div id="new_video">
                         <div id="upload_external_image">
                           <form action="modpack_external_image">
                             <input type="text" autocomplete="off" name="image_name" placeholder="add image title here ..." id="upload_local_image">
                             <input type="text" autocomplete="off" name="image_path" placeholder="add image url here .." id="upload_external_image">
                             <button type="submit" name="submit" class="button">Upload</button>
                           </form>
                         </div>
                         </div><!-- new image -->      



                        <div class="base_images_list">
                            <form action="" method="GET">
                              <input type="text" name="search" placeholder="search string" autocomplete="off"><!--<button type="submit" class="button small_button"><i class="fa fa-search"></i></button>-->
                            </form>

                            <!-- get list of images -->
                            <?php
                                $get_modpack_images = "SELECT * from modpack_images WHERE modpack_id=$modpack_id";
                                $result = mysqli_query($link, $get_modpack_images) or die("MySQLi ERROR: ".mysqli_error($link));
                                while($row = mysqli_fetch_array($result)){
                                    $img_id = $row['img_id'];
                                    $image_name = $row['image_name'];
                                    //echo $image_name;
                                    echo "<div class='base_image'>"; //base_image
                                        //$root = "http://".$_SERVER["SERVER_NAME"]."/minecraft/prod/gallery/";
                                        //echo "<img src='".$root."base_".$base_id."/".$image_name."'>";
                                    echo "</div>"; //base image
                                } 
                             ?>   
                         </div><!--base / modpack image list -->