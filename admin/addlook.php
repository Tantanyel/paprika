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
	$nevdir = '../lookphoto/';
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
	$name = mysql_real_escape_string($_POST["name"]);
	$num = $_POST["num"];
	$collection = $_POST["collection"];

	$query = mysql_query("INSERT INTO photo VALUES('','$photostr','$name','$num','$collection')",$db);

	$_SESSION['soob'] = "Фотография добавлена";
	redir('/admin/lookbook');
}
?>
<html>

<head>
	<meta charset="UTF-8">
	<title>Добавить фото</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="../libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>
	<?php include("menu.php");?>
	<div class="center">
		<h2 class="zag">Добавить фото</h2>
		<div class="addlook">
			<h2>Фотография</h2>
			<div class="photolook" id="lookp">
				<div class="file">
					<input id="photo" type="file" accept="image/*">
					<span>Загрузить</span>
					<a></a>
				</div>
			</div>
			<h2>Основное</h2>
			<form method="post" action="addlook">
				<input name="files" type="text" class="hiden" id="hidadd">
				<div class="lookosn">
					<input name="name" class="name" type="text" placeholder="Текст под фото">
					<input name="num" class="num" type="number" placeholder="Номер товара">
					<select name="collection" class="collection">
						<?php
						$catalog = @mysql_query("SELECT * FROM collections ORDER BY num",$db);
						$myrow = @mysql_fetch_array($catalog);
						if($myrow){
							do{
								echo '<option value="'.$myrow["id"].'">'.$myrow["name"].'</option>';
							}
							while($myrow = @mysql_fetch_array($catalog));
						}
						?>
					</select>
				</div>
				<div class="knb">
					<input name="add" class="add" type="submit" value="Добавить фото">
				</div>
			</form>
		</div>
	</div>

</body>

</html>