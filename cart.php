<?php
session_start();
include("templates/connect.php");


if($_GET['opl']){
	if($_GET['opl']=="ok"){
		$_SESSION['cart'] = "Спасибо за ваш заказ, мы с вами свяжемся";
		redir('/cart');
	}
	if($_GET['opl']=="err"){
		$_SESSION['cart'] = "Оплата не прошла, обратитесь в слушбу оплаты";
		redir('/cart');
	}
}

if(isset($_POST["submit"])){
		$tovar = mysql_real_escape_string($_POST["tovar"]);
		$email = mysql_real_escape_string($_POST["email"]);
		$fio = mysql_real_escape_string($_POST["fio"]);
		$tel = mysql_real_escape_string($_POST["tel"]);
		$adr = mysql_real_escape_string($_POST["adr"]);
		$com = mysql_real_escape_string($_POST["com"]);
		$oplata = mysql_real_escape_string($_POST["oplata"]);
		$time = time();
		$cena = 0;

		$tovararr = explode("|", $tovar);
		foreach ($tovararr as $key => $value) {
			$arrt = explode(",", $value);
			$idt = $arrt[0];
			$razt = $arrt[1];
			$colt = $arrt[2];

			$catalog = @mysql_query("SELECT * FROM items WHERE id=$idt",$db);
			$myrow = @mysql_fetch_array($catalog);
			if($myrow){
				$kcol = "razcol".($razt+1);
				$col = $myrow[$kcol]-$colt;
				$cenai = ceil($myrow["cena"]-($myrow["cena"]*($myrow["skid"]/100)));
				$cena = $cena+$cenai*$colt;

				$query = mysql_query("UPDATE items SET $kcol='$col' WHERE id='$idt'",$db);
			}
		}

		$query = mysql_query("INSERT INTO zakaz VALUES('','$tovar','$email','$fio','$tel','$adr','$com','$oplata','$cena','$time','1')",$db);
		$idopl = mysql_insert_id();
		setcookie("cart", "", time()+30000000, '/');
		$_SESSION['cart'] = "Спасибо за ваш заказ, мы с вами свяжемся";
		redir('/cart');
}


?>
<html>
<?php include("templates/title.php"); ?>
<head>
	<title>Корзина | paprika</title>
</head>

<body>

			<?php include("templates/header.php"); ?>

			<?php include("templates/menu.php"); ?>

			<div class="formcart">
				<div onclick="clozeall('.formcart')" class="cloz"></div>
				<form action="cart" method="post">
					<h2 class="zag"><span>Оформление заказа</span></h2>
					<input id="tovar" name="tovar" type="text" class="hid">
					<input name="email" type="text" placeholder="Email" required>
					<input name="fio" type="text" placeholder="Ф.И.О" required>
					<input name="tel" type="text" placeholder="Телефон" required>
					<input name="adr" type="text" placeholder="Адрес" required>
					<textarea name="com" placeholder="Комментарий"></textarea>
					<div class="oplata">
						<!--<input name="oplata" value="onl" type="radio" class="radio" id="oonl" />
						<label for="oonl">Оплата онлайн</label>-->
						<input name="oplata" value="nal" type="radio" class="radio" id="ocur" checked />
						<label for="ocur">Оплата курьеру</label>
					</div>
					<div class="hrform">
						<a href="info?info=dost">Условия доставки</a>
						<a href="info?info=opl">Информация об оплате</a>
						<a href="info?info=voz">Условия возврата</a>
					</div>
					<input name="submit" type="submit" value="Заказать">
					<p>Мы свяжемся с вами после подтверждения заказа</p>
				</form>
			</div>

			<div class="content">
				<h2 class="zag"><span>Корзина</span></h2>
				<div class="cartcont">
					<?php
					$incart = $_COOKIE["cart"];
					$incart = substr($incart, 1);
					$cart =  explode("|", $incart);
					$cart = array_unique($cart);

					foreach ($cart as $key => $value) {
						$forarr =  explode(",", $cart[$key]);
						$idarr = $forarr[0];
						$sizearr = $forarr[1];

						$item = @mysql_query("SELECT * FROM items WHERE id=$idarr",$db);
						$myrow = @mysql_fetch_array($item);
						if($myrow){
							$img = explode("|", $myrow["photo"]);
							$img = $img[0];
							$size = explode(",", $myrow["razm"]);

							$size = $size[$sizearr];
							$razcol = $myrow["razcol".($sizearr+1)];

							$skid = ceil($myrow["cena"]-($myrow["cena"]*($myrow["skid"]/100)));

							echo '
							<div class="cartitem" num="'.$myrow["id"].'">
							<div class="imgcart"><img src="itemphoto/'.$img.'"></div>
							<div class="namecart">
							<a href="product?num='.$myrow["id"].'">'.$myrow["name"].'</a>
							<span>Артикул: '.$myrow["art"].'</span>
							</div>
							<div class="cartparam">
							<div class="pcart">
							<span>Цвет:</span>
							<a col="'.$myrow["osncolor"].'"></a>
							</div>
							<div class="pcart">
							<span>Размер:</span>
							<a num="'.$sizearr.'" raz="'.$size.'"></a>
							</div>
							<div class="numitem" col="'.$razcol.'">
							<a class="mi">–</a>
							<input class="price" type="number" value="1" min="1" max="100" />
							<a class="pl">+</a>
							</div>
							<span class="cartprice" num="'.$skid.'">'.$skid.' руб</span>
							<span class="delcart" onclick="delcart(this)"></span>
							</div>
							</div>
							';
						}
					}
					?>
				</div>
				<div class="itogo"><span>Итого:</span>
					<p id="bigprice">0 руб</p>
				</div>
				<span onclick="clozeall('.formcart')" class="knoform">Оформить заказ</span>
				<?php
				if($_SESSION['cart']){
					echo '<span class="revsoob">'.$_SESSION['cart'].' <a onclick="clozerevsoob()"></a></span>';
					$_SESSION['cart']="";
				}
				?>
				<?php include("templates/foot.php"); ?>
			</div>


		</body>

		</html>