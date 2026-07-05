<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$get_id = $_GET['id'];
	
	$title = 'Неизвестно';

	if($get_id == 1){
        $title = 'Загрузка анимации';
    }elseif($get_id == 2){
        $title = 'Кнопка "Старт" и "Заново"';
    }elseif($get_id == 3){
        $title = 'Открытие ссылки по кнопке';
    }
?>
<html lang="RU">
	<head>
		<title>Урок "<?=$title?>" | MultVerse</title>
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
					<?php
                    	if($get_id == 1){
                    ?>
                    	<center>
                            <h1><?=$title?></h1>
                        </center>
                    	<h2>Эмулятор Ruffle уже делает загрузку анимации за вас, но если зритель будет смотреть не через эмулятор, а через родной Flash Player? Тут вы узнаете как создать базовую сцену загрузки!</h2>
                    <br><br>
                    <h3>Для начала создайте новый проект с ActionScript 2.0<br>Далее создайте новый слой специально для скриптов для удобства.
                    <br>Затем нажмите на первый кадр этого слоя и нажмите F9. (Это откроет вам окно редактирования кода.)</h3>
                    <center><img src="imgs/guide/1.gif" width=510></center>
                    <br>
                    <h3>Затем вставьте этот код:</h3>
                    <pre class="blue_panel"><code>
                        stop();

                        // Функция, которая проверяет загрузку
                        this.onEnterFrame = function() {
                            var total = _root.getBytesTotal();
                            var loaded = _root.getBytesLoaded();

                            if (total > 0) {
                                var percent = Math.round((loaded / total) * 100);
                                percentText.text = percent + "%";
                            }

                            // Когда всё загружено — переходим дальше
                            if (loaded >= total && total > 0) {
                                delete this.onEnterFrame;
                                gotoAndPlay("start"); // запускаем основной контент
                            }
                        };
                    </code></pre>
                    <br>
                    <h3>Вернитесь в кадр первого слоя и создайте там два текста.<br>
                    В первом напишите "Загрузка". Оно может быть любого типа.<br>
                    Во втором можете написать "0%".<br>
                    А вот уже второй текст вы должны выбрать, зайти в "Properties" и вместо "Static Text" выбрать "Dynamic Text" и назвать его "percentText"</h3>
                    <center><img src="imgs/guide/2.gif" width=510></center>
                    <br>
                    <h3>В коде уже прописано, что этот текст будет меняться на процент загрузки.</h3>
                    <h3>Теперь сделайте новый ключевой кадр рядом с кадром кода и создайте новый код. Потом зайдите в свойства кадра и назовите эвент "start"</h3>
                    <center><img src="imgs/guide/3.gif" width=510></center>
                    <h3>Готово! Теперь у вашей анимации есть загрузка!</h3>
                    <br>
                    <a href="fla_guide/loading.fla"><h2>.FLA файл как пример</h2></a>
                    <a>Этот файл открывается с Macromedia Flash 8 и выше.</a>
                    <?php
                        }elseif($get_id == 2){
                    ?>
                    	<center>
                            <h1><?=$title?></h1>
                        </center>
						<h2>Просто резко начинаемая анимация и просто конец, который сразу перекидывает на начало не очень красиво и прикольно. Поэтому нужна кнопка старта и заново.</h2>
                    <a href="fla_guide/loading.fla"><h2>.FLA файл как пример</h2></a>
                    <a>Этот файл открывается с Macromedia Flash 8 и выше.</a>                    
                    <?php
                        }     
                    ?>
				</td>
			</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
	</body>
</html>