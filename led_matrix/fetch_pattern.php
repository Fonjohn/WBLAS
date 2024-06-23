<?php
header('Content-Type: application/json'); // Set response type to JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if request is POST
    $input = strtoupper($_POST['char']); // Get 'char' from POST, convert to uppercase
    
    $db = new SQLite3('patterns.db'); // Connect to the SQLite database
        $stmt = $db->prepare('SELECT row_1, row_2, row_3, row_4, row_5, row_6, row_7 FROM patterns WHERE character = :character'); // Prepares an SQL statement to fetch rows for the given character. It uses a placeholder :character to prevent SQL injection.
        $stmt->bindValue(':character', $input, SQLITE3_TEXT); // Binds the input character to the :character placeholder in the SQL statement, treating it as text.
        $result = $stmt->execute(); // Executes the prepared statement, which queries the database for the corresponding pattern.
        $row = $result->fetchArray(SQLITE3_ASSOC); // Fetches the resulting row as an associative array where each key corresponds to a column name.

        if ($row) { // If a row is found
            $pattern = implode(',', array_values($row)); // Combine row values into a single comma-separated string
            echo json_encode(['pattern' => $pattern]); // Return the pattern as a JSON object
        } else {
            echo json_encode(['pattern' => '']); // Return an empty pattern if no row found
        }

    $db->close(); // Close the database connection
    
}
?>
