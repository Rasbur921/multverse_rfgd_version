<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];

?>
<html lang="RU">
	<head>
		<title>Справочник по анимациям | MultVerse</title>
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
				<td width="760" valign="top">
				<center>
                    <h3>Здесь будут примеры полезных кодов для анимаций. Так же каждый урок будет включать в себя исходник для самостоятельного рассмотрения.</h3>
                </center>
					<a href="guide_page.php?id=1">1. Загрузка анимации</a><br>
                    <a href="guide_page.php?id=2">2. Кнопка "Старт" и "Заново"</a><br>
                    <a href="guide_page.php?id=3">3. Открытие ссылки по кнопке</a><br>
				</td>
			</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
	</body>
</html>