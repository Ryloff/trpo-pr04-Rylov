<?php
require_once __DIR__ . '/../src/functions.php'; 

$appName = "Управление сотрудниками";
$version = 1.0;                      
$year = 2026;    
$employees = loadEmployees(__DIR__ . '/../data/employees.csv');

$fio = trim($_POST['fio'] ?? '');
$email = trim($_POST['email'] ?? '');
$department = trim($_POST['department'] ?? '');
$days = trim($_POST['days'] ?? '');

$errors = []; 
$success = false; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strlen($fio) < 6) {
        $errors['fio'] = 'Введите полное ФИО (минимум 6 символов)';
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите корректный email';
    }
    
    if ($department === '') {
        $errors['department'] = 'Укажите отдел';
    }
    
    if (!is_numeric($days) || $days < 1 || $days > 14) {
        $errors['days'] = 'Количество дней должно быть от 1 до 14';
    }

    if (empty($errors)) {
        $success = true;
        $fio = $email = $department = $days = '';
    }
}

$filterDept = trim($_GET['dept'] ?? '');

if ($filterDept !== '') {
    $filteredEmployees = [];
    foreach ($employees as $emp) {
        if ($emp[2] === $filterDept) {
            $filteredEmployees[] = $emp;
        }
    }
    $employees = $filteredEmployees;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $appName ?></title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Новая заявка на отпуск</h2>

    <?php if ($success): ?>
        <p>Заявка успешно отправлена!</p>
    <?php endif; ?>

    <form method="POST" action="">
        <div>
            <label>ФИО:</label><br>
            <input type="text" name="fio" value="<?= htmlspecialchars($fio) ?>">
            <span style="color:red;"><?= $errors['fio'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <label>Email:</label><br>
            <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
            <span style="color:red;"><?= $errors['email'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <label>Отдел:</label><br>
            <select name="department">
                <option value="">-- Выберите --</option>
                <option value="Разработка" <?= $department === 'Разработка' ? 'selected' : '' ?>>Разработка</option>
                <option value="Аналитика" <?= $department === 'Аналитика' ? 'selected' : '' ?>>Аналитика</option>
                <option value="Тестирование" <?= $department === 'Тестирование' ? 'selected' : '' ?>>Тестирование</option>
            </select>
            <span style="color:red;"><?= $errors['department'] ?? '' ?></span>
        </div>
        <br>
        <div>
            <label>Кол-во дней (1-14):</label><br>
            <input type="number" name="days" value="<?= htmlspecialchars($days) ?>">
            <span style="color:red;"><?= $errors['days'] ?? '' ?></span>
        </div>
        <br>
        <button type="submit">Отправить заявку</button>
    </form>
    <p>Фильтр по отделу: 
    <a href="?dept=">Все</a> | 
    <a href="?dept=Разработка">Разработка</a> | 
    <a href="?dept=Аналитика">Аналитика</a>
    </p>
    <h1><?= $appName ?> (v<?= $version ?>)</h1>
    <p>Год: <?= $year ?></p>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>department</th>
                <th>experience</th>
                <th>email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <?php foreach ($employee as $value): ?>
                        <td><?= htmlspecialchars($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>