<?php include "includes/dbconnect.php";
      include "includes/functions.php";
     
      if(isset($_POST['delete_picture'])){
        $picture_id=intval($_POST['picture_id']);
        
        //zistime si z dataazy o aky subor ide
        $base_dir="gallery";
        
        $sql="SELECT picture_name from pictures where picture_id=$picture_id";
        $result=mysqli_query($link, $sql) or die(mysqli_error($link));
        $row = mysqli_fetch_array($result);
        $picture_name=$base_dir."/".$row['picture_name']; //cesta k suboru

        //vymazeme subor z file systemu
        unlink($picture_name);

        //a vymazeme obrazok z databazy
        $sql="DELETE from pictures where picture_id=$picture_id";
        $result=mysqli_query($link, $sql) or die(mysqli_error($link));

        //zapiseme do wallu 
         //databaza na hostingu
      //mistna databaza

        
        $diary_text="Minecraft IS: Bol vymazany obrazok <strong>$picture_name</strong>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
      
        
       //echo "obrazook bol vymazany";  
       echo "<script>alert('Obrazok id $picture_id bol vymazany')</script>";
       //zobrazime alter
        //echo "<script>alert('');</script>";
      }


      if(isset($_POST['add_new_pic'])){
          global $link;

          $file = $_FILES['picture']['tmp_name'];  //docasne meno, cela cesta
          $image_name = addslashes($_FILES['picture']['name']); // meno suboru

          //skontrolujem ci je uz v databazy

          $sql="SELECT count(*) as nr_pictures from pictures where picture_name='".$image_name."'";
          //echo $sql;
          $result=mysqli_query($link, $sql) or die(mysqli_error($link));     
          $row = mysqli_fetch_array($result);
          $nr_pics=$row['nr_pictures'];
          
          if($nr_pics==1){
            echo $nr_pics;
            //echo "<script>alert($nr_pics);</script>";
             echo "<script>alert('Tento obrazok je uz v galerii');
             window.location.href='pics.php';
            </script>";
          } else {



          $path = $_FILES['picture']['name'];
          $ext = pathinfo($path, PATHINFO_EXTENSION); //zisti tomu priponu

          if (!isset($file)){ //kontrola ci je to obrazok
            echo "<script>alert('Ziaden subor nebol vybraty');
            window.location.href='pics.php';
            </script>";
           }

          
           //resize of the image 
           $picture_title=mysqli_real_escape_string($link, $_POST['picture_title']); //popis obrazku
           $picture_size = filesize($_FILES['picture']['tmp_name']); //velkost suboru
          
       
        
           $base_dir="gallery/";
        
          //upload suboru
          move_uploaded_file($file, "$base_dir/$image_name");

          //kontrola ci je zadany mod
          if(isset($_POST['category'])){
          
            $mod_id=$_POST['category'];
          } else{
              $mod_id=0;
          }   
          
          //kontrola ci je zadany modpack
          if(isset($_POST['modpack_id'])){
            $modpack=$_POST['modpack_id'];
           }  else {
               $modpack=0;
           }

          //kontrola ci obrazok je z EISu 
         
          

          //vlozim do databazy
          $picture_title=mysqli_real_escape_string($link,$_POST['picture_title']);
          $picture_description=mysqli_real_escape_string($link, $_POST['picture_description']);

          //echo $picture_description;

          $add_image="INSERT INTO pictures (picture_title,picture_description,picture_name,picture_path,picture_ext, picture_size,cat_id ,modpack_id,added_date) VALUES ('$picture_title','$picture_description','$image_name','$path','$ext',$picture_size,$mod_id,$modpack,now())";
          $result=mysqli_query($link, $add_image) or die(mysqli_error($link));
         
        //vlozim do wallu 
        
      
        $diary_text="Minecraft IS: Bol pridany novy obrazok s nazvom <strong>$image_name</strong>";
        $add_to_diary="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $add_to_diary) or die("MySQLi ERROR: ".mysqli_error($link));
        

        echo "<script>alert('Novy obrazok bol pridany!!!');
        window.location.href='images.php'
        </script>";
          }
      }

      if(isset($_POST['edit_info]'])){
        $picture_id=$_POST['picture_id'];
        echo "<script>alert('Edituj obrazok id $picture_id !!');</script>";
        
        //header('location:pics_edit.php');
      }

      if(isset($_POST['add_new_ext_pic'])){
        //var_dump($_POST);
        $image_name = mysqli_real_escape_string($link, $_POST['image_name']);
        $image_url = mysqli_real_escape_string($link, $_POST['image_url']);
        $image_description = mysqli_real_escape_string($link, $_POST['image_description']);
        
        $sql="INSERT INTO pictures (picture_title, picture_description, picture_name, picture_path, added_date) VALUES ('$image_name', '$image_description','$image_url','$image_url',now())";
        // echo $sql;
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link)); 

        //get latest id;
        $image_id = mysqli_insert_id($link);
        
        //upated_mods
        $cat_id=0;
        $insert_into_mods = "INSERT INTO pictures_mods (image_id, cat_id, created_date) VALUES ($image_id, $cat_id, now())";
        $result = mysqli_query($link, $insert_into_mods) or die("MySQLi ERROR: ".mysqli_error($link));
        
        //updates modpacks
        $modpack_id=9;
        $insert_into_modpacks = "INSERT INTO pictures_modpacks (image_id, modpack_id, created_date) VALUES ($image_id, $modpack_id,now())";
        $result = mysqli_query($link, $insert_into_modpacks) or die("MySQLi ERROR: ".mysqli_error($link));
        
        //updates tags
        //$insert_into_tags = "INSERT INTO pictures_tags (image_id, tag_id, created_date) VALUES ($image_id, $tag_id, $created_date)";
        //$result = mysqli_query($link, $insert_into_tags) or die("MySQLi ERROR: ".mysqli_error($link));
        
    
        ////vlozim do wallu 
        $diary_text="Minecraft IS: Bol pridany novy obrazok s nazvom <strong>$image_name</strong>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        

        echo "<script>alert('Novy obrazok bol pridany!!!');
        window.location.href='images.php'
        </script>";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script defer src="js/images.js?<?php echo time(); ?>"></script>
     <!-- <script defer src="js/app_event_tracker.js?<?php echo time() ?>"></script> -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>

  <body>
  <?php 
       echo "<script>sessionStorage.setItem('current_module','images')</script>";
       include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
    </div>
       
    <div class="content">
        <div class='middle_list'>
          <div class="add_new_image">
              <form action="" enctype="multipart/form-data" method="post" id="upload_external_image" onsubmit="return save_external_image();">    
                <input type=hidden name="modpack_id" value=<?php if(isset($_GET['modpack_id'])){echo $_GET['modpack_id'];}else{echo 0;} ?>>
                <input type="hidden" name="<?php echo ini_get('session.upload_progress.name'); ?>" value="test" />
                <input type="text" name="image_name" placeholder='picture title' autocomplete=off>
                <input type="text" name="image_url" placeholder="image url" autocomplete="off" id="image_url">
                <textarea name="image_description" placeholder="something about..."></textarea>
                <div class="action"><button type="submit" name="add_new_ext_pic" class="button pull-right"><i class="fa fa-plus"></i></button></div>
              </form> 
          </div>   
            <div class="image_tags_map">
            <input type="text" namae="search_tag" placeholder="Search a tag" autocomplete="off">
            <?php 
                  $get_videos_tags = "SELECT a.tag_id,b.tag_name from video_tags a, tags_list b WHERE a.tag_id NOT IN (0) and a.tag_id = b.tag_id GROUP BY b.tag_name ORDER BY b.tag_name ASC";
                  $result_tags=mysqli_query($link, $get_videos_tags);
                  while ($row_tags = mysqli_fetch_array($result_tags)) {
                    $tag_id = $row_tags['tag_id'];
                    $tag_name=$row_tags['tag_name'];
                    echo "<button type='button' class='button blue_button small_button' tag-id=$tag_id>$tag_name</button>";
                  }
                  ?>
            </div>


            <div id="picture_list">
              <?php
                    //check list of the files and compare it with the databases
                    $dir="gallery/";
                    
                    $itemsPerPage = 10;

                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $itemsPerPage;  


                    //$sql="SELECT * from notes ORDER BY note_id DESC LIMIT $itemsPerPage OFFSET $offset";  
                  
                    $sql="SELECT picture_id, picture_name,picture_title, picture_description, picture_path from pictures ORDER BY picture_id DESC LIMIT $itemsPerPage OFFSET $offset";
                     $result=mysqli_query($link, $sql);
                     while ($row = mysqli_fetch_array($result)) {
                       $picture_id=$row['picture_id'];
                       $picture_title=$row['picture_title'];
                       $picture_description=$row['picture_description']; 
                      
                       $picture_id = $row['picture_id'];
                       $picture_name=$row['picture_name'];
                       $picture_path=$row['picture_path'];
                        
                       echo "<div class='picture' image-id=$picture_id>";
                       echo "<div class='picture_name'>$picture_title</div>";

                       if($picture_title==""){
                         $picture_title=$picture_name;
                       }

                      
                       // var_dump(parse_url($picture_path));

                       echo "<div class='pic' image-id=$picture_id>";
                       if(!empty(parse_url($picture_path, PHP_URL_SCHEME))){
                       
                         echo "<img src='$picture_path' title='$picture_title' loading='lazy'></div>";  
                       } else {
                         echo "<img src='gallery/$picture_path' title='$picture_title' loading='lazy'></div>";
                       }
                       
                       echo "<div class='picture_footer'>"; 
                       
                       //echo "<div class='mod_modpack'>".$modpack_name."</div>";

                         echo "<div class='picture_action' image-id=$picture_id>";
                          echo "<div class='picture_modpacks'>".GetImageModpack($picture_id)."</div><button name='add_tag' type='button' class='button small_button' title='Add tagg'><i class='fas fa-tag'></i></button><button name='add_comment' type='button' class='button small_button' title='Add new comment'><i class='fa fa-comment'></i></button><button name='view_image' type='button'class='button small_button' title='View image'><i class='fa fa-eye'></i></button><button name='delete_image' type='button' class='button small_button' title='Delete picture'><i class='fa fa-times'></i></button>";
                          echo "</div>";//picture_action
                       echo "</div>";
                       //echo "<div class='mod'>$mod_name</div>";         
                    echo "</div>";//div picture

                    }                
                  
              ?>
            </div><!-- picture list -->
              <?php
                // Calculate the total number of pages
                $count_images = "SELECT COUNT(*) as total FROM pictures";
                $result=mysqli_query($link, $count_images);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                  echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
                ?>  
        </div><!--list-->    
    </div><!-- content -->
