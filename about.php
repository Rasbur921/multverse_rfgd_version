<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
?>
<html lang="RU">
	<head>
		<title>О сайте | MultVerse</title>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="icon" href="imgs/favicon.png" type="image/x-icon"/>
	</head>
	<body link="0072C9" vlink="#0079D7" alink="#0083E8">
		<?
			include('includes/header.php');
		?>
		<br>
		<center>
			<img src="imgs/content-bg-top.gif" width="760" height="10" border="0" style="display:block"><!--
		--><table width="760" border="0" align="center" cellpadding="3" cellspacing="3" background="imgs/content-bg.gif" style="display:block">
			<tr>
				<td width="760" valign="top" align="center">
					<img src="imgs/logo.gif">
                    <br>
                    <h1>Вы находитесь на сайте MultVerse - Вселенной флеш мультов!</h1>
                    <h3>Данный сайт является инди-проектом про сайт в стиле начала-середины 2000-х. Здесь можно выкладывать свои мульты, смотреть и оценивать мульты других! Главной фишкой этого сайта является возможность создания отдельных мультов со своими эпизодами и сезонами.<br><br>
                    Данный сайт сделал и придумал человек <a href="http://rasbur.w10.site" target="_blank">Rasbur</a> + кодом помогал ChatGPT 28 октября 2025 года.</h3>
					<h4>А ещё вы смотрите его опен-сурс версию, которая была официальной примерно 30 мая-1 апреля  2026 года:P</h4>
				</td>
			</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
	</body>
</html>