<?php
// src/controllers/AuctionController.php

require_once '../src/config/database.php';
require_once '../src/models/Auction.php';

class AuctionController {
    private $db;
    private $auction;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->auction = new Auction($this->db);
    }

    public function getActiveAuctions() {
        $stmt = $this->auction->getActiveAuctions();
        $auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($auctions, JSON_PRETTY_PRINT);
    }

    // Other methods for handling auction-related requests...
}
