<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: profile_users.php'); // Перенаправление на страницу входа
    exit;
}

// Подключение к БД
$host = 'localhost';
$dbname = 'watchedl';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получение списка доступных компьютеров
    $stmt = $pdo->query("SELECT * FROM computers");
    $computers = $stmt->fetchAll();

    // Получение бронирований пользователя
    $userId = $_SESSION['user_id'];
    $bookingStmt = $pdo->prepare("SELECT b.*, c.computer_name FROM bookings b JOIN computers c ON b.computer_id = c.id WHERE b.user_id = ?");
    $bookingStmt->execute([$userId]);
    $bookings = $bookingStmt->fetchAll();

    // Получение баланса пользователя
    $balanceStmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
    $balanceStmt->execute([$userId]);
    $userData = $balanceStmt->fetch(PDO::FETCH_ASSOC);
    $balance = $userData['balance'] ?? 0.00;

    // Получение истории платежей пользователя
    $paymentStmt = $pdo->prepare("SELECT * FROM payment WHERE user_id = ? ORDER BY date DESC");
    $paymentStmt->execute([$userId]);
    $payments = $paymentStmt->fetchAll();

} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Компьютерный клуб</title>
    <style>
         
        /* Общие стили */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212; /* Основной цвет фона */
            background-image: url('1234.gif'); /* Путь к фоновой картинке */
            background-repeat: no-repeat; /* Не повторять фон */
            background-size: cover; /* Растянуть фон на весь экран */
            background-position: center; /* Центрировать фон */
            color: #e0e0e0; /* Цвет текста */
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%; /* Убедитесь, что html и body занимают всю высоту экрана */
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0px;
            background-color:  rgba(30, 30, 30, 0.7); /* Полупрозрачный черный */
            z-index: 1000;
        }

        .header-text {
            font-family: Arial, sans-serif; /* Шрифт как на картинке */
            
            color: rgba(255, 255, 255, 0.7);; /* Цвет текста */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Тень для текста */
            margin-left: 20px; /* Отступ слева */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 100%;
            text-shadow: 1px 2px 3px #000;
        }

        .balance-container {
            display: flex;
            align-items: center;
            margin-right: 20px; /* Отступ справа */
        }

        #balance {
            margin-right: 10px;
        }

        #topup-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        #topup-button:hover {
            background-color: #2980b9;
        }
         /* Кнопка "Выйти" */
        .logout-button {
            background-color: #3498db; /* Цвет как у кнопки пополнения баланса */
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none; /* Убираем подчеркивание ссылки */
            margin-right: 20px; /* Отступ справа, чтобы не прилипала к балансу */
        }

        .logout-button:hover {
            background-color: #2980b9; /* Затемнение при наведении */
        }
        main {
            padding: 20px;
        }

        /* Контейнер для бронирований и истории платежей */
        .bookings-payments-container {
            display: flex;
            gap: 40px;
            width: 100%;
            justify-content: space-between;
        }

        /* Общий стиль для полупрозрачных блоков */
        .glass-panel {
            background-color: rgba(30, 30, 30, 0.7);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            width: 30%;
            box-sizing: border-box;
            min-height: 150px;
            left: 360px;
        }... .glass-panel h2 {
            color: #00bcd4;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #424242;
            padding-bottom: 10px;
        }

        /* Стили для списка бронирований */
        #bookings-list p {
            margin-bottom: 8px;
        }

        /* Стили для секции компьютеров */
        #all-computers {
            margin-top: 30px;
        }

        .computers-grid {
            display: flex;
            flex-wrap: wrap; /* Разрешить перенос блоков на новую строку */
            gap: 20px; /* Расстояние между блоками */
            justify-content: flex-start; /* Выравнивание блоков влево */
            width: 100%;
        }

        /* Увеличенный отступ для секции "Доступные компьютеры" */
        #all-computers {
            margin-top: 150px; /* Увеличенный вертикальный отступ */
        }

        /* Увеличение ширины блоков с компьютерами */
        .computer-item {
            background-color: rgba(30, 30, 30, 0.7);
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            width: 550px; /* Еще большая максимальная ширина каждого блока */
            text-align: left; /* Выравнивание текста внутри блока */
            margin: 0; /* Убрать отступы */
        }

        /* Стили для контейнера с датой и временем */
        .date-time-container {
            display: flex;
            align-items: center; /* Выравнивание по центру по вертикали */
            gap: 10px; /* Расстояние между элементами */
            margin-bottom: 10px; /* Отступ снизу */
        }

        /* Стили для полей ввода даты и времени */
        .date-time-container input[type="date"],
        .date-time-container input[type="time"] {
            width: auto; /* Автоматическая ширина */
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #424242;
            background-color: rgba(255, 255, 255, 0.1); /* Полупрозрачный фон */
            color: #e0e0e0; /* Цвет текста */
        }

        .computer-item h3 {
            color: #00bcd4;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .computer-item p {
            margin-bottom: 8px;
        }

        .computer-item form label,
        .computer-item form input,
        .computer-item form button {
            display: block;
            margin-bottom: 8px;
        }

        .computer-item form button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .computer-item form button:hover {
            background-color: #2980b9;
        }

        .empty-message {
            font-style: italic;
            color: #757575;
        }

        /* Modal styles */
        .modal {
            display: none; /* Скрыто по умолчанию */
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Фон за модальным окном */
            z-index: 1;
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .modal-content form {
            text-align: left; /* Выравнивание формы */
        }

        .modal-content label {
            display: block;
            margin-bottom: 5px;
        }... .modal-content input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .modal-content button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<header>
    <div class="header-text">| Компьютерный клуб - Watched |</div>
    <div class="balance-container">
        <span id="balance">Ваш баланс: <?php echo htmlspecialchars($balance); ?> рублей</span>
        <button id="topup-button">Пополнить баланс</button>
    </div>
     <a href="http://localhost/watchedl/db_connect.php" class="logout-button">Выйти</a>
</header>
<main>
    <?php
    // Вывод сообщений
    if (isset($_SESSION['success'])) {
        echo '<div id="modal" class="modal">
            <div class="modal-content">
                <p>' . $_SESSION['success'] . '</p>
            </div>
        </div>';
        echo '<script>
            setTimeout(function() {
                document.getElementById("modal").style.display = "none";
            }, 5000); // Закрыть через 5 секунд
        </script>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<div id="modal" class="modal">
            <div class="modal-content">
                <p>' . $_SESSION['error'] . '</p>
            </div>
        </div>';
        echo '<script>
            setTimeout(function() {
                document.getElementById("modal").style.display = "none";
            }, 5000); // Закрыть через 5 секунд
        </script>';
        unset($_SESSION['error']);
    }
    ?>

    <div class="bookings-payments-container">
        <!-- Мои бронирования -->
        <section id="user-profile" class="glass-panel">
            <h2>Мои бронирования</h2>
            <div id="bookings-list">
                <?php if (empty($bookings)): ?>
                    <p class="empty-message">У вас пока нет бронирований.</p>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                        <p>ПК: <?php echo htmlspecialchars($booking['computer_name']); ?> | Дата: <?php echo htmlspecialchars($booking['booking_date']); ?> | Время: <?php echo htmlspecialchars($booking['booking_time']); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- История платежей -->
        <section id="payment-history" class="glass-panel">
            <h2>История оплат</h2>
            <?php if (empty($payments)): ?>
                <p class="empty-message">У вас пока нет истории оплат.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($payments as $payment): ?>
                        <li>
                            Сумма: <?php echo htmlspecialchars($payment['amount']); ?> рублей |
                            Дата: <?php echo htmlspecialchars($payment['date']); ?> |
                            Способ: <?php echo htmlspecialchars($payment['method']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
        <!-- Список компьютеров в рамочках -->
        <section id="all-computers">
            <h2>Доступные компьютеры</h2>
            <div class="computers-grid">
                <?php foreach ($computers as $computer): ?>
                    <div class="computer-item">
                        <h3><?php echo htmlspecialchars($computer['computer_name']); ?></h3>
                        <p><?php echo isset($computer['specs']) ? htmlspecialchars($computer['specs']) : 'Описание отсутствует'; ?></p>
                        <p>Цена: <?php echo isset($computer['price']) ? htmlspecialchars($computer['price']) : 'Цена не указана'; ?> рублей/час</p>
                        <form method="POST" action="process_booking.php">
                            <input type="hidden" name="computer_id" value="<?php echo htmlspecialchars($computer['id']); ?>">
                            <div class="date-time-container">
                                <label for="booking_date">Дата:</label>
                                <input type="date" name="booking_date" id="booking_date" required>
                                <label for="booking_time">Время:</label>
                                <input type="time" name="booking_time" id="booking_time" required>
                            </div>
                            <button type="submit">Забронировать</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
</main>

<!-- Модальное окно для пополнения баланса -->
<div id="topup-modal" class="modal">
    <div class="modal-content">
        <h2>Пополнение баланса</h2>
        <form id="topup-form" method="POST" action="process_topup.php">
            <label for="amount">Сумма:</label>
            <input type="number" name="amount" id="amount" required placeholder="Введите сумму">
            <label for="number_card">Номер карты:</label>
            <input type="text" name="number_card" id="number_card" required placeholder="Введите номер карты">
            <button type="submit">Подтвердить оплату</button>
        </form>
    </div>
</div>

<script>
    // Открытие модального окна при нажатии на кнопку "Пополнить баланс"
    document.getElementById('topup-button').addEventListener('click', function() {
        document.getElementById('topup-modal').style.display = 'block';
    });

    // Закрытие модального окна по клику вне его
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('topup-modal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>
</body>
</html>
