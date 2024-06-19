<?php
session_start();

// verift if logged in
if (!isset($_SESSION['UserId'])) {
    header("Location: ../html/login.html");
    exit();
}

// get the user in session
$userId = $_SESSION['UserId'];


if (isset($_GET['id'])) {
    $expenseId = $_GET['id'];

    
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'expenseman';

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // delete query in db
    $query = "DELETE FROM expense WHERE ID = '$expenseId' AND UserId = '$userId'";
    if ($conn->query($query) === TRUE) {
        // Expense deleted successfully, redirect back to expenses page
        header("Location: ../html/expenses.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    // if theres no matching expense id, redierct
    header("Location: ../html/expenses.php");
    exit();
}
?>
