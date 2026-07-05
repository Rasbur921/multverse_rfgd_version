<?php
include('db.php');
session_start();
$session_id = $_SESSION['id'];

if (isset($_FILES['file'])) {
    $max_size = 75 * 1024; // 75 KB в байтах
    $file = $_FILES['file'];
	
    $title = $_POST['title'];
    $desc = $_POST['desc'];
	$date = date('d.m.Y H:i');
    
    // Проверка размера файла
    if ($file['size'] > $max_size) {
        header("Location: ../create_mult.php?error=limit");
		die();
    }
    
    // Проверка на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../create_mult.php?error=fail");
    }
    
    // Перемещение файла в целевую директорию
    $upload_dir = '../imgs/mult-icons/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

	$result = mysqli_query($conn, "INSERT INTO mults (`title`, `desc`, `date`, `user_id`) 
	VALUES ('$title', '$desc', '$date', '$session_id')");
		
	if (!$result) {
		die('Ошибка вставки: ' . mysqli_error($conn));
	}
	$future_id = $conn->insert_id;
    
    $file_path = $upload_dir . $future_id . '.gif';
	
	move_uploaded_file($file['tmp_name'], $file_path);
    
	header("Location: ../mult.php?id=" . $future_id);
}else{
	header("Location: ../create_mult.php?error=fail");
}
?>