<?php
session_start();
include("templates/connect.php");

$items = "all";

if($_GET['catalog']){
    $cat = true;
    $items = $_GET['catalog'];
    $items = mysql_real_escape_string($items);
    $num = @mysql_query("SELECT * FROM catalog WHERE url='$items'",$db);
    $myrow = @mysql_fetch_array($num);
    $items = $myrow['id'];
}
if($_GET['brend']){
    $brend = true;
    $items = $_GET['brend'];
    $items = mysql_real_escape_string($items);
    $num = @mysql_query("SELECT * FROM brends WHERE url='$items'",$db);
    $myrow = @mysql_fetch_array($num);
    $items = $myrow['id'];
}
if($_GET['sale']){
    $items = "sale";
}

$numscroll = 4;

if($_SESSION['scroll']){
    $scrolls =  explode(",", $_SESSION['scroll']);
    $typear = $scrolls[0];
    $catar = $scrolls[1];
    $numar = $scrolls[2];

    if($cat&&$typear=="catalog"&&$items=="$catar"){
        $numscroll = $numar;
    }else{
        $_SESSION['scroll'] = "";
    }

    if($brend&&$typear=="brend"&&$items=="$catar"){
        $numscroll = $numar;
    }else{
        $_SESSION['scroll'] = "";
    }

    if($items=="all"&&$typear=="all"){
        $numscroll = $numar;
    }else{
        $_SESSION['scroll'] = "";
    }

    if($items=="sale"&&$typear=="sale"){
        $numscroll = $numar;
    }else{
        $_SESSION['scroll'] = "";
    }
}

?>

<html>
<?php include("templates/title.php"); ?>
<head>
    <title>Каталог | paprika</title>
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

    <div class="content">
        <div class="katalogitem">
            <?php
            if($items == "all"){
                $item = @mysql_query("SELECT * FROM items ORDER BY id DESC LIMIT $numscroll",$db);
                $col = @mysql_query("SELECT * FROM items ORDER BY id DESC",$db);
            }
            if($items == "sale"){
                $item = @mysql_query("SELECT * FROM items WHERE skid>0 ORDER BY id DESC LIMIT $numscroll",$db);
                $col = @mysql_query("SELECT * FROM items WHERE skid>0 ORDER BY id DESC",$db);
            }
            if($cat){
                $item = @mysql_query("SELECT * FROM items WHERE catalog='$items' ORDER BY id DESC LIMIT $numscroll",$db);
                $col = @mysql_query("SELECT * FROM items WHERE catalog='$items' ORDER BY id DESC",$db);
            }
            if($brend){
                $item = @mysql_query("SELECT * FROM items WHERE brend='$items' ORDER BY id DESC LIMIT $numscroll",$db);
                $col = @mysql_query("SELECT * FROM items WHERE brend='$items' ORDER BY id DESC",$db);
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
                if($colitem>4){
                    if($cat){
                        $strtype = $items;
                        $items = "catalog";
                    }
                    if($brend){
                        $strtype = $items;
                        $items = "brend";
                    }
                    $strmore = $items.','.$strtype;
                    echo '<span onclick="more(\''.$strmore.'\')" class="show">ПОКАЗАТЬ ЕЩЕ</span>';
                }
            }
            ?>
        </div>
        <?php include("templates/foot.php"); ?>
    </div>


</body>

</html>