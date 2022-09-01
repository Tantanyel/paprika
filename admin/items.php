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
	<title>Товары</title>
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
	<div class="colred">
		<div class="contcolred">
			<a onclick="clozeall('.colred')" class="cloz"></a>
			<h2>Изменение количества товара - №<span>200</span></h2>
			<span>S</span>
			<span>S</span>
			<span>S</span>
			<input type="number" placeholder="Количество">
			<input type="number" placeholder="Количество">
			<input type="number" placeholder="Количество">
			<div class="knb">
				<a onclick="izmcol()">Обновить количество</a>
			</div>
		</div>
	</div>
	<div class="center">
		<h2 class="zag">Товары</h2>
		<div class="searchprod">
			<input onkeyup="filtertradeinp(this)" type="text" placeholder="Поиск по товарам">
			<a href="additem">Добавить товар</a>
		</div>
		<div class="prodcont">
			<?php
			$items = @mysql_query("SELECT * FROM items ORDER BY id DESC",$db);
			$myrow = @mysql_fetch_array($items);
			if($myrow){
				do{
					$img = explode("|", $myrow["photo"]);
					$img = $img[0];
					$skid = ceil($myrow["cena"]-($myrow["cena"]*($myrow["skid"]/100)));
					$raz = explode(",", $myrow["razm"]);
					echo '
					<div class="prod" num="'.$myrow["id"].'">
						<h2>Номер товара - '.$myrow["id"].'</h2>
						<div class="imgprod">
							<img src="../itemphoto/'.$img.'">
						</div>
						<div class="infoprod">
							<a class="find" href="../product?num='.$myrow["id"].'">'.$myrow["name"].'</a>
							<span>Артикул: '.$myrow["art"].'</span>
							<span>Цена: '.$myrow["cena"].' руб</span>
							<span>Скидка: '.$myrow["skid"].'%</span>
							<span>Цена со скидкой: '.$skid.' руб</span>
						</div>
						<div class="kol">
							<span>'.$raz[0].': '.$myrow["razcol1"].' шт</span>
							<span>'.$raz[1].': '.$myrow["razcol2"].' шт</span>
							<span>'.$raz[2].': '.$myrow["razcol3"].' шт</span>
							<a onclick="opencol('.$myrow["id"].')">Изменить количество</a>
						</div>
						<div class="kn">
							<a href="сhangeitem?id='.$myrow["id"].'">Редактировать</a>
							<a onclick="deleteitem('.$myrow["id"].')">Удалить</a>
						</div>
					</div>
					';
				}
				while($myrow = @mysql_fetch_array($items));
			}
			?>
		</div>
	</div>

</body>

</html>
