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

if($_GET['id']){
	$id = (int)$_GET['id'];
	$query = @mysql_query("SELECT * FROM items WHERE id='$id'",$db);
	$myrow = @mysql_fetch_array($query);
	if($myrow){
		$photo_l = $myrow["photo"];
		$photo_l = explode("|", $photo_l);
		$name_l = $myrow["name"];
		$art_l = $myrow["art"];
		$catalog_l = $myrow["catalog"];
		$brend_l = $myrow["brend"];
		$cena_l = $myrow["cena"];
		$skid_l = $myrow["skid"];
		$opis_l = $myrow["opisanie"];
		$param_l = $myrow["param"];
		$sostav_l = $myrow["sostav"];
		$osncolor_l = $myrow["osncolor"];
		$colors_l = $myrow["colors"];
		$colors_l = explode("|", $colors_l);
		$color1 = explode(",", $colors_l[0]);
		$color2 = explode(",", $colors_l[1]);
		$razm_l = $myrow["razm"];
		$razm_l = explode(",", $razm_l);
	}else{
		$_SESSION['soob'] = "Непраельный товар";
		redir('/admin/items');
	}
}else{
	$_SESSION['soob'] = "Непраельный товар";
	redir('/admin/items');
}


if(isset($_POST["chang"])){
	$photo = explode("|", $_POST['files']);
	$nevdir = '../itemphoto/';
	$photoarr=array();
	if( ! is_dir( $nevdir ) ) mkdir( $nevdir, 0777 );
	for ($i = 1; $i < count($photo); $i++){
		$phot = basename($photo[$i]);
		if (file_exists("tmp/".$phot)) {
			rename("tmp/".$phot,$nevdir.$phot);
		}
		$photoarr[]=$phot;
	}
	$photostr = implode("|", $photoarr);
	foreach (glob('tmp/*') as $file){
		unlink($file);
	}
	$name = mysql_real_escape_string($_POST["naz"]);
	$art = $_POST["art"];
	$catalog = $_POST["catalog"];
	$brend = $_POST["brend"];
	$cena = $_POST["cena"];
	$skid = $_POST["skid"];
	$opis = $_POST["opis"];
	$param = $_POST["param"];
	$sostav = $_POST["sostav"];
	$osncolor = $_POST["osncolor"];
	$colors = $_POST["vcol"].",".$_POST["numvcol"]."|".$_POST["tcol"].",".$_POST["numtcol"];
	$razm = $_POST["raz1"].",".$_POST["raz2"].",".$_POST["raz3"];
	$razm = strtoupper ($razm);

	$query = mysql_query("UPDATE items SET photo='$photostr',name='$name',art='$art',catalog='$catalog',brend='$brend',cena='$cena',skid='$skid',opisanie='$opis',param='$param',sostav='$sostav',osncolor='$osncolor',colors='$colors',razm='$razm' WHERE id='$id'",$db);

	$query = @mysql_query("SELECT * FROM items",$db);
	$myrow = @mysql_fetch_array($query);
	if($myrow){
		$arrfiles = array();
		do{
			$bdfile = explode("|", $myrow["photo"]);
			for ($i = 0; $i < count($bdfile); $i++){
				$arrfiles[] = $bdfile[$i];
			}
		}
		while($myrow = @mysql_fetch_array($query));
		$dir    = '../itemphoto';
		$files1 = array_diff(scandir($dir), array('..', '.'));
		sort($files1);
		$dif = array_diff($files1, $arrfiles);
		foreach($dif as $key => $val) {
			$file_name = '../itemphoto/'.$dif[$key];
			if(file_exists($file_name)) {
				unlink($file_name);
			}
		}
	}

	$_SESSION['soob'] = "Товар изменен";
	redir('/admin/items');
}
?>

<html>

