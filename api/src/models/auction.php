<?php
// src/models/Auction.php

class Auction {
    private $conn;
    private $table_name = "player_auctions";

    public $id;
    public $player_id;
    public $current_bid;
    public $highest_bidder_id;
    public $end_time;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getActiveAuctions() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Other methods for CRUD operations on auctions...
}
