<?php

require('fpdf.php');
include "../func/config.php";
include "../func/szmsk.php";
include "../slownie/slownie.php";
include "../pdf/pdf.php";
include "../voip/voip.php";
include "../customers/customers.php";
$data=date("Y-m");

$dbh=DBConnect($DBNAME1);

$pdf=new PDF();
$voip=new VOIP();
$customers=new CUSTOMERS();

$pdf->SetUTF8(true); 
$pdf->SetCompression(true);

$pdf->AliasNbPages();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Tahoma','B','tahomabd.php');
$pdf->SetAutoPageBreak( 1, 10);


switch ($_GET[dok])
	{
	case fv:
		$pdf->Faktura($pdf, $dbh, $_GET[nr], $_GET[typ]);
		$pdf->Output();		
		break;

	case fyv:
		if ( !$_GET[comiesiac])
		  {
		  //$pdf=$pdf->Faktury($pdf, $dbh, $_GET[data_od], $_GET[data_do], "ORYGINAŁ", false, $_GET[order]);
			$pdf->Faktury($pdf, $dbh, $_GET[data_od], $_GET[data_do], "KOPIA", false, $_GET[order]);
		  $pdf->Output();
		  }
		else 
			{
			$pdf=$pdf->Faktury($pdf, $dbh, $_GET[data_od], $_GET[data_do], "ORYGINAŁ", true,  $_GET[order]);
      $pdf->Output();
      break;		                                                                
		  }
		break;
	
	case nob:
		$pdf->DebitNote($pdf, $dbh, $_GET[nr]);
		$pdf->Output();		
		break;
		
	case rspw:
		$pdf->RaportZadluzenia($pdf, $dbh, $_GET[data_od], $_GET[data_do]);
		$pdf->Output();		
		break;

	case pz:
		$pdf->PonaglenieZaplaty($pdf, $dbh, $_GET[id_spw]);
		$pdf->Output();		
		break;
		
	case uma:
		$pdf->UmowaAbonencka($pdf, $dbh, $_GET[uma], $customers);
		$pdf->Output();
		break;
		
	case psw:
		$pdf->PismoWychodzace($pdf, $dbh, $_GET[id_psw]);
		$pdf->Output();
		break;
		
	case wz:
		$pdf->WezwanieZaplata($pdf, $dbh, $_GET[id_spw]);
		$pdf->Output();
		break;
	case wz2:
		$pdf->PWezwanieZaplata($pdf, $dbh, $_GET[id_spw]);
		$pdf->Output();
		break;
	case zwz3:
		$pdf=$pdf->WezwaniaDoZaplaty3($pdf, $dbh,  $_GET[krok]);
		$pdf->Output();
		break;
		
	case ks:
		$pdf->Ksiazeczki($pdf, $dbh, $_GET[data_od], $_GET[data_do], $_GET[abon]);
		$pdf->Output();
		break;
	case rsp:
		$pdf->RejSprzedazy($pdf, $dbh, $_GET[data_od], $_GET[data_do]);
		$pdf->Output("RejestrSprzedazy-$data.pdf", "D");
		break;
	case rspz:
		$pdf->RejSprzedazy($pdf, $dbh, $_GET[data_od], $_GET[data_do], $ZALICZKI="tak");
		$pdf->Output();
		break;
  case epp:
    $pdf->EwidencjaPrzebiegu($pdf, $dbh, $_GET[data_od], $_GET[data_do], $_GET[pojazd]);
 		$pdf->Output("EwidencjaPrzebiegu-$_GET[pojazd]-$data.pdf", "D");
		break;
	case psma:
		$pdf->Pisma($pdf, $dbh);
		$pdf->Output();
		break;                                        
	case dw:
		$pdf->DowodWplaty($pdf, $dbh, $_GET[id_wpl]);
		$pdf->Output();
		break;
	case vb:
		$pdf->VoipBiling($pdf, $dbh, $_GET[data_od], $_GET[data_do], $_GET[abon], $voip);
		$pdf->Output();
		break;
	case msm:
		$pdf->ListaMSM($pdf, $dbh, $_GET[data_od], $_GET[data_do]);
		$pdf->Output();
		break;	
	}
?>
