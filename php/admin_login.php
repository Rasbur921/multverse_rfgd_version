<?php
include('db.php');
session_start();

$post_id = $_POST['id'];

// Готовим запрос
$stmt = $conn->prepare("SELECT id, login FROM users WHERE id = ?");
$stmt->bind_param("i", $post_id); // "i" = integer, и только один параметр
$stmt->execute();

// Получаем результат
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $login_db);
    $stmt->fetch();
    
    $_SESSION['login'] = $login_db;
    $_SESSION['id'] = $id;
    
    header("Location: ../profile.php?id=" . $id);
    exit; // <-- важно! прекращает выполнение, чтобы header сработал корректно
} else {
    header("Location: ../index.php?msng=fail_login");
    exit;
}
?>
