<?php
session_start(); // Start or resume the session

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

// Get user input from the login form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute the SQL query to retrieve user data
$sql = "SELECT id, name, email, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $hashedPassword = $user['password'];

    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        // Store user data in a session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        header("Location: index.php");
        exit; 
    } else {
        echo "Login failed. Please check your email and password.";
    }
} else {
    echo "Login failed. Please check your email and password.";
}

$stmt->close();
$conn->close();
?>
