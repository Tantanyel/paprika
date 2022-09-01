<?php
session_start();
include("templates/connect.php");

if(isset($_POST["addotz"])){
	$name = mysql_real_escape_string($_POST["name"]);
	$otv = mysql_real_escape_string($_POST["otz"]);
	$time = time();
	$query = mysql_query("INSERT INTO reviews VALUES('','$name','$otv','$time','')",$db);
	$_SESSION['okrev'] = "Спасибо за ваш отзыв!";
	redir('/reviews');
}

?>

<html>
<?php include("templates/title.php"); ?>
<head>
	<title>Отзывы | paprika</title>
</head>

<body>
	<?php include("templates/header.php"); ?>

	<?php include("templates/menu.php"); ?>

	<div class="formrev">
		<form action="reviews" method="post">
			<h2>Ваше мнение важно для нас!</h2>
			<input name="name" type="text" placeholder="Имя" required>
			<textarea name="otz" placeholder="Отзыв" required></textarea>
			<input name="addotz" type="submit" value="Оставить отзыв">
			<?php
			if($_SESSION['errrev']){
				echo '<span class="revsoob err">'.$_SESSION['errrev'].' <a onclick="clozerevsoob()"></a></span>';
				$_SESSION['errrev']="";
			}
			if($_SESSION['okrev']){
				echo '<span class="revsoob">'.$_SESSION['okrev'].' <a onclick="clozerevsoob()"></a></span>';
				$_SESSION['okrev']="";
			}
			?>
		</form>
		<div onclick="scrollrev()" class="downrev">
			<span>Читать отзывы</span>
			<img src="img/rev.png">
		</div>
	</div>

	<div class="content revc">
		<h2 class="zag"><span>Отзывы</span></h2>
		<div class="revtcont">
			<?php
			$rew = @mysql_query("SELECT * FROM reviews ORDER BY id DESC",$db);
			$myrow = @mysql_fetch_array($rew);
			if($myrow){
				do{
					$data = date("d.m.Y" ,$myrow["time"]);
					if($myrow["otv"]){
						$otv = '
						<div class="otvetm">
							<span onclick="revopn(this)">Наш ответ</span>
							<p>'.$myrow["otv"].'</p>
						</div>
						';
					}else{
						$otv = "";
					}
					echo '
					<div class="rev">
						<div class="namerev">
							<span>'.$myrow["name"].'</span>
							<i>'.$data.'</i>
						</div>
						<p>'.$myrow["otz"].'</p>
						'.$otv.'
					</div>
					';
				}
				while($myrow = @mysql_fetch_array($rew));
			}
			?>
			
		</div>

		<?php include("templates/foot.php"); ?>
	</div>


</body>

</html>
