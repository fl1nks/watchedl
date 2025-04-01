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
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM managers WHERE login = :login AND password = :password");
    $stmt->execute(['login' => $login, 'password' => $password]);
    $manager= $stmt->fetch();

    if ($manager) {
        $_SESSION['manager_id'] = $manager['id'];
        $_SESSION['login'] = $manager['login'];

        // Перенаправление на страницу пользователя
        header("Location: managers/profile_managers.php");
        exit();
    } else {
        // Если данные неверны, показать ошибку на той же странице
        $_SESSION['login_error'] = "Неверные данные для входа. Попробуйте еще раз.";
        header("Location: db_connect.php");
        exit();
    }
}
?>


