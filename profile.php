<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$user_id = $_GET['id'];
	$user_name = $_GET['user'];
	
	if(!empty($user_id)){
		$result_id = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
		$row_id = mysqli_fetch_assoc($result_id);
		
		$id_name = $row_id['login'];		
		
		header("Location: profile.php?user=$id_name");
	}else{	
        $result = mysqli_query($conn, "SELECT * FROM users WHERE login = '$user_name'");
        $row = mysqli_fetch_assoc($result);

        $s_id = $row['id'];
        $name = htmlspecialchars($row['login']);
        $desc = htmlspecialchars($row['desc']);
        $ava = $row['avatar'];

            $datestring = $row['date'];
            $datest = DateTime::createFromFormat('d.m.Y H:i', $datestring);
            $datest->modify('+8 hours');
            $date = $datest->format('d.m.Y H:i');

        if(empty($s_id)){
            header("Location: index.php?msng=no_user");
        }
    }
?>
<html lang="RU">
	<head>
		<title><?=$name?> | MultVerse</title>
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
					<img src="imgs/avatars/<?=$ava?>.gif" width="200">
					<h2><?=$name?></h2>
                    <a>ID пользователя: <?=$s_id?></a><br>
                    <hr>
					<a>Дата регистрации: <?=$date?></a>
					<br>
					<?php
						if($s_id == $session_id){
					?>
						<a href="php/logout.php" class="small_a">Выйти с аккаунта</a>
						<br>
						<a href="#" onclick="window.open('edit_profile.php','edit_popup','width=300,height=550,menubar=no,status=no,scrollbars=no'); return false;" class="small_a">Редактировать профиль</a>
						<br>
						<br>
						<a href="javascript: del()" class="small_a" style="color:red">Удалить аккаунт</a>
					<?php
						}
					?>
				</td>
				<td>
				<td>
				<td width="560" valign="top">
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
					<h2>Мульты:</h2>
					<table>
						<?php
							$query_m = mysqli_query($conn, "SELECT * FROM `mults` WHERE user_id = '$s_id' ORDER BY id DESC LIMIT 3");
							while ($array_m = mysqli_fetch_assoc($query_m)) {
							$id_m = $array_m['id'];
                            $datestring_m = $array_m['date'];
                            $datest_m = DateTime::createFromFormat('d.m.Y H:i', $datestring_m);
                            $datest_m->modify('+8 hours');
                            $date_m = $datest_m->format('d.m.Y H:i');
							$title_m = htmlspecialchars($array_m['title']);
							
							$rquery_mr_m = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$id_m}' AND `type` = 'mult'";
							$rquery_result_mr_m = mysqli_query($conn, $rquery_mr_m);
							$rrow_mr_m = mysqli_fetch_assoc($rquery_result_mr_m);
							
							$rating_m = round($rrow_mr_m['avg_rate'], 1);
                                
								$query_сs = "SELECT COUNT(*) AS count FROM `anims` WHERE `mult_id`= '$id_m'";
								$query_results = mysqli_query($conn, $query_сs);
								while($rows = mysqli_fetch_assoc($query_results)) {
								$outputs = $rows['count'];
                                }
						?>
						<tr>
							<td>
								<a href="mult.php?id=<?=$id_m?>"><img src="imgs/mult-icons/<?=$id_m?>.gif" width="130"></a>
							</td>
							<td style="width:280px">
								<a href="mult.php?id=<?=$id_m?>"><?=$title_m?></a>
									<br>
									<a class="small_a">Дата: <?=$date_m?></a>
									<br>
									<a class="small_a">Рейтинг: <a style="color:<?php
										if($rating_m < '2.4'){
											echo'red';
										}elseif($rating_m < '4.5' && $rating_m > '2.3'){
											echo'#EBCD00';
										}elseif($rating_m < '5.1' && $rating_m > '4.4'){
											echo'green';
										}?>" class="small_a"><?=$rating_m?></a></a>
                                	<br>
                                	<a class="small_a">Эпизодов: <?=$outputs?></a>
									<hr>
							</td>
						</tr>
						<?php
							}
						?>
                        <tr>
                            <td>
                                <br><br>
                            	<a href="user_mults.php?id=<?=$s_id?>">Больше мультов от автора</a>
                            </td>
                        </tr>
					</table>
					<h2>Самоделки:</h2>
					<table>
						<?php
							$query_s = mysqli_query($conn, "SELECT * FROM `anims` WHERE user_id = '$s_id' AND mult_id = '-1' ORDER BY id DESC LIMIT 3");
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
								<a href="view.php?id=<?=$id_s?>"><img src="imgs/anim-icons/<?=$id_s?>.gif" width="100"></a>
							</td>
							<td style="width:280px">
                                <table>
                                    <tr>
                                        <td><img src="imgs/rating/<?=$age_s?>+.gif" width=23 height=23></td>
                                        <td><a href="view.php?id=<?=$id_s?>"><?=$title_s?></a></td>
                                    </tr>
                                </table> 
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
							}
						?>
                        <tr>
                            <td>
                                <br><br>
                            	<a href="user_selfmades.php?id=<?=$s_id?>">Больше самоделок от автора</a>
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
	<script>
		function del(){
			if (confirm('Вы уверены, что хотите удалить аккаунт?')) {
			  window.location.href = 'php/delete_user.php';
			}
		}
	</script>
	</body>
</html>