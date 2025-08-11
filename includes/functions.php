<?php 
include("dbconnect.php");


function GetAllInfluencers() {
	global $link;
	$influncer = "";
	$sql = "SELECT * FROM influencers ORDER BY id DESC";
	$result = mysqli_query($link, $sql) or die(mysqli_error($link));
	while($row = mysqli_fetch_array($result)) {
	$influncer .= "<div class='influencer' influencer_id='".$row['id']."'>";	
		$influncer .= "<div class='influencer_image'><img src='".htmlspecialchars($row['influencer_image'], ENT_QUOTES)."'></div>";
		$influncer .= "<div class='influencer_info'>";
		$influncer .= "<div class='influencer_name'>" . htmlspecialchars($row['influencer_name'], ENT_QUOTES) . "</div>";
		$influncer .= "</div>";
	$influncer .= "</div>";	
	}
	
	echo $influncer;
}


function GetImageGallery($image_id) { 
	global $link;
	$get_gallery = "SELECT a.gallery_id, b.gallery_name 
	                FROM pictures_gallery_images a, picture_galleries b 
	                WHERE a.picture_id=$image_id AND a.gallery_id = b.gallery_id";
	$result = mysqli_query($link, $get_gallery) or die(mysqli_error($link));
	$row = mysqli_fetch_array($result);

	if(mysqli_num_rows($result) == 0) {
		return "<button type='button' name='change_gallery' class='button small_button' title='Add to gallery'><i class='fa fa-image'></i></button>";
	} else {
		return "<button type='button' name='change_gallery' gallery-id='" . $row['gallery_id'] . "' class='button small_button'>" . htmlspecialchars($row['gallery_name']) . "</button>";
	}
}

function GetImageGalleryName($image_id) { 
	global $link;
	$get_gallery = "SELECT a.gallery_id, b.gallery_name 
	                FROM pictures_gallery_images a, picture_galleries b 
	                WHERE a.picture_id=$image_id AND a.gallery_id = b.gallery_id";
	$result = mysqli_query($link, $get_gallery) or die(mysqli_error($link));
	$row = mysqli_fetch_array($result);
		if(mysqli_num_rows($result) > 0) {
		return  htmlspecialchars($row['gallery_name']);
	}
		
	
}

function GetAllImageGalleries(){
	global $link;
	$gallery ="";	
	$query = "SELECT * from picture_galleries";
	$result=mysqli_query($link, $query) or die(mysql_error());
	if(mysqli_num_rows($result)==0) {
		echo "<div class='no_gallery' gallery-id='0'>No galleries</div>";
	} else {
		while($row = mysqli_fetch_array($result)){
		$gallery .= '<button class="button small_button jade_button" name="gallery" gallery-id="'.$row['gallery_id'].'">'.$row['gallery_name'].'<span>('.GetCountImagesInGallery($row['gallery_id']).')</span> </button>';
	}
		
	}
	echo $gallery;
}

function GetCountImagesInGallery($gallery_id){
	global $link;
	$query = "SELECT count(*) as count from pictures_gallery_images where gallery_id=$gallery_id";
	$result=mysqli_query($link, $query) or die(mysql_error());
	$row = mysqli_fetch_array($result);
	return $row['count'];
}


// 🧱 Validuj a dekóduj JSON
function getJsonPayload(): array {
    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Neplatný JSON formát']);
        exit;
    }

    return $data;
}

// 🔗 Získaj YouTube video ID
function extractYouTubeId(string $url): ?string {
    if (strpos($url, 'youtube.com') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        return $params['v'] ?? null;
    } elseif (strpos($url, 'youtu.be') !== false) {
        return ltrim(parse_url($url, PHP_URL_PATH), '/');
    }
    return null;
}

// 🛡️ Over duplicitu videa
function videoExists(mysqli $link, string $url): bool {
    $urlEscaped = $link->real_escape_string($url);
    $query = "SELECT 1 FROM videos WHERE video_url = '$urlEscaped' LIMIT 1";
    $result = $link->query($query);
    return $result && $result->num_rows > 0;
}

// 💾 Ulož video do databázy
function insertVideo(mysqli $link, string $title, string $url, string $thumbnail, string $edition, string $source): int {
    $query = "
        INSERT INTO videos (video_title, video_url, edition, video_thumbnail, video_source, added_date)
        VALUES ('$title', '$url', '$edition', '$thumbnail', '$source', NOW())
    ";

    if ($link->query($query) === TRUE) {
        return $link->insert_id;
    }

    http_response_code(500);
    echo json_encode(['error' => 'Chyba pri ukladaní videa: ' . $link->error]);
    exit;
}

