<?php
/**
* Updated: Mohammad M. AlBanna
* Updated: Tomas Misura
* Website: MBanna.info
*/

//MySQL server and database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'minecraft_db';
$tables = '*';

//Call the core function
backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables);

//Core function
function backup_tables($host, $user, $pass, $dbname, $tables = '*') {
    $link = mysqli_connect($host,$user,$pass, $dbname);

    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    mysqli_query($link, "SET NAMES 'utf8'");

    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    $return = '';
    //cycle through
    foreach($tables as $table)
    {
        $result = mysqli_query($link, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        $num_rows = mysqli_num_rows($result);

        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        $counter = 1;

        //Over tables
        for ($i = 0; $i < $num_fields; $i++) 
        {   //Over rows
            while($row = mysqli_fetch_row($result))
            {   
                if($counter == 1){
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                } else{
                    $return.= '(';
                }

                //Over fields
                for($j=0; $j<$num_fields; $j++) 
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }

                if($num_rows == $counter){
                    $return.= ");\n";
                } else{
                    $return.= "),\n";
                }
                ++$counter;
            }
        }
        $return.="\n\n\n";
    }

    //save file
    $fileName = 'backups/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
    //insert it in to database
    #save_file 

    $handle = fopen($fileName,'w+');
    fwrite($handle,$return);
    if(fclose($handle)){
        echo "Done, the file name is: ".$fileName;


    
    $filesize = filesize($fileName);
    $save_file = "INSERT INTO backup_files (file_name, file_size, file_backup_date) VALUES ('$fileName',$filesize,now())";
    mysqli_query($link, $save_file) or die(mysqli_error($link));

    $diary_text="Minecraft IS: Bola vytvorena zaloha, subor <b>$fileName</b> s velkostou <b>$filesize</b> ";
    $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

    //Check if there is just 7 files in folder Backup, if yes delete delete the oldest
    $folder = 'Backups';
    $files = array_diff(scandir($folder), array('..', '.'));

    if (count($files) == 7) {
        $oldestTime = time();
        $oldestFile = '';

        foreach ($files as $file) {
            $filePath = "$folder/$file";
            $fileTime = filemtime($filePath);
            if ($fileTime < $oldestTime) {
                $oldestTime = $fileTime;
                $oldestFile = $filePath;
            }
        }

        if ($oldestFile != '') {
            if (unlink($oldestFile)) {
                
                $diary_text="Minecraft IS: Subor <b>$oldestFile</b> bol vymazany";
                $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
                $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

            } else {
                echo "There was an error deleting the file '$oldestFile'.";
            }
        } else {
            echo "No files found in the directory.";
        }
    } else {
        echo "There are not exactly 7 files in the directory. No files have been deleted.";
    }

        exit; 
    }
}
?>
