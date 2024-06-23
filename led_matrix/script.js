// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('led-matrix'); // Get the table element by ID
    
    // Create the 7x5 LED matrix grid
    for (let i = 0; i < 7; i++) { // Loop to create 7 rows
        const row = document.createElement('tr'); // Create a new table row
        for (let j = 0; j < 5; j++) { // Loop to create 5 cells per row
            const cell = document.createElement('td'); // Create a new table cell
            row.appendChild(cell); // Append cell to the current row
        }
        table.appendChild(row); // Append the row to the table
    }

    // Function to update the LED matrix display
    function updateMatrix(pattern) {
        const rows = pattern.split(','); // Split pattern string by commas into rows
        for (let i = 0; i < rows.length; i++) { // Loop through each row pattern
            const rowPattern = rows[i].split(''); // Split row pattern into individual characters
            for (let j = 0; j < rowPattern.length; j++) { // Loop through each character in the row
                // Toggle 'on' class based on character value (1 = on, 0 = off)
                table.rows[i].cells[j].classList.toggle('on', rowPattern[j] === '1');
            }
        }
    }

    // Add event listener to the form submission
    const form = document.querySelector('form'); // Select the form element
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission behavior
        
        const char = document.getElementById('char').value.toUpperCase(); // Get and uppercase the input character
        fetch('fetch_pattern.php', { // Send POST request to fetch pattern
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // Set request content type
            },
            body: `char=${char}` // Include the character in the request body
        })
        .then(response => response.json()) // Parse the response as JSON
        .then(data => { // Handle the response data
            if (data.pattern) { // Check if a pattern was returned
                updateMatrix(data.pattern); // Update the matrix with the fetched pattern
            } else {
                // Clear the matrix if no pattern is found
                updateMatrix('00000,00000,00000,00000,00000,00000,00000'); // Default empty pattern
            }
        });
    });
});