// 📦 Priraď video k modpacku
function linkVideoToModpack(mysqli $link, int $video_id, int $modpack_id): void {
    $query = "INSERT INTO videos_modpacks (video_id, modpack_id) VALUES ($video_id, $modpack_id)";
    if ($link->query($query) !== TRUE) {
        http_response_code(500);
        echo json_encode(['error' => 'Chyba pri priraďovaní k modpacku: ' . $link->error]);
        exit;
    }
}

function GetImageModpack($image_id) {
	global $link;
	$get_image_modpack = "SELECT b.modpack_id, b.modpack_name from pictures_modpacks a, modpacks b WHERE image_id = $image_id and a.modpack_id = b.modpack_id";
	//echo $get_image_modpack;
	$result=mysqli_query($link, $get_image_modpack);
	if ($result && $row = mysqli_fetch_array($result)) {
		$modpack_name = $row['modpack_name'];
		$modpack_id = $row['modpack_id'];
		$modpack_name = "<button class='button blue_button' modpack-id=$modpack_id name='image_modpack'>$modpack_name</button>";
	} else {
		$modpack_name = "<button class='button blue_button' name='image_modpack'>No modpack</button>" ; // Alebo nechaj prázdne: $modpack_name = "";
	}


	return $modpack_name;
}


function GetCountTags(){
	global $link;

	$query = "SELECT COUNT(*) as nr_of_records from tags_list";

	$result=mysqli_query($link, $query);

	$row = mysqli_fetch_array($result);

	 $nr_of_records= $row['nr_of_records'];

	return $nr_of_records;
}


function GetListModpacks() {
	global $link;
	$modpack_list="";
	$get_modpacks = "SELECT * from modpacks";
	//echo $get_video_modpack;
	$result=mysqli_query($link, $get_modpacks);
	while ($row = mysqli_fetch_array($result)) {
	$modpack_id = $row['modpack_id'];	
	$modpack_name = $row['modpack_name'];

	$modpack_list= $modpack_list."<button class='button blue_button' name='modpack' modpack-id=$modpack_id>$modpack_name</button>";
	}	
	return $modpack_list;
}


function GetVideoName($video_id) {
	global $link;
	//$mod_list="";
	$get_video_name = "SELECT video_title from videos WHERE video_id = $video_id";
	//echo $get_video_modpack;
	$result=mysqli_query($link, $get_video_name);
	while ($row = mysqli_fetch_array($result)) {
	
	$video_name = $row['video_title'];
	
	}	
	return $video_name;
}



function GetVideoMods($video_id) {
	global $link;
	$mod_list="";
	$get_video_mods = "SELECT b.cat_id, b.cat_name from videos_mods a, mods b WHERE video_id = $video_id and a.cat_id = b.cat_id";
	//echo $get_video_modpack;
	$result=mysqli_query($link, $get_video_mods);
	while ($row = mysqli_fetch_array($result)) {
	$mod_id = $row['cat_id'];	
	$mod_name = $row['cat_name'];

	$mod_list= $mod_list."<button class='button blue_button' mod-id=$mod_id>$mod_name</button>";
	}	
	return $mod_list;
}




function GetVideoModpack($video_id) {
	global $link;
	$get_video_modpack = "SELECT b.modpack_id, b.modpack_name from videos_modpacks a, modpacks b WHERE video_id = $video_id and a.modpack_id = b.modpack_id";
	//echo $get_video_modpack;
	$result=mysqli_query($link, $get_video_modpack);
	if ($result && $row = mysqli_fetch_array($result)) {
		$modpack_name = $row['modpack_name'];
		$modpack_id = $row['modpack_id'];
		$modpack_name = "<button class='button blue_button' modpack-id=$modpack_id name='video_modpack'>$modpack_name</button>";
	} else {
		$modpack_name = ""; // Alebo nechaj prázdne: $modpack_name = "";
	}


	return $modpack_name;
}


function GetAttachedImages($note_id) {
    global $link;
    
    $query = "SELECT COUNT(*) as images_count 
              FROM notes_file_attachements 
              WHERE note_id = ?";
              
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $note_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    
    mysqli_stmt_close($stmt);
    
    return (int)$row['images_count'];
}

