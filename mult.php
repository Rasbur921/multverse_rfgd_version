<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$get_id = $_GET['id'];
	$get_c = $_GET['c'];
	
	$result = mysqli_query($conn, "SELECT * FROM mults WHERE id = '$get_id'");
	$row = mysqli_fetch_assoc($result);
	
	$title = htmlspecialchars($row['title']);
	$desc = htmlspecialchars($row['desc']);
		$datestring = $row['date'];
		$datest = DateTime::createFromFormat('d.m.Y H:i', $datestring);
		$datest->modify('+8 hours');
		$date = $datest->format('d.m.Y H:i');
	$user_id = $row['user_id'];
	
	$result_e = mysqli_query($conn, "SELECT * FROM anims WHERE mult_id = '$get_id'");
	$row_e = mysqli_fetch_assoc($result_e);
	
	$season = $row_e['season'];
	
	$result_u = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
	$row_u = mysqli_fetch_assoc($result_u);
	$name = htmlspecialchars($row_u['login']);
	$ava = $row_u['avatar'];
	
	$result_r = mysqli_query($conn, "SELECT * FROM rate WHERE `rate_id` = '$get_id' AND `user_id` = '$session_id' AND `type` = 'mult'");
	$row_r = mysqli_fetch_assoc($result_r);
	$user_id_r = $row_r['user_id'];

	$result_rv = mysqli_query($conn, "SELECT * FROM rate WHERE `rate_id` = '$get_id' AND `type` = 'mult' AND `user_id` = '$session_id'");
	$row_rv = mysqli_fetch_assoc($result_rv);
	
	$rate_id = $row_rv['id'];
	$user_value = $row_rv['value'];
	
	$rquery = "SELECT COUNT(*) AS value FROM `rate` WHERE `rate_id`= '{$get_id}' AND `type` = 'mult'";
	$rquery_result = mysqli_query($conn, $rquery);
	$rrow = mysqli_fetch_assoc($rquery_result);
	
	$routput = $rrow['value'];
	
	$rquery_mr = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$get_id}' AND `type` = 'mult'";
	$rquery_result_mr = mysqli_query($conn, $rquery_mr);
	$rrow_mr = mysqli_fetch_assoc($rquery_result_mr);
	
	$rating = round($rrow_mr['avg_rate'], 1);
	
	$result_s = mysqli_query($conn, "SELECT * FROM subs WHERE mult_id = '$get_id' AND user_id = '$session_id'");
	while($row_s = mysqli_fetch_assoc($result_s)){
		$sub_user_id = $row_s['user_id'];
	}
