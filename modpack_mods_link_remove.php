    <?php
        include("includes/dbconnect.php");
        include("includes/functions.php");


        $link_id = $_POST['link_id'];
        $modpack_id = $_POST['modpack_id'];

        $remove_link = "DELETE from modpack_mods_links WHERE link_id=$link_id and modpack_id=$modpack_id";
        $result = mysqli_query($link, $remove_link) or die("MySQLi ERROR: ".mysqli_error($link));


        //add to log
        $diary_text= "Link s id $link_id bol vymazany z modpacku s id $modpack_id";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));