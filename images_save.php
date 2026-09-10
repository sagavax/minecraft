<?php
include "includes/dbconnect.php";
include "includes/functions.php";

header("Content-Type: application/json; charset=utf-8");

// Any leftover output from the includes would corrupt the JSON payload.
if (ob_get_level() === 0) {
  ob_start();
}

function respond($payload, $httpStatus = 200) {
  if (ob_get_level() > 0) {
    ob_end_clean();
  }
  http_response_code($httpStatus);
  echo json_encode($payload);
  exit();
}

if (!isset($_POST['image_name'], $_POST['image_url'])) {
  respond(array("status" => "error", "message" => "Missing image_name or image_url."), 400);
}

$image_name        = mysqli_real_escape_string($link, $_POST['image_name']);
$sripped_image_name = strip_tags($image_name);
$pure_image_name   = html_entity_decode($sripped_image_name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$image_url         = mysqli_real_escape_string($link, $_POST['image_url']);
$image_description = mysqli_real_escape_string($link, isset($_POST['image_description']) ? $_POST['image_description'] : '');
$modpack_id        = isset($_POST['modpack_id']) ? mysqli_real_escape_string($link, $_POST['modpack_id']) : 2;

try {
  $add_image = "INSERT INTO pictures (picture_title, picture_description, picture_name, picture_path, added_date)
                VALUES ('$pure_image_name', '$image_description', '$image_url', '$image_url', now())";
  if (!mysqli_query($link, $add_image)) {
    throw new Exception(mysqli_error($link));
  }

  $image_id = mysqli_insert_id($link);

  $cat_id = 0;
  $insert_into_mods = "INSERT INTO pictures_mods (image_id, cat_id, created_date) VALUES ($image_id, $cat_id, now())";
  if (!mysqli_query($link, $insert_into_mods)) {
    throw new Exception(mysqli_error($link));
  }

  $insert_into_modpacks = "INSERT INTO pictures_modpacks (image_id, modpack_id, created_date) VALUES ($image_id, $modpack_id, now())";
  if (!mysqli_query($link, $insert_into_modpacks)) {
    throw new Exception(mysqli_error($link));
  }

  $diary_text = "Minecraft IS: Bol pridany novy obrazok s nazvom <strong>$image_name</strong>";
  $sql = "INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
  mysqli_query($link, $sql); // wall entry is best-effort, don't fail the request over it

} catch (Throwable $e) {
  respond(array("status" => "error", "message" => "Database error while saving image.", "detail" => $e->getMessage()), 500);
}

respond(array(
  "status"   => "success",
  "message"  => "Image added successfully",
  "image_id" => $image_id,
));
