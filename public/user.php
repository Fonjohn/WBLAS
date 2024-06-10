<?php
$user_id = $_GET['user_id'];
$room_code = $_GET['room_code'];

try {
    $db = new PDO('sqlite:room_codes.db');

    // Get the user details
    $stmt = $db->prepare('SELECT * FROM users WHERE id = :user_id');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
    <h2>Room Code: <?php echo htmlspecialchars($room_code); ?></h2>
    
    <form action="send_message.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <input type="hidden" name="room_code" value="<?php echo htmlspecialchars($room_code); ?>">
        <label for="message">Message:</label>
        <input type="text" id="message" name="message" required>
        <button type="submit">Send Message</button>
    </form>
</body>
</html>
