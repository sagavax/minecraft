<?php include "includes/dbconnect.php";


//var_dump($_GET);
$video_title= $_GET['video_title'];
//$video_url="https://www.youtube.com/watch?v=ughu2Aa4ODU";
$sql="SELECT count(*) as videos from videos where video_title='$video_title'";
//echo $sql;
$result=mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
  $nr_videos= $row['videos'];
  
} 

echo $nr_videos;
//echo "banzaaaaaaaaaaaaaaai";
