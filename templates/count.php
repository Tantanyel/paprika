<?php
include("connect.php");

if($_POST["type"]=="fav"){
	$id = (int)$_POST["id"];
	$fav =  explode(",", $_COOKIE["fav"]);
	setcookie('fav','');
	$key = array_search($id, $fav);
	if($key){
		unset($fav[$key]);
		$col = count($fav)-1;
		$favs = implode(",", $fav);
		setcookie("fav", $favs, time()+30000000, '/');
		echo 'delfav,'.$col;
	}else{
		$fav[] = $id;
		$col = count($fav)-1;
		$favs = implode(",", $fav);
		setcookie("fav", $favs, time()+30000000, '/');
		echo 'addfav,'.$col;
	}
}

if($_POST["type"]=="cart"){
	$param =  explode(",", $_POST["param"]);
	$id = (int)$param[0];
	$size = (int)$param[1];
	$cart =  explode("|", $_COOKIE["cart"]);
	setcookie('cart','');
	$cart[] = $id.','.$size;
	$col = array_count_values($cart);
	$col = count($col)-1;
	$carts = implode("|", $cart);
	setcookie("cart", $carts, time()+30000000, '/');
	echo 'addcart,'.$col;
}
?>