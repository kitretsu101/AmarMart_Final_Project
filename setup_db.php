<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('CREATE DATABASE IF NOT EXISTS amarmart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo "MySQL OK — database amarmart ready\n";
} catch (Throwable $e) {
    echo "MySQL FAIL: " . $e->getMessage() . "\n";
    exit(1);
}
