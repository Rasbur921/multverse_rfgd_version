<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
?>
<html lang="RU">
	<head>
		<title>Пользователи | MultVerse</title>
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
						<?php
							$query_new = mysqli_query($conn, "SELECT * FROM `users` ORDER BY id DESC");
							$count = 0;
							while ($array_new = mysqli_fetch_assoc($query_new)) {
							$id_n = $array_new['id'];
							$name_n = htmlspecialchars($array_new['login']);
                            $datestring = $array_new['date'];
                            $datest = DateTime::createFromFormat('d.m.Y H:i', $datestring);
                            $datest->modify('+8 hours');
                            $date_n = $datest->format('d.m.Y H:i');
                            $ava_n = $array_new['avatar'];
                                
								$query_сs = "SELECT COUNT(*) AS count FROM `anims` WHERE `user_id`= '$id_n'";
								$query_results = mysqli_query($conn, $query_сs);
								while($rows = mysqli_fetch_assoc($query_results)) {
								$outputs = $rows['count'];
                                }
						?>
							<td style="width: 130px" valign="top">
								<a href="profile.php?id=<?=$id_n?>"><img src="imgs/avatars/<?=$ava_n?>.gif" width="130"></a>
								<br>
								<a href="profile.php?id=<?=$id_n?>"><?=$name_n?></a>
								<br>
                                <a class="small_a"><?=$date_n?></a>
                                <br>
                                <a class="small_a">Анимаций: <?=$outputs?></a>
                                <br>
								<br>
							</td>
						<?php
							$count++;
							if($count % 5 == 0) echo "</tr><tr>";
							}
						?>
						</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
	</body>
</html>