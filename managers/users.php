<?php
require_once 'db.php';

// Обработка действий
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $balance = $_POST['balance'];
        $data_reg = date('Y-m-d'); // Установка текущей даты

        $stmt = $pdo->prepare("INSERT INTO users (surname, email, data_reg, balance) VALUES (?, ?, ?, ?)");
        $stmt->execute([$surname, $email, $data_reg, $balance]);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $data_reg = $_POST['data_reg'];
        $balance = $_POST['balance'];

        $stmt = $pdo->prepare("UPDATE users SET surname = ?, email = ?, data_reg = ?, balance = ? WHERE id = ?");
        $stmt->execute([$surname, $email, $data_reg, $balance, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Получение всех пользователей
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Управление пользователями</h1>
    <!-- В верхней части страницы -->
<div class="back-button-container">
    <a href="profile_managers.php"><button class="back-button">Назад</button></a>
</div>


    

    <!-- Форма для создания нового пользователя -->
    <h2>Добавить пользователя</h2>
    <form method="POST">
        <input type="hidden" name="create" value="1">
        <label>Фамилия: <input type="text" name="surname" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Баланс: <input type="number" step="0.01" name="balance" required></label><br>
        <button type="submit">Добавить</button>
    </form>

    <!-- Список пользователей -->
    <h2>Список пользователей</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Фамилия</th>
            <th>Email</th>
            <th>Дата регистрации</th>
            <th>Баланс</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['surname']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['data_reg']) ?></td>
            <td><?= htmlspecialchars($user['balance']) ?></td>
            <td>
                <a href="?edit=<?= $user['id'] ?>">Редактировать</a>
                <form method="POST" style="display: inline-block;">
                    <input type="hidden" name="delete" value="<?= $user['id'] ?>">
                    <button type="submit" onclick="return confirm('Вы уверены?')">Удалить</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Форма для редактирования пользователя -->
    <?php if (isset($_GET['edit'])): ?>
    <?php
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>Редактировать пользователя</h2>
    <form method="POST">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
        <label>Фамилия: <input type="text" name="surname" value="<?= htmlspecialchars($user['surname']) ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></label><br>
        <label>Дата регистрации: <input type="date" name="data_reg" value="<?= htmlspecialchars($user['data_reg']) ?>" required></label><br>
        <label>Баланс: <input type="number" step="0.01" name="balance" value="<?= htmlspecialchars($user['balance']) ?>" required></label><br>
        <button type="submit">Сохранить</button>
    </form>
    <?php endif; ?>
</body>
</html>
