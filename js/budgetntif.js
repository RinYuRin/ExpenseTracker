function showNotification(message) {
    // Create a notification element
    var notification = document.createElement('div');
    notification.classList.add('notification');
    notification.textContent = message;

    // Append the notification to the floating window
    var floatingWindow = document.getElementById('setBudgetFloatingWindow');
    floatingWindow.appendChild(notification);

    // Remove the notification after 5 seconds
    setTimeout(function() {
        floatingWindow.removeChild(notification);
    }, 5000);
}