function GetCountAllBasesImages(){
	global $link;
	$get_count_images = "SELECT COUNT(*) as images_count from vanila_base_images";
	$result=mysqli_query($link, $get_count_images);
	$row = mysqli_fetch_array($result);
	$images_count = $row['images_count'];
	return $images_count;

}

	
function convertLinks($string) {
    // Convert YouTube links
    $string = preg_replace(
        '#https?://youtu\.be/([a-zA-Z0-9_-]+)#i',
        '<a href="$0" target="_blank">$0</a>',
        $string
    );

    // Convert Imgur links
    $string = preg_replace(
        '#https?://imgur\.com/a/([a-zA-Z0-9_-]+)#i',
        '<a href="$0" target="_blank">$0</a>',
        $string
    );

    return $string;
}

	
	function GetModpacks() {
		global $link;
		$get_modpacks = "SELECT * from modpacks ORDER BY modpack_name";
		$result=mysqli_query($link, $get_modpacks);
		$modpacks ="";
		$modpacks.="<select name='modpack'>";
		while ($row = mysqli_fetch_array($result)) {
			$id = $row['modpack_id'];
			$name = $row['modpack_name'];
			$modpacks.="<option value=$id>$name</option>";
			}		
		$modpacks .="</select>";

		return $modpacks;
	}

	Function GetAllVideoTagPaginated(){
		global $link;
  	    
		$itemsPerPage = 10;

        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $itemsPerPage;  

  	    $tags ="";
  	 	$get_all_tags = "SELECT * from tags_list ORDER BY tag_name ASC LIMIT $itemsPerPage OFFSET $offset";
  	 	//echo $get_tags;
		$result=mysqli_query($link, $get_all_tags);

		while ($row = mysqli_fetch_array($result)) {
			   $tag_id= $row['tag_id'];
			   $tag_name= $row['tag_name'];

			   $tags .= "<button class='modal_tag' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			   
			   }

	return $tags;
	}


	function GetTotalPagesVideosTags(){

		global $link;

		 $itemsPerPage = 10;

		 $sql = "SELECT COUNT(*) as total FROM tags_list";
                $result=mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                //echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<button type="button" class="button app_badge">' . $i . '</button>';
                }
               // echo '</div>';	
	}

	Function GetAllVideoTags(){
		global $link;
  	    
  	    $tags ="";
  	 	$get_all_tags = "SELECT * from tags_list ORDER BY tag_name ASC";
  	 	//echo $get_tags;
		$result=mysqli_query($link, $get_all_tags);

		while ($row = mysqli_fetch_array($result)) {
			   $tag_id= $row['tag_id'];
			   $tag_name= $row['tag_name'];

			   $tags .= "<button class='modal_tag' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			   }
	
	return $tags;
	}



  function GetLastestRecVideoTags($video_id){
  	global $link;
  	$latest_rec = "SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id ORDER BY a.video_id DESC LIMIT 1";
  }	

  function GetCountVideoTags($video_id){
  	global $link;
  	    //get total numbers of records
  	    $tags ="";
		$count_all ="SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id";
  	    $count_result=mysqli_query($link, $count_all);
  	    $total = mysqli_num_rows($count_result);
  		
		//echo $total;
  	    
		$tags .= "<button class='button'>$total</button>";
  	 	$tags .= "<button class='button app_badge' name='new_tag' video-id=$video_id><i class='fa fa-plus'></i></button>";  

	return $total;

  }


  function GetImageTagListArray($picture_id) {
    global $link;

    // Optimalizovaný SQL dopyt
    $get_tags = "SELECT b.tag_name FROM pictures_tags a, tags_list b WHERE a.image_id = $picture_id AND a.tag_id = b.tag_id";
    $result = mysqli_query($link, $get_tags);

    // Vytvorte pole pre tagy
    $tags_array = array();

    // Získajte všetky tagy z databázy a pridajte ich do poľa
    while ($row = mysqli_fetch_array($result)) {
        $tags_array[] = $row['tag_name'];
    }

    // Vráťte pole tagov ako JSON reťazec
    return json_encode($tags_array);
}

function GetImageTagListByLetter($letter){

	global $link;

	$tags ="";

	$get_tags = "SELECT * from tags_list  where tag_name like '$letter%'";
	//echo $get_tags;
	$result=mysqli_query($link, $get_tags);
	while ($row = mysqli_fetch_array($result)) {
		$tag_id= $row['tag_id'];
		$tag_name= $row['tag_name'];

		$tags .= "<button class='button small_button' name='add_new_tag' tag-id=$tag_id>$tag_name</button>";
		};
	return $tags;
}


 function GetImageTags($picture_id) {
	global $link;
	$count_all ="SELECT a.image_id, a.tag_id, b.tag_name from pictures_tags a, tags_list b where a.image_id=$picture_id and a.tag_id = b.tag_id";
		$count_result=mysqli_query($link, $count_all);
		$total = mysqli_num_rows($count_result);

		$tags ="";
		 $get_tags = "SELECT a.image_id, a.tag_id, b.tag_name from pictures_tags a, tags_list b where a.image_id=$picture_id and a.tag_id = b.tag_id";
		 //echo $get_tags;
	  $result=mysqli_query($link, $get_tags);
		while ($row = mysqli_fetch_array($result)) {
			$tag_id= $row['tag_id'];
			$tag_name= $row['tag_name'];

			//$tags .= "<button class='button' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			$tags .= "<button class='button tag_button'>$tag_name</button>";
			};
  return $tags;
  }	



  function GetImageTagList($picture_id) {
	global $link;
	$count_all ="SELECT a.image_id, a.tag_id, b.tag_name from pictures_tags a, tags_list b where a.image_id=$picture_id and a.tag_id = b.tag_id";
		$count_result=mysqli_query($link, $count_all);
		$total = mysqli_num_rows($count_result);

		$tags ="";
		 $get_tags = "SELECT a.image_id, a.tag_id, b.tag_name from pictures_tags a, tags_list b where a.image_id=$picture_id and a.tag_id = b.tag_id";
		 //echo $get_tags;
	  $result=mysqli_query($link, $get_tags);
		while ($row = mysqli_fetch_array($result)) {
			$tag_id= $row['tag_id'];
			$tag_name= $row['tag_name'];

			//$tags .= "<button class='button' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			$tags .= "<button class='button small_button'>$tag_name</button>";
			}
	   
		//echo "<button class='button' name='video_tags_count'>".GetCountVideoTags($video_id)."</button>";	
		$tags .= "<button class='button small_button' name='new_tag' picture-id=$picture_id title='Add new tag'><i class='fa fa-plus'></i></button>";
  return $tags;
  }


  function GetVideoTagList($video_id) {
	global $link;
	$count_all ="SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id";
		$count_result=mysqli_query($link, $count_all);
		$total = mysqli_num_rows($count_result);

		$tags ="";
		 $get_tags = "SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id LIMIT 6";
		 //echo $get_tags;
	  $result=mysqli_query($link, $get_tags);
		while ($row = mysqli_fetch_array($result)) {
			$tag_id= $row['tag_id'];
			$tag_name= $row['tag_name'];

			//$tags .= "<button class='button' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			$tags .= "<button class='button small_button'>$tag_name</button>";
			}
	   
		//echo "<button class='button' name='video_tags_count'>".GetCountVideoTags($video_id)."</button>";	
		if($total>6){
		$tags = $tags. " <button class='button small_button' name='video_tags_count'>More...</button>";	
		} 
  return $tags;
  }
 
  function GetAllUnassignedVideosTags() {
	global $link;
	$tags="";
	//$get_all_tags ="SELECT * from tags_list b ORDER BY tag_name ASC";
	$get_all_tags ="SELECT * from tags_list WHERE LEFT(tag_name,1)='A' ORDER BY tag_name ASC";	
	  $result=mysqli_query($link, $get_all_tags);

	  while ($row = mysqli_fetch_array($result)) {
			 $tag_id= $row['tag_id'];
			 $tag_name= $row['tag_name'];
			  $tags .= "<button class='button small_button' tag-id=$tag_id name='add_new_tag'>$tag_name</button>";
			 }
			
  return $tags;
  }


/*  function GetVideoTags($video_id){
	global $link;
		//get total numbers of records
		$count_all ="SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id";
		$count_result=mysqli_query($link, $count_all);
		$total = mysqli_num_rows($count_result);

		$tags ="";
		 $get_tags = "SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id LIMIT 6";
		 //echo $get_tags;
	  $result=mysqli_query($link, $get_tags);

	  while ($row = mysqli_fetch_array($result)) {
			 $tag_id= $row['tag_id'];
			 $tag_name= $row['tag_name'];

			 $tags .= "<button class='button' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			 //$tags .= "<button class='button'>$tag_name</button>";
			 }
			 if($total>6){
				  $remain = intval($total) - 6;
				   $tags.="<button class='button'>+ $remain tags</button>";
			 }

  $tags .= "<button class='button app_badge' name='new_tag' video-id=$video_id><i class='fa fa-plus'></i></button>";  

  return $tags;
 
} */

function VideoTags($video_id){
  	global $link;
  	    $tags ="";
  	 	
		$get_tags = "SELECT a.video_id, a.tag_id, b.tag_name from video_tags a, tags_list b where a.video_id=$video_id and a.tag_id = b.tag_id";
		
  	 	//echo $get_tags;
		$result=mysqli_query($link, $get_tags);

		while ($row = mysqli_fetch_array($result)) {
			   $tag_id= $row['tag_id'];
			   $tag_name= $row['tag_name'];

			   //$tags .= "<button class='button' name='$tag_name' tag-id=$tag_id>$tag_name</button>";
			   //$tags .= "<li tag-id=$tag_id>$tag_name <i class='fa fa-times' onclick='remove(this, $tag_id)'></i></li>";
			   $tags .= "<button tag-id=$tag_id class='button small_button'>$tag_name <i class='fa fa-times' title='Close'></i></button>";
			   }
	     

	return $tags;

  }




  function getYouTubeVideoId($url) {
            $parsedUrl = parse_url($url);
            
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);

                if (isset($queryParams['v'])) {
                    return $queryParams['v'];
                }
            } elseif (isset($parsedUrl['path'])) {
                $pathSegments = explode('/', trim($parsedUrl['path'], '/'));

                if (in_array('shorts', $pathSegments) && count($pathSegments) === 2) {
                    return $pathSegments[1];
                }
            }

            return false;
        }


