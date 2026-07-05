<?php
session_start();

// Настройки
$width = 120;
$height = 40;

// Создаём картинку
$image = imagecreatetruecolor($width, $height);

// Цвета
$bg = imagecolorallocate($image, 240, 240, 240);
$line = imagecolorallocate($image, 150, 150, 150);
$text_color = imagecolorallocate($image, 0, 0, 0);

// Заливаем фон
imagefilledrectangle($image, 0, 0, $width, $height, $bg);

// Генерируем код
$chars = "ABCDEFGHJKLMNPRSTUVWXYZabcdefghijklmnopqrstuvwxyz23456789";
$code = "";
for ($i = 0; $i < 5; $i++) {
    $code .= $chars[rand(0, strlen($chars) - 1)];
}

// Сохраняем в сессию
$_SESSION['captcha'] = $code;

// Добавляем шум (старый стиль)
for ($i = 0; $i < 40; $i++) {
    imageline($image, rand(0,$width), rand(0,$height),
                     rand(0,$width), rand(0,$height), $line);
}

// Добавляем текст
imagestring($image, 5, 10, 12, $code, $text_color);

// Заголовки
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
