<?php
// Database connection parameters
$host = "std-mysql.ist.mospolytech.ru";
$username = "std_1871_channelcreator";
$password = "12345678";
$database = "std_1871_channelcreator"; // Change to your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the form
$name = $_POST['name'];
$description = $_POST['description'];

// Perform data validation here if needed

// Prepare and execute the SQL query to insert the new channel data into the database
$sql = "INSERT INTO channels (name, description) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $description);

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
