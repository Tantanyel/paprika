<?php 

$db = @mysql_connect("mysql.9105169449.myjino.ru","9105169449","adminadmin");
@mysql_query("SET NAMES 'utf8'");
@mysql_select_db("9105169449",$db);

function redir($str){
	$adr = $_SERVER['SERVER_NAME'];
	$str = '<script>document.location.href="http://'.$adr.$str.'";</script>';
	echo $str;
	exit();
}

?>