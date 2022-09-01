<?php
session_start();
include("templates/connect.php");

if($_GET["info"]){
	$type = $_GET["info"];
	$info = @mysql_query("SELECT * FROM info WHERE id='1'",$db);
	$myrow = @mysql_fetch_array($info);
	$text = $myrow[$type];
	if($type=="dost"){
		$zagol = "Условия доставки";
	}
	if($type=="opl"){
		$zagol = "Об оплате";
	}
	if($type=="voz"){
		$zagol = "Условия возврата";
	}
}else{
	redir('info?info=dost');
}

?>

<html>
<?php include("templates/title.php"); ?>
<head>
	<title><?php echo $zagol; ?> | paprika</title>
</head>

<body>
	<?php include("templates/header.php"); ?>

	<?php include("templates/menu.php"); ?>
	
	<div class="katalogmenu">
		<div class="stolbkatalog">
			<a href="info?info=dost">Условия доставки</a>
			<a href="info?info=opl">Об оплате</a>
			<a href="info?info=voz">Условия возврата</a>
		</div>
	</div>

	<div class="content">
		<h2 class="zag"><span><?php echo $zagol; ?></span></h2>
		<div class="infocont">
			<?php echo $text; ?>
		</div>

		<?php include("templates/foot.php"); ?>
	</div>


</body>

</html>