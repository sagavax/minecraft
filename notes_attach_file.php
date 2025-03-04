<?php 
include("includes/dbconnect.php");

$note_id = $_POST['note_id'];
//var_dump($_FILES);

if(!empty($_FILES['image'])){
    $targetDir = 'gallery/note_attach_'.$note_id.'/';
    if (!is_dir($targetDir)) {
    	mkdir($targetDir, 0775, true);
    }	
   
    $filename = basename($_FILES['image']['name']);
    $file_type = $_FILES['image']['type'];
    $targetFilePath = $targetDir.$filename;

    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)){
        $file_size = $_FILES['image']['size'];
        $save_file = "INSERT INTO notes_file_attachements (note_id, file_name, file_type, file_size,added_date) VALUES ($note_id,'$filename','$file_type',$file_size,now())";
        mysqli_query($link, $save_file) or die(mysqli_error($link));

    }
}

echo "<script>alert('The file has been uploaded');
	window.location.href='notes.php'
</script>"
?>