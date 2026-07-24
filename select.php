<?php
require_once 'config.php';

function getUsers($pdo) {
    $stmt = $pdo->query("SELECT * FROM user ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>