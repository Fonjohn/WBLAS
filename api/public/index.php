<?php
// public/index.php

require '../vendor/autoload.php';  // If using Composer
require '../src/routes/routes.php';

// Set the content type to JSON
header('Content-Type: application/json');

// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Route the request
$routeFound = false;
foreach ($routes as $route => $handler) {
    if (preg_match("~^$route$~", $requestUri, $matches)) {
        $routeFound = true;
        array_shift($matches); // Remove the full match from the matches
        call_user_func_array($handler, $matches);
        break;
    }
}

if (!$routeFound) {
    echo json_encode(['error' => 'Endpoint not found'], JSON_PRETTY_PRINT);
}
