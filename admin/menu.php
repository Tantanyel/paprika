<?php

$strname = basename($_SERVER['PHP_SELF'], ".php");

?>

<div class="menu">
	<a href="zakaz" <?php if($strname=="zakaz"){echo 'class="active"';}?>>Заказы</a>
	<a href="catalog" <?php if($strname=="catalog"){echo 'class="active"';}?>>Каталог</a>
	<a href="items" <?php if($strname=="items"){echo 'class="active"';}?>>Товары</a>
	<a href="lookbook" <?php if($strname=="lookbook"){echo 'class="active"';}?>>Коллекции</a>
	<a href="message" <?php if($strname=="message"){echo 'class="active"';}?>>Сообщения</a>
	<a href="rev" <?php if($strname=="rev"){echo 'class="active"';}?>>Отзывы</a>
	<a href="faq" <?php if($strname=="faq"){echo 'class="active"';}?>>FAQ</a>
	<a href="info" <?php if($strname=="info"){echo 'class="active"';}?>>Информация</a>
	<a href="contacts" <?php if($strname=="contacts"){echo 'class="active"';}?>>Контакты</a>
	<a href="about" <?php if($strname=="about"){echo 'class="active"';}?>>О нас</a>
</div>