function GetCountMods(){
	global $link;

	$query = "SELECT COUNT(*) as nr_of_records from mods";

	$result=mysqli_query($link, $query);

	$row = mysqli_fetch_array($result);

	 $nr_of_records= $row['nr_of_records'];

	return $nr_of_records;
}


function GetCountLogRecords(){
	global $link;

	$query = "SELECT COUNT(*) as nr_of_records from app_log";

	$result=mysqli_query($link, $query);

	$row = mysqli_fetch_array($result);

	 $nr_of_records= $row['nr_of_records'];

	return $nr_of_records;
}


function GetBanseNameByID($base_id){
	global $link;
	$query="SELECT zakladna_id, zakladna_meno from vanila_suradnice WHERE zakladna_id=$base_id";
	$result=mysqli_query($link, $query);
	 $row = mysqli_fetch_array($result);
	$base_name = $row['zakladna_meno'];
	return $base_name;
}





function GetModName($mod_id) {
	global $link;
	$mod_name="";
	if($mod_id==0){
		$cat_name="";
	} else {
	$query="SELECT cat_name from mods where cat_id=$mod_id";
	$result=mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
		   $mod_name= $row['cat_name'];

	   }
	}   
	 return $mod_name;
  	
}

function GetModpackImage(){
	global $link;
	$modpack_id = $_GET['modpack_id'];
	$query = "SELECT modpack_image from modpacks WHERE modpack_id=$modpack_id";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	$modpack_image = $row['modpack_image'];

	return $modpack_image;
}



