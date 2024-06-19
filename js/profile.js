function createNotification(message) {
    const notification = document.createElement('div');
    notification.className = `bg-white rounded-xl shadow-lg overflow-hidden animate-slidein transition-all duration-500`;

    notification.innerHTML = `
            <div class="flex items-center space-x-4 p-4">
                <img class="h-12 w-12" src="https://www.svgrepo.com/show/326725/notifications-circle-outline.svg" alt="Logo">
                <div>
                    <div class="text-xl font-medium text-black">System</div>
                    <p class="text-slate-500">${message}</p>
                </div>
            </div>
        `;

    // Insert notification into container
    const notificationContainer = document.getElementById('notificationContainer');
    notificationContainer.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

function submitChangePasswordForm() {
    event.preventDefault();

    // Get form data
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;

    fetch('../php/change_password.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `currentPassword=${currentPassword}&newPassword=${newPassword}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                createNotification(data.message);
                closeChangePasswordFloatingWindow();
            } else {
                createNotification(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Function to handle form submission
function submitBudgetForm() {
    event.preventDefault();

    // Get form data
    const budget = document.getElementById('budget').value;

    // Send form data to server using fetch
    fetch('../php/budget.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `budget=${budget}`,
    })
    .then(response => response.json())
    .then(data => {
        // Display notification
        if (data.success) {
            createNotification(data.message);
            closeSetBudgetFloatingWindow()
        } else {
            createNotification(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// og js from aldrin haha
function Logout() { // added notification
    createNotification("Logging out...");

    setTimeout(() => {
        window.location.href = "../php/logout.php";
    }, 2000);
}

function openSetBudgetFloatingWindow() {
    var setBudgetFloatingWindow = document.getElementById("setBudgetFloatingWindow");
    setBudgetFloatingWindow.style.display = "block";
}

function closeSetBudgetFloatingWindow() {
    var setBudgetFloatingWindow = document.getElementById("setBudgetFloatingWindow");
    setBudgetFloatingWindow.style.display = "none";
}

function openChangePasswordFloatingWindow() {
    var changePasswordFloatingWindow = document.getElementById("changePasswordFloatingWindow");
    changePasswordFloatingWindow.style.display = "block";
}

function closeChangePasswordFloatingWindow() {
    var changePasswordFloatingWindow = document.getElementById("changePasswordFloatingWindow");
    changePasswordFloatingWindow.style.display = "none";
}
