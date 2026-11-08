<?php

    include ("includes/dbconnect.php");
    include("includes/functions.php");

    header('Content-Type: application/json');

    $image_id = (int)($_POST['image_id'] ?? 0);

    if ($image_id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid image id."]);
        exit;
    }

    // tabuľka => stĺpec s ID obrázka
    $related_tables = [
        "pictures_tags"           => "image_id",
        "picture_comments"        => "pic_id",
        "pictures_mods"           => "image_id",
        "pictures_modpacks"       => "image_id",
        "pictures_gallery_images" => "picture_id",
        "pictures"                => "picture_id",
    ];

    mysqli_begin_transaction($link);

    try {
        foreach ($related_tables as $table => $column) {
            if (!mysqli_query($link, "DELETE FROM $table WHERE $column = $image_id")) {
                throw new Exception(mysqli_error($link));
            }
        }
        mysqli_commit($link);
    } catch (Throwable $e) {
        mysqli_rollback($link);
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Database error while deleting image.", "detail" => $e->getMessage()]);
        exit;
    }

    // log (best-effort)
    $diary_text = "Minecraft IS: Bol vymazany obrazok s ID $image_id";
    mysqli_query($link, "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())");

    echo json_encode(["success" => true, "message" => "Image removed successfully."]);
