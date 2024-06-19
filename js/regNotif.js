document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById('form');
    registrationForm.addEventListener('submit', function (event) {
        event.preventDefault();

        fetch('../php/register.php', {
            method: 'POST',
            body: new FormData(registrationForm)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Create HTML content for success message
                    const successMessage = `
                        <div class="fixed top-4 right-4 z-50 bg-white rounded-xl shadow-lg overflow-hidden animate-slidein transition-all duration-500">
                            <div class="flex items-center space-x-4 p-4">
                                <img class="h-12 w-12" src="https://www.svgrepo.com/show/326725/notifications-circle-outline.svg" alt="Logo">
                                <div>
                                    <div class="text-xl font-medium text-black">System</div>
                                    <p class="text-slate-500">${data.message}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    // Insert the success message into a container element
                    const container = document.getElementById('messageContainer');
                    container.innerHTML = successMessage;

                    // Slide out animation and redirect after 2 seconds
                    setTimeout(function() {
                        container.innerHTML = ''; // Clear message
                        window.location.href = 'login.html'; // Redirect
                    }, 2400);
                } else {
                    // Create HTML content for error message
                    const errorMessage = `
                        <div class="fixed top-4 right-4 z-50 bg-red-200 rounded-xl shadow-lg overflow-hidden animate-slidein transition-all duration-500">
                            <div class="flex items-center space-x-4 p-4">
                            <img class="h-12 w-12" src="https://www.svgrepo.com/show/326725/notifications-circle-outline.svg" alt="Logo">
                                <div>
                                    <div class="text-xl font-medium text-red-800">Error</div>
                                    <p class="text-red-600">${data.message}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    // Insert the error message into a container element
                    const container = document.getElementById('messageContainer');
                    container.innerHTML = errorMessage;

                    setTimeout(function() {
                        container.innerHTML = ''; // Clear message
                    }, 2700);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});
