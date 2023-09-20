<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

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
    die("Ошибка подключения: " . $conn->connect_error);
}

// Database connection parameters and session_start() code

$userId = $_SESSION['user_id'];

// Retrieve the channel_id from the URL parameter
if (isset($_GET['channel_id'])) {
    $channelId = $_GET['channel_id'];

    // Prepare the SQL statement to remove the channel from favorites
    $sql = "DELETE FROM favorite_channels WHERE user_id = ? AND channel_id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Подготовка неуспешна: " . $conn->error);
    }

    // Bind the user_id and channel_id to the SQL statement
    $stmt->bind_param("ii", $userId, $channelId);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Redirect back to the favorite channels page
        header("Location: favorite_channels.php"); // Replace with your favorite channels page URL
        exit();
    } else {
        echo "Ошибка при удалении из избранного: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID канала не приведен.";
}

// Close the database connection
$conn->close();
?>
