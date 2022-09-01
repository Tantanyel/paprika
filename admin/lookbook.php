<?php 
session_start();
include("connect.php");

$soob = $_SESSION['soob'];

if($_SESSION['login']){
	$arrlogin =  explode(",", $_SESSION['login']);
	$name = $arrlogin[0];
	$password = $arrlogin[1];
	$query = @mysql_query("SELECT * FROM admins WHERE name='$name'",$db);
	$myrow = @mysql_fetch_array($query);
	if($password==$myrow['password']){
	}else{
		$_SESSION['login']="";
		redir('/admin');
	}
}else{
	redir('/admin');
}

function translit($string) {
	$converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => '',  'ы' => 'y',   'ъ' => '',
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
		'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		' ' => '_',
		);
	return strtr($string, $converter);
}

if(isset($_POST["addlook"])){
	$colcat = @mysql_query("SELECT * FROM collections",$db);
	$colcat = mysql_num_rows($colcat);
	$colcat ++;
	
	$query = mysql_query("INSERT INTO collections VALUES('','$colcat','Новая коллекция','$colcat')",$db);
	redir('/admin/lookbook');
}

if(isset($_POST["savelook"])){
	$catarr = explode("|", $_POST['arr']);
	for ($i = 1; $i <= count($catarr); $i++) 
	{ 
		$arratr = explode(",", $catarr[$i]);
		$id = $arratr[0];
		$num = $arratr[1];
		$name = $arratr[2];
		$urlname = translit($name);
		$query = mysql_query("UPDATE collections SET num='$num',name='$name',url='$urlname' WHERE id='$id'",$db);
	}
	$_SESSION['soob'] = "Коллекции сохранены";
	redir('/admin/lookbook');
}

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Коллекции</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="../libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>

	<?php 	
	if($soob!=""){
		echo '
		<div class="soob">
			<a class="cloz" onclick="clozesoob()"></a>
			<span>'.$soob.'</span>
		</div>';
		$_SESSION['soob'] = "";
	}

	include("menu.php");
	?>



	<div class="center">
		<h2 class="zag">Категории каталога</h2>
		<div class="catalog">
			<?php
			$catalog = @mysql_query("SELECT * FROM collections ORDER BY num",$db);
			$myrow = @mysql_fetch_array($catalog);
			if($myrow){
				do{
					echo '
					<div class="categoria" num="'.$myrow["id"].'"> 
						<span>Позиция</span>
						<input id="num" type="number" value="'.$myrow["num"].'">
						<span>Название</span>
						<input id="name" type="text" value="'.$myrow["name"].'">
						<input onclick="deletelook('.$myrow["id"].')" type="submit" value="Удалить">
					</div>
					';
				}
				while($myrow = @mysql_fetch_array($catalog));
			}
			?>
			<div class="kn">
				<form method="post" action="lookbook">
					<input name="arr" type="text" class="hiden" id="hidcat">
					<input name="addlook" type="submit" value="Добавить коллекцию">
					<input name="savelook" type="submit" value="Сохранить коллекции">
				</form>
			</div>
		</div>

		<h2 class="zag">Фотографии</h2>
		<div class="searchprod">
			<input onkeyup="filtertrlook(this)" type="text" placeholder="Поиск по фотографиям">
			<a href="addlook">Добавить фото</a>
		</div>
		<div class="photolook">
			<?php
			$items = @mysql_query("SELECT * FROM photo ORDER BY id DESC",$db);
			$myrow = @mysql_fetch_array($items);
			if($myrow){
				do{
					$img = explode("|", $myrow["photo"]);
					$img = $img[0];
					$idc = $myrow["collection"];
					$coll = @mysql_query("SELECT * FROM collections WHERE id='$idc'",$db);
					$rowcoll = @mysql_fetch_array($coll);
					$idprod = $myrow["num"];
					$prod = @mysql_query("SELECT * FROM items WHERE id='$idprod'",$db);
					$rowprod = @mysql_fetch_array($prod);
					echo '
					<div class="look" num="'.$myrow["id"].'">
						<div class="img">
							<img src="../lookphoto/'.$img.'">
						</div>
						<span class="textlook">Коллекция: '.$rowcoll["name"].'</span>
						<span class="textlook find">'.$myrow["name"].' <a href="../product?num='.$myrow["num"].'">'.$rowprod["name"].'</a></span>
						<div class="knl">
							<a href="сhangelook?id='.$myrow["id"].'">Редактировать</a>
							<a onclick="deletelookp('.$myrow["id"].')">Удалить</a>
						</div>
					</div>
					';
				}
				while($myrow = @mysql_fetch_array($items));
			}
			?>
		</div>
	</div>

</body>

</html>
