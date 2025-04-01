<?php
$host = 'localhost';
$dbname = 'watchedl';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '';
} catch (PDOException $e) {
    die(' ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watched</title>
    <style>
        /* Базовые стили */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            color: #fff;
            background: #000000 url(1234.gif) no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column; /* Layout elements vertically */
            align-items: center; /* Center horizontally */
        }

        /* Шапка */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background-color:rgba(30, 30, 30, 0.7);
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 100%;
        }

        .left-section {
            font-weight: bold;
        }

        header nav {
            display: flex;
            align-items: center;
        }
        
        header nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            cursor: pointer;
        }

        header nav a:hover {
            text-decoration: underline;
        }
        h3,h1{
            color:  #3498db;
        }
        /* Контейнер с текстом */
        .welcome-container {
            margin-top: 100px; /* Add margin to position below the header */
            background-color:rgba(30, 30, 30, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 80%;
            max-width: 600px;
            box-sizing: border-box;
        }

        .features {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .feature {
            text-align: center;
        }

        /* Формы логина */
        .login-form-container {
            margin-top: 20px; /* Add margin to position below welcome text */
            background-color: rgba(30, 30, 30, 0.7);
            padding: 30px;
            border-radius: 10px;
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            width: 80%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }

        .login-form {
            text-align: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
        }

        .login-form input {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 3px;
            border: 1px solid #444;
            background-color: #333;
            color: #fff;
            width: 100%;
            box-sizing: border-box;
        }

        .login-form button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

        /* Классы для скрытия/показа */
        .hidden {
            display: none;
        }

        .show {
            opacity: 1;
            visibility: visible;
            display: block;
        }

        /* Контент */
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <div class="left-section">| Компьютерный клуб - Watched |</div>
            <nav>
                <a href="#" id="user-login-btn">Вход для пользователей</a>
                <a href="#" id="employee-login-btn">Вход для сотрудников</a>
                <a href="https://t.me/Saportik0">Поддержка</a>

            </nav>
        </div>
    </header>

    <div class="welcome-container">
        <h1>Добро пожаловать в компьютерный клуб Watched!</h1>
        <p>Мы предлагаем вам уникальную возможность погрузиться в мир технологий и гейминга.</p>
        <div class="features">
            <div class="feature">
                <h3>Гейминг</h3>
                <p>Играйте в самые популярные игры на наших мощных компьютерах.</p>
            </div>
            <div class="feature">
                <h3>Программирование</h3>
                <p>Учитесь программировать и разрабатывать свои собственные проекты.</p>
            </div>
            <div class="feature">
                <h3>Обслуживание ПК</h3>
                <p>Узнайте, как собирать и обслуживать компьютеры.</p>
            </div>
        </div>
    </div>

    <div id="user-login-form" class="login-form-container hidden">
        <div class="login-form">
            <h2>Вход для пользователей</h2>
            <form method="POST" action="authenticate.php">

                <input type="text" name="surname" id="surname" required placeholder="Surname">

                <input type="email" name="email" id="email" required placeholder="Email">
                <button>Войти</button>
            </form>
        </div>
    </div>

    <div id="employee-login-form" class="login-form-container hidden">
        <div class="login-form">
            <h2>Вход для сотрудников</h2>
            <form method="POST" action="authenticate2.php">

                <input type="text" name="login" id="login" required placeholder="login">

                <input type="password" name="password" id="password" required placeholder="password">
            <button>Войти</button>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>
