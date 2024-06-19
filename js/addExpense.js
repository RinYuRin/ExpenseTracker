function submitExpenseForm() {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Get form data
    const item = document.getElementById('item').value;
    const cost = document.getElementById('cost').value;
    const date = document.getElementById('date').value;

    // Add expense using AJAX (fetch)
    addExpense(item, cost, date);
}

function addExpense(item, cost, date) {
    // Send data to server using fetch
    fetch('../php/add_expenses.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `item=${item}&cost=${cost}&date=${date}`,
    })
        .then(response => response.json())
        .then(data => {
            // Display notification
            if (data.success) {
                displayNotification(data.message);
            } else {
                console.error('Error adding expense:', data.message);
            }
        })
        .catch(error => {
            console.error('Error adding expense:', error);
        });
}

function displayNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 bg-white rounded-xl shadow-lg overflow-hidden animate-slidein transition-all duration-500`;

    // Set notification content
    notification.innerHTML = `
    <div class="shrink-0">
    <div class="flex items-center space-x-4 p-4">
        <img class="h-12 w-12" src="https://www.svgrepo.com/show/326725/notifications-circle-outline.svg" alt="Logo">
        <div>
            <div class="text-xl font-medium text-black">System</div>
            <p class="text-slate-500">${message}</p>
        </div>
    </div>
</div>
    `;

    // Insert notification into container
    const notificationContainer = document.getElementById('notificationContainer');
    notificationContainer.appendChild(notification);

    // Remove notification after 2 seconds
    setTimeout(() => {
        notification.remove();
    }, 2000);
}
