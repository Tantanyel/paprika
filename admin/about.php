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

if(isset($_POST["saveab"])){
	$text = $_POST["about"];
	$query = mysql_query("UPDATE about SET about='$text' WHERE id='1'",$db);
	$_SESSION['soob'] = "Информация сохранена";
	redir('/admin/about');
}

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>О нас</title>
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

	$ab = @mysql_query("SELECT * FROM about WHERE id='1'",$db);
	$myrow = @mysql_fetch_array($ab);

	?>

	<div class="center">
		<h2 class="zag">О нас</h2>
		<form action="about" method="post">
			<div class="about">
				<textarea name="about"><?php echo $myrow["about"];?></textarea>
				<input type="submit" name="saveab" value="Сохранить информацию">
			</div>
		</form>
	</div>

</body>

</html>
