function Logout() {
    window.location.href = "../php/logout.php";
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