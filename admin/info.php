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

if(isset($_POST["saveinfo"])){
	$dost = $_POST["dost"];
	$opl = $_POST["opl"];
	$voz = $_POST["voz"];
	$query = mysql_query("UPDATE info SET dost='$dost',opl='$opl',voz='$voz' WHERE id='1'",$db);
	$_SESSION['soob'] = "Информация сохранена";
	redir('/admin/info');
}

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Информация</title>
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

	$info = @mysql_query("SELECT * FROM info WHERE id='1'",$db);
	$myrow = @mysql_fetch_array($info);

	?>

	<div class="center">
		<h2 class="zag">Информация</h2>
		<form action="info" method="post">
			<div class="info">
				<span>Условия доставки</span>
				<textarea name="dost"><?php echo $myrow["dost"];?></textarea>
				<span>Об оплате</span>
				<textarea name="opl"><?php echo $myrow["opl"];?></textarea>
				<span>Условия возврата</span>
				<textarea name="voz"><?php echo $myrow["voz"];?></textarea>
				<input type="submit" name="saveinfo" value="Сохранить информацию">
			</div>
		</form>
	</div>

</body>

</html>
