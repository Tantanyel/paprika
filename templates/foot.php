<?php
$cont = @mysql_query("SELECT * FROM contacts WHERE id='1'",$db);
$myrow = @mysql_fetch_array($cont);
$soc_l = explode("|", $myrow['soc']);
?>

<div class="soc socb">
	<a href="<?php echo $soc_l[2];?>" target="_blank"><img src="img/fbb.png"></a>
	<a href="<?php echo $soc_l[1];?>" target="_blank"><img src="img/instb.png"></a>
	<a href="<?php echo $soc_l[0];?>" target="_blank"><img src="img/vkb.png"></a>
</div>
<p class="copy copyb">Copyright © 2017 paprika. Все права защищены. Создали <a href="http://polimerstudios.ru" target="_blank">Polimer</a></p>