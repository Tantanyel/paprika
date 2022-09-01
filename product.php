<?php
session_start();
include("templates/connect.php");

if($_GET['num']){
    $idprod = (int)$_GET['num'];
    $prod = @mysql_query("SELECT * FROM items WHERE id='$idprod'",$db);
    $myrow = @mysql_fetch_array($prod);
    if($myrow){
        $photo = $myrow["photo"];
        $photo = explode("|", $photo);
        $name = $myrow["name"];
        $art = $myrow["art"];
        $catalog = $myrow["catalog"];
        $catl = $myrow["catalog"];
        $brend = $myrow["brend"];
        $cena = $myrow["cena"];
        $skid = $myrow["skid"];
        $opis = $myrow["opisanie"];
        $param = $myrow["param"];
        $sostav = $myrow["sostav"];
        $osncolor = $myrow["osncolor"];
        $colors = $myrow["colors"];
        $colors = explode("|", $colors);
        $color1 = explode(",", $colors[0]);
        $color2 = explode(",", $colors[1]);
        $razm = $myrow["razm"];
        $razm = explode(",", $razm);
        $colrazm1 = $myrow["razcol1"];
        $colrazm2 = $myrow["razcol2"];
        $colrazm3 = $myrow["razcol3"];
    }else{
        redir('/catalog');
    }
}else{
    redir('/catalog');
}

?>

<html>
<?php include("templates/title.php"); ?>
<head>
    <title><?php echo $name; ?> | paprika</title>
</head>

