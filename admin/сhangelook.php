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
	$query = @mysql_query("SELECT * FROM photo WHERE id='$id'",$db);
	$myrow = @mysql_fetch_array($query);
	if($myrow){
		$photo_l = $myrow["photo"];
		$name_l = mysql_real_escape_string($myrow["name"]);
		$num_l = $myrow["num"];
		$collection_l = $myrow["collection"];
	}else{
		$_SESSION['soob'] = "Непраельный товар";
		redir('/admin/lookbook');
	}
}else{
	$_SESSION['soob'] = "Непраельный товар";
	redir('/admin/lookbook');
}


if(isset($_POST["chang"])){
	$photo = explode("|", $_POST['files']);
	$nevdir = '../lookphoto/';
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
	$name = $_POST["name"];
	$num = $_POST["num"];
	$collection = $_POST["collection"];

	$query = mysql_query("UPDATE photo SET photo='$photostr',name='$name',num='$num',collection='$collection' WHERE id='$id'",$db);

	$query = @mysql_query("SELECT * FROM photo",$db);
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
		$dir    = '../lookphoto';
		$files1 = array_diff(scandir($dir), array('..', '.'));
		sort($files1);
		$dif = array_diff($files1, $arrfiles);
		foreach($dif as $key => $val) {
			$file_name = '../lookphoto/'.$dif[$key];
			if(file_exists($file_name)) {
				unlink($file_name);
			}
		}
	}

	$_SESSION['soob'] = "Фотография обновлена";
	redir('/admin/lookbook');
}
?>
<html>

<head>
	<meta charset="UTF-8">
	<title>Редактировать фото №<?php echo $id; ?></title>
	<link rel="shortcut icon" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css">
	<script src="../libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>
	<?php include("menu.php");?>
	<div class="center">
		<h2 class="zag">Редактировать фото №<?php echo $id; ?></h2>
		<div class="addlook">
			<h2>Фотография</h2>
			<div class="photolook" id="lookp">
				<?php
				if($photo_l){
					echo '
					<div class="img"><img src="../lookphoto/'.$photo_l.'"><a onclick="delphoto(this)">Удалить</a></div>
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
			<form method="post" action="сhangelook?id=<?php echo $id; ?>">
				<input name="files" type="text" class="hiden" id="hidadd">
				<div class="lookosn">
					<input name="name" class="name" type="text" placeholder="Текст под фото" value="<?php echo $name_l; ?>">
					<input name="num" class="num" type="number" placeholder="Номер товара" value="<?php echo $num_l; ?>">
					<select name="collection" class="collection">
						<?php
						$catalog = @mysql_query("SELECT * FROM collections ORDER BY num",$db);
						$myrow = @mysql_fetch_array($catalog);
						if($myrow){
							do{
								if($myrow["id"]==$collection_l){
									echo '<option value="'.$myrow["id"].'" selected>'.$myrow["name"].'</option>';
								}else{
									echo '<option value="'.$myrow["id"].'">'.$myrow["name"].'</option>';
								}
							}
							while($myrow = @mysql_fetch_array($catalog));
						}
						?>
					</select>
				</div>
				<div class="knb">
					<input name="chang" class="chang" type="submit" value="Сохранить фото">
				</div>
			</form>
		</div>
	</div>

</body>

</html>