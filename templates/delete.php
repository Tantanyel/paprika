<?php
include("connect.php");
if($_POST["id"]){
	$id = (int)$_POST["id"];
	$id--;

	$incart = $_COOKIE["cart"];
	$incart = substr($incart, 1);
	$cart =  explode("|", $incart);
	$cart = array_unique($cart);

	unset($cart[$id]);
	$cart=array_values($cart);


	$cart = implode("|", $cart);
	if($cart){
		$cart = "|".$cart;
	}
	setcookie("cart", $cart, time()+30000000, '/');
	echo $cart;
}

?>