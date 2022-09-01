<?php
session_start();
include("templates/connect.php");

if($_GET['c']){
    $slid = false;
    $collection = $_GET['c'];
    $collection = mysql_real_escape_string($collection);
}else{
    $slid = true;
}

?>
<html>
<?php include("templates/title.php"); ?>
<head>
    <title>LOOKBOOK | paprika</title>
</head>

<body>
    <?php include("templates/header.php"); ?>

    <?php include("templates/menu.php"); ?>

    <div class="content">
        <div class="lookbook">
            <?php
            if($slid){
                echo '<h2 class="zag"><span>Все коллекции</span></h2>';
                $coll = @mysql_query("SELECT * FROM collections ORDER BY id DESC",$db);
                $myrow = @mysql_fetch_array($coll);
                $slide = '';
                if($myrow){
                    do{
                        $idcol = $myrow["id"];
                        $img = @mysql_query("SELECT * FROM photo WHERE collection='$idcol' ORDER BY id DESC",$db);
                        $rimg = @mysql_fetch_array($img);
                        $img = $rimg["photo"];
                        $slide=$slide.'
                        <div class="slid">
                            <img src="lookphoto/'.$img.'">
                            <a href="lookbook?c='.$myrow["url"].'">'.$myrow["name"].'</a>
                        </div>
                        ';
                    }
                    while($myrow = @mysql_fetch_array($coll));
                }
                echo'
                <div class="sliderlook">
                    <span class="arrows lefta">&lsaquo;</span>
                    <span class="arrows righta">&rsaquo;</span>
                    <div class="slider">
                        '.$slide.'
                    </div>
                </div>
                ';
            }


            if($slid){
                $collname = @mysql_query("SELECT * FROM collections ORDER BY id DESC",$db);
                $myrow = @mysql_fetch_array($collname);
                $idcollection = $myrow["id"];
                echo '<h2 class="zag"><span>'.$myrow["name"].'</span></h2>';
            }else{
                $collname = @mysql_query("SELECT * FROM collections WHERE url='$collection'",$db);
                $myrow = @mysql_fetch_array($collname);
                $idcollection = $myrow["id"];
                echo '<h2 class="zag"><span>'.$myrow["name"].'</span></h2>';
            }

            $colbig = @mysql_query("SELECT * FROM photo WHERE collection='$idcollection' ORDER BY id DESC LIMIT 1",$db);
            $rowbig = @mysql_fetch_array($colbig);
            if($rowbig){
                do{
                    $idprod = $rowbig["num"];
                    $prod = @mysql_query("SELECT * FROM items WHERE id='$idprod'",$db);
                    $rowprod = @mysql_fetch_array($prod);
                    echo'
                    <div class="bigbook">
                        <div class="bookitem">
                            <div class="imgi"><img src="lookphoto/'.$rowbig["photo"].'"></div>
                            <div class="bookname">
                                <span>'.$rowbig["name"].' -</span>
                                <a href="product?num='.$rowprod["id"].'">'.$rowprod["name"].'</a>
                            </div>
                        </div>
                    </div>
                    ';
                }
                while($rowbig = @mysql_fetch_array($colbig));
            }

            ?>

            <div class="allbook">
                <?php
                $colmin = @mysql_query("SELECT * FROM photo WHERE collection='$idcollection' ORDER BY id DESC LIMIT 1,99999999",$db);
                $rowmin = @mysql_fetch_array($colmin);

                if($rowmin){
                    do{
                        $idprod = $rowmin["num"];
                        $prod = @mysql_query("SELECT * FROM items WHERE id='$idprod'",$db);
                        $rowprod = @mysql_fetch_array($prod);
                        echo'
                        <div class="minbook">
                            <div class="bookitem">
                                <div class="imgi"><img src="lookphoto/'.$rowmin["photo"].'"></div>
                                <div class="bookname">
                                    <span>'.$rowmin["name"].' -</span>
                                    <a href="product?num='.$rowprod["id"].'">'.$rowprod["name"].'</a>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    while($rowmin = @mysql_fetch_array($colmin));
                }
                ?>
            </div>


        </div>
        <?php include("templates/foot.php"); ?>
    </div>


</body>

</html>