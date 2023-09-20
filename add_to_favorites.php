<?php
session_start();

// Include the functions.php file to access functions
include('functions.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or handle as appropriate
    header("Location: login.php"); // Replace with your login page URL
    exit();
}

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

$userId = $_SESSION['user_id'];
$channelId = $_GET['channel_id'];

if (addToFavorites($conn, $userId, $channelId)) {
    header("Location: index.php"); // Redirect to the index page
    exit();
} else {
    echo "Error adding to favorites.";
}

$conn->close();
?>
