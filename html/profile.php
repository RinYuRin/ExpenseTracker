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

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['UserId'])) {
    header("Location: ../html/login.html");
    exit();
}

// Get user ID
$userId = $_SESSION['UserId'];

// Fetch user information from the database
$query = "SELECT * FROM user WHERE UserId = '$userId'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/fonts.css">
</head>

<body class="bg-gray-100">

    <nav class="bg-blue-500 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold mtext">Expense Tracking</h1>
            <ul class="flex justify-center space-x-6 text-white stext">
                <li><a href="./dashboard.html">HOME</a></li>
                <li><a href="./expenses.php">EXPENSES</a></li>
                <li><a href="./history.php">HISTORY</a></li>
                <li><a href="./profile.php">PROFILE</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-8 mtext">User Profile</h1>

        <div class="mb-4 wtext">
            <p><strong>Name:</strong> <?php echo $user['Full_Name']; ?></p>
            <p><strong>Username:</strong> <?php echo $user['Username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
        </div>

        <button onclick="openSetBudgetFloatingWindow()" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4 stext">Set
            Budget</button>

        <button onclick="openChangePasswordFloatingWindow()"
            class="bg-blue-500 text-white px-4 py-2 rounded-md mr-4 stext">Change Password</button>

        <button onclick="Logout()" class="bg-red-500 text-white px-4 py-2 rounded-md stext">Logout</button>
    </div>

    <div id="setBudgetFloatingWindow"
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white shadow-lg rounded-lg p-8 w-96"
        style="display: none;">
        <span onclick="closeSetBudgetFloatingWindow()" class="absolute top-2 right-2 cursor-pointer">&times;</span>
        <h2 class="text-2xl font-bold mb-4">Set Budget</h2>
        <form onsubmit="submitBudgetForm(); return false;" class="space-y-4">
            <label for="budget" class="block">Initial Budget (PHP):</label>
            <input type="number" id="budget" name="budget" required
                class="border border-gray-300 px-4 py-2 rounded-md w-full">

            <input type="submit" name="submit" value="Set Budget"
                class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer">
        </form>
    </div>

    <div id="changePasswordFloatingWindow"
        class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white shadow-lg rounded-lg p-8 w-96"
        style="display: none;">
        <span onclick="closeChangePasswordFloatingWindow()" class="absolute top-2 right-2 cursor-pointer">&times;</span>
        <h2 class="text-2xl font-bold mb-4 stext">Change Password</h2>
        <form onsubmit="submitChangePasswordForm(); return false;" class="space-y-4">
            <label for="currentPassword" class="block stext">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required
                class="border border-gray-300 px-4 py-2 rounded-md w-full">

            <label for="newPassword" class="block stext">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required
                class="border border-gray-300 px-4 py-2 rounded-md w-full">

            <input type="submit" name="submit" value="Change Password"
                class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer stext">
        </form>
    </div>

    <div id="notificationContainer" class="fixed top-4 right-4 z-50"></div>
    <!--js for change password and budget -->
    <script src="../js/profile.js"></script> 
    <script src="../js/validator001.js"></script>

</body>

</html>