<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);

    if (!empty($name) && $age > 0) {
        $stmt = $pdo->prepare("INSERT INTO user (name, age) VALUES (:name, :age)");
        $stmt->execute([':name' => $name, ':age' => $age]);
    }
}

header('Location: index.php');
exit;