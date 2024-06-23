<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Status Board</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <?php
    // Function to format starter player data into a card layout
    if (!function_exists('starterCard')) {
        function starterCard($playerData) {
            if ($playerData) {
                list($name, $salary, $team) = explode('|', $playerData);
                return "<div class='starter-card'>
                            <strong>$name</strong>
                            <p>Team: $team</p>
                            <p>Salary: $$salary</p>
                        </div>";
            } else {
                return "<div class='no-player'>No Player</div>";
            }
        }
    }

    // Function to format bench player data into a card layout
    if (!function_exists('benchCard')) {
        function benchCard($playerData) {
            if ($playerData) {
                list($name, $salary, $team) = explode('|', $playerData);
                return "<div class='bench-card'>
                            <strong>$name</strong>
                            <p>Team: $team</p>
                            <p>Salary: $$salary</p>
                        </div>";
            } else {
                return "<div class='no-player'>No Player</div>";
            }
        }
    }

    // Fetch the auction status board data
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=auction_db', 'root', 'mysql');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the query to fetch from the view
        $stmt = $pdo->query('SELECT * FROM auction_status_board');

        // Fetch the results
        $statusBoard = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the results in HTML
        echo "<h2>Auction Status Board</h2>";
        echo "<table border='1'>
                <tr>
                    <th>User Name</th>
                    <th>Funds</th>
                    <th>Max Bid</th>
                    <th>QB</th>
                    <th>RB</th>
                    <th>RBWR</th>
                    <th>WR1</th>
                    <th>WR2</th>
                    <th>WRTE</th>
                    <th>TE</th>
                    <th>DST</th>
                    <th>K</th>
                    <th>Bench Players</th>
                </tr>";

        foreach ($statusBoard as $row) {
            echo "<tr>
                    <td>{$row['user_name']}</td>
                    <td>{$row['available_funds']}</td>
                    <td>{$row['max_bid']}</td>";

            // Display each primary position using the starterCard function
            $positions = ['QB', 'RB', 'RBWR', 'WR1', 'WR2', 'WRTE', 'TE', 'DST', 'K'];
            foreach ($positions as $position) {
                echo "<td>" . starterCard($row[$position]) . "</td>";
            }

            // Display bench players in a 2x3 grid using the benchCard function
            $benchPlayers = explode(', ', $row['bench_players']);
            echo "<td><table class='bench-grid'>";

            // Create a 2x3 grid
            $benchSlots = 6; // We have 6 slots in a 2x3 grid
            for ($i = 0; $i < 2; $i++) { // 2 rows
                echo "<tr>";
                for ($j = 0; $j < 3; $j++) { // 3 columns
                    $index = $i * 3 + $j;
                    if (isset($benchPlayers[$index]) && $benchPlayers[$index] !== '') {
                        echo "<td>" . benchCard($benchPlayers[$index]) . "</td>";
                    } else {
                        echo "<td>" . benchCard(null) . "</td>";
                    }
                }
                echo "</tr>";
            }

            echo "</table></td>";

            echo "</tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>
</html>
