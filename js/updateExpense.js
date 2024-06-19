// real time expenses table update
function fetchExpenseData() {
    fetch('../php/get_expenses.php')
    .then(response => response.json())
    .then(data => {
        updateExpensesTable(data);
        console.log("Tables Updated -->")
    })
    .catch(error => {
        console.error('Error fetching expense data:', error);
    });
}

function updateExpensesTable(expenses) {
    const tableBody = document.getElementById('expensesTableBody');
    tableBody.innerHTML = ''; // Clear the table body before adding new rows

    // Iterate over expenses and create table rows
    expenses.forEach(expense => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="border px-4 py-2">${expense.ID}</td>
            <td class="border px-4 py-2">${expense.Item}</td>
            <td class="border px-4 py-2">${expense.Cost}</td>
            <td class="border px-4 py-2">${expense.Date}</td>
            <td class="border px-4 py-2"><a href="../php/delete_expenses.php?id=${expense.ID}" class="text-red-500">Delete</a></td>
        `;
        tableBody.appendChild(row); // Append the row to the table body
    });
}


setInterval(fetchExpenseData, 3000);
