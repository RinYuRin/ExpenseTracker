function showWelcomeNotification() {
    const notification = document.createElement('div');
    notification.className = `bg-white rounded-xl shadow-lg overflow-hidden animate-slidein transition-all duration-500`;

    notification.innerHTML = `
        <div class="flex items-center space-x-4 p-4">
            <img class="h-12 w-12" src="https://www.svgrepo.com/show/326725/notifications-circle-outline.svg" alt="Logo">
            <div>
                <div class="text-xl font-medium text-black">System</div>
                <p class="text-slate-500">Welcome back!</p>
            </div>
        </div>
    `;

    const notificationContainer = document.getElementById('notificationContainer');
    notificationContainer.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

if (window.location.href.includes('dashboard.html')) {
    showWelcomeNotification();
}