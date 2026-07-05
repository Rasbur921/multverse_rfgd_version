<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	
	if(empty($session_id)){
		header("Location: index.php");
	}

	mysqli_query($conn, "UPDATE `notifications` SET `read` = '1' WHERE `send_user_id` = '$session_id'");
?>
<html lang="RU">
	<head>
		<title>Уведомления | MultVerse</title>
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
				<a href="php/clear_notifs.php"><h3>Очистить уведомления</h3></a>
				<table>
					<?php
							$query_c = mysqli_query($conn, "SELECT * FROM `notifications` WHERE send_user_id = '$session_id' ORDER BY id DESC");
							while ($array_c = mysqli_fetch_assoc($query_c)) {
							$id_c = $array_c['id'];
							$text_c = htmlspecialchars($array_c['text']);
							$user_id_c = $array_c['user_id'];
							$view_id_c = $array_c['view_id'];
							$link = $array_c['link'];
                            $comm = $array_c['comm'];
							
							$result_u = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id_c'");
							$row_u = mysqli_fetch_assoc($result_u);
							
							$id_u = $row_u['id'];
							$name_u = htmlspecialchars($row_u['login']);
							$ava_u = $row_u['avatar'];
							
							if($link == 'view'){
								$result_a = mysqli_query($conn, "SELECT * FROM anims WHERE id = '$view_id_c'");
								$row_a = mysqli_fetch_assoc($result_a);
								
								$title_a = htmlspecialchars($row_a['title']);
							}
							
							if($link == 'mult'){
								$result_a = mysqli_query($conn, "SELECT * FROM mults WHERE id = '$view_id_c'");
								$row_a = mysqli_fetch_assoc($result_a);
								
								$title_a = htmlspecialchars($row_a['title']);
							}
					?>
							<tr id="<?=$id_c?>">
								<td valign="top">
									<a href="profile.php?id=<?=$id_u?>"><img src="imgs/avatars/<?=$ava_u?>.gif" width="100"></a>
								</td>
								<td valign="top">
									<a href="profile.php?id=<?=$id_u?>" class="small_a"><?=$name_u?></a><a class="small_a"> <?=$text_c?> "<?=$title_a?>"</a>
									<br>
									<a href="<?=$link?>.php?id=<?=$view_id_c?><?php if($comm == '1') { echo'#comments'; } ?>">Посмотреть</a>
									<hr>
								</td>
							</tr>
					<?php
						}
					?>
					</table>
				</td>
			</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
	</body>
</html>