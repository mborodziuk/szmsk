<?php
	header('Content-type: image/jpeg');

include "../func/config.php";
include "../func/szmsk.php";
include "../slownie/slownie.php";
include "../image/image.php";

$image=new IMAGE();

//$dbh=DBConnect($DBNAME1);

	$image->ImagePrint($_GET[id_dok], $_GET[dok]);


	
?>
