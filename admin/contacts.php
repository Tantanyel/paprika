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

if(isset($_POST["savecont"])){
	$email = $_POST["email1"]."|".$_POST["email2"]."|".$_POST["email3"];
	$tel = $_POST["tel1"]."|".$_POST["tel2"]."|".$_POST["tel3"];
	$wa = $_POST["wa1"]."|".$_POST["wa2"]."|".$_POST["wa3"];
	$viber = $_POST["viber1"]."|".$_POST["viber2"]."|".$_POST["viber3"];
	$soc = $_POST["vk"]."|".$_POST["fb"]."|".$_POST["inst"];
	$query = mysql_query("UPDATE contacts SET email='$email',phone='$tel',wa='$wa',viber='$viber',soc='$soc' WHERE id='1'",$db);
	$_SESSION['soob'] = "Контакты сохранены";
	redir('/admin/contacts');
}

if(isset($_POST["addadr"])){
	$query = mysql_query("INSERT INTO maps VALUES('','Адрес','Карта')",$db);
	redir('/admin/contacts');
}

if(isset($_POST["saveadr"])){
	$catarr = explode("|", $_POST['arr']);
	for ($i = 1; $i <= count($catarr); $i++) 
	{ 
		$arratr = explode("}", $catarr[$i]);
		$id = $arratr[0];
		$adr = $arratr[1];
		$map = $arratr[2];
		$query = mysql_query("UPDATE maps SET adr='$adr',map='$map' WHERE id='$id'",$db);
	}
	$_SESSION['soob'] = "Адреса сохранены";
	redir('/admin/contacts');
}

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Контакты</title>
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
		<h2 class="zag">Контакты</h2>
		<form method="post" class="contform" action="contacts">
			<?php
			$cont = @mysql_query("SELECT * FROM contacts WHERE id='1'",$db);
			$myrow = @mysql_fetch_array($cont);
			$email_l = explode("|", $myrow['email']);
			$tel_l = explode("|", $myrow['phone']);
			$wa_l = explode("|", $myrow['wa']);
			$viber_l = explode("|", $myrow['viber']);
			$soc_l = explode("|", $myrow['soc']);
			?>
			<h3>Email</h3>
			<input name="email1" type="text" value="<?php echo $email_l[0];?>">
			<input name="email2" type="text" value="<?php echo $email_l[1];?>">
			<input name="email3" type="text" value="<?php echo $email_l[2];?>">
			<h3>Телефоны</h3>
			<input name="tel1" type="text" value="<?php echo $tel_l[0];?>">
			<input name="tel2" type="text" value="<?php echo $tel_l[1];?>">
			<input name="tel3" type="text" value="<?php echo $tel_l[2];?>">
			<h3>WhatsApp</h3>
			<input name="wa1" type="text" value="<?php echo $wa_l[0];?>">
			<input name="wa2" type="text" value="<?php echo $wa_l[1];?>">
			<input name="wa3" type="text" value="<?php echo $wa_l[2];?>">
			<h3>Viber</h3>
			<input name="viber1" type="text" value="<?php echo $viber_l[0];?>">
			<input name="viber2" type="text" value="<?php echo $viber_l[1];?>">
			<input name="viber3" type="text" value="<?php echo $viber_l[2];?>">
			<h3>Соц сети</h3>
			<span>Вконтакте</span>
			<input name="vk" class="socinp" type="text" value="<?php echo $soc_l[0];?>">
			<span>Facebook</span>
			<input name="fb" class="socinp" type="text" value="<?php echo $soc_l[1];?>">
			<span>Instagram</span>
			<input name="inst" class="socinp" type="text" value="<?php echo $soc_l[2];?>">
			<input name="savecont" type="submit" value="Сохранить контакты">
		</form>
		<h2 class="zag">Адреса</h2>
		<?php
		$adr = @mysql_query("SELECT * FROM maps ORDER BY id",$db);
		$myrow = @mysql_fetch_array($adr);
		if($myrow){
			do{
				echo '
				<div class="addr" num="'.$myrow["id"].'">
					<span>Адрес</span>
					<input id="adr" type="text" value="'.$myrow["adr"].'">
					<span>Сылка на карту(iframe)</span>
					<textarea onchange="obnadr()" id="map">'.$myrow["map"].'</textarea>
					<input onclick="deleteadr('.$myrow["id"].')" type="submit" value="Удалить">
				</div>
				';
			}
			while($myrow = @mysql_fetch_array($adr));
		}
		?>
		<div class="kn">
			<form method="post" action="contacts">
				<input name="arr" type="text" class="hiden" id="hidadr">
				<input name="addadr" type="submit" value="Добавить адрес">
				<input name="saveadr" type="submit" value="Сохранить адреса">
			</form>
		</div>
	</div>

</body>

</html>
