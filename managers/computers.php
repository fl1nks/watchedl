<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $computer_name = $_POST['computer_name'];
        $specs = $_POST['specs'];
        $price = $_POST['price'];

        $stmt = $pdo->prepare("INSERT INTO computers (computer_name, specs, price) VALUES (?, ?, ?)");
        $stmt->execute([$computer_name, $specs, $price]);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $computer_name = $_POST['computer_name'];
        $specs = $_POST['specs'];
        $price = $_POST['price'];

        $stmt = $pdo->prepare("UPDATE computers SET computer_name = ?, specs = ?, price = ? WHERE id = ?");
        $stmt->execute([$computer_name, $specs, $price, $id]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        $stmt = $pdo->prepare("DELETE FROM computers WHERE id = ?");
        $stmt->execute([$id]);
    }
}

$stmt = $pdo->query("SELECT * FROM computers");
$computers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление компьютерами</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Управление компьютерами</h1>
    
    <!-- В верхней части страницы -->
<div class="back-button-container">
    <a href="profile_managers.php"><button class="back-button">Назад</button></a>
</div>


    <!-- Форма для создания нового компьютера -->
    <h2>Добавить компьютер</h2>
    <form method="POST">
        <input type="hidden" name="create" value="1">
        <label>Название: <input type="text" name="computer_name" required></label><br>
        <label>Характеристики: <textarea name="specs" required></textarea></label><br>
        <label>Цена: <input type="number" step="0.01" name="price" required></label><br>
        <button type="submit">Добавить</button>
    </form>

    <!-- Список компьютеров -->
    <h2>Список компьютеров</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Характеристики</th>
            <th>Цена</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($computers as $computer): ?>
        <tr>
            <td><?= htmlspecialchars($computer['id']) ?></td>
            <td><?= htmlspecialchars($computer['computer_name']) ?></td>
            <td><?= htmlspecialchars($computer['specs']) ?></td>
            <td><?= htmlspecialchars($computer['price']) ?></td>
            <td>
                <a href="?edit=<?= $computer['id'] ?>">Редактировать</a>
                <form method="POST" style="display: inline-block;">
                    <input type="hidden" name="delete" value="<?= $computer['id'] ?>">
                    <button type="submit" onclick="return confirm('Вы уверены?')">Удалить</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Форма для редактирования компьютера -->
    <?php if (isset($_GET['edit'])): ?>
    <?php
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM computers WHERE id = ?");
    $stmt->execute([$id]);
    $computer = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>Редактировать компьютер</h2>
    <form method="POST">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="<?= htmlspecialchars($computer['id']) ?>">
        <label>Название: <input type="text" name="computer_name" value="<?= htmlspecialchars($computer['computer_name']) ?>" required></label><br>
        <label>Характеристики: <textarea name="specs" required><?= htmlspecialchars($computer['specs']) ?></textarea></label><br>
        <label>Цена: <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($computer['price']) ?>" required></label><br>
        <button type="submit">Сохранить</button>
    </form>
    <?php endif; ?>
</body>
</html>
