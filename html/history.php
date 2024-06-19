<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['UserId'])) {
    header("Location: ../index.html");
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

$userId = $_SESSION['UserId'];
$sql = "SELECT DATE_FORMAT(Date, '%Y-%m-%d') AS ExpenseDate, SUM(Cost) AS TotalCost 
        FROM expense WHERE UserId = '$userId' 
        GROUP BY DATE_FORMAT(Date, '%Y-%m-%d')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $expenseDates = [];
    $totalCosts = [];
    while ($row = $result->fetch_assoc()) {
        $expenseDates[] = $row['ExpenseDate'];
        $totalCosts[] = $row['TotalCost'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Expenses Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h1 class="text-3xl font-bold mb-8 mtext">User Expenses Dashboard</h1>

        <div class="bg-white shadow-md rounded-lg">
            <div class="responsive">
                <canvas id="userExpensesChart"></canvas>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('userExpensesChart').getContext('2d');
            var userExpensesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($expenseDates); ?>,
                    datasets: [{
                        label: 'Total Expenses (PHP)',
                        data: <?php echo json_encode($totalCosts); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Tailwind cyan-300
                        borderColor: 'rgba(75, 192, 192, 1)', // Tailwind cyan-500
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    plugins: {
                        legend: {
                            display: true // Hide legend for cleaner look
                        }
                    }
                }
            });
        </script>
    </div>
</body>

</html>