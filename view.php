<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$view_id = $_GET['id'];
	
	$result = mysqli_query($conn, "SELECT * FROM anims WHERE id = '$view_id'");
	$row = mysqli_fetch_assoc($result);
	
	$s_id = $row['id'];
	$mult_id = $row['mult_id'];
	$title = htmlspecialchars($row['title']);
	$desc = htmlspecialchars($row['desc']);
	$age = $row['age'];
		$datestring = $row['date'];
		$datest = DateTime::createFromFormat('d.m.Y H:i', $datestring);
		$datest->modify('+8 hours');
		$date = $datest->format('d.m.Y H:i');
	$width = $row['width'];
	$height = $row['height'];
	$season = $row['season'];
	$user_id = $row['user_id'];

	if(empty($s_id)){
		header("Location: index.php?msng=no_anim");
	}
	
	$result_u = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
	$row_u = mysqli_fetch_assoc($result_u);
	$name = htmlspecialchars($row_u['login']);
	$ava = $row_u['avatar'];
	
	$result_m = mysqli_query($conn, "SELECT * FROM mults WHERE id = '$mult_id'");
	$row_m = mysqli_fetch_assoc($result_m);
	$title_m = htmlspecialchars($row_m['title']);
	
	$result_r = mysqli_query($conn, "SELECT * FROM rate WHERE `rate_id` = '$view_id' AND `user_id` = '$session_id' AND `type` = 'anim'");
	$row_r = mysqli_fetch_assoc($result_r);
	$user_id_r = $row_r['user_id'];

	$result_rv = mysqli_query($conn, "SELECT * FROM rate WHERE `rate_id` = '$view_id' AND `type` = 'anim' AND `user_id` = '$session_id'");
	$row_rv = mysqli_fetch_assoc($result_rv);
	
	$rate_id = $row_rv['id'];
	$user_value = $row_rv['value'];
	
	$rquery = "SELECT COUNT(*) AS value FROM `rate` WHERE `rate_id`= '{$view_id}' AND `type` = 'anim'";
	$rquery_result = mysqli_query($conn, $rquery);
	$rrow = mysqli_fetch_assoc($rquery_result);
	
	$routput = $rrow['value'];
	
	$rquery_mr = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$view_id}' AND `type` = 'anim'";
	$rquery_result_mr = mysqli_query($conn, $rquery_mr);
	$rrow_mr = mysqli_fetch_assoc($rquery_result_mr);
	
	$rating = round($rrow_mr['avg_rate'], 1);
	
