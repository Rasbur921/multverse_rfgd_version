<?php
$id = $_GET['id'];
$path = 'swf/' . basename($id) . '.swf';

if (file_exists($path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    readfile($path);
} else {
    echo "Τΰιλ νε νΰιδεν.<br>";
	die();
}
?>