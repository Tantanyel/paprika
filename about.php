<?php
session_start();
include("templates/connect.php");

?>

<html>
<?php include("templates/title.php"); ?>
<head>
	<title>О нас | paprika</title>
</head>

<body>
	<?php include("templates/header.php"); ?>

	<?php include("templates/menu.php"); ?>

	<?php
	$ab = @mysql_query("SELECT * FROM about WHERE id='1'",$db);
	$myrow = @mysql_fetch_array($ab);
	$text = $myrow['about'];
	?>

	<div class="content">
		<h2 class="zag"><span>О НАС</span></h2>
		<div class="aboutcont">
			<?php echo $text;?>
		</div>

		<?php include("templates/foot.php"); ?>
	</div>


</body>

</html>
