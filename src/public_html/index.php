
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
  <title>SZMSK ver. 0.4</title>
  <meta content="Mirosław Borodziuk" name="author" />
  <link rel="stylesheet" href="/css/style.css" type="text/css" />
  <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body onload="fokus('login');">
<div>

<?php
	session_start();

	require 'Net/IPv4.php';
	include "func/config.php";
	include "func/szmsk.php";
	include "www/www.php";
	$www=new WWW();
	include "szmsk/szmsk.php";
	$szmsk=new SZMSK();
			
			if (	!isset($_SESSION['id_abon']) )
				{
				switch ( $_GET["menu"] )
					{
					case NULL :
							session_destroy();
				 			include("func/auth.php");
							break;
					case "authwyslij" :
							$_SESSION['haslo']=$_POST['haslo'];
				 			if ( ValidateAuth("'fin','admin','inst', 'sprzedaz', 'callcenter'",$_POST['login'],$_POST['haslo']) )		
							    include("index2.php");
							else
								{
								echo "Błąd logowania";
								include("func/auth.php");
								}
							break;
					default :
							session_destroy();
				 			include("func/auth.php");
							break;
					}
				}
			else 
					switch ( $_GET["menu"] )
					{
					case NULL :
							session_destroy();
				 			include("func/auth.php");
							break;
					case "wyloguj" :
							session_destroy();
				 			include("func/auth.php");
							break;
					default :
							include("index2.php");
					}

?>

</div>
</body>
</html>
