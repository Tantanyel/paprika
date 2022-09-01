<div class="fmenu"></div>
<div class="icomenu iblack" onclick="menu()">
	<span class="up"></span>
	<span class="mid"></span>
	<span class="down"></span>
</div>

<a href="/" class="logo logob">
	<img src="img/logob.png">
</a>

<?php
$fav =  explode(",", $_COOKIE["fav"]);
$cart =  explode("|", $_COOKIE["cart"]);
$colfav = count($fav)-1;
$colcart = array_count_values($cart);
$colcart = count($colcart)-1;
?>

<a href="/favorite" class="fav">
	<img src="img/heartb.png">
	<span><?php echo $colfav;?></span>
</a>

<a href="/cart" class="corz cblzck">
	<img src="img/corzb.png">
	<span><?php echo $colcart ;?></span>
</a>