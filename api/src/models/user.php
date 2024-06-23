<?php
// src/models/User.php

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $funds;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserInventory($userId) {
        $query = "SELECT dp.*, p.name, p.nfl_team, p.position 
                  FROM drafted_players dp
                  JOIN players p ON dp.player_id = p.id
                  WHERE dp.owner_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt;
    }

    // Other methods for CRUD operations on users...
}
