<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'expenseman';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    // get user in the session
    $userId = $_SESSION['UserId'];

    // get the credentials of users
    $sql = "SELECT password FROM user WHERE UserId = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentPasswordDB = $row['password'];

        // verify if the pass is match the db
        if ($currentPassword != $currentPasswordDB) {
            $response = array("success" => false, "message" => "Current password is incorrect!");
            echo json_encode($response);
            exit();
        }

        // update user pass in the db
        $sqlUpdate = "UPDATE user SET password = '$newPassword' WHERE UserId = '$userId'";
        if ($conn->query($sqlUpdate) === TRUE) {
            $response = array("success" => true, "message" => "Password changed successfully!");
            echo json_encode($response);
            exit();
        } else {
            $response = array("success" => false, "message" => "Error updating record: " . $conn->error);
            echo json_encode($response);
            exit();
        }
    } else {
        $response = array("success" => false, "message" => "0 results");
        echo json_encode($response);
        exit();
    }
}

$conn->close();
?>
