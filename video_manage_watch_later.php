  <?php include "includes/dbconnect.php";

          $video_id=intval($_POST['video_id']);
          $watch_later = $_POST['watch_later'];
          //$video_name=mysqli_real_escape_string($link, $_POST['video_name']);
          $sql="UPDATE videos set watch_later=$watch_later where video_id=$video_id";
          $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));