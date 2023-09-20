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

// Retrieve the channel ID from the URL parameter (or from a hidden form field)
$channelId = $_GET['id']; // Assuming the ID is passed via the URL parameter

// Retrieve the existing channel data from the database
$sql = "SELECT name, description FROM channels WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $channelId);
$stmt->execute();
$stmt->bind_result($channelName, $channelDescription);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Channel creator</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <div class="container mt-4">
        <h2>Редактировать канал</h2>
        <form action="process_edit_channel.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Название канала</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($channelName); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание канала</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($channelDescription); ?></textarea>
            </div>
            <input type="hidden" name="channel_id" value="<?php echo $channelId; ?>">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>

    <!-- ... (other HTML and scripts) ... -->
</body>
</html>
