<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$host = "std-mysql";
$username = "std_1871_channelcreator"871_channelcreator";
$password = "12345678"678";
$database = "channelcreator"; // Change to your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Database connection parameters and session_start() code

$userId = $_SESSION['user_id'];

// Prepare the SQL statement
$sql = "SELECT c.id, c.name, c.description, c.date
        FROM channels AS c
        INNER JOIN favorite_channels AS fc ON c.id = fc.channel_id
        WHERE fc.user_id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the user's ID to the SQL statement
$stmt->bind_param("i", $userId);

// Execute the SQL statement
if ($stmt->execute()) {
    // Bind the result variables
    $stmt->bind_result($channelId, $channelName, $channelDescription, $channelDate);

    // Initialize $result as an array
    $result = [];

    // Fetch results into the $result array
    while ($stmt->fetch()) {
        $result[] = [
            'id' => $channelId,
            'name' => $channelName,
            'description' => $channelDescription,
            'date' => $channelDate
        ];
    }

    $stmt->close();
} else {
    echo "Error executing SQL statement: " . $stmt->error;
}

// Close the database connection
$conn->close();
?>
<!-- Rest of your HTML code -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Channels</title>
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
                        <a class="nav-link" href="#">Избранное</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Выйти</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo '<a class="nav-link" href="#">Пользователь: ' . $_SESSION['user_name'] . '</a>';
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="mb-4"><h2>Избранные каналы</h2></div>
        <?php if (!empty($result)): ?>
    <table class="table table-striped table-bordered mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><a href='channel_page.php?id=<?php echo $row['id']; ?>' class='text-primary'><?php echo $row['name']; ?></a></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td>
                        <a href="remove_from_favorites.php?channel_id=<?php echo $row['id']; ?>" class="btn btn-danger">Удалить с избранного</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Нет избранных каналов.</p>
<?php endif; ?>
    </div>
</body>
</html>
