<?php
$appName = "Управление сотрудниками";
$version = 1.0;                      
$year = 2026;                         
$menu = ['Сотрудники', 'Отчеты'];   

$employees = []; 
$file = __DIR__ . '/../data/employees.csv';

if (file_exists($file)) {
    $handle = fopen($file, 'r');
    $headers = fgetcsv($handle, 1000, ';', '"', '\\');
    
    while (($row = fgetcsv($handle, 1000, ';', '"', '\\')) !== false) {
        $employees[] = $row;
    }
    fclose($handle);
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
    <h1><?= $appName ?> (v<?= $version ?>)</h1>
    <p>Год: <?= $year ?></p>
    <table>
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th><?= htmlspecialchars($header) ?></th>
                <?php endforeach; ?>
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