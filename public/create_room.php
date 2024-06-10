<?php
function generateRoomCode($length = 4) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_code = generateRoomCode();

    try {
        $db = new PDO('sqlite:room_codes.db');

        // Insert the new room code into the database
        $stmt = $db->prepare('INSERT INTO rooms (code) VALUES (:code)');
        $stmt->bindParam(':code', $new_code);
        $stmt->execute();

        // Redirect to the new room page
        header("Location: room.php?code=" . $new_code);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
