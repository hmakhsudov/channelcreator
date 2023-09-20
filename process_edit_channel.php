<?php
// Database connection parameters
$host = "std-mysql.ist.mospolytech.ru";
$username = "std_1871_channelcreator";
$password = "12345678";
$database = "channelcreator"; // Change to your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the edit channel form
$channelId = $_POST['channel_id'];
$channelName = $_POST['name'];
$channelDescription = $_POST['description'];

// Perform data validation here if needed

// Prepare and execute the SQL query to update the channel information in the database
$sql = "UPDATE channels SET name = ?, description = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $channelName, $channelDescription, $channelId);

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
