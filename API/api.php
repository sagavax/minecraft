<?php
header('Content-Type: application/json');

$endpoint = $_GET['endpoint'] ?? '';

$method = $_SERVER['REQUEST_METHOD'];

//volanie endpointov
/* //api/api.php?endpoint=products alebo /api/api.php?endpoint=users */

switch ($endpoint) {
    case 'videos':
        if ($method === 'GET') {
            require 'videos.php';
        } elseif ($method === 'POST') {
            // Tu spracuj vytvorenie nového videa
            require 'create_video.php';
        } else if ($method === 'DELETE') {
           require 'delete_video.php';
        }
        elseif ($method === 'PUT' || $method === 'PATCH') {
       require 'update_video.php'; // napríklad
      }  
         else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;

    case 'tags':
        if ($method === 'GET') {
            require 'tags.php';
        } elseif ($method === 'POST') {
            // Tu spracuj vytvorenie novej tagy
            require 'create_tags.php';
        } elseif ($method === 'DELETE') {
            require 'delete_tags.php';
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
      

    // Pridaj ďalšie endpointy podľa potreby

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}