function GetModPackName($modpack_id){
	global $link;
	$modpack_name="";
	if($modpack_id==999){
		$modpack_name="Unspecified";
	} else {
	$query="SELECT modpack_name from modpacks where modpack_id=$modpack_id";
	$result=mysqli_query($link, $query);
   	while ($row = mysqli_fetch_array($result)) {
		$modpack_name= $row['modpack_name'];
		}
	}	
	return $modpack_name;	
}

function GetCountBases(){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_bases from vanila_bases";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_bases= $row['nr_of_bases'];
	return $nr_of_bases;	
}

function GetCountVanilaVideos(){
	global $link;
	$query = "SELECT COUNT(*) as vanila_videos from videos a, videos_modpacks b where b.modpack_id=0";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $vanila_videos= $row['vanila_videos'];
	return $vanila_videos;	
}

function GetCountVanilaNotes(){
	global $link;
	$query = "SELECT COUNT(*) as vanila_notes from notes where modpack_id=99";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $vanila_notes= $row['vanila_notes'];
	return $vanila_notes;	
}


function GetCountIdeas(){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_ideas from ideas";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_ideas= $row['nr_of_ideas'];
	return $nr_of_ideas;	
}

function GetCountIdeaComments($idea_id){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_comms from ideas_comments WHERE idea_id=$idea_id";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_comms= $row['nr_of_comms'];
	return $nr_of_comms;			
}


