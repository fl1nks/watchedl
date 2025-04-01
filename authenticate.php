<?php
session_start();

$host = 'localhost';
$dbname = 'watchedl';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE surname = :surname AND email = :email");
    $stmt->execute(['surname' => $surname, 'email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['surname'] = $user['surname'];

        // Перенаправление на страницу пользователя
        header("Location: users/profile_users.php");
        exit();
    } else {
        // Если данные неверны, показать ошибку на той же странице
        $_SESSION['surname_error'] = "Неверные данные для входа. Попробуйте еще раз.";
        header("Location: db_connect.php");
        exit();
    }
}
?>


