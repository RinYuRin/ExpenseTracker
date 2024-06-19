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

    const notificationContainer = document.getElementById('notificationContainer');
    notificationContainer.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

function login() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    fetch('../php/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${username}&password=${password}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            createNotification(data.message);
            setTimeout(() => {
                window.location.href = "../html/dashboard.html";
            }, 2000);
        } else {
            createNotification(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}