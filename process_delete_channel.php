<?php
// Database connection parameters
$host = "std-mysql";
$username = "std_1871_channelcreator";
$password = "12345678";
$database = "channelcreator"; // Change to your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the channel ID from the URL parameter
$channelId = $_GET['id'];

// Perform data validation here if needed

// Prepare and execute the SQL query to delete the channel from the database
$sql = "DELETE FROM channels WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $channelId);

if ($stmt->execute()) {
    // Redirect the user back to the index.php page or show a success message
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
