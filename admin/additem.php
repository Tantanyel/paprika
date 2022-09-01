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

if(isset($_POST["add"])){
	$photo = explode("|", $_POST['files']);
	$nevdir = '../itemphoto/';
	$photoarr=array();
	if( ! is_dir( $nevdir ) ) mkdir( $nevdir, 0777 );
	for ($i = 1; $i < count($photo); $i++){
		$phot = basename($photo[$i]);
		rename("tmp/".$phot,$nevdir.$phot);
		$photoarr[]=$phot;
	}
	$photostr = implode("|", $photoarr);
	foreach (glob('tmp/*') as $file){
		unlink($file);
	}
	$name = mysql_real_escape_string($_POST["naz"]);
	$art = $_POST["art"];
	$catalog = $_POST["catalog"];
	$brend = $_POST["brend"];
	$cena = $_POST["cena"];
	$skid = $_POST["skid"];
	$opis = $_POST["opis"];
	$param = $_POST["param"];
	$sostav = $_POST["sostav"];
	$osncolor = $_POST["osncolor"];
	$colors = $_POST["vcol"].",".$_POST["numvcol"]."|".$_POST["tcol"].",".$_POST["numtcol"];
	$razm = $_POST["raz1"].",".$_POST["raz2"].",".$_POST["raz3"];
	$razm = strtoupper ($razm);

	$query = mysql_query("INSERT INTO items VALUES('','$photostr','$name','$art','$catalog','$brend','$cena','$skid','$opis','$param','$sostav','$osncolor','$colors','$razm','0','0','0')",$db);

	$_SESSION['soob'] = "Товар добавлен";
	redir('/admin/items');
}
?>

<html>

<head>
	<meta charset="UTF-8">
	<title>Добавить товар</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="../libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>
	<?php include("menu.php");?>
	<div class="center">
		<h2 class="zag">Добавить товар</h2>
		<div class="additem">
			<h2>Фотографии</h2>
			<div class="photo">
				<div class="file">
					<input id="photo" type="file" accept="image/*">
					<span>Загрузить</span>
					<a></a>
				</div>
			</div>
			<h2>Основное</h2>
			<form method="post" action="additem">
				<input name="files" type="text" class="hiden" id="hidadd">
				<div class="osn">
					<input name="naz" class="nazv" type="text" placeholder="Название" required>
					<input name="art" class="artik" type="text" placeholder="Артикул">
					<select name="catalog" class="sel">
						<?php
						$catalog = @mysql_query("SELECT * FROM catalog ORDER BY num",$db);
						$myrow = @mysql_fetch_array($catalog);
						if($myrow){
							do{
								echo '<option value="'.$myrow["id"].'">'.$myrow["name"].'</option>';
							}
							while($myrow = @mysql_fetch_array($catalog));
						}
						?>
					</select>
					<select name="brend" class="bre">
						<?php
						$catalog = @mysql_query("SELECT * FROM brends ORDER BY num",$db);
						$myrow = @mysql_fetch_array($catalog);
						if($myrow){
							do{
								echo '<option value="'.$myrow["id"].'">'.$myrow["name"].'</option>';
							}
							while($myrow = @mysql_fetch_array($catalog));
						}
						?>
					</select>
					<span>Цена</span>
					<input name="cena" class="cena" type="number" placeholder="Цена" required>
					<span>Скидка</span>
					<input name="skid" class="skid" type="number" placeholder="Скидка">
					<span class="proc">%</span>
				</div>
				<h2>Информация о товаре</h2>
				<div class="infoprod">
					<textarea name="opis" placeholder="Описание"></textarea>
					<textarea name="param" placeholder="Параметры модели"></textarea>
					<textarea name="sostav" placeholder="Состав"></textarea>
				</div>
				<h2>Цвет и размер</h2>
				<div class="coloraraz">
					<span>Основной цвет</span>
					<input name="osncolor" class="osncv" type="text" placeholder="Основной цвет (#ffffff)" required>
					<span>Второй цвет</span>
					<input name="vcol" class="vcv" type="text" placeholder="Второй цвет (#ffffff)">
					<span>Номер товара</span>
					<input name="numvcol" class="nom" type="number" placeholder="Номер товара">
					<span>Третий цвет</span>
					<input name="tcol" class="tcv" type="text" placeholder="Третий цвет (#ffffff)">
					<span>Номер товара</span>
					<input name="numtcol" class="nom" type="number" placeholder="Номер товара">
					
					<span>Размеры</span>
					<input name="raz1" class="raz" type="text" required placeholder="Размер">
					<input name="raz2" class="raz" type="text" placeholder="Размер">
					<input name="raz3" class="raz" type="text" placeholder="Размер">
				</div>
				<div class="knb">
					<input name="add" class="add" type="submit" value="Добавить товар">
				</div>
			</form>
		</div>
	</div>

</body>

</html>
