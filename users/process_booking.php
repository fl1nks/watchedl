<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: profile_users.php');
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        $computerId = $_POST['computer_id'];
        $bookingDate = $_POST['booking_date'];
        $bookingTime = $_POST['booking_time'];

        // Получаем имя компьютера для записи в bookings
        $computerNameStmt = $pdo->prepare("SELECT computer_name FROM computers WHERE id = ?");
        $computerNameStmt->execute([$computerId]);
        $computerName = $computerNameStmt->fetchColumn();

        // Проверяем доступность компьютера на указанное время
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE computer_id = ? AND booking_date = ? AND booking_time = ?");
        $checkStmt->execute([$computerId, $bookingDate, $bookingTime]);
        if ($checkStmt->fetchColumn() > 0) {
            $_SESSION['error'] = "Компьютер уже забронирован на это время.";
            header('Location: profile_users.php');
            exit;
        }

        // Получаем цену компьютера
        $priceStmt = $pdo->prepare("SELECT price FROM computers WHERE id = ?");
        $priceStmt->execute([$computerId]);
        $pricePerHour = (float)$priceStmt->fetchColumn();

        // Проверяем баланс пользователя
        $balanceStmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
        $balanceStmt->execute([$userId]);
        if ($balanceStmt->fetchColumn() < $pricePerHour) {
            $_SESSION['error'] = "Недостаточно средств для бронирования.";
            header('Location: profile_users.php');
            exit;
        }

        // Списываем деньги с баланса пользователя
        $updateBalanceStmt = $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        if (!$updateBalanceStmt->execute([$pricePerHour, $userId])) {
            $_SESSION['error'] = "Ошибка при списании средств.";
            header('Location: profile_users.php');
            exit;
        }

        // Записываем платеж в историю
        $insertPaymentStmt = $pdo->prepare("
            INSERT INTO payment (user_id, amount, date, method)
            VALUES (?, ?, NOW(), ?)
        ");
        if (!$insertPaymentStmt->execute([$userId, -$pricePerHour, 'Booking'])) {
            $_SESSION['error'] = "Ошибка при записи платежа.";
            header('Location: profile_users.php');
            exit;
        }

        // Вставляем новое бронирование
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, computer_id, booking_date, booking_time, computer_name) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$userId, $computerId, $bookingDate, $bookingTime, htmlspecialchars($computerName)])) {
            $_SESSION['success'] = "Компьютер успешно забронирован!";
            header('Location: profile_users.php');
            exit;
        } else {
            $_SESSION['error'] = "Ошибка при создании бронирования.";
            header('Location: profile_users.php');
            exit;
        }
    }
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . htmlspecialchars($e->getMessage()));
}
?>
