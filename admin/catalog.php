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

if(isset($_POST["addcat"])){
	$colcat = @mysql_query("SELECT * FROM catalog",$db);
	$colcat = mysql_num_rows($colcat);
	$colcat ++;
	
	$query = mysql_query("INSERT INTO catalog VALUES('','$colcat','Новая категория','$colcat')",$db);
	redir('/admin/catalog');
}

if(isset($_POST["savecat"])){
	$catarr = explode("|", $_POST['arr']);
	for ($i = 1; $i <= count($catarr); $i++) 
	{ 
		$arratr = explode(",", $catarr[$i]);
		$id = $arratr[0];
		$num = $arratr[1];
		$name = $arratr[2];
		$urlname = translit($name);
		$query = mysql_query("UPDATE catalog SET num='$num',name='$name',url='$urlname' WHERE id='$id'",$db);
	}
	$_SESSION['soob'] = "Каталоги сохранены";
	redir('/admin/catalog');
}

if(isset($_POST["addbrend"])){
	$colb = @mysql_query("SELECT * FROM brends",$db);
	$colb = mysql_num_rows($colb);
	$colb ++;
	
	$query = mysql_query("INSERT INTO brends VALUES('','$colb','Новый бренд','$colb')",$db);
	redir('/admin/catalog');
}

if(isset($_POST["savebrend"])){
	$barr = explode("|", $_POST['arr']);
	for ($i = 1; $i <= count($barr); $i++) 
	{ 
		$arratr = explode(",", $barr[$i]);
		$id = $arratr[0];
		$num = $arratr[1];
		$name = $arratr[2];
		$urlname = translit($name);
		$query = mysql_query("UPDATE brends SET num='$num',name='$name',url='$urlname' WHERE id='$id'",$db);
	}
	$_SESSION['soob'] = "Бренды сохранены";
	redir('/admin/catalog');
}

?>


<html>

<head>
	<meta charset="UTF-8">
	<title>Каталог</title>
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
			$catalog = @mysql_query("SELECT * FROM catalog ORDER BY num",$db);
			$myrow = @mysql_fetch_array($catalog);
			if($myrow){
				do{
					echo '
					<div class="categoria" num="'.$myrow["id"].'"> 
						<span>Позиция</span>
						<input id="num" type="number" value="'.$myrow["num"].'">
						<span>Название</span>
						<input id="name" type="text" value="'.$myrow["name"].'">
						<input onclick="deletecat('.$myrow["id"].')" type="submit" value="Удалить">
					</div>
					';
				}
				while($myrow = @mysql_fetch_array($catalog));
			}
			?>
			<div class="kn">
				<form method="post" action="catalog">
					<input name="arr" type="text" class="hiden" id="hidcat">
					<input name="addcat" type="submit" value="Добавить категорию">
					<input name="savecat" type="submit" value="Сохранить каталоги">
				</form>
			</div>
		</div>

		<h2 class="zag">Бренды</h2>
		<div class="catalog">
			<?php
			$catalog = @mysql_query("SELECT * FROM brends ORDER BY num",$db);
			$myrow = @mysql_fetch_array($catalog);
			if($myrow){
				do{
					echo '
					<div class="brends" num="'.$myrow["id"].'"> 
						<span>Позиция</span>
						<input id="num" type="number" value="'.$myrow["num"].'">
						<span>Название</span>
						<input id="name" type="text" value="'.$myrow["name"].'">
						<input onclick="deleteb('.$myrow["id"].')" type="submit" value="Удалить">
					</div>
					';
				}
				while($myrow = @mysql_fetch_array($catalog));
			}
			?>
			<div class="kn">
				<form method="post" action="catalog">
					<input name="arr" type="text" class="hiden" id="hidbrend">
					<input name="addbrend" type="submit" value="Добавить бренд">
					<input name="savebrend" type="submit" value="Сохранить бренды">
				</form>
			</div>
		</div>
	</div>

</body>

</html>
