<?php
// src/controllers/PlayerController.php

require_once '../src/config/database.php';
require_once '../src/models/Player.php';

class PlayerController {
    private $db;
    private $player;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->player = new Player($this->db);
    }

    public function getAvailablePlayers() {
        $stmt = $this->player->getAvailablePlayers();
        $players = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($players, JSON_PRETTY_PRINT);
    }

    // Other methods for handling player-related requests...
}
