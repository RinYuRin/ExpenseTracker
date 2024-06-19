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

$query = "SELECT * FROM expense WHERE UserId = '$userId'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="../js/addExpense.js"></script>
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

    <div class="p-4">
        <h1 class="text-3xl font-bold mb-8 mtext">Expenses</h1>

        <!-- Expenses Table -->
        <table class="w-full border-collapse border border-gray-300">
            <!-- Table Header -->
            <thead>
                <tr class="bg-gray-200 mtext">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Item</th>
                    <th class="px-4 py-2">Cost (PHP)</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody id="expensesTableBody">
                <!-- PHP Loop to Populate Table Rows -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr class="stext">
                            <td class="border px-4 py-2"><?php echo $row['ID']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['Item']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['Cost']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['Date']; ?></td>
                            <td class="border px-4 py-2"><a href="../php/delete_expenses.php?id=<?php echo $row['ID']; ?>"
                                    class="text-red-500">Delete</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Currently Doesn't Have Any Expenses</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Expense Form -->
    <div class="p-4 stext">
        <h1 class="text-3xl font-bold mb-8 mtext">Add Expense</h1>
        <form id="expenseForm" method="post" action="../php/add_expenses.php" class="space-y-4">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="w-full md:w-1/3">
                    <label for="item" class="block">Item:</label>
                    <input type="text" id="item" name="item" required
                        class="border border-gray-300 px-4 py-2 rounded-md w-full">
                </div>
                <div class="w-full md:w-1/3">
                    <label for="cost" class="block">Cost (PHP):</label>
                    <input type="number" id="cost" name="cost" min="0" step="0.01" required
                        class="border border-gray-300 px-4 py-2 rounded-md w-full">
                </div>
                <div class="w-full md:w-1/3">
                    <label for="date" class="block">Date:</label>
                    <input type="date" id="date" name="date" required
                        class="border border-gray-300 px-4 py-2 rounded-md w-full">
                </div>
            </div>
            <input type="submit" name="submit" value="Add Expense" onclick="submitExpenseForm()"
                class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer">
        </form>
    </div>

    <div id="notificationContainer" class="fixed top-4 right-4 z-50"></div>

    <script src="../js/updateExpense.js"></script>
    <script src="../js/validator001.js"></script>

</body>

</html>


<?php
$conn->close();
?>