?>
<html lang="RU">
	<head>
		<title>Мульт "<?=$title?>" | MultVerse</title>
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
				<td width="255" valign="top">
					<h3>Описание:</h3>
					<a><?=$desc?></a>
					<hr>
					<a>Рейтинг: <a style="color:<?php
						if($rating < '2.4'){
							echo'red';
						}elseif($rating < '4.5' && $rating > '2.3'){
							echo'#EBCD00';
						}elseif($rating < '5.1' && $rating > '4.4'){
							echo'green';
						}?>"><?=$rating?></a></a>
					<br>
					<a class="small_a">Всего оценок: <?=$routput?></a>
					<hr>
					<?php
						if($sub_user_id != $session_id && $user_id != $session_id && !empty($session_id)){
					?>
						<a href="php/sub.php?id=<?=$get_id?>"><img src="imgs/subscribe.gif" width="141" height="31" alt="Подписаться"></a>
						<br>
					<?php
						}elseif($user_id != $session_id && !empty($session_id)){
					?>
						<a href="php/unsub.php?id=<?=$get_id?>"><img src="imgs/unsubscribe.gif" width="141" height="31" alt="Отписаться"></a>
						<br>
					<?php
						}
					?>
					<h2>Автор:</h2>
					<a href="profile.php?id=<?=$user_id?>"><img src="imgs/avatars/<?=$ava?>.gif" width="120"></a>
					<a href="profile.php?id=<?=$user_id?>"><h3><?=$name?></h3></a>
					<hr>
					<a>Дата создания: <?=$date?></a>
					<br>
					<?php
						if($user_id == $session_id){
					?>
						<hr>
						<a href="#" onclick="window.open('edit_mult.php?id=<?=$get_id?>','edit_popup','width=300,height=550,menubar=no,status=no,scrollbars=no'); return false;" class="small_a">Редактировать данные</a>
						<br>
						<br>
						<a href="php/delete_mult.php?id=<?=$get_id?>" class="small_a" style="color:red">Удалить мульт</a>
					<?php
						}
					?>
				</td>
				<td>
				<td>
				<td width="505" valign="top">
					<table>
						<tr align="middle">
							<td>
								<h1><?=$title?></h1>
							</td>
						</tr>
						<tr align="middle">
							<td>
								<img src="imgs/mult-icons/<?=$get_id?>.gif" width="230">
							</td>
						</tr>
						<tr>
							<td>
							<?php
								if($user_id_r != $session_id && $user_id != $session_id){
							?>
							<form action="php/rate_mult.php?id=<?=$get_id?>" method="post">
								<table>
									<tr>
										<td>
											<a>Оценить на</a>
										</td>
										<td>
											<select name="rate">
												<option value="1">1</a>
												<option value="2">2</a>
												<option value="3">3</a>
												<option value="4">4</a>
												<option value="5">5</a>
											</select>
										</td>
										<td>
											<button type="submit">Оценить!</button>
										</td>
									</tr>
								</table>
							</form>
							<?php
								}elseif(!empty($session_id) && $user_id != $session_id){
							?>
								<br>
								<a>Ваша оценка: <?=$user_value?></a><br>
								<form action="php/delete_rate_mult.php?id=<?=$rate_id?>&v_id=<?=$get_id?>" method="post">
									<button type="submit">Удалить оценку</button>
								</form>
							<?php
								}

								$query_сs = "SELECT COUNT(*) AS count FROM `anims` WHERE `mult_id`= '$get_id' AND `season` != '-1'";
								$query_results = mysqli_query($conn, $query_сs);
								while($rows = mysqli_fetch_assoc($query_results)) {
								$outputs = $rows['count'];
                                }   
                                    
								$query_сb = "SELECT COUNT(*) AS count FROM `anims` WHERE `mult_id`= '$get_id' AND `season` = '-1'";
								$query_resultb = mysqli_query($conn, $query_сb);
								while($rowb = mysqli_fetch_assoc($query_resultb)) {
								$outputb = $rowb['count'];
                                }
							?>
							<br>
								<table>
									<tr>
										<td><a href="mult.php?id=<?=$get_id?>&c=seasons">Сезоны (Эпизодов: <?=$outputs?>)</a></td>
										<td> | </td>
										<td><a href="mult.php?id=<?=$get_id?>&c=bonus">Доп. контент (Эпизодов: <?=$outputb?>)</a></td>
									</tr>
								</table>
							<br>
								<?php
								if($get_c == 'seasons' OR empty($get_c)){
								// Получаем список уникальных сезонов для данного мультфильма
								$seasons_query = mysqli_query($conn, "SELECT DISTINCT season FROM `anims` WHERE mult_id = '$get_id' AND season != '-1' ORDER BY season DESC");
								
								while ($season_row = mysqli_fetch_assoc($seasons_query)) {
									$season = $season_row['season'];
								?>
									<h2 id="season<?=$season?>"><?=$season?> сезон:</h2>
								
									<table>
										<?php
										// Получаем эпизоды только для этого сезона
										$query_s = mysqli_query($conn, "SELECT * FROM `anims` WHERE mult_id = '$get_id' AND season = '$season' ORDER BY id DESC");
										while ($array_s = mysqli_fetch_assoc($query_s)) {
											$id_s = $array_s['id'];
											$title_s = htmlspecialchars($array_s['title']);
                                            $age_s = $array_s['age'];
                                            $datestring_s = $array_s['date'];
                                            $datest_s = DateTime::createFromFormat('d.m.Y H:i', $datestring_s);
                                            $datest_s->modify('+8 hours');
                                            $date_s = $datest_s->format('d.m.Y H:i');

											$rquery_mr = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$id_s}' AND `type` = 'anim'";
											$rquery_result_mr = mysqli_query($conn, $rquery_mr);
											$rrow_mr = mysqli_fetch_assoc($rquery_result_mr);
											
											$rating = round($rrow_mr['avg_rate'], 1);
										?>
										<tr>
											<td>
												<a href="view.php?id=<?= $id_s ?>">
													<img src="imgs/anim-icons/<?= $id_s ?>.gif" width="150">
												</a>
											</td>
											<td style="width:340px">
												<a href="view.php?id=<?=$id_s ?>"><?= $title_s ?></a>
                                                <br>
                                                <img src="imgs/rating/<?=$age_s?>+.gif" width=20 height=20>
                                                <br>
												<a class="small_a">Дата: <?=$date_s?></a>
												<br>
												<a class="small_a">Рейтинг: <a style="color:<?php
													if($rating < '2.4'){
														echo'red';
													}elseif($rating < '4.5' && $rating > '2.3'){
														echo'#EBCD00';
													}elseif($rating < '5.1' && $rating > '4.4'){
														echo'green';
													}?>" class="small_a"><?=$rating?></a></a>
												<hr>
											</td>
										</tr>
										<?php
										} // конец цикла эпизодов
										?>
									</table>
								<br>
								<br>
								<hr>
								<br>
								<br>
								<?php
								} // конец цикла сезонов
								}
								?>
								
								<?php
								if($get_c == 'bonus'){
								?>
									<table>
										<?php
										// Получаем эпизоды только для этого сезона
										$query_s = mysqli_query($conn, "SELECT * FROM `anims` WHERE mult_id = '$get_id' AND season = '-1' ORDER BY id DESC");
										while ($array_s = mysqli_fetch_assoc($query_s)) {
											$id_s = $array_s['id'];
											$title_s = htmlspecialchars($array_s['title']);
                                            $age_s = $array_s['age'];
                                            $datestring_s = $array_s['date'];
                                            $datest_s = DateTime::createFromFormat('d.m.Y H:i', $datestring_s);
                                            $datest_s->modify('+8 hours');
                                            $date_s = $datest_s->format('d.m.Y H:i');

											$rquery_mr = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$id_s}' AND `type` = 'anim'";
											$rquery_result_mr = mysqli_query($conn, $rquery_mr);
											$rrow_mr = mysqli_fetch_assoc($rquery_result_mr);
											
											$rating = round($rrow_mr['avg_rate'], 1);
										?>
										<tr>
											<td>
												<a href="view.php?id=<?= $id_s ?>">
													<img src="imgs/anim-icons/<?= $id_s ?>.gif" width="150">
												</a>
											</td>
											<td style="width:340px">
												<a href="view.php?id=<?=$id_s ?>"><?= $title_s ?></a>
                                                <br>
                                                <img src="imgs/rating/<?=$age_s?>+.gif" width=20 height=20>
                                                <br>
												<a class="small_a">Дата: <?=$date_s?></a>
												<br>
												<a class="small_a">Рейтинг: <a style="color:<?php
													if($rating < '2.4'){
														echo'red';
													}elseif($rating < '4.5' && $rating > '2.3'){
														echo'#EBCD00';
													}elseif($rating < '5.1' && $rating > '4.4'){
														echo'green';
													}?>" class="small_a"><?=$rating?></a></a>
												<hr>
											</td>
										</tr>
										<?php
										} // конец цикла эпизодов
										?>
									</table>
								<br>
								<br>
								<hr>
								<br>
								<br>
								<?php
								}
								?>
							</td>
						</tr>
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