<head>
	<meta charset="UTF-8">
	<title>Редактировать товар №<?php echo $id; ?></title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="../libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>
	<?php include("menu.php");?>
	<div class="center">
		<h2 class="zag">Редактировать товар №<?php echo $id; ?></h2>
		<div class="additem">
			<h2>Фотографии</h2>
			<div class="photo">
				<?php
				for ($i = 0; $i < count($photo_l); $i++){
					echo '
					<div class="img"><img src="../itemphoto/'.$photo_l[$i].'"><a onclick="delphoto(this)">Удалить</a></div>
					';
				}
				?>
				<div class="file">
					<input id="photo" type="file" accept="image/*">
					<span>Загрузить</span>
					<a></a>
				</div>
			</div>
			<h2>Основное</h2>
			<form method="post" action="сhangeitem?id=<?php echo $id; ?>">
				<input name="files" type="text" class="hiden" id="hidadd">
				<div class="osn">
					<input name="naz" class="nazv" type="text" placeholder="Название" required value="<?php echo htmlspecialchars($name_l); ?>">
					<input name="art" class="artik" type="text" placeholder="Артикул" value="<?php echo $art_l; ?>">
					<select name="catalog" class="sel">
						<?php
						$catalog = @mysql_query("SELECT * FROM catalog ORDER BY num",$db);
						$myrow = @mysql_fetch_array($catalog);
						if($myrow){
							do{
								if($myrow["id"]==$catalog_l){
									echo '<option value="'.$myrow["id"].'" selected>'.$myrow["name"].'</option>';
								}else{
									echo '<option value="'.$myrow["id"].'">'.$myrow["name"].'</option>';
								}
							}
							while($myrow = @mysql_fetch_array($catalog));
						}
						?>
					</select>
					<select name="brend" class="bre">
						<?php
						$catalog = @mysql_query("SELECT * FROM brends ORDER BY num",$db);
						$myrow = @mysql_fetch_array($catalog);
						if($myrow){
							do{
								if($myrow["id"]==$brend_l){
									echo '<option value="'.$myrow["id"].'" selected>'.$myrow["name"].'</option>';
								}else{
									echo '<option value="'.$myrow["id"].'">'.$myrow["name"].'</option>';
								}
							}
							while($myrow = @mysql_fetch_array($catalog));
						}
						?>
					</select>
					<span>Цена</span>
					<input name="cena" class="cena" type="number" placeholder="Цена" required value="<?php echo $cena_l; ?>">
					<span>Скидка</span>
					<input name="skid" class="skid" type="number" placeholder="Скидка" value="<?php echo $skid_l; ?>">
					<span class="proc">%</span>
				</div>
				<h2>Информация о товаре</h2>
				<div class="infoprod">
					<textarea name="opis" placeholder="Описание"><?php echo $opis_l; ?></textarea>
					<textarea name="param" placeholder="Параметры модели"><?php echo $param_l; ?></textarea>
					<textarea name="sostav" placeholder="Состав"><?php echo $sostav_l; ?></textarea>
				</div>
				<h2>Цвет и размер</h2>
				<div class="coloraraz">
					<span>Основной цвет</span>
					<input name="osncolor" class="osncv" type="text" placeholder="Основной цвет (#ffffff)" required value="<?php echo $osncolor_l; ?>">
					<span>Второй цвет</span>
					<input name="vcol" class="vcv" type="text" placeholder="Второй цвет (#ffffff)" value="<?php echo $color1[0]; ?>">
					<span>Номер товара</span>
					<input name="numvcol" class="nom" type="number" placeholder="Номер товара" value="<?php echo $color1[1]; ?>">
					<span>Третий цвет</span>
					<input name="tcol" class="tcv" type="text" placeholder="Третий цвет (#ffffff)" value="<?php echo $color2[0]; ?>">
					<span>Номер товара</span>
					<input name="numtcol" class="nom" type="number" placeholder="Номер товара" value="<?php echo $color2[1]; ?>">
					
					<span>Размеры</span>
					<input name="raz1" class="raz" type="text" placeholder="Размер" required value="<?php echo $razm_l[0]; ?>">
					<input name="raz2" class="raz" type="text" placeholder="Размер" value="<?php echo $razm_l[1]; ?>">
					<input name="raz3" class="raz" type="text" placeholder="Размер" value="<?php echo $razm_l[2]; ?>">
				</div>
				<div class="knb">
					<input name="chang" class="chang" type="submit" value="Сохранить изменения">
				</div>
			</form>
		</div>
	</div>

</body>

</html>
