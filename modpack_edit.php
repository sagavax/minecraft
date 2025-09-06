<?php include "includes/dbconnect.php";
      include "includes/functions.php";

       if(isset($_POST['save_changes'])) {
     /*    $modpack_id=$_POST['modpack_id'];
        $modpack_name=mysqli_real_escape_string($link, $_POST['modpack_name']);
        $modpack_description=mysqli_real_escape_string($link, $_POST['modpack_description']);
        $modpack_url=mysqli_real_escape_string($link, $_POST['modpack_url']);
        $modpack_image=mysqli_real_escape_string($link, $_POST['modpack_image']);
        $is_active = $_POST['modpack_status'];
        //$modpack_pic=$_POST['image'];
        //var_dump($_POST);

        $update_modpack_info="UPDATE modpacks SET modpack_name='$modpack_name', modpack_description='$modpack_description',modpack_url='$modpack_url', modpack_image='$modpack_image',is_active=$is_active where modpack_id=$modpack_id";
        //echo $sql;
        $result=mysqli_query($link, $update_modpack_info) or die("MySQLi ERROR: ".mysqli_error($link));
        
        
        //update wall / log
        //$modpack_pic=mysqli_real_escape_string($link, $_POST['modpack_pic']);
         
        
          
          $diary_text="Minecraft IS: Bol upraveny modpack s nazvom <strong>$modpack_name</strong>";
          $update_app_log="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
          $result = mysqli_query($link, $update_app_log) or die("MySQLi ERROR: ".mysqli_error($link));
          
        
        
        $url="modpack_edit.php?modpack_id=$modpack_id";
        //echo $url; 
        header("location: ".$url);*/
       }


?>      
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/message.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <script type="text/javascript" src="js/modpack_edit.js" defer></script>
    <script type="text/javascript" src="js/message.js" defer></script>
  </head>

  <body>
      <div class="header">
          <a href="."><div class="app_picture"><img src="pics/logo.svg" alt="Minecraft logo"></div></a>
      </div>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        </div>
        <div class="content">
          <div class='list'>
              <?php
                    if(isset($_GET['modpack_id'])){
                    $modpack_id=$_GET['modpack_id'];
                } else {
                    header('location:modpacks.php');
                }
                       
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
                            echo "<div class='modpack_basic_info'>Detail of the <b>".GetModPackName($modpack_id)." </b> modpack</div>";
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
                                    echo "<button name='back' class='button small_button'>Back</button>";
                                    //echo "<button name='save_changes' class='button small_button'>Save</button>";
                              echo "</div>";      
                            echo "</form>";
                            echo "</div>"; //modpack details
                            }        
                          
                          echo "</div>"; //modpack
                          

                         //echo "<div class='mod_list'>";
                         //echo "<h3>List of mods:</h3>";
                           //echo GetModList($modpack_id);
                         //eho "</div>";//mod list  
                ?>
        </div><!-- list -->    
    </div><!-- content -->  