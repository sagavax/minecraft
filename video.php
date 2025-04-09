<?php 
      include "includes/dbconnect.php";
      include "includes/functions.php";
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
    <script type="text/javascript" defer src="js/video.js"></script>
    <!-- <script type="text/javascript" defer src="js/video_tags.js"></script> -->
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>

  <body>
      <?php include "includes/header.php"?>
      <div class="main_wrap">
      <div class="tab_menu">
         <?php include "includes/menu.php";?>
        </div>
        <div class="content">
            <div class='list'>

<?php
$video_id = $_GET['video_id'];
echo "<script>sessionStorage.setItem('video_id',$video_id)</script>";



$sql = "SELECT * from videos where video_id=$video_id";
//$sql = "SELECT video_id, video_title, video_url, video_source, cat_id, modpack_id from videos where video_id=$video_id";
//echo $sql;

$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $cat_id = $row['cat_id'];
    //$modpack_id = $row['modpack_id'];
    //$cat_name = GetModName($cat_id);
    //$modpack_name = GetModPackName($modpack_id);
    $video_name = $row['video_title'];
    $video_url = $row['video_url'];
    $video_source = $row['video_source'];
    $video_edition = $row['edition'];

    
     echo "<div class='video_details'>";
     echo "<div class='video_details_name_wrap'>";   
         echo "<div class='video_details_name'>$video_name</div>";
         echo "<button type='button' class='button small_button' title='Edit title' name='edit_title'><i class='fa fa-edit'></i></button>";
         echo "<button type='button' class='button small_button' title='Save changes' name='save_chnages'>Save</button>";
     echo "</div>"; // video title wrap



    if($video_source=="YouTube"){
       if(strpos( $video_url, "shorts" ) !== false){
        $video_shorts_url= preg_replace("/\s*[a-zA-Z:\/\/:\.]*youtube.com\/shorts\/([a-zA-Z0-9_-]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $video_url);    
        echo "<div class='video_player'>$video_shorts_url</div>";        
                } else {       
                $video_url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $video_url);
                echo "<div class='video_player'>$video_url</div>";  
                }
               }

                elseif($video_source=="TikTok") {

                    //embed video_url
                    $tiktok = "https://www.tiktok.com/oembed?url=".$video_url;
                    //echo $tiktok;
                
                    $curl = curl_init($tiktok);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    $return = curl_exec($curl);

                    if (curl_errno($curl)) {
                        echo 'Curl error: ' . curl_error($curl);
                    }

                    $data = json_decode($return, true);

                    curl_close($curl);

                    $video_url=$data['html'];

                    echo $video_url;    
                } elseif($video_source=="Pinterest"){
                    //<iframe src="https://assets.pinterest.com/ext/embed.html?id=276478864617988301" height="714" width="345" frameborder="0" scrolling="no" ></iframe>
                   $pattern = '/\/pin\/(\d+)\//';
                   if (preg_match($pattern, $video_url, $matches)) {
                     $videoId = $matches[1];
                     $pinterest_video = "<iframe src='https://assets.pinterest.com/ext/embed.html?id=".$videoId."' height='714' width='345' frameborder='0' scrolling='no' ></iframe>";
                    echo "<div class='video_player'>$pinterest_video</div>";
                }
                }
                 
                echo "<div class='video_info'>";
                    echo "<div class='video_tags_list'>".VideoTags($video_id)."<button name='add_new_tag' class='button small_button'><i class='fa fa-plus'></i></button></div>";
                    echo "<div class='video_comm_info'><div class='video_edition'><button class='button small_button'>".$video_edition." edition</button></div><span><span id='nr_of_comments'>" . GetNrOfComments($video_id) . "</span>comment(s)</span></div></div>";
                echo "<div class='video_comments_wrap'>";
                echo "<div class='video_comments' id='comments'>";
                //echo "<ul>";
                $video_comments = "SELECT * from video_comments where video_id=$video_id";
                //echo $video_comments;
                $result_comments = mysqli_query($link, $video_comments);
                while ($row_comments = mysqli_fetch_array($result_comments)) {
                    $comm_id = $row_comments['comm_id'];
                    $comment_text = $row_comments['video_comment'];
                    $comment_date = $row_comments['comment_date'];

                    $comment_text = preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "<a target='_blank' href=\"\\0\">\\0</a>", $comment_text);

                
                  echo "<div class='comment' data-id=$comm_id>";
                  echo "<div class='comment_text'>$comment_text</div>";
                  echo "<div class='comment_footer'><button type='button' class='button small_button'><i class='fa fa-times'></i></button></div>";
                  echo "</div>";

                }
                echo "</div>"; 
                echo "<div class='new_comment'><input type='text' name='video_comment' id='video_comment' autocomplete='off'><button name='add_comment' type='button'><i class='fa fa-plus'></i></button></div></div>";
                echo "<div class='action_back'><button onclick='reload_comments();' ><i class='fas fa-sync'></i> Reload</button> <a href='videos.php'><i class='fas fa-angle-left'></i> Back</a></div>";
                echo "</div>"; // div video comments_wrap
                echo "</div>"; // div video details
            }

            ?>
        </div>
              </div> <!-- div list -->   
      </div> <!--content -->
      <dialog class="modal_new_tags">
          <div class="inner_layer">
              <button type="button" class="close_inner_modal"><i class="fa fa-times"></i></button>  
              <input type="text" name="tag_name" placeholder="tag name ...." autocomplete="off">
              <div class="video_tags_alphabet">
                <?php 
                        foreach (range('A', 'Z') as $char) {
                          echo "<button type='button' class='button small_button'>$char</button>";

                        }
                     ?>  
              </div>
              <div class="tags_list"><?php echo GetAllUnassignedVideosTags()?></div>
              <!-- <div class="loading" style="display: none;">Loading...</div> -->
          </div>
        </dialog>
</body>