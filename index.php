<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Channel creator</title>
   
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
              <li class="nav-item">
              <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                session_start();
                if (isset($_SESSION['user_id'])) {
                  $userId = $_SESSION['user_id'];
                } else {
                  // Handle the case where the user is not logged in
                  // You may redirect them to the login page or take other appropriate actions
                }

                // Function to check if a channel is in a user's favorites
                // Include the functions.php file
                include('functions.php');

                // Rest of your code

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
        <div class="mb-4"><h2 >Список каналов</h2></div>
        <a href="create_channel.html" class="btn btn-primary mb-3">+ Создать канал</a>

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
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
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

        // Retrieve channels from the database
        $sql = "SELECT id, name, description, date FROM channels";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["id"] . "</td>";
              echo "<td><a href='channel_page.php?id=" . $row["id"] . "' class='text-primary'>" . $row["name"] . "</a></td>";
              echo "<td>" . $row["description"] . "</td>";
              echo "<td>" . $row["date"] . "</td>";
              echo "<td>";
      
              $isFavorite = checkIfChannelIsFavorite($conn, $userId, $row["id"]); // Pass $conn, $userId, and channel ID
      
              if ($isFavorite) {
                  echo '<a href="remove_from_favorites.php?channel_id=' . $row["id"] . '" class="btn btn-danger">Remove from Favorites</a>';
              } else {
                  echo '<a href="add_to_favorites.php?channel_id=' . $row["id"] . '" class="btn btn-primary">Add to Favorites</a>';
              }
              
              echo "<a href='edit_channel.php?id=" . $row["id"] . "' class='btn btn-outline-blue btn-sm mr-2'><i class='bi bi-pencil'></i> Редактировать</a>";
              echo "<a href='delete_confirmation.php?id=" . $row["id"] . "' class='btn btn-outline-red btn-sm'><i class='bi bi-trash'></i> Удалить</a>";
              echo "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='5'>No channels found.</td></tr>";
      }

        $conn->close();
        ?>
    </tbody>
</table>

    </div>
</body>
</html>
