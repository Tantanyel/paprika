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
	<title>Заказы</title>
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
		<h2 class="zag">Заказы</h2>
		<?php
		$zak = @mysql_query("SELECT * FROM zakaz ORDER BY id DESC",$db);
		$zakrow = @mysql_fetch_array($zak);
		if($zakrow){
			do{
				if($zakrow["oplata"]=="nal"){
					$opl="Наличные";
				}
				if($zakrow["oplata"]=="onl"){
					$opl="Онлайн оплата: НЕ ОПЛАЧЕНО";
				}
				if($zakrow["oplata"]=="onlok"){
					$opl="Онлайн оплата: ОПЛАЧЕНО";
				}

				$html = '';
				$bigpr = 0;
				$cart =  explode("|", $zakrow["tovar"]);
				foreach ($cart as $key => $value) {
					$allarr =  explode(",", $cart[$key]);
					$id = $allarr[0];
					$sizearr = $allarr[1];
					$col = $allarr[2];
					$item = @mysql_query("SELECT * FROM items WHERE id=$id",$db);
					$myrow = @mysql_fetch_array($item);
					if($myrow){
						$img = explode("|", $myrow["photo"]);
						$img = $img[0];
						$size = explode(",", $myrow["razm"]);

						$size = $size[$sizearr];
						$skid = ceil($myrow["cena"]-($myrow["cena"]*($myrow["skid"]/100)));

						$bigpr = $bigpr+($skid*$col);

						$html = $html.'
						<div class="tovar">
							<div class="infoimg">
								<div class="imgprod">
									<img src="../itemphoto/'.$img.'">
								</div>
								<div class="infonaz">
									<a href="../product?num='.$myrow["id"].'">'.$myrow["name"].'</a>
									<span>Артикул: '.$myrow["art"].'</span>
								</div>
							</div>
							<div class="infot">
								<div class="bli">
									<span>Цвет</span>
									<a style="background: '.$myrow["osncolor"].'"></a>
								</div>
								<div class="bli">
									<span>Размер</span>
									<a>'.$size.'</a>
								</div>
								<div class="bli">
									<span>Количество</span>
									<a>'.$col.'</a>
								</div>
								<p>'.$skid*$col.' руб</p>
							</div>
						</div>
						';
					}
				}
				if($zakrow["vipol"]==1){
					$svip = 'style="display:none"';
					$bvip = '';
				}else{
					$svip = '';
					$bvip = 'style="display:none"';
				}
				echo '
				<div class="zakaz" num="'.$zakrow["id"].'">
					<div class="infopoc">
						<h2>Заказ №'.$zakrow["id"].' от '.date("d.m.Y" ,$zakrow["time"]).'</h2>
						<span>Ф.И.О: '.$zakrow["fio"].'</span>
						<span>Eamil: '.$zakrow["email"].'</span>
						<span>Телефон: '.$zakrow["tel"].'</span>
						<span>Адрес: '.$zakrow["adr"].'</span>
						<span>Комментарий покупателя: '.$zakrow["com"].'</span>
						<a>Вид оплаты: '.$opl.'</a>
					</div>
					<div class="tovari">
						'.$html.'
					</div>
					<div class="infoitog">
						<span id="svip" '.$svip.'>Выполнен</span>
						<button id="bvip" '.$bvip.' onclick="vipcart('.$zakrow["id"].')">Выполнить</button>
						<button onclick="deletecart('.$zakrow["id"].')">Удалить</button>
						<p>Итого: '.$zakrow["cena"].' руб</p>
					</div>
				</div>
				';
			}
			while($zakrow = @mysql_fetch_array($zak));
		}
		?>
	</div>

</body>

</html>
