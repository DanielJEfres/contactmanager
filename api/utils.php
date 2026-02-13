<?php

function sendResponse($success, $message, $data = null) {

    header('Content-Type: application/json');

    $response = [
        "success" => $success,
        "message" => $message,
        "data"    => $data
    ];

    echo json_encode($response);
    exit();
}
?>