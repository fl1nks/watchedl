<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Вы не авторизованы.";
    header('Location: profile_users.php');
    exit;
}

// Подключение к базе данных
$host = 'localhost';
$dbname = 'watchedl';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получение данных из POST-запроса
    $userId = $_SESSION['user_id'];
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $numberCard = isset($_POST['number_card']) ? htmlspecialchars(trim($_POST['number_card'])) : '';

    // Валидация данных
    if ($amount <= 0) {
        $_SESSION['error'] = "Сумма пополнения должна быть больше нуля.";
        header('Location: profile_users.php');
        exit;
    }

    if (empty($numberCard)) {
        $_SESSION['error'] = "Пожалуйста, укажите номер карты.";
        header('Location: profile_users.php');
        exit;
    }

    // Обновление баланса пользователя
    $updateBalanceStmt = $pdo->prepare("UPDATE users SET balance = balance + :amount WHERE id = :user_id");
    $updateBalanceStmt->bindParam(':amount', $amount, PDO::PARAM_STR);
    $updateBalanceStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $updateBalanceSuccess = $updateBalanceStmt->execute();

    if (!$updateBalanceSuccess || $updateBalanceStmt->rowCount() === 0) {
        $_SESSION['error'] = "Не удалось обновить баланс пользователя.";
        header('Location: profile_users.php');
        exit;
    }

    // Добавление записи о платеже в таблицу payment
    $insertPaymentStmt = $pdo->prepare("
        INSERT INTO payment (user_id, amount, date, method, number_card)
        VALUES (:user_id, :amount, NOW(), :method, :number_card)
    ");
    $insertPaymentStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $insertPaymentStmt->bindParam(':amount', $amount, PDO::PARAM_STR);
    $insertPaymentStmt->bindValue(':method', 'Карта', PDO::PARAM_STR);
    $insertPaymentStmt->bindParam(':number_card', $numberCard, PDO::PARAM_STR);
    $insertPaymentSuccess = $insertPaymentStmt->execute();

    if (!$insertPaymentSuccess) {
        $_SESSION['error'] = "Не удалось сохранить запись о платеже.";
        header('Location: profile_users.php');
        exit;
    }

    // Установка сообщения об успехе
    $_SESSION['success'] = "Баланс успешно пополнен на сумму {$amount} рублей.";

    // Перенаправление обратно на страницу профиля
    header('Location: profile_users.php');
    exit;

} catch (PDOException $e) {
    error_log("Ошибка подключения к БД: " . $e->getMessage());
    $_SESSION['error'] = "Произошла ошибка при обработке запроса. Пожалуйста, попробуйте позже.";
    header('Location: profile_users.php');
    exit;
}