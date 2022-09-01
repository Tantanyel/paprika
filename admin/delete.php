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
    if(isset($_POST['cat'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM catalog WHERE id='$id'",$db);
        echo "catdel";
    }
    if(isset($_POST['cart'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM zakaz WHERE id='$id'",$db);
        echo "cartdel";
    }
    if(isset($_POST['cartv'])){
        $id = $_POST['id'];
        $query = mysql_query("UPDATE zakaz SET vipol='0' WHERE id='$id'",$db);
        echo "cartv";
    }
    if(isset($_POST['brend'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM brends WHERE id='$id'",$db);
        echo "bdel";
    }
    if(isset($_POST['item'])){
        $id = $_POST['id'];
        $query = @mysql_query("SELECT * FROM items WHERE id='$id'",$db);
        $myrow = @mysql_fetch_array($query);
        $photo = explode("|", $myrow["photo"]);
        for ($i = 0; $i < count($photo); $i++){
            unlink('../itemphoto/'.$photo[$i]);
        }
        $query = mysql_query("DELETE FROM items WHERE id='$id'",$db);
        echo "itemdel";
    }
    if(isset($_POST['mes'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM message WHERE id='$id'",$db);
        echo "mesdel";
    }
    if(isset($_POST['adr'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM maps WHERE id='$id'",$db);
        echo "adrdel";
    }
    if(isset($_POST['faq'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM faq WHERE id='$id'",$db);
        echo "faqdel";
    }
    if(isset($_POST['rev'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM reviews WHERE id='$id'",$db);
        echo "revdel";
    }
    if(isset($_POST['look'])){
        $id = $_POST['id'];
        $query = mysql_query("DELETE FROM collections WHERE id='$id'",$db);
        echo "lookdel";
    }
    if(isset($_POST['lookp'])){
        $id = $_POST['id'];
        $query = @mysql_query("SELECT * FROM photo WHERE id='$id'",$db);
        $myrow = @mysql_fetch_array($query);
        $photo = explode("|", $myrow["photo"]);
        for ($i = 0; $i < count($photo); $i++){
            unlink('../lookphoto/'.$photo[$i]);
        }
        $query = mysql_query("DELETE FROM photo WHERE id='$id'",$db);
        echo "lookpdel";
    }
}else{
    echo "nodost";
}
?>