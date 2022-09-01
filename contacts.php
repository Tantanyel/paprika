<?php
session_start();
include("templates/connect.php");

?>

<html>
<?php include("templates/title.php"); ?>
<head>
	<title>Контакты | paprika</title>
</head>

<body>
	<?php include("templates/header.php"); ?>

	<?php include("templates/menu.php"); ?>

	<?php
	$contacts = @mysql_query("SELECT * FROM contacts WHERE id='1'",$db);
	$myrow = @mysql_fetch_array($contacts);
	$email_l = explode("|", $myrow['email']);
	$tel_l = explode("|", $myrow['phone']);
	$wa_l = explode("|", $myrow['wa']);
	$viber_l = explode("|", $myrow['viber']);
	$soc_l = explode("|", $myrow['soc']);
	?>

	<div class="content">
		<h2 class="zag"><span>Контакты</span></h2>
		<div class="contacont">
			<div class="containfo">
				<p>Email:
					<?php
					foreach($email_l as $key => $val) {
						if($val!=""){
							echo '<a>'.$val.'</a>';
						}
					}
					?>
				</p>
				<p>Телефон: 
					<?php
					foreach($tel_l as $key => $val) {
						if($val!=""){
							echo '<a>'.$val.'</a>';
						}
					}
					?>
				</p>
				<p>WhatsApp: 
					<?php
					foreach($wa_l as $key => $val) {
						if($val!=""){
							echo '<a>'.$val.'</a>';
						}
					}
					?>
				</p>
				<p>Viber: 
					<?php
					foreach($viber_l as $key => $val) {
						if($val!=""){
							echo '<a>'.$val.'</a>';
						}
					}
					?>
				</p>
				<p>Мы в социальных сетях: <a href="<?php echo $soc_l[1];?>" target="_blank">instagram</a> <a href="<?php echo $soc_l[0];?>" target="_blank">Вконтакте</a> <a href="<?php echo $soc_l[2];?>" target="_blank">Facebook</a></p>
			</div>
			<div class="karta">
				<h2>Пункты самовызова в Санкт-Петербурге</h2>
				<?php
				$maps = @mysql_query("SELECT * FROM maps ORDER BY id",$db);
				$myrow = @mysql_fetch_array($maps);
				if($myrow){
					do{
						echo'
						<div class="punctsam">
							<span>'.$myrow["adr"].'</span>
							<div class="kartaif">
								<iframe src="'.$myrow["map"].'" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
							</div>
						</div>
						';
					}
					while($myrow = @mysql_fetch_array($maps));
				}
				?>
			</div>
		</div>

		<?php include("templates/foot.php"); ?>
	</div>


</body>

</html>
