// Функция для показа формы и скрытия других
function showLoginForm(formId) {
    // Сначала скрываем все формы
    document.querySelectorAll('.login-form-container').forEach(form => {
        form.classList.remove('show');
    });

    // Затем показываем нужную форму
    document.getElementById(formId).classList.add('show');
}

// Привязка событий к кнопкам
document.getElementById('user-login-btn').addEventListener('click', function(event) {
    event.preventDefault();
    showLoginForm('user-login-form');
});

document.getElementById('employee-login-btn').addEventListener('click', function(event) {
    event.preventDefault();
    showLoginForm('employee-login-form');
});

// Закрытие формы по клику вне ее
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('login-form-container')) {
        event.target.classList.remove('show');
    }
});
