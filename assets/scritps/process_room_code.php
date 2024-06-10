<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_code = $_POST['room_code'];

    try {
        $db = new PDO('sqlite:room_codes.db');

        $stmt = $db->prepare('SELECT * FROM rooms WHERE code = :code');
        $stmt->bindParam(':code', $room_code);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Room code is valid.";
        } else {
            echo "Room code is invalid.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
