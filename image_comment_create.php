<?php
include("includes/dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získaj a ošetri vstupy
    $image_id = isset($_POST['image_id']) ? intval($_POST['image_id']) : 0;
    $comment = isset($_POST['comment_text']) ? mysqli_real_escape_string($link, $_POST['comment_text']) : '';

    // Validácia: nezmyselný alebo prázdny komentár?
    if ($image_id <= 0 || empty($comment)) {
        http_response_code(400);
        echo json_encode(["error" => "Neplatný vstup"]);
        exit;
    }

    // Vytvorenie komentára
    $create_comment = "
        INSERT INTO picture_comments (pic_id, comment, comment_date)
        VALUES ($image_id, '$comment', NOW())
    ";
    $result = mysqli_query($link, $create_comment);

    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Chyba pri ukladaní komentára: " . mysqli_error($link)]);
        exit;
    }

    // Záznam do logu
    $diary_text = "Bol pridaný nový komentár k obrázku ID <b>$image_id</b>";
    $log_sql = "
        INSERT INTO app_log (diary_text, date_added)
        VALUES ('$diary_text', NOW())
    ";
    $log_result = mysqli_query($link, $log_sql);

    if (!$log_result) {
        http_response_code(500);
        echo json_encode(["error" => "Komentár bol uložený, ale log zlyhal."]);
        exit;
    }

    // Všetko prebehlo OK
    echo json_encode(["success" => true]);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Nepovolená metóda"]);
}
?>

