<?php
session_start();
include("templates/connect.php");


?>
<html>
<?php include("templates/title.php"); ?>
<head>
	<title>F.A.Q | paprika</title>
</head>

<body>
	<?php include("templates/header.php"); ?>

	<?php include("templates/menu.php"); ?>

	<div class="content">
		<h2 class="zag"><span>Часто задаваемые вопросы</span></h2>
		<div class="faqcont">
			<?php
			$faq = @mysql_query("SELECT * FROM faq ORDER BY id",$db);
			$myrow = @mysql_fetch_array($faq);
			if($myrow){
				do{
					echo'
					<div class="faq">
					<span onclick="faqopn(this);">'.$myrow["vop"].'</span>
						<a onclick="faqopn(this);">+</a>
						<p>'.$myrow["otv"].'</p>
					</div>
					';
				}
				while($myrow = @mysql_fetch_array($faq));
			}
			?>
			
		</div>
		
		<?php include("templates/foot.php"); ?>
	</div>


</body>

</html>