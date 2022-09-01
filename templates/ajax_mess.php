<?php
include("connect.php");
if($_POST["param"]){
	$param = mysql_real_escape_string($_POST["param"]);
	$param =  explode("|", $param);
	$ip = $_SERVER["REMOTE_ADDR"];
	$sql = @mysql_query("SELECT * FROM message WHERE ip='$ip' ORDER BY time LIMIT 1",$db);
	$myrow = @mysql_fetch_array($sql);
	if($myrow){
		$zap = $myrow["time"]+3600;
		$tim = time();
		if($tim>$zap){
			$name = $param[0];
			$email = $param[1];
			$text = $param[2];
			$query = mysql_query("INSERT INTO message VALUES('','$name','$email','$text','$ip','$tim')",$db);
			echo "ok";
		}else{
			echo "time";
		}
	}else{
		$name = $param[0];
		$email = $param[1];
		$text = $param[2];
		$tim = time();
		$query = mysql_query("INSERT INTO message VALUES('','$name','$email','$text','$ip','$tim')",$db);
		echo "ok";
	}
}

?>