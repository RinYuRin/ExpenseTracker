<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserId'])) {
    http_response_code(401); // Unauthorized
    exit();
}

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'expenseman';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session
$userId = $_SESSION['UserId'];

// Prepare SQL statement to select expenses for the logged-in user
$query = "SELECT * FROM expense WHERE UserId = '$userId'";
$result = $conn->query($query);

// Check if there are any expenses
if ($result->num_rows > 0) {
    $expenses = array();

    // Fetch expenses and add them to the array
    while ($row = $result->fetch_assoc()) {
        $expenses[] = array(
            'ID' => $row['ID'],
            'Item' => $row['Item'],
            'Cost' => $row['Cost'],
            'Date' => $row['Date']
        );
    }

    // Return expenses data in JSON format
    echo json_encode($expenses);
} else {
    // No expenses found
    echo json_encode(array());
}

// Close the database connection
$conn->close();
?>
