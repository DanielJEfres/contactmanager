<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

function validatePostRequest() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse(false, "Invalid request method. Only POST is allowed");
    }
}

function sendResponse($success, $message, $data = null) {
    $response = [
        "success" => $success,
        "message" => $message,
        "data"    => $data
    ];

    echo json_encode($response);
    exit();
}
?>