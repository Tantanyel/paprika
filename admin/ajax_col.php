<?
session_start();
include("connect.php");

if($_SESSION['login']){
    $arrlogin =  explode(",", $_SESSION['login']);
    $name = $arrlogin[0];
    $password = $arrlogin[1];
    $query = @mysql_query("SELECT * FROM admins WHERE name='$name'",$db);
    $myrow = @mysql_fetch_array($query);
    if($password==$myrow['password']){
        $dost = true;
    }else{
        $_SESSION['login']="";
        $dost = false;
    }
}
if($dost){
    if(isset($_POST['open'])){
        $id = $_POST['id'];
        $query = @mysql_query("SELECT * FROM items WHERE id='$id'",$db);
        $myrow = @mysql_fetch_array($query);
        $raz = explode(",", $myrow["razm"]);
        echo '
        <div class="contcolred">
            <a onclick="clozeall(\'.colred\')" class="cloz"></a>
            <h2>Изменение количества товара - №<span>'.$myrow['id'].'</span></h2>
            <span>'.$raz[0].'</span>
            <span>'.$raz[1].'</span>
            <span>'.$raz[2].'</span>
            <input type="number" placeholder="Количество" value="'.$myrow["razcol1"].'">
            <input type="number" placeholder="Количество" value="'.$myrow["razcol2"].'">
            <input type="number" placeholder="Количество" value="'.$myrow["razcol3"].'">
            <div class="knb">
                <a onclick="izmcol('.$myrow['id'].',this)">Обновить количество</a>
            </div>
        </div>
        ';
    }
    if(isset($_POST['izm'])){
        $id = $_POST['id'];
        $col = explode(",", $_POST['col']);
        $query = mysql_query("UPDATE items SET razcol1='$col[0]',razcol2='$col[1]',razcol3='$col[2]' WHERE id='$id'",$db);
        echo "okizm";
        $_SESSION['soob']="Количество обновлено";
    }
}else{
    echo "nodost";
}
?>