<?php include "includes/dbconnect.php";


//var_dump($_GET);
$video_url= $_GET['video_id'];
//$video_url="https://www.youtube.com/watch?v=ughu2Aa4ODU";
$sql="SELECT count(*) as videos from videos where video_url='$video_url'";
//echo $sql;
$result=mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
  $nr_videos= $row['videos'];
  
} 

echo $nr_videos;
//echo "banzaaaaaaaaaaaaaaai";
