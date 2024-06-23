<?php
// src/models/Player.php

class Player {
    private $conn;
    private $table_name = "players";

    public $id;
    public $nfl_team;
    public $position;
    public $name;
    public $salary;
    public $owner_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAvailablePlayers() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE owner_id IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Other methods for CRUD operations on players...
}
