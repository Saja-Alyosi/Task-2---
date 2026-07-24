<?php
require_once 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // جلب الحالة الحالية
    $stmt = $pdo->prepare("SELECT status FROM user WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $newStatus = ($user['status'] == 0) ? 1 : 0;
        $update = $pdo->prepare("UPDATE user SET status = :status WHERE id = :id");
        $update->execute([':status' => $newStatus, ':id' => $id]);
    }
}

header('Location: index.php');
exit;