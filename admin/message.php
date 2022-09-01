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

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Сообщения</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="../libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>

	<?php include("menu.php");?>

	<div class="center">
		<h2 class="zag">Сообщения</h2>
		<?php
		$mes = @mysql_query("SELECT * FROM message ORDER BY id DESC",$db);
		$myrow = @mysql_fetch_array($mes);
		if($myrow){
			do{
				echo '
				<div class="soobuser" num="'.$myrow["id"].'">
					<div class="infouser">
						<span class="name">Имя: '.$myrow["name"].'</span>
						<span class="email">Email: '.$myrow["email"].'</span>
						<span class="data">Дата: '.date("d.m.Y" ,$myrow["time"]).'</span>
						<a onclick="delmes('.$myrow["id"].')" class="delmes">Удалить</a>
					</div>
					<p class="textmes">'.$myrow["text"].'</p>
				</div>
				';
			}
			while($myrow = @mysql_fetch_array($mes));
		}
		?>
	</div>

</body>

</html>
