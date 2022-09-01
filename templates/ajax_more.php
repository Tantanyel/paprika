<?php
session_start();
include("connect.php");
if($_POST["count"]){
	$types =  explode(",", $_POST["type"]);
	$type = $types[0];
	$cat = $types[1];
	$count = (int)$_POST["count"];
	$minc = $count;
	$maxc = 4;
	$html;

	$_SESSION['scroll']=$type.",".$cat.",".($minc+$maxc);

	if($type == "all"){
		$item = @mysql_query("SELECT * FROM items ORDER BY id DESC LIMIT $minc,$maxc",$db);
		$col = @mysql_query("SELECT * FROM items ORDER BY id DESC",$db);
	}
	if($type == "sale"){
		$item = @mysql_query("SELECT * FROM items WHERE skid>0 ORDER BY id DESC DESC LIMIT $minc,$maxc",$db);
		$col = @mysql_query("SELECT * FROM items WHERE skid>0 ORDER BY id DESC DESC",$db);
	}
	if($type == "catalog"){
		$item = @mysql_query("SELECT * FROM items WHERE catalog='$cat' ORDER BY id DESC LIMIT $minc,$maxc",$db);
		$col = @mysql_query("SELECT * FROM items WHERE catalog='$cat' ORDER BY id DESC",$db);
	}
	if($type == "brend"){
		$item = @mysql_query("SELECT * FROM items WHERE brend='$cat' ORDER BY id DESC LIMIT $minc,$maxc",$db);
		$col = @mysql_query("SELECT * FROM items WHERE brend='$cat' ORDER BY id DESC",$db);
	}

	$myrow = @mysql_fetch_array($item);
	if($myrow){
		do{
			$img = explode("|", $myrow["photo"]);
			$img = $img[0];
			$skid = ceil($myrow["cena"]-($myrow["cena"]*($myrow["skid"]/100)));
			if($myrow["skid"]>0){
				$skidclass = 'saleitem';
				$cena = '<s>'.$myrow["cena"].' руб</s><p>'.$skid.' руб</p>';
				$pskid = '<span class="proc">-'.$myrow["skid"].'%</span>';
			}else{
				$skidclass = '';
				$cena = '<p>'.$myrow["cena"].' руб</p>';
				$pskid = '';
			}
			$fav =  explode(",", $_COOKIE["fav"]);
                    if (in_array($myrow["id"], $fav)) {
                        $addsfav = "activei";
                    }
                    $cart =  explode("|", $_COOKIE["cart"]);
                    if (in_array($myrow["id"].",0", $cart)||in_array($myrow["id"].",1", $cart)||in_array($myrow["id"].",2", $cart)) {
                        $addscart = "activei";
                    }
                    if($myrow["razcol1"]+$myrow["razcol2"]+$myrow["razcol3"]>0){
                        $raz = explode(",", $myrow["razm"]);
                        $corztable = "";
                        foreach($raz as $key => $val) {
                            $colraz = $key+1;
                            $colraz = "razcol".$colraz;
                            if($myrow[$colraz]>0){
                                $corztable = $corztable.'<span onclick="cart('.$myrow["id"].','.$key.',this)">'.$raz[$key].'</span>';
                            }else{
                                $corztable = $corztable.'<span class="non">'.$raz[$key].'</span>';
                            }
                        }
                    }else{
                        $corztable = '<a>Нет в наличии</a>';
                    }
                    echo '
                    <div class="itemcont">
                        <a href="product?num='.$myrow["id"].'" class="item '.$skidclass.'">
                            <div class="imgi"><img src="itemphoto/'.$img.'"></div>
                            '.$pskid.'
                            <div class="opisitem">
                                <span class="name">'.$myrow["name"].'</span>
                                <span class="prise">'.$cena.'</span>
                            </div>
                        </a>
                        <div class="itemkn">
                            <span onclick="favorite('.$myrow["id"].',this)" class="favitem '.$addsfav.'"></span>
                            <span onclick="cartcatalog(this)" class="corzitem '.$addscart.'"></span>
                        </div>
                        <div class="corztable">
                            '.$corztable.'
                        </div>
                    </div>
                    ';
			$addsfav = "";
			$addscart = "";
		}
		while($myrow = @mysql_fetch_array($item));
		$colitem = mysql_num_rows($col);
		echo $colitem;
		if($colitem>$minc+$maxc){
			$strmore = $type.','.$cat;
			$html = $html.'<span onclick="more(\''.$strmore.'\')" class="show">ПОКАЗАТЬ ЕЩЕ</span>';
		}
		echo $html;
	}
}
?>