function GetCountBugs(){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_bugs from bugs";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_bugs= $row['nr_of_bugs'];
	return $nr_of_bugs;			
}


function GetCountBugComments($bug_id){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_comms from bugs_comments WHERE bug_id=$bug_id";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_comms= $row['nr_of_comms'];
	return $nr_of_comms;			
}


function GetCountModpackMods($modpack_id){
	global $link;
	$query = "SELECT COUNT(*) as nr_of_mods from modpack_mods WHERE modpack_id=$modpack_id";
	$result=mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	 $nr_of_mods= $row['nr_of_mods'];
	return $nr_of_mods;			
   }



function GetModList($modpack_id){
	global $link;
	$list="<ul>";
	$sql="SELECT * from modpack_mods where modpack_id=$modpack_id";
	$result=mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$mod_id=$row['mod_id'];
		$mod=GetModName($mod_id);
	    $list=$list."<li><span class='span_mod'>$mod</span></li>";
	   }	
	   $list.="<li><a class='span_mod' title='Add mod to this modpack' href='#'>+</a></li></ul>";
	return $list;
	//   return $mod;
}

function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
{
    $path = $uploadDir . '/' . $image_name;

    $mime = getimagesize($path);

    if($mime['mime']=='image/png') { 
        $src_img = imagecreatefrompng($path);
    }
    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
        $src_img = imagecreatefromjpeg($path);
    }   

    $old_x          =   imageSX($src_img);
    $old_y          =   imageSY($src_img);

    if($old_x > $old_y) 
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $old_y*($new_height/$old_x);
    }

    if($old_x < $old_y) 
    {
        $thumb_w    =   $old_x*($new_width/$old_y);
        $thumb_h    =   $new_height;
    }

    if($old_x == $old_y) 
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $new_height;
    }

    $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


    // New save location
    $new_thumb_loc = $moveToDir . $image_name;

    if($mime['mime']=='image/png') {
        $result = imagepng($dst_img,$new_thumb_loc,8);
    }
    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
        $result = imagejpeg($dst_img,$new_thumb_loc,80);
    }

    imagedestroy($dst_img); 
    imagedestroy($src_img);

    return $result;
}


//https://www.9lessons.info/2014/07/ajax-upload-and-resize-image-with-php.html

function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth)
{

if($ext=="jpg" || $ext=="jpeg" )
{
$src = imagecreatefromjpeg($uploadedfile);
}
else if($ext=="png")
{
$src = imagecreatefrompng($uploadedfile);
}
else if($ext=="gif")
{
$src = imagecreatefromgif($uploadedfile);
}
else
{
$src = imagecreatefrombmp($uploadedfile);
}

list($width,$height)=getimagesize($uploadedfile);
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
$filename = $path.$newwidth.'_'.$actual_image_name; //PixelSize_TimeStamp.jpg
imagejpeg($tmp,$filename,100);
imagedestroy($tmp);
return $filename;
}

function is_category_in_sync($cat_id){
	//connect 
}



function modpacks ($module){
	global $link;
	echo "<ul>";
	if($module=="tasks"){

		$sql="SELECT DISTINCTROW a.modpack_id, b.modpack_name from tasks a, modpacks b where a.modpack_id=b.modpack_id";
	} elseif ($module=="notes"){
		$sql="SELECT DISTINCTROW a.modpack_id, b.modpack_name from notes a, modpacks b where a.modpack_id=b.modpack_id";
	}

	$result=mysqli_query($link, $sql);
	while($row = mysqli_fetch_array($result)) {
		$modpack_name=$row['modpack_name'];
		$modpack_id=$row['modpack_id'];
		echo "<li class='span_modpack'><a href='$module.php?modpack_id=$modpack_id'>$modpack_name</a></li>";
	}
   echo "<ul>";	
}

