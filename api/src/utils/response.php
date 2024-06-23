<?php
// src/utils/response.php

function sendResponse($status, $data = null) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sendError($message, $status = 500) {
    sendResponse($status, ['error' => $message]);
}
?>
