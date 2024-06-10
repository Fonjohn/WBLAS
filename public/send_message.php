<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $room_code = $_POST['room_code'];
    $message = $_POST['message'];

    try {
        $db = new PDO('sqlite:room_codes.db');

        // Insert the message into the messages table
        $stmt = $db->prepare('INSERT INTO messages (user_id, room_code, message) VALUES (:user_id, :room_code, :message)');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':room_code', $room_code);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // Redirect back to the user page
        header("Location: user.php?user_id=" . $user_id . "&room_code=" . $room_code);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