/**
 * Generates a Universally Unique IDentifier, version 4.
 *
 * RFC 4122 (http://www.ietf.org/rfc/rfc4122.txt) defines a special type of Globally
 * Unique IDentifiers (GUID), as well as several methods for producing them. One
 * such method, described in section 4.4, is based on truly random or pseudo-random
 * number generators, and is therefore implementable in a language like PHP.
 *
 * We choose to produce pseudo-random numbers with the Mersenne Twister, and to always
 * limit single generated numbers to 16 bits (ie. the decimal value 65535). That is
 * because, even on 32-bit systems, PHP's RAND_MAX will often be the maximum *signed*
 * value, with only the equivalent of 31 significant bits. Producing two 16-bit random
 * numbers to make up a 32-bit one is less efficient, but guarantees that all 32 bits
 * are random.
 *
 * The algorithm for version 4 UUIDs (ie. those based on random number generators)
 * states that all 128 bits separated into the various fields (32 bits, 16 bits, 16 bits,
 * 8 bits and 8 bits, 48 bits) should be random, except : (a) the version number should
 * be the last 4 bits in the 3rd field, and (b) bits 6 and 7 of the 4th field should
 * be 01. We try to conform to that definition as efficiently as possible, generating
 * smaller values where possible, and minimizing the number of base conversions.
 *
 * @copyright  Copyright (c) CFD Labs, 2006. This function may be used freely for
 *              any purpose ; it is distributed without any form of warranty whatsoever.
 * @author      David Holmes <dholmes@cfdsoftware.net>
 *
 * @return  string  A UUID, made up of 32 hex digits and 4 hyphens.
 */

function uuid() {
  
	// The field names refer to RFC 4122 section 4.1.2
 
	return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
		mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
		mt_rand(0, 65535), // 16 bits for "time_mid"
		mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
		bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
		mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node" 
	); 
 }


 function GetNrOfComments($video_id){
	 global $link;
	 $sql ="SELECT COUNT(*) as nr_of_comments from video_comments where video_id=".$video_id;
	 $result=mysqli_query($link, $sql);
	 $row = mysqli_fetch_array($result);
	 $nr_of_comments=$row['nr_of_comments'];	
	 return $nr_of_comments;
    
 }

