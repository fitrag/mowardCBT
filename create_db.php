<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS moward_cbt');
    echo 'Database created';
} catch (PDOException $e) {
    echo $e->getMessage();
}
