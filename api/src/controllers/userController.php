<?php
// src/controllers/UserController.php

require_once '../src/config/database.php';
require_once '../src/models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function getUserInventory($userId) {
        $stmt = $this->user->getUserInventory($userId);
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($inventory, JSON_PRETTY_PRINT);
    }

    // Other methods for handling user-related requests...
}
