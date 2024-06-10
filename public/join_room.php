<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $room_code = $_POST['room_code'];

    try {
        $db = new PDO('sqlite:room_codes.db');

        // Check if the room code exists
        $stmt = $db->prepare('SELECT * FROM rooms WHERE code = :code');
        $stmt->bindParam(':code', $room_code);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Insert the user into the users table
            $stmt = $db->prepare('INSERT INTO users (name, room_code) VALUES (:name, :room_code)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':room_code', $room_code);
            $stmt->execute();

            // Get the user ID
            $user_id = $db->lastInsertId();

            // Redirect to the user page
            header("Location: user.php?user_id=" . $user_id . "&room_code=" . $room_code);
            exit();
        } else {
            echo "Invalid room code.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