function  GetNrOfImageComments($picture_id){
	global $link;
	$sql ="SELECT COUNT(*) as nr_of_comments from picture_comments where pic_id=$picture_id";
	$result=mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$nr_of_comments=$row['nr_of_comments'];	
	return $nr_of_comments;
 }

 function GetCountNewestNotes(){
	global $link;
	$sql="SELECT COUNT(*) as nr_notes from notes WHERE date(added_date) BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY note_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_notes = $row['nr_notes'];
	
	return $nr_notes;
  }  

  function GetCountNotes(){
	global $link;
	$sql="SELECT COUNT(*) as nr_notes from notes ORDER BY note_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_notes = $row['nr_notes'];
	
	return $nr_notes;
  }  

   function GetCountVanillaNotes(){
	global $link;
	$sql="SELECT COUNT(*) as nr_notes from vanila_base_notes ORDER BY note_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_notes = $row['nr_notes'];
	
	return $nr_notes;
  }  

  function GetCountNewestVanillaNotes(){
	global $link;
	$sql="SELECT COUNT(*) as nr_new_notes from vanila_base_notes WHERE date(added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY note_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_new_notes = $row['nr_new_notes'];
	
	return $nr_new_notes;
  }  


  function GetCountTasks(){
	global $link;
	$sql="SELECT COUNT(*) as nr_tasks from tasks ORDER BY task_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_tasks = $row['nr_tasks'];
	
	return $nr_tasks;
  }

     function GetCountBases_old(){
	global $link;
	$sql="SELECT COUNT(*) as nr_bases from vanila_suradnice ORDER BY zakladna_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_bases = $row['nr_bases'];
	
	return $nr_bases;
  }

   function GetCountNewestBases(){
	global $link;
	$sql="SELECT COUNT(*) as nr_new_bases from vanila_suradnice WHERE date(added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY zakladna_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_new_bases = $row['nr_new_bases'];
	
	return $nr_new_bases;
  }  


  function GetCountVanillaTasks(){
	global $link;
	$sql="SELECT COUNT(*) as nr_tasks from vanila_base_tasks ORDER BY task_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_tasks = $row['nr_tasks'];
	
	return $nr_tasks;
  }  

   function GetCountNewestVanillaTasks(){
	global $link;
	$sql="SELECT COUNT(*) as nr_tasks from vanila_base_tasks WHERE date(added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY task_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_tasks = $row['nr_tasks'];
	
	return $nr_tasks;
  }  


   function GetCountVanillaIdeas(){
	global $link;
	$sql="SELECT COUNT(*) as nr_ideas from vanila_base_ideas ORDER BY idea_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_ideas = $row['nr_ideas'];
	
	return $nr_ideas;
  }

   function GetCountNewestVanillaIdeas(){
	global $link;
	$sql="SELECT COUNT(*) as nr_ideas from vanila_base_ideas WHERE date(added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY idea_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_ideas = $row['nr_ideas'];
	
	return $nr_ideas;
  }  



  function GetCountVideos(){
	global $link;
	$sql="SELECT COUNT(*) as nr_videos from videos ORDER BY video_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_videos = $row['nr_videos'];
	
	return $nr_videos;
  }  
 


  function GetCountNewestVideos(){
	global $link;
	$sql="SELECT COUNT(*) as nr_videos from videos WHERE date(added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY video_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_videos = $row['nr_videos'];
	
	return $nr_videos;
  }  


  function GetCountVanillaVideos(){
	global $link;
	$sql="SELECT COUNT(*) AS nr_videos from videos_modpacks WHERE modpack_id=0";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_videos = $row['nr_videos'];
	
	return $nr_videos;
  }  
 
     
  function GetCountNewestVanillaVideos(){
	global $link;
	$sql="SELECT COUNT(*) as nr_videos from videos a, videos_modpacks b WHERE date(a.added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) and b.modpack_id=0";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_videos = $row['nr_videos'];
	
	return $nr_videos;
  }  



  function GetCountNewestTasks(){
	global $link;
	$sql="SELECT COUNT(*) as nr_tasks from tasks WHERE date(added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY task_id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_tasks = $row['nr_tasks'];
	
	return $nr_tasks;
  }  



  

  
  function GetCountNewestComments(){
	global $link;
	$sql="SELECT COUNT(*) as nr_comments from video_comments WHERE date(added_date)  BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 3 DAY) AND DATE(NOW()) ORDER BY id DESC";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_comments = $row['nr_comments'];
	
	return $nr_comments;
  }

  function GetCountModpacks(){
	global $link;
	$sql="SELECT COUNT(*) as nr_modpacks from modpacks";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_modpacks = $row['nr_modpacks'];
	
	return $nr_modpacks;
  } 
  
  function GetCountActiveModpacks(){
	global $link;
	$sql="SELECT COUNT(*) as nr_active_modpacks from modpacks WHERE is_active=1";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_active_modpacks = $row['nr_active_modpacks'];
	
	return $nr_active_modpacks;
  }  
 
  
  function GetCountInactiveModpacks(){
	global $link;
	$sql="SELECT COUNT(*) as nr_inactive_modpacks from modpacks WHERE is_active=0";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_inactive_modpacks = $row['nr_inactive_modpacks'];
	
	return $nr_inactive_modpacks;
  } 
 
  function GetCountImages(){
	global $link;
	$sql="SELECT COUNT(*) as nr_images from pictures";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$nr_images = $row['nr_images'];
	
	return $nr_images;
  } 

  function GetMaxBaseId(){
	global $link;  
	$sql="SELECT MAX(zakladna_id) as max_base_id from vanila_suradnice";
	$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
	$row = mysqli_fetch_array($result);
	$max_id = $row['max_base_id'];

	return $max_id;
  }

  function GetCountBaseTasks($base_id){
	global $link;  
	  $nr_tasks = "SELECT COUNT(*) as nr_base_tasks from vanila_base_tasks WHERE zakladna_id=".$base_id;
	  $result = mysqli_query($link, $nr_tasks) or die("MySQLi ERROR: ".mysqli_error($link));
	  $row = mysqli_fetch_array($result);
	  $nr_base_tasks = $row['nr_base_tasks'];

	  return $nr_base_tasks;
  }

  function GetCountBaseNotes($base_id){
	global $link;
	$sql="SELECT count(*) as nr_of_notes from vanila_base_notes where zakladna_id=$base_id";
	//echo $sql;
	$result=mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$nr_of_notes=$row['nr_of_notes'];

	return $nr_of_notes;
}

 function GetCountBaseIdeas($base_id){
	global $link;
	$sql="SELECT count(*) as nr_of_ideas from vanila_base_ideas where zakladna_id=$base_id";
	//echo $sql;
	$result=mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$nr_of_ideas=$row['nr_of_ideas'];

	return $nr_of_ideas;
}