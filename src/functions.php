<?php
function e($text) {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

function loadEmployees($filePath) {
    $employees = [];
    if (file_exists($filePath)) {
        $handle = fopen($filePath, 'r');
        fgetcsv($handle, 1000, ';', '"', '\\');
        while (($row = fgetcsv($handle, 1000, ';', '"', '\\')) !== false) {
            $employees[] = $row;
        }
        fclose($handle);
    }
    return $employees;
}