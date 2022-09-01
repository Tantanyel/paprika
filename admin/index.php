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
		redir('/admin/zakaz');
	}else{
		$_SESSION['login']="";
	}
}

if(isset($_POST["vhodadmin"])){
	$v_name = $_POST["v_login"];
	$v_password = md5($_POST["v_password"]);

	$query = @mysql_query("SELECT * FROM admins WHERE name='$v_name'",$db);
	$myrow = @mysql_fetch_array($query);

	if($myrow['password']==$v_password){
			$_SESSION['login']=$myrow['name'].",".$myrow['password'];
			redir('/admin');
	}else{
		$_SESSION['login']="";
		$_SESSION['soob'] = "Неправильный логин или пароль";
		redir('/admin');
	}
}

?>

<html>

<head>
	<meta charset="UTF-8">
	<title>Вход</title>
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
	?>
	<form method="post" action="index" class="vhod">
		<div class="logo"><img src="img/logo.png"></div>
		<input name="v_login" type="text" placeholder="Логин" required>
		<input name="v_password" type="password" placeholder="Пароль" required>
		<input name="vhodadmin" type="submit" value="Войти">
	</form>

</body>

</html>
