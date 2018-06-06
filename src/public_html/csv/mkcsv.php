<?php
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="uke-inwentaryzacja-'.date("Ymdhis").'.csv"');

include "../func/config.php";
include "../func/szmsk.php";
include "../csv/csv.php";

$csv=new CSV();

$dbh=DBConnect($DBNAME1);

switch ($_GET[rep])
	{
	case inwentaryzacja:
		$csv->CreateInwent($dbh);
		break;
		
	}


?>
