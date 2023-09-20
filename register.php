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

// Get user input from the registration form
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password']; // Get the password without hashing

// Validate password length
if (strlen($password) < 8) {
    echo "Error: Password must be at least 8 characters long.";
} else {
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Proceed with database insertion
    // Prepare and execute the SQL query to insert user data into the database
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful! You can now <a href='login.html'>login</a>.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>