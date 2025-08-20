  <?php

      include("includes/dbconnect.php");
      include("includes/functions.php");

      $base_id = $_GET['base_id'];

  $sql="SELECT * from vanila_base_ideas  WHERE base_id = $base_id ORDER BY idea_id DESC";

                    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
                    while($row = mysqli_fetch_array($result)){
                        $idea_id = $row['idea_id'];
                        $idea_text = $row['idea_text'];
                        $base_id = $row['base_id'];

                        $idea_text=preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a href=\"\\0\">\\0</a>", $idea_text);
                        
                        echo "<div class='idea vanilla_idea' idea-id=$idea_id>"; //idea
                        echo "<div class='idea_body'>$idea_text</div>";
                        echo "<div class='idea_footer'>";
                             echo "<div class='vanila_note_act'>";
                               
                               $base_name =  GetBanseNameByID($base_id);

                          echo "<div class='span_modpack'>$base_name</div><button class='button small_button' idea_id=$idea_id><i class='fa fa-times' title='Delete idea'></i></button></div>";
                          echo "</div>"; //footer
                    echo "</div>";// idea
                  }