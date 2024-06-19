<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'expenseman';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if the input match the one in db
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // user redirect and store in session
        $user = $result->fetch_assoc();
        $_SESSION['UserId'] = $user['UserId'];
        $_SESSION['success'] = 'Login successful!';
        echo json_encode(['success' => true, 'message' => 'Login successful!']);
    } else {
        // show err message if the credentials dont match
        $_SESSION['error'] = 'Invalid username or password!';
        echo json_encode(['success' => false, 'message' => 'Invalid username or password!']);
    }
}

$conn->close();
?>
