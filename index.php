<?php
session_start();
include("templates/connect.php");
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Интернет магазин одежды | paprika</title>
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css" />
    <script src="libs/jquery/jquery-1.11.1.min.js"></script>
    <script src="libs/device/device.js"></script>
    <script src="js/landing.js"></script>
    <script src="libs/hammer/hammer.min.js"></script>
    <script src="libs/slidepage/slidepage.js"></script>

    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="width=320, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
</head>

<body>

    <div class="icomenu" onclick="menu()">
        <span class="up"></span>
        <span class="mid"></span>
        <span class="down"></span>
    </div>

    <a href="/" class="logo">
        <img src="img/logo.png">
    </a>

    <?php
    $fav =  explode(",", $_COOKIE["fav"]);
    $cart =  explode("|", $_COOKIE["cart"]);
    $colfav = count($fav)-1;
    $colcart = array_count_values($cart);
    $colcart = count($colcart)-1;
    ?>
    
    <a href="favorite" class="fav">
        <img src="img/heart.png">
        <span><?php echo $colfav;?></span>
    </a>

    <a href="cart" class="corz">
        <img src="img/corz.png">
        <span><?php echo $colcart ;?></span>
    </a>

    <?php include("templates/menu.php"); ?>

    <div class="punct">
        <a class="pimp activepimp" slid="0"></a>
        <a class="pimp" slid="1"></a>
        <a class="pimp" slid="2"></a>
    </div>

    <?php
    $cont = @mysql_query("SELECT * FROM contacts WHERE id='1'",$db);
    $myrow = @mysql_fetch_array($cont);
    $soc_l = explode("|", $myrow['soc']);
    $email_l = explode("|", $myrow['email']);
    $tel_l = explode("|", $myrow['phone']);
    ?>

    <div class="soc">
        <a href="<?php echo $soc_l[2];?>" target="_blank"><img src="img/fb.png"></a>
        <a href="<?php echo $soc_l[1];?>" target="_blank"><img src="img/inst.png"></a>
        <a href="<?php echo $soc_l[0];?>" target="_blank"><img src="img/vk.png"></a>
    </div>

    <p class="copy">Copyright © 2017 paprika. Все права защищены. Создали <a href="http://polimerstudios.ru" target="_blank">Polimer</a></p>

    <div class="centerland" id="center">

        <div class="layer layer1">
            <a href="catalog" class="gkn">КАТАЛОГ</a>
            <img src="img/bg1.jpg" class="fon">
        </div>

        <div class="layer layer2">
            <a href="lookbook" class="gkn">LOOKBOOK</a>
            <img src="img/bg2.jpg" class="fon">
        </div>

        <div class="layer layer3">
            <img src="img/bg3.jpg" class="fon">
            <form class="formsend">
                <h2>Не стесняйтесь обращаться к нам</h2>
                <div class="formcont">
                    <div class="pcont"><img src="img/phone.png"><span><?php echo $tel_l[0];?></span></div>
                    <div class="pcont"><img src="img/mail.png"><span><?php echo $email_l[0];?></span></div>
                </div>
                <input id="names" type="text" placeholder="Ваше имя" required>
                <input id="emails" type="email" placeholder="Ваш e-mail" required>
                <textarea id="texts" placeholder="Сообщение" required></textarea>
                <a onclick="sendmes(this)" class="sendmes">Отправить</a>
            </form>
        </div>

    </div>


</body>

</html>