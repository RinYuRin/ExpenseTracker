<?php
session_start();

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify user
    if (!isset($_SESSION['UserId'])) {
        echo json_encode(array("success" => false, "message" => "User is not logged in"));
        exit();
    }

    // Get user in session
    $userId = $_SESSION['UserId'];

    // Validate data
    $item = $_POST['item'];
    $cost = $_POST['cost'];
    $date = $_POST['date'];

    // db connection
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'expenseman';

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        echo json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error));
        exit();
    }

    $sql = "INSERT INTO expense (UserId, Item, Cost, Date) VALUES ('$userId', '$item', '$cost', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true, "message" => "Expense added successfully"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error));
    }

    $conn->close();
} else {
    // If the request method is not POST, return an error
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
