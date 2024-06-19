<?php
session_start();

if (!isset($_SESSION['UserId'])) {
    header("Location: ../html/login.html");
    exit();
}

// get user in session
$userId = $_SESSION['UserId'];

$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'expenseman';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// fetch the budget in db
$query = "SELECT Budget FROM budget WHERE UserId = '$userId'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $budget = $row['Budget'];
} else {
    $budget = 0;
}

// calculate expenses
$query = "SELECT SUM(Cost) AS TotalExpenses FROM expense WHERE UserId = '$userId'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalExpenses = $row['TotalExpenses'];
} else {
    $totalExpenses = 0; 
}

// calculate remaining budget
$remainingBudget = $budget - $totalExpenses;



// get start and end of the week
function getCurrentWeekDates() {
  $startOfWeek = date('Y-m-d', strtotime('monday this week'));
  $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
  return array($startOfWeek, $endOfWeek);
}

// fetch data based on date
function fetchExpensesByDateRange($startDate, $endDate, $userId, $conn) {
  $query = "SELECT * FROM expense WHERE UserId = '$userId' AND Date BETWEEN '$startDate' AND '$endDate'";
  $result = $conn->query($query);
  return $result;
}

// get todays expenses
$today = date('Y-m-d');
$resultToday = fetchExpensesByDateRange($today, $today, $userId, $conn);

// get yesterdays expenses
$yesterday = date('Y-m-d', strtotime('-1 day'));
$resultYesterday = fetchExpensesByDateRange($yesterday, $yesterday, $userId, $conn);

// get weeks expenses
list($startOfWeek, $endOfWeek) = getCurrentWeekDates();
$resultThisWeek = fetchExpensesByDateRange($startOfWeek, $endOfWeek, $userId, $conn);

// get the start and end of the month
function getCurrentMonthDates() {
  $startOfMonth = date('Y-m-01');
  $endOfMonth = date('Y-m-t');
  return array($startOfMonth, $endOfMonth);
}

// get current month expensses
list($startOfMonth, $endOfMonth) = getCurrentMonthDates();
$resultThisMonth = fetchExpensesByDateRange($startOfMonth, $endOfMonth, $userId, $conn);

// get start and end of a year
function getCurrentYearDates() {
  $startOfYear = date('Y-01-01');
  $endOfYear = date('Y-12-31');
  return array($startOfYear, $endOfYear);
}

// get current year expensses
list($startOfYear, $endOfYear) = getCurrentYearDates();
$resultThisYear = fetchExpensesByDateRange($startOfYear, $endOfYear, $userId, $conn);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/fonts.css">
</head>
<body>

    <div class="container mx-auto px-4 py-8 wtext">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-xl p-6">
                <p class="font-bold">Budget:</p>
                <p><?php echo $budget; ?> PHP</p>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-6">
                <p class="font-bold">Total Expenses:</p>
                <p><?php echo $totalExpenses; ?> PHP</p>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-6">
                <p class="font-bold">Remaining Budget:</p>
                <p><?php echo $remainingBudget; ?> PHP</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">
            <div class="bg-white rounded-lg shadow-xl p-6">
                <h2 class="text-lg font-bold mb-4">Today's Expenses</h2>
                <ul>
                    <?php while ($row = $resultToday->fetch_assoc()) { ?>
                        <li><?php echo $row['Item']; ?> - <?php echo $row['Cost']; ?> PHP</li>
                    <?php } ?>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-6">
                <h2 class="text-lg font-bold mb-4">Yesterday's Expenses</h2>
                <ul>
                    <?php while ($row = $resultYesterday->fetch_assoc()) { ?>
                        <li><?php echo $row['Item']; ?> - <?php echo $row['Cost']; ?> PHP</li>
                    <?php } ?>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-6">
                <h2 class="text-lg font-bold mb-4">This Week's Expenses</h2>
                <ul>
                    <?php while ($row = $resultThisWeek->fetch_assoc()) { ?>
                        <li><?php echo $row['Item']; ?> - <?php echo $row['Cost']; ?> PHP</li>
                    <?php } ?>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-6">
                <h2 class="text-lg font-bold mb-4">This Month's Expenses</h2>
                <ul>
                    <?php while ($row = $resultThisMonth->fetch_assoc()) { ?>
                        <li><?php echo $row['Item']; ?> - <?php echo $row['Cost']; ?> PHP</li>
                    <?php } ?>
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-6">
                <h2 class="text-lg font-bold mb-4">This Year's Expenses</h2>
                <ul>
                    <?php while ($row = $resultThisYear->fetch_assoc()) { ?>
                        <li><?php echo $row['Item']; ?> - <?php echo $row['Cost']; ?> PHP</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