<body>
    <?php include("templates/header.php"); ?>

    <?php include("templates/menu.php"); ?>

    <div class="katalogmenu">
        <div class="stolbkatalog">
            <span>КАТАЛОГ</span>
            <?php
            $catalog = @mysql_query("SELECT * FROM catalog ORDER BY num",$db);
            $myrow = @mysql_fetch_array($catalog);
            if($myrow){
                do{
                    echo '<a href="catalog?catalog='.$myrow["url"].'">'.$myrow["name"].'</a>';
                }
                while($myrow = @mysql_fetch_array($catalog));
            }
            ?>
        </div>
        <div class="stolbkatalog">
            <span>НАШИ БРЕНДЫ</span>
            <?php
            $catalog = @mysql_query("SELECT * FROM brends ORDER BY num",$db);
            $myrow = @mysql_fetch_array($catalog);
            if($myrow){
                do{
                    echo '<a href="catalog?brend='.$myrow["url"].'">'.$myrow["name"].'</a>';
                }
                while($myrow = @mysql_fetch_array($catalog));
            }
            ?>
        </div>
        <div class="stolbkatalog">
            <a href="catalog?sale=sale" class="sal">SALE</a>
        </div>
    </div>

    <div class="tsize">
        <div class="contsize">
            <div onclick="clozeall('.tsize')" class="cloz"></div>
            <table cellspacing="0">
                <tr>
                    <th>Размеры</th>
                    <td>S</td>
                    <td>M</td>
                    <td>L</td>
                </tr>
                <tr>
                    <th>Обхват груди</th>
                    <td>88см</td>
                    <td>92см</td>
                    <td>96см</td>
                </tr>
                <tr>
                    <th>Обхват талии</th>
                    <td>86см</td>
                    <td>74см</td>
                    <td>78см</td>
                </tr>
                <tr>
                    <th>Обхват бедер</th>
                    <td>94см</td>
                    <td>100см</td>
                    <td>104см</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="opisproduct">
        <div class="contopis">
            <div onclick="clozeall('.opisproduct')" class="cloz"></div>
            <div class="skrolopis">
                <div class="punctopis">
                    <h2>Описание</h2>
                    <p><?php echo $opis; ?></p>
                </div>
                <div class="punctopis">
                    <h2>Параметры модели</h2>
                    <p><?php echo $param; ?></p>
                </div>
                <div class="punctopis">
                    <h2>Состав</h2>
                    <p><?php echo $sostav; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="corzdob">
        <div class="contcorz">
            <div onclick="clozeall('.corzdob')" class="cloz"></div>
            <h2>Вы добавили этот товар в корзину</h2>
            <a href="cart" class="btnprod"><img src="img/corzb.png"><i>Перейти в корзину</i></a>
        </div>
    </div>

    <div class="product">
        <div class="pimpphoto">
            <?php
            foreach($photo as $key => $val) {
                $num = $key+1;
                echo '<span onclick="chphoto('.$num.')"><img src="itemphoto/'.$val.'"></span>';
            }
            ?>
        </div>
        <div class="photos">
           <?php
           foreach($photo as $key => $val) {
            $num = $key+1;
            echo '
            <div class="photo">
                <img src="itemphoto/'.$val.'">
            </div>';
        }
        ?>
    </div>
    <div class="opisprod">
        <div class="nameblprod">
            <p><?php echo $name; ?></p>
            <i>Артикул: <?php echo $art; ?></i>
            <?php
            $skidp = ceil($cena-($cena*($skid/100)));
            if($skid>0){
                $skidclass = 'saleitem';
                $cena = '<s>'.$cena.' руб</s><p>'.$skidp.' руб</p>';
            }else{
                $skidclass = '';
                $cena = '<p>'.$cena.' руб</p>';
            }
            ?>
            <span class="priseprod saleprod"><?php echo $cena; ?></span>
        </div>
        <div class="paramprod">
            <div class="pprod">
                <span>Цвет:</span>
                <a class="actprod" col="<?php echo $osncolor; ?>"></a>
                <?php
                if($color1[0]!=""){
                    echo '<a href="product?num='.$color1[1].'" col="'.$color1[0].'"></a>';
                }
                if($color2[0]!=""){
                    echo '<a href="product?num='.$color2[1].'" col="'.$color2[0].'"></a>';
                }
                ?>
            </div>
            <div class="pprod">
                <span>Размер:</span>
                <?php
                if($razm[0]!=""){
                    echo '<a id="firazm" onclick="chrazm(this)" num="'.$colrazm1.'" raz="'.$razm[0].'"></a>';
                }
                if($razm[1]!=""){
                    echo '<a onclick="chrazm(this)" num="'.$colrazm2.'" raz="'.$razm[1].'"></a>';
                }
                if($razm[2]!=""){
                    echo '<a onclick="chrazm(this)" num="'.$colrazm3.'" raz="'.$razm[2].'"></a>';
                }
                ?>
            </div>
            <span class="colit">Товар отсутствует</span>
        </div>
        <span onclick="addcartprod(<?php echo $idprod; ?>,this)" id="cart" class="btnprod"><img src="img/corzb.png"><i>Добавить в корзину</i></span>
        <span onclick="favorite(<?php echo $idprod; ?>,this);" id="favprod" class="btnprod">
            <?php
            $fav =  explode(",", $_COOKIE["fav"]);
            if (in_array($idprod, $fav)) {
                echo '
                <img src="img/heartactive.png">
                <i>Убрать из избранного</i>
                ';
            }else{
                echo '
                <img src="img/heartb.png">
                <i>Добавить в избранное</i>
                ';
            }
            ?>
        </span>
        <a onclick="clozeall('.tsize')" class="overlayprod">Таблица размеров</a>
        <a onclick="clozeall('.opisproduct')" class="overlayprod">Информация о товаре</a>
    </div>
</div>

<div class="recproduct">
    <div class="katalogitem">
        <h2 class="zag"><span>Возможно вам понравится</span></h2>
        <?php
        $item = @mysql_query("SELECT * FROM items WHERE catalog='$catl' ORDER BY RAND() LIMIT 2",$db);
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
        }
        ?>
    </div>
    <?php include("templates/foot.php"); ?>
</div>


</body>

</html>