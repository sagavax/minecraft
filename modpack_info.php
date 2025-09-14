<?php
       include "includes/dbconnect.php";
       include "includes/functions.php";

       $modpack_id=$_GET['modpack_id'];
       $modpack_name=GetModPackName($modpack_id);

       $sql="SELECT * from modpacks where modpack_id=$modpack_id";
//echo $sql;
    $result=mysqli_query($link, $sql);
       while ($row = mysqli_fetch_array($result)) {
       $modpack_id=$row['modpack_id'];
       $modpack_name=$row['modpack_name'];
       $modpack_description=$row['modpack_description'];
       $modpack_url=$row['modpack_url'];
       $is_active=$row['is_active'];
       $is_visible = $row['is_visible'];
       $modpack_image=$row['modpack_image'];
       $modpack_index_id=$row['modpack_index_id'];

       if($modpack_image<>""){
              $modpack_image=$row['modpack_image'];
       } else {
              $modpack_image="./pics/noimage.jpg";
       }
       

       //$modpack_url=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $modpack_url);
       
       echo "<div class='modpack'>";
       //echo "<div class='modpack_basic_info'>Detail of the <b>".GetModPackName($modpack_id)." </b> modpack</div>";
       echo "<form action='' method='post'>";
              echo "<div class='modpack_pic_wrap'><img src='".$modpack_image."'></div>";
              echo "<div class='modpack_details'>";
                     echo "<input type='hidden' name='modpack_id' value=$modpack_id>";
                     echo "<input type='text' name='modpack_name' value='$modpack_name'>";
                     echo "<div class='modpack_description' placeholder='Modpack&apos; description here....' >$modpack_description</div>";
                     echo "<input type='text' name='modpack_url' value='$modpack_url' placeholder='modpacks&apos; url'>";
                     echo "<input type='text' name='modpack_index_id' value='$modpack_index_id' placeholder='modpack index id' title='modpack_index.com id'>";
                     echo "<input type='text' name='modpack_image' value='$modpack_image'>";
                     echo "<select name='modpack_status'>";
                     echo "<option value='$is_active' selected='selected'>";
                            if($is_active==1){
                            echo "Active";
                            } else {
                            echo "Inactive";
                            };
                     echo "</option>";
                     echo "<option value=1>Active</option>";
                     echo "<option value=0>Inactive</option>";
                     echo "</select>";
              echo "<div class='modpack_action'>";
                     //echo "<button name='back' class='button small_button'>Back</button>";
                     //echo "<button name='save_changes' class='button small_button'>Save</button>";
              echo "</div>";      
       echo "</form>";
       echo "</div>"; //modpack details
       }        
?>