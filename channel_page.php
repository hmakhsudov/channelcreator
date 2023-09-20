<?php
// Start a session and include necessary files
session_start();
include('functions.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle as appropriate
    header("Location: login.php"); // Replace with your login page URL
    exit();
}

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "root";
$database = "channelcreator"; // Change to your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the channel ID from the URL parameter (assuming you pass it in the URL)
if (isset($_GET['id'])) {
    $channelId = $_GET['id'];

    // Retrieve channel information from the database
    $sql = "SELECT name, description, date FROM channels WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $channelId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $channelName = $row['name'];
        $channelDescription = $row['description'];
        $channelDate = $row['date'];
    } else {
        // Handle the case where the channel is not found
        // You can display an error message or redirect the user
        echo "Channel not found.";
    }

    $stmt->close();
} else {
    // Handle the case where the channel ID is not provided
    // You can display an error message or redirect the user
    echo "Channel ID not provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $channelName; ?></title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="#">ChannelCreator</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Главная страница</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="favorite_channels.php">Избранное</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Выйти</a>
              </li>
 
            </ul>
          </div>
        </div>
      </nav>
    <div class="container mt-4">
        <h2><?php echo $channelName; ?></h2>
        <p><?php echo $channelDescription; ?></p>
        <p>Дата создания: <?php echo $channelDate; ?></p>
    </div>
</body>
</html>


