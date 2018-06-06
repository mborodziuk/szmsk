<?php
header('Content-type: application/xml; charset="utf-8"');

include "../func/config.php";
include "../func/szmsk.php";
include "../slownie/slownie.php";
include "../xml/xml.php";

$xml=new XML();

$dbh=DBConnect($DBNAME1);

switch ($_GET[dok])
	{
	case pozew:
		$xml->CreatePlaint($xml, $dbh, $_GET[id_spw]);
		break;
	case jpk_vat:
		$xml->JPK_VAT($xml, $dbh, $_GET[data_od], $_GET[data_do]);
		break;
	case jpk_fa:
		$xml->JPK_FA($xml, $dbh, $_GET[data_od], $_GET[data_do]);
		break;
		
	}


?>
