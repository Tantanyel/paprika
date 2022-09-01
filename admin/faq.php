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

if(isset($_POST["addfaq"])){
	$query = mysql_query("INSERT INTO faq VALUES('','Вопрос','Ответ')",$db);
	redir('/admin/faq');
}

if(isset($_POST["savefaq"])){
	$catarr = explode("|", $_POST['arr']);
	for ($i = 1; $i <= count($catarr); $i++) 
	{ 
		$arratr = explode("}", $catarr[$i]);
		$id = $arratr[0];
		$vop = $arratr[1];
		$otv = $arratr[2];
		$query = mysql_query("UPDATE faq SET vop='$vop',otv='$otv' WHERE id='$id'",$db);
	}
	$_SESSION['soob'] = "Вопросы сохранены";
	redir('/admin/faq');
}

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Вопросы</title>
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
		<h2 class="zag">Часто задаваемые вопросы</h2>
		<?php
		$adr = @mysql_query("SELECT * FROM faq ORDER BY id",$db);
		$myrow = @mysql_fetch_array($adr);
		if($myrow){
			do{
				echo '
				<div class="addr" num="'.$myrow["id"].'">
					<span>Вопрос</span>
					<textarea onchange="obnadr()" id="adr">'.$myrow["vop"].'</textarea>
					<span>Ответ</span>
					<textarea onchange="obnadr()" id="map">'.$myrow["otv"].'</textarea>
					<input onclick="deletefaq('.$myrow["id"].')" type="submit" value="Удалить">
				</div>
				';
			}
			while($myrow = @mysql_fetch_array($adr));
		}
		?>
		<div class="kn">
			<form method="post" action="faq">
				<input name="arr" type="text" class="hiden" id="hidadr">
				<input name="addfaq" type="submit" value="Добавить вопрос">
				<input name="savefaq" type="submit" value="Сохранить вопросы">
			</form>
		</div>
	</div>

</body>

</html>
