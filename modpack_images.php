  <?php include "includes/dbconnect.php";
      include "includes/functions.php";

      $modpack_id=$_GET['modpack_id'];
?>

   <h3><?php echo GetModPackName($modpack_id); ?> images</h3>
                        
                        <div class="insert_new_image">
                            <input type="radio" name="group2" onclick="show_upload_form()" id="upload" checked><label for="upload">Upload image</label>
                            <input type="radio" name="group2" onclick="show_link_form()" id="external"><label for="external">Image link</label>
                            <input type="radio" name="group2" onclick="show_drag_form()" id="drag"><label for="drag">Drag & Drop</label>
                        </div>

                        <div id="new_video">
                          <div id="upload_image">
                              <form action="modpack_image_upload.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="base_id" value="<?php echo $modpack_id ?>" >
                                <input type="text" name="picture_title" placeholder='picture title' autocomplete=off>
                                <input type="file" name="file">
                                 <button type="submit" name="submit" class="button">Upload</button>
                              </form>
                           </div>
                          <div id="upload_external_image">
                           <form action="modpack_external_image">
                             <input type="text" autocomplete="off" name="image_name" placeholder="add image title here ..." id="upload_local_image">
                             <input type="text" autocomplete="off" name="image_path" placeholder="add image url here .." id="upload_external_image">
                             <button type="submit" name="submit" class="button">Upload</button>
                           </form>
                         </div>
                          <div id="drag_and_drop">
                              <div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                              <!--<div id="drop_zone" ondrop="runUpload(event);" ondragover="dragOverHandler(event);">-->
                                  <span>Drop Files Here</span>
                                  
                            </div>
                            <div id="upload-fileinfo"></div>
                          </div>
                          <div class="progress_bar_wrap">
                            <div class="progress_bar" style="width:0%"></div>
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
                                        $root = "http://".$_SERVER["SERVER_NAME"]."/minecraft/prod/gallery/";
                                        echo "<img src='".$root."base_".$base_id."/".$image_name."'>";
                                    echo "</div>"; //base image
                                } 
                             ?>   
                         </div><!--base / modpack image list -->