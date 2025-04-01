<?php
$host = 'localhost';
$dbname = 'watchedl';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Операции</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Профиль менеджера</h1>
    <div class="back-button-container">
        <a href="http://localhost/watchedl/db_connect.php"><button class="back-button">Выход</button></a>
    </div>
    <div class="menu">
        <a href="users.php">Управление пользователями</a>
        <a href="computers.php">Управление компьютерами</a>
        <a href="sessions.php">Управление сессиями</a>

    </div>
</body>
</html>
