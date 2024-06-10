<?php
$room_code = $_GET['code'];

try {
    $db = new PDO('sqlite:room_codes.db');

    // Get the room details
    $stmt = $db->prepare('SELECT * FROM rooms WHERE code = :code');
    $stmt->bindParam(':code', $room_code);
    $stmt->execute();
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get the users in the room
    $stmt = $db->prepare('SELECT * FROM users WHERE room_code = :room_code');
    $stmt->bindParam(':room_code', $room_code);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the messages in the room
    $stmt = $db->prepare('SELECT users.name, messages.message, messages.created_at FROM messages JOIN users ON messages.user_id = users.id WHERE messages.room_code = :room_code ORDER BY messages.created_at ASC');
    $stmt->bindParam(':room_code', $room_code);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room <?php echo htmlspecialchars($room_code); ?></title>
</head>
<body>
    <h1>Room Code: <?php echo htmlspecialchars($room_code); ?></h1>
    <h2>Users in Room:</h2>
    <ul>
        <?php foreach ($users as $user) : ?>
            <li><?php echo htmlspecialchars($user['name']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Messages:</h2>
    <ul>
        <?php foreach ($messages as $message) : ?>
            <li><strong><?php echo htmlspecialchars($message['name']); ?>:</strong> <?php echo htmlspecialchars($message['message']); ?> <em>(<?php echo $message['created_at']; ?>)</em></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
