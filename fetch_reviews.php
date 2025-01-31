<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "travel_reviews"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each review
    while($row = $result->fetch_assoc()) {
        echo "<div class='review-item'>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<div class='rating'>Rating: " . htmlspecialchars($row['rating']) . "/5</div>";
        echo "<p>" . nl2br(htmlspecialchars($row['review'])) . "</p>";
        echo "</div>";
    }
} else {
    echo "No reviews yet!";
}

// Close the connection
$conn->close();
?>
