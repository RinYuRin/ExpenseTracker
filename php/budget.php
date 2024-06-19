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

// verify user
if (!isset($_SESSION['UserId'])) {
    header("Location: ../html/login.html");
    exit();
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $budget = $_POST['budget'];

    // Validate the budget value
    if (!is_numeric($budget) || $budget <= 0) {
        $response['success'] = false;
        $response['message'] = "Please enter a valid budget amount.";
    } else {
        // get user in session
        $userId = $_SESSION['UserId'];

        // check if there's a budget set in db
        $check_query = "SELECT * FROM budget WHERE UserId = '$userId'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            // update the budget if there's one
            $sql = "UPDATE budget SET Budget = '$budget' WHERE UserId = '$userId'";
        } else {
            // set a budget
            $sql = "INSERT INTO budget (UserId, Budget) VALUES ('$userId', '$budget')";
        }

        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Budget set successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

echo json_encode($response);

$conn->close();
?>
