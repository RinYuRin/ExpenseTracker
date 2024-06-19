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
    $fullname = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Prepared statement to prevent SQL injection
    $check_query = "SELECT * FROM user WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If email or username already exist, return error message as JSON, you need this -->
        $response = array("status" => "error", "message" => "Username or email already exists!");
        echo json_encode($response);
    } else {
        // Prepared statement to insert new user
        $sql = "INSERT INTO user (full_name, username, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password. currently broken asf
        $stmt->bind_param("ssss", $fullname, $username, $email, $password);

        if ($stmt->execute()) {
            // Fetch the userid and store it in session
            $UserId = $stmt->insert_id;
            $_SESSION['UserId'] = $UserId;
            $response = array("status" => "success", "message" => "Registered successfully!");
            echo json_encode($response);
        } else {
            $response = array("status" => "error", "message" => "Error: " . $conn->error);
            echo json_encode($response);
        }
    }
}

$conn->close();
?>
