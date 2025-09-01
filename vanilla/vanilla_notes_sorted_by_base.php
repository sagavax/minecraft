  <?php

      include("../includes/dbconnect.php");
      include("../includes/functions.php");

      $base_id = $_GET['base_id'];

  $sql="SELECT * from vanila_base_notes  WHERE base_id = $base_id ORDER BY note_id DESC";

                    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                    while($row = mysqli_fetch_array($result)){
                         $id = $row['note_id'];
                        $note_text = $row['note_text'];
                        $note_title = $row['note_title'];
                        $added_date = $row['added_date'];
                        $base_id = $row['base_id'];

                        $note_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $note_text);
                        
                         $zakladna = GetBanseNameByID($base_id);

                        echo "<div class='base_note' note-id='$id'>";
                            echo "<div class='vanila_note_title'>".$note_title."</div>";
                            echo "<div class='vanila_note_text'>".$note_text."</div>";
                            echo "<div class='vanila_note_act'><span class='span_modpack'>$zakladna</span><button class='button small_button' btn-id=$id);'><i class='fa fa-times' title='Delete note'></i></button></div>";
                        echo "</div>";
                  }