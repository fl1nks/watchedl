2 КТ
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 01 2025 г., 11:03
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `watchedl`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `computer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `computer_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `computer_id`, `user_id`, `booking_date`, `booking_time`, `computer_name`) VALUES
(41, 1, 1, '2025-03-26', '18:37:00', 'МойПК-01'),
(42, 1, 1, '2025-03-26', '17:41:00', 'МойПК-01'),
(43, 1, 1, '2025-03-05', '16:43:00', 'МойПК-01'),
(44, 1, 1, '2025-03-26', '02:46:00', 'МойПК-01'),
(45, 1, 1, '2025-04-02', '16:21:00', 'МойПК-01');

-- --------------------------------------------------------

--
-- Структура таблицы `computers`
--

CREATE TABLE `computers` (
  `id` int(11) NOT NULL,
  `computer_name` varchar(128) NOT NULL,
  `specs` varchar(256) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `computers`
--

INSERT INTO `computers` (`id`, `computer_name`, `specs`, `price`) VALUES
(1, 'МойПК-01', 'Intel i9, 32GB RAM, 512GB SSD', 150.00),
(4, 'Workstation', 'AMD Ryzen 9, 32GB RAM, 1TB NVMe', 1500.00),
(14, 'ва', 'uyhjihgufyguhiv', 600.00);

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE `managers` (
  `id` int(11) NOT NULL,
  `login` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `managers`
--

INSERT INTO `managers` (`id`, `login`, `password`) VALUES
(1, 'admin', '123456789');

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL,
  `method` varchar(50) NOT NULL,
  `number_card` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `computer_id` int(11) NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `computer_id`, `start_time`, `end_time`) VALUES
(0, 8, 4, '2025-03-28', '2025-03-28');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `surname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `data_reg` date DEFAULT curdate(),
  `balance` decimal(20,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `surname`, `email`, `data_reg`, `balance`) VALUES
(1, 'test', 'test@example.com', '2025-03-25', 30550.00),
(8, 'папв2', 'kro11ik02@mail.ru', '2025-03-25', 0.00),
(9, 'папв', 'kro11ik02@mail.ru', '2025-03-25', 0.00),
(10, 'папв', 'kro11ik02@mail.ru', '2025-03-25', 0.00);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `computer_id` (`computer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `computers`
--
ALTER TABLE `computers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_payment` (`user_id`,`date`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `computer_id` (`computer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`computer_id`) REFERENCES `computers` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`computer_id`) REFERENCES `computers` (`id`),
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

----------------------------------------------------------------------------------------------------------------
3 КТ
Компьютерный Клуб
Для веб-приложения выбрана СУБД MySQL. Работа с СУБД производится при помощи панели управления PHPMyAdmin.
	В СУБД MySQL структура БД выглядит так:
 ![image](https://github.com/user-attachments/assets/d706fd1b-95d5-4e77-8e0c-35c7d6ea7f40)
![image](https://github.com/user-attachments/assets/3d611bd4-aad9-4f05-9cf1-9303db342f55)
![image](https://github.com/user-attachments/assets/dd4ef8a0-9c53-4fca-b778-236210b0b158)
![image](https://github.com/user-attachments/assets/608a8f33-326a-48a7-b11a-ffb677beb5f8)
![image](https://github.com/user-attachments/assets/aff1ca45-e21e-4031-8c67-5dfb88fb8b2d)
![image](https://github.com/user-attachments/assets/4e2e5eaa-282c-46cf-a6f7-c4b382c467bb)
![image](https://github.com/user-attachments/assets/718b92c8-e4d9-4461-b4c0-d8f1fd65ccd3)
![image](https://github.com/user-attachments/assets/700a610a-07e0-4e82-87a2-91bc4f12f49c)


 

 

 

 
 

 

 


 
Классы PHP

Взаимодействие с компьютерами

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












Взаимодействие с пользователями

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











Взаимодействие с сессиями

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







































Создание отчетов

<?php
require_once 'db.php'; // Подключение к базе данных
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Запрос данных из базы данных
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Создание отчета в Word
$phpWord = new PhpWord();
$section = $phpWord->addSection();
$section->addText('Отчет по пользователям', array('size' => 24));

$table = $section->addTable();
$table->addRow();
$table->addCell(2000)->addText('ID');
$table->addCell(2000)->addText('Имя');
$table->addCell(2000)->addText('Email');

foreach ($users as $user) {
    $table->addRow();
    $table->addCell(2000)->addText($user['id']);
    $table->addCell(2000)->addText($user['surname']);
    $table->addCell(2000)->addText($user['email']);
}

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('export/users_report.docx');

// Создание отчета в Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Имя');
$sheet->setCellValue('C1', 'Email');

$row = 2;
foreach ($users as $user) {
    $sheet->setCellValue('A' . $row, $user['id']);
    $sheet->setCellValue('B' . $row, $user['surname']);
    $sheet->setCellValue('C' . $row, $user['email']);
    $row++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('export/users_report.xlsx');

echo "Отчеты созданы успешно!";










Процесс оплаты

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



Процесс бронирования

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









Отдельный класс для взаимодействия с базой данных

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




Описание функционала программы
 ![image](https://github.com/user-attachments/assets/079b0df4-7b99-408d-bfe8-96b277aefdc5)

Рис. 1 – Главная страница
Вход со стороны клиента
 ![image](https://github.com/user-attachments/assets/7ab922ce-9731-444a-be66-ecaa941f9952)
Рис. 2 – Войти за клиента
 ![image](https://github.com/user-attachments/assets/1ef1c95e-cf1d-41db-9a60-5bfaabbbb093)
Рис. 3 – Зарегистрироваться за клиента

Для входа или регистрации в системе необходимо ввести фамилию и email.
 ![image](https://github.com/user-attachments/assets/234f86c2-48da-47e9-9c80-4bbf7d83d4a3)
Рис. 4 – Личный кабинет клиента и историей оплат, доступными компьютерами для бронирования и списком текущих бронирований.
На странице отображается список доступных компьютеров для бронирования, а также информация о ваших текущих бронированиях и истории оплат.
 ![image](https://github.com/user-attachments/assets/75e1dc9f-e3fc-4382-b54d-127ebe2a0e6a)
Рис. 5 – Страница пополнения счета
Для того чтобы начать бронирование, сначала необходимо пополнить счет - для этого нужно нажать кнопку «Пополнить баланс» в верхней части страницы, ввести сумму, номер карту и подтвердить оплату.
Далее вы можете выбрать подходящий компьютер из списка, указать желаемые дату и время, и нажать кнопку «Забронировать».

 ![image](https://github.com/user-attachments/assets/5f4605d7-53e9-401e-bd5b-b9923e1aef94)
Рис. 6 – История транзакций в личном кабинете
После успешного бронирования в истории оплат появится еще одна запись, а в разделе «Мои бронирования» отобразится новое бронирование с выбранными параметрами.

Вход со стороны сотрудника
 ![image](https://github.com/user-attachments/assets/0fb02d0f-e182-4356-8cda-a9446024c255)
Рис. 7 – Вход для сотрудников
 ![image](https://github.com/user-attachments/assets/2f71b5e7-e689-4df0-991f-d5c2cb9d7f52)
Рис. 8 – Регистрация для сотрудников
![image](https://github.com/user-attachments/assets/61f3072b-d2ed-433d-98ac-6590876b1dd6)

С сотрудниками в случае входа и регистрации та же ситуация что и для клиентов.
 ![image](https://github.com/user-attachments/assets/c6a97b77-1472-4390-b402-b572e81d4dc4)
Рис. 9 – Панель управления сотрудников
Сотруднику предоставлен полный доступ для управления пользователями, компьютерами и сессиями. Также доступны кнопки для создания отчетов в форматах Word и Excel.
 ![image](https://github.com/user-attachments/assets/b60550e4-ad9b-4c48-8efe-d4e5fce70130)
Рис. 10 – Управление пользователями 
Администратор может добавлять новых пользователей, редактировать их данные и баланс, а также просматривать список всех зарегистрированных пользователей с их балансами и датами регистрации.  
![image](https://github.com/user-attachments/assets/3a4a77f1-b4b6-46a3-b5b9-07536ab8ffdb)

Рис. 11 – Управление компьютерами
В разделе управления компьютерами можно добавлять новые компьютеры, указывать их характеристики и стоимость аренды, а также редактировать или удалять существующие записи. Вся информация представлена в виде таблицы для удобства поиска и управления.  
![image](https://github.com/user-attachments/assets/b4b14c0b-3ad8-4a29-9e12-c8a1d2da4618)

Рис. 12 – Управление сессиями
На данной странице администратор может добавить новую сессию, указав email пользователя, компьютер, дату и время начала и окончания. После добавления сессия появится в списке ниже, где отображаются все активные и завершённые сессии с возможностью управления ими.
![image](https://github.com/user-attachments/assets/42666ba2-7ce6-4f81-b66f-fdfa8cb811f3)
Рис. 13 – Отчет пополнения Word
 ![image](https://github.com/user-attachments/assets/73fa0dfa-640f-485a-bc5d-bc783948be02)
Рис. 14 – Отчет пополнения Excel
В этом отчете содержится информация о финансовых операциях пользователей — суммы пополнения баланса, даты и способы оплаты. Отчет полезен для учета поступлений и контроля денежных потоков.
 ![image](https://github.com/user-attachments/assets/346bdacd-a590-468a-8db3-2eba97ecd8c7)
Рис. 15 – Отчет бронирования Word
 ![image](https://github.com/user-attachments/assets/69d4f32c-94b3-4329-9c0a-d2152f888053)
Рис. 16 – Отчет бронирования Excel
Этот отчет предоставляет данные о всех совершенных пользователями бронированиях: выбранный компьютер, дата и время. Он помогает анализировать загруженность и предпочтения клиентов.
 ![image](https://github.com/user-attachments/assets/dfa8f512-f634-4c93-a2c6-6f5012409df8)
Рис. 17 – Отчет компьютеров Word
 ![image](https://github.com/user-attachments/assets/e476ce93-9a7f-4da7-bcda-030c4bb2c0c6)
Рис. 18 – Отчет компьютеров Excel
Данный отчет содержит информацию компьютерах: технические характеристику, название и цену.
 ![image](https://github.com/user-attachments/assets/545e9eae-1ce9-4782-96e4-03f9e1862587)
Рис. 19 – Отчет сессий пользователя Word
 ![image](https://github.com/user-attachments/assets/6b741c18-d1df-4247-a787-f7d55c867fac)
Рис. 20 – Отчет сессий пользователя Excel
В отчете отображается детальная информация о каждой сессии конкретного пользователя: дата, время начала и окончания. Такой отчет удобен для проверки истории посещений и выявления активности пользователей.