?>
<html lang="RU">
	<head>
		<title>"<?=$title?>" | MultVerse</title>
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
		--><table width="760" border="0" align="center" cellpadding="3" cellspacing="3" background="imgs/content-bg.gif" style="display:block">			<tr>
				<td width="200" valign="top">
					<h2>Автор:</h2>
					<a href="profile.php?id=<?=$user_id?>"><img src="imgs/avatars/<?=$ava?>.gif" width="120"></a>
					<a href="profile.php?id=<?=$user_id?>"><h3><?=$name?></h3></a>
					<hr>
					<a>Дата публикации: <?=$date?></a>
					<br>
					<br>
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
					<?php
						if($mult_id !== '-1'){
					?>
						<br>
						<br>					
						Мульт: <a href="mult.php?id=<?=$mult_id?>"><?=$title_m?></a>
						<br>
                    	<?php
                        	if($season != '-1'){
                        ?>
						Сезон: <a href="mult.php?id=<?=$mult_id?>#season<?=$season?>"><?=$season?> сезон</a>
                    	<?php
                                }else{
                        ?>
                        	<a href="mult.php?id=<?=$mult_id?>&c=bonus">Доп. контент</a>
                    	<?php
                            }
                    	?>
					<?php
						}
					?>
					<br>
					<?php
						if($user_id == $session_id){
					?>
						<hr>
						<a href="#" onclick="window.open('edit_anim.php?id=<?=$view_id?>','edit_popup','width=320,height=650,menubar=no,status=no,scrollbars=no'); return false;" class="small_a">Редактировать данные</a>
						<br>
						<br>
						<a href="php/delete_anim.php?id=<?=$view_id?>" class="small_a" style="color:red">Удалить анимацию</a>
					<?php
						}
					?>
				</td>
				<td>
				<td>
				<td width="560" valign="top">
						<script>
								window.RufflePlayer = window.RufflePlayer || {};
								window.RufflePlayer.config = {
									"warnOnUnsupportedContent": false, 
									"autoplay": "on", 
									"unmuteOverlay": "hidden"
								};
						</script>
						<script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
					<table>
						<tr>
							<td valign="top"><img src="imgs/rating/<?=$age?>+.gif" width=42 height=42></td>
							<td><h1><?=$title?></h1></td>
						</tr>
					</table>
					<?php
						if($age == 18 && empty($session_id)){
					?>
						<h1 style="color:red">Эта анимация 18+!</h1>
						<h3 style="color:red">Для его просмотра вам нужно войти в свой аккаунт!</h3>
					<?php
						}else{
					?>
						<object data="swf/<?=$view_id?>.swf" width="<?=$width?>" height="<?=$height?>"></object>
					<br>
					<br>
					<button onclick="window.open('download.php?id=<?=$view_id?>','download_popup','width=400,height=23,menubar=no,status=no,scrollbars=no'); return false;">Скачать</button>
					<br>
					<?php
						}
					?>
					<?php
						if($user_id_r != $session_id && $user_id != $session_id){
					?>
					<form action="php/rate_anim.php?id=<?=$view_id?>" method="post">
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
						}elseif(!empty($session_id) and $user_id != $session_id){
					?>
						<br>
						<a>Ваша оценка: <?=$user_value?></a><br>
						<form action="php/delete_rate.php?id=<?=$rate_id?>&v_id=<?=$view_id?>" method="post">
							<button type="submit">Удалить оценку</button>
						</form>
					<?php
						}
					?>
					<hr>
					<h2>Описание:</h2>
					<?
						if(!empty($desc)){
					?>
						<a><?=$desc?></a>
					<?
						}else{
					?>
						<a style="color: gray">Нет описания...</a>
					<?
						}
					?>
					<hr>
					<h2 id="comments">Комментарии:</h2>
					<?php
						if(!empty($session_id)){
					?>
						<a>Оставить комментарий:</a>
						<form action="php/comment.php?id=<?=$view_id?>&user_id=<?=$user_id?>" method="post">
							<textarea style="width:450px; height:130px" name="text"></textarea>
							<br>
							<button type="submit">Отправить</button>
						</form>
						<br>
						<br>
					<?php
						}
					?>
					<table>
					<?php
							$query_c = mysqli_query($conn, "SELECT * FROM `comments` WHERE anim_id = '$view_id' ORDER BY id DESC");
							while ($array_c = mysqli_fetch_assoc($query_c)) {
							$id_c = $array_c['id'];
							$text_c = htmlspecialchars($array_c['text']);
							$user_id_c = $array_c['user_id'];
                            $datestring_c = $array_c['date'];
                            $datest_c = DateTime::createFromFormat('d.m.Y H:i', $datestring_c);
                            $datest_c->modify('+8 hours');
                            $date_c = $datest_c->format('d.m.Y H:i');
                            $ischange_c = $array_c['ischange'];
							
							$result_u = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id_c'");
							$row_u = mysqli_fetch_assoc($result_u);
							
							$id_u = $row_u['id'];
							$name_u = htmlspecialchars($row_u['login']);
							$ava_u = $row_u['avatar'];
					?>
							<tr id="<?=$id_c?>">
								<td valign="top">
									<a href="profile.php?id=<?=$id_u?>"><img src="imgs/avatars/<?=$ava_u?>.gif" width="100"></a>
								</td>
								<td valign="top">
									<a href="profile.php?id=<?=$id_u?>"><?=$name_u?></a>
                                    <?php
                        				if($user_id_c == $user_id){
                        			?>
                                    	<br>
                                    	<a class="small_a" style="color:red">АВТОР</a>
                                    <?php
                                            }
                                    ?>
									<br>
									<a class="small_a"><?=$date_c?></a>
									<?php
										if($ischange_c == '1'){
									?>
										<br>
										<a class="small_a">(Изменено)</a>
									<?php
										}
									?>
									<br>
									<a style="width:400px"><?=$text_c?></a>
									<?php
										if($user_id_c == $session_id){
									?>
										<br>
                                    	<table>
                                            <tr>
                                                <td>
                                                    <form action="php/delete_comm.php?id=<?=$id_c?>&v_id=<?=$view_id?>" method="post">
                                                        <button type="submit">Удалить</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="#" method="post">
                                                        <button onclick="window.open('edit_comm.php?id=<?=$id_c?>','reg_popup','width=450,height=350,menubar=no,status=no,scrollbars=no'); return false;">Редактировать</button>
                                                    </form>
                                                </td>     
                                            </tr>
                                        </table>
									<?php
										}
									?>
								</td>
							</tr>
                            <tr>
                                <td>

                                </td>
                                <td>
                                    <hr style="width:400px">
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