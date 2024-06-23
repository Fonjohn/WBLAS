<?php
// src/routes/routes.php

require_once '../src/controllers/AuctionController.php';
require_once '../src/controllers/PlayerController.php';
require_once '../src/controllers/UserController.php';

$routes = [
    '/api/auctions/active' => function() {
        $controller = new AuctionController();
        $controller->getActiveAuctions();
    },
    '/api/players/available' => function() {
        $controller = new PlayerController();
        $controller->getAvailablePlayers();
    },
    '/api/users/:id/inventory' => function($userId) {
        $controller = new UserController();
        $controller->getUserInventory($userId);
    },
    // Add more routes as needed...
];
