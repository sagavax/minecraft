<?php
$backupDirectory = 'backups/';

// Check if the directory exists
if (is_dir($backupDirectory)) {
    // Get all files in the directory
    $files = scandir($backupDirectory);

    // Remove . and .. from the list
    $files = array_diff($files, array('.', '..'));

    // Loop through each file and delete it
    foreach ($files as $file) {
        $filePath = $backupDirectory . $file;
        if (is_file($filePath)) {
            // Delete the file
            if (unlink($filePath)) {
               // echo "File '$file' deleted successfully.<br>";

                $diary_text="Minecraft IS: Subor <b>$file</b> vymazane";
				$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
				$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));


            } else {
                echo "Failed to delete file '$file'.
                <br>";
            }
        }
    }
} else {
    echo "Backup directory '$backupDirectory' does not exist.";
}

 $diary_text="Minecraft IS: Zalohy boli vymazane";
 $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
 $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

?>
