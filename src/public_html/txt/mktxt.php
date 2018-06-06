<?php
header('Content-type: text/txt; charset="utf-8"');
header('Content-Disposition: attachment; filename="E24FNP05621ported-in0.txt"');

include "../func/config.php";
include "../func/szmsk.php";
include "../txt/txt.php";

$txt=new TXT();

$dbh=DBConnect($DBNAME1);

switch ($_GET[rep])
	{
	case E24Input:
		$txt->E24Input($dbh);
		break;
	case E24Output:
		$txt->E24Output($dbh);
		break;
	case UpdLms:
		$txt->UpdLms($dbh,$dbh2);
		break;
	case Optima_Vat_r:
		$name="Rejestr-Sprzedazy-$_GET[data_od].txt";
		header("Content-Disposition: attachment; filename=$name");
		$txt->Optima_Vat_r( $dbh, $_GET[data_od], $_GET[data_do]);
		break;
	}


?>
