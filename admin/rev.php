<?php 
session_start();
include("connect.php");

$soob = $_SESSION['soob'];

if($_SESSION['login']){
	$arrlogin =  explode(",", $_SESSION['login']);
	$name = $arrlogin[0];
	$password = $arrlogin[1];
	$query = @mysql_query("SELECT * FROM admins WHERE name='$name'",$db);
	$myrow = @mysql_fetch_array($query);
	if($password==$myrow['password']){
	}else{
		$_SESSION['login']="";
		redir('/admin');
	}
}else{
	redir('/admin');
}

if(isset($_POST["otvrev"])){
	$id = (int)$_POST["id"];
	$otv = $_POST["otv"];
	$query = mysql_query("UPDATE reviews SET otv='$otv' WHERE id='$id'",$db);
	$_SESSION['soob'] = "Ответ сохранен";
	redir('/admin/rev');
}

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Отзывы</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="../libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>

	<?php
	if($soob!=""){
		echo '
		<div class="soob">
			<a class="cloz" onclick="clozesoob()"></a>
			<span>'.$soob.'</span>
		</div>';
		$_SESSION['soob'] = "";
	}

	include("menu.php");
	?>

	<div class="center">
		<h2 class="zag">Отзывы</h2>
		<?php
		$mes = @mysql_query("SELECT * FROM reviews ORDER BY id DESC",$db);
		$myrow = @mysql_fetch_array($mes);
		if($myrow){
			do{
				echo '
				<div class="soobuser" num="'.$myrow["id"].'">
					<div class="infouser">
						<span class="name">Имя: '.$myrow["name"].'</span>
						<span class="data">Дата: '.date("d.m.Y" ,$myrow["time"]).'</span>
						<a onclick="delrev('.$myrow["id"].')" class="delmes">Удалить</a>
					</div>
					<p class="textmes">'.$myrow["otz"].'</p>
					<form class="otvrev" action="rev" method="post">
						<input type="text" name="id" class="hiden" value="'.$myrow["id"].'">
						<textarea name="otv">'.$myrow["otv"].'</textarea>
						<input name="otvrev" type="submit" value="Сохранить ответ">
					</form>
				</div>
				';
			}
			while($myrow = @mysql_fetch_array($mes));
		}
		?>
	</div>

</body>

</html>
