<?php
session_start();

// Проверка авторизации менеджера
if (!isset($_SESSION['manager_id'])) {
    header("Location: login_manager.php");
    exit();
}

require_once 'db.php';

// Обработка действий
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $email = $_POST['email'];
        $computer_name = $_POST['computer_name'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        // Получение ID пользователя по email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Получение ID компьютера по названию
        $stmt = $pdo->prepare("SELECT id FROM computers WHERE computer_name = ?");
        $stmt->execute([$computer_name]);
        $computer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $computer) {
            $user_id = $user['id'];
            $computer_id = $computer['id'];
            $stmt = $pdo->prepare("INSERT INTO sessions (user_id, computer_id, start_time, end_time) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $computer_id, $start_time, $end_time]);
        } else {
            $error = "Пользователь или компьютер не найдены.";
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $computer_name = $_POST['computer_name'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        // Получение ID пользователя по email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Получение ID компьютера по названию
        $stmt = $pdo->prepare("SELECT id FROM computers WHERE computer_name = ?");
        $stmt->execute([$computer_name]);
        $computer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $computer) {
            $user_id = $user['id'];
            $computer_id = $computer['id'];
            $stmt = $pdo->prepare("UPDATE sessions SET user_id = ?, computer_id = ?, start_time = ?, end_time = ? WHERE id = ?");
            $stmt->execute([$user_id, $computer_id, $start_time, $end_time, $id]);
        } else {
            $error = "Пользователь или компьютер не найдены.";
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Получение всех сессий с почтой пользователя и названием компьютера
$stmt = $pdo->query("
    SELECT 
        sessions.*,
        users.email AS user_email,
        computers.computer_name AS computer_name
    FROM sessions
    JOIN users ON sessions.user_id = users.id
    JOIN computers ON sessions.computer_id = computers.id
");
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Получение списка пользователей для выбора
$usersStmt = $pdo->query("SELECT email FROM users");
$users = $usersStmt->fetchAll(PDO::FETCH_COLUMN);

// Получение списка компьютеров для выбора
$computersStmt = $pdo->query("SELECT computer_name FROM computers");
$computers = $computersStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление сессиями</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Управление сессиями</h1>
    <div class="back-button-container">
        <a href="http://localhost/watchedl/managers/profile_managers.php"><button class="back-button">Назад</button></a>
    </div>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- Форма для создания новой сессии -->
    <h2>Добавить сессию</h2>
    <form method="POST">
        <input type="hidden" name="create" value="1">
        <label>Email пользователя: 
            <select name="email" required>
                <?php foreach ($users as $email): ?>
                    <option value="<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Название компьютера: 
            <select name="computer_name" required>
                <?php foreach ($computers as $computer_name): ?>
                    <option value="<?= htmlspecialchars($computer_name) ?>"><?= htmlspecialchars($computer_name) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Start Time: <input type="datetime-local" name="start_time" required></label><br>
        <label>End Time: <input type="datetime-local" name="end_time" required></label><br>
        <button type="submit">Добавить</button>
    </form>

    <!-- Список сессий -->
    <h2>Список сессий</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Email пользователя</th>
            <th>Название компьютера</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($sessions as $session): ?>
        <tr>
            <td><?= htmlspecialchars($session['id']) ?></td>
            <td><?= htmlspecialchars($session['user_email']) ?></td>
            <td><?= htmlspecialchars($session['computer_name']) ?></td>
            <td><?= htmlspecialchars($session['start_time']) ?></td>
            <td><?= htmlspecialchars($session['end_time']) ?></td>
            <td>
                <a href="?edit=<?= $session['id'] ?>">Редактировать</a>
                <form method="POST" style="display: inline-block;">
                    <input type="hidden" name="delete" value="<?= $session['id'] ?>">
                    <button type="submit" onclick="return confirm('Вы уверены?')">Удалить</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Форма для редактирования сессии -->
    <?php if (isset($_GET['edit'])): ?>
    <?php
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM sessions WHERE id = ?");
    $stmt->execute([$id]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);
        // Получение списка пользователей для выбора
    $usersStmt = $pdo->query("SELECT email FROM users");
    $users = $usersStmt->fetchAll(PDO::FETCH_COLUMN);

    // Получение списка компьютеров для выбора
    $computersStmt = $pdo->query("SELECT computer_name FROM computers");
    $computers = $computersStmt->fetchAll(PDO::FETCH_COLUMN);
    ?>
    <h2>Редактировать сессию</h2>
    <form method="POST">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
      
<!-- Поле для ввода email -->
<label>Email:</label>
<input 
    type="email" 
    name="email" 
    value="<?php echo isset($session['email']) ? htmlspecialchars($session['email']) : ''; ?>" 
    required
/>


       <!-- Поле для выбора компьютера -->
<label>Название компьютера:</label>
<select name="computer_name" required>
    <?php foreach ($computers as $computer_name): ?>
        <option value="<?php echo htmlspecialchars($computer_name); ?>"
            <?php if (isset($session['computer_name']) && $computer_name === $session['computer_name']): ?>
                selected
            <?php endif; ?>>
            <?php echo htmlspecialchars($computer_name); ?>
        </option>
    <?php endforeach; ?>
</select>


        </label><br>
        <label>Start Time: <input type="datetime-local" name="start_time" value="<?= htmlspecialchars($session['start_time']) ?>" required></label><br>
        <label>End Time: <input type="datetime-local" name="end_time" value="<?= htmlspecialchars($session['end_time']) ?>" required></label><br>
        <button type="submit">Сохранить</button>
    </form>
    <?php endif; ?>
</body>
</html>
