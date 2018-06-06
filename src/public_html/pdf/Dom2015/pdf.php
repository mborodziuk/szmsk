<?php

class PDF extends FPDF
{
/*
	// header
	function PDF()
	{
		include "../slownie/slownie.php";		//Logo
//		$this->Image("$conf[pdf_logo1]",15,10,70,15);
	}
	*/
	function MakeFV(&$pdf, $dbh, $dokks, $typ, $adrk=false, $file="../func/config.php")
	{
		include $file;

		$poz_h=7;
		$y1=25;
		$x1=15;
		$y2=46;
		
		$pdf->SetLineWidth(0.3);
		$pdf->AddPage();
		$pdf->Image("$conf[pdf_logo1]",15,10,70,15);
		$pdf->SetTextColor(0,0,0);        
		$pdf->SetDrawColor(128,128,128); 

		$pdf->SetFont('Tahoma','B',15);
		$pdf->SetXY($x1+84, 10);
		$pdf->Cell(97,7,'Faktura VAT',1,0,'C');

		$pdf->SetMargins(15,15,15);
		$pdf->SetFont('Tahoma','',10);
		$pdf->SetXY($x1+84, 18);
		$pdf->Cell(48,7,"Nr: $dokks[nr_d]",1,0,'C');
		$pdf->SetXY($x1+133, 18);
		$pdf->Cell(48,7,$typ,1,0,'C');
		$pdf->SetXY($x1+5, $y1);
		$pdf->SetTextColor(128,128,128);
		$pdf->Cell(33,10,"Miejsce wystawienia: ",0,0,'C');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(30,10,"$dokks[miejsce_wyst]",0,0,'L');
		$pdf->SetTextColor(128,128,128);
		$pdf->Cell(30,10,"Data wystawienia:",0,0,'C');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(30,10,"$dokks[data_wyst]",0,0,'L');
		$pdf->SetTextColor(128,128,128);
		$pdf->Cell(30,10,"Data sprzedaży:",0,0,'C');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(30,10,"$dokks[data_sprzed]",0,1,'L');
		// Sprzedawca
		$pdf->SetXY(15,$y1+10);
		$pdf->Cell(90,29,'',1,0,'C');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Text(17,$y1+15,'Sprzedawca:');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Text(60,$y1+15,"NIP: $firma[nip]");
		
		$pdf->Text($x1+5,$y2,$firma[nazwa]);
		$pdf->Text($x1+5,$y2+4,$firma[nazwa2]);
		$pdf->Text($x1+5,$y2+9,$firma[adres]);
		$pdf->SetFont('Tahoma','',8);
		$pdf->Text($x1+5,$y2+15,"Bank: $firma[bank]  Konto: $dokks[konto]");
		//$pdf->Text($x1,$y2+19,"Konto:  $firma[konto]");
		$pdf->SetFont('Tahoma','',10);

		// Nabywca
		$pdf->SetXY(15,$y1+40);
		$pdf->Cell(90,25,'',1,0,'C');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Text($x1+2,$y2+25,'Nabywca:');
		$pdf->SetTextColor(0,0,0); 

		if ( !empty($dokks[pesel_nip]) && ValidateNip($dokks[pesel_nip]))
		$pdf->Text(60,$y2+25,"NIP: $dokks[pesel_nip]");

		$pdf->SetXY($x1+4,$y2+28);
		$pdf->MultiCell(70,4,"$dokks[nazwa]",0,L,0);
		$adres=$dokks[kod]." ".$dokks[miasto].", $dokks[cecha] ".$dokks[ulica]." ".$dokks[nr_bud];
		if (!empty($dokks[nr_mieszk]))
			$adres.="/$dokks[nr_mieszk]";
		$pdf->Text($x1+5,$y2+40,$adres);	
		
		// Adresat
		$pdf->SetXY(106,$y1+10);
		$pdf->Cell(90,55,'',1,1,'C');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Text(108,$y1+15,'Adresat:');
		$pdf->SetTextColor(0,0,0); 

		if ( $adrk==true && !empty($dokks[k_nazwa]) && !empty($dokks[k_ulica]) 
					&& !empty($dokks[k_nr_bud]) && !empty($dokks[k_miasto]) )
				{						
					$dokks[nazwa]=$dokks[k_nazwa];
					$adres=$dokks[k_kod]." ".$dokks[k_miasto].", $dokks[k_cecha] ".$dokks[k_ulica]." ".$dokks[k_nr_bud];
					if (!empty($dokks[k_nr_mieszk]))
							$adres.="/$dokks[k_nr_mieszk]";
				}
		else
				{
					$adres=$dokks[kod]." ".$dokks[miasto].", $dokks[cecha] ".$dokks[ulica]." ".$dokks[nr_bud];
					if (!empty($dokks[nr_mieszk]))
						$adres.="/$dokks[nr_mieszk]";
				}
		$pdf->SetXY(111,57);
		$pdf->MultiCell(70,4,"$dokks[nazwa]",0,L,0);
		$pdf->Text(112,68,$adres);	
		

		$pdf->SetTextColor(128,128,128); 
		if ( $typ =='DUPLIKAT')
			{
				$pdf->SetXY(30,90);
				$pdf->Cell(30,10,"Data wystawienia faktury:",0,0,'R');
				$pdf->SetTextColor(0,0,0); 
				$pdf->Cell(30,10,"$dokks[data_wyst_fv]",0,0,'L');
				$pdf->Cell(30,10,"Termin płatności:",0,0,'R');
				$pdf->SetTextColor(0,0,0); 
				$pdf->Cell(30,10,"$dokks[term_plat]",0,0,'L');
				$pdf->SetTextColor(128,128,128); 
				$pdf->Cell(30,10,"Forma płatności:",0,0,'R');
				$pdf->SetTextColor(0,0,0); 
				$pdf->Cell(30,10,"$dokks[forma_plat]",0,1,'L');
			}
		else
			{
				
				$pdf->SetXY(20,90);
				$pdf->Cell(45,10,"Termin płatności:",0,0,'R');
				$pdf->SetTextColor(0,0,0); 
				$pdf->Cell(45,10,"$dokks[term_plat]",0,0,'L');
				$pdf->SetTextColor(128,128,128); 
				$pdf->Cell(45,10,"Forma płatności:",0,0,'R');
				$pdf->SetTextColor(0,0,0); 
				$pdf->Cell(45,10,"$dokks[forma_plat]",0,1,'L');
			}
		$pdf->SetFont('Tahoma','',8);
		$pdf->Cell(6,15,'L.p.',1,0,'C');
		$pdf->Cell(76,15,'Pełna nazwa towaru / usługi',1,0,'C');
		$pdf->Cell(12,15,'PKWiU',1,0,'C');
		$pdf->Cell(7,15,'Ilość',1,0,'C');
		$pdf->Cell(7,15,'j.m.',1,0,'C');
		$pdf->Cell(15,15,'',1,0,'C'); //Cena jedn. netto
		$pdf->Cell(18,15,'Netto',1,0,'C'); // Netto
		$pdf->Cell(7,15,'',1,0,'C');	// % VAT
		$pdf->Cell(15,15,'Kwota VAT',1,0,'C');
		$pdf->Cell(18,15,'Brutto',1,0,'C');
		$pdf->Text(124,106, '   Cena');
		$pdf->Text(124,110,'jedn. netto');
		$pdf->Text(157, 106,' % ');
		$pdf->Text(157,110,'VAT');

		$q2="(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat
				from pozycje_sprzedaz p, towary_sprzedaz t
				where p.id_tows=t.id_tows and p.nr_ds='$dokks[nr_d]' order by t.nazwa)
				union all
				(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat
				from pozycje_sprzedaz p, uslugi_voip t
				where p.id_tows=t.id_uvp and p.nr_ds='$dokks[nr_d]' order by t.nazwa)";

		$razem_netto=$razem_vato=$razem_brutoo=0;
		$Lp=0;
		$sth1=Query($dbh,$q2);
		while ( $row1=$sth1->fetchRow() )
		{
			++$Lp;
			$pdf->Ln();
			if ( strlen($row1[0]) > 70 )
			    $poz_h=30;
			    													
			$pdf->Cell(6,$poz_h,"$Lp.",1,0,'C');
			if ( strlen($row1[0]) > 70 )
			    {
				$pdf->Cell(76,$poz_h,"",1,0,'L');
				$pdf->SetXY(25,120);
				$pdf->MultiCell(70,4,"$row1[0]",0,L,0);
				$pdf->SetXY(97,115);		
			    }
			else
			    $pdf->Cell(76,$poz_h, $row1[0],1,0,'L');
		
			$pdf->Cell(12,$poz_h, $row1[1],1,0,'C');
			$pdf->Cell(7,$poz_h, $row1[2],1,0,'C');
			$pdf->Cell(7,$poz_h, $row1[3],1,0,'C');

			//$brutto=$netto+$kwota_vat;
			$jedn_brutto = round( $row1[4], 2);
			$jedn_netto = $row1[4] / (1+$row1[5]/100) ;
			$brutto=$row1[2] * $jedn_brutto;
			$netto= $brutto/ (1+ $row1[5]/100) ;
			$kwota_vat=$brutto-$netto;					

			$pdf->Cell(15,$poz_h, number_format($jedn_netto, 2, ',',''),1,0,'R'); //Cena jedn. netto
			$pdf->Cell(18,$poz_h, number_format($netto, 2, ',','') ,1,0,'R'); // Netto
			$pdf->Cell(7,$poz_h, $row1[5],1,0,'C');	// % VAT
			$pdf->Cell(15,$poz_h,number_format(round($kwota_vat,2), 2,',',''),1,0,'R');
			
			$pdf->Cell( 18, $poz_h, number_format(round($brutto ,2), 2, ',',''), 1, 0, 'R' );

			$razem_netto+=round($netto, 2);
			$razem_vat+=round($kwota_vat,2 );
			$razem_brutto+=round($brutto, 2);
		}

		$pdf->Ln();
		$pdf->SetFont('Tahoma','',10);
		$pdf->Cell(123,15,'Razem zł:',1,0,'C');
		$r_razem_netto=round($razem_netto, 2);
		$r_razem_vat=round($razem_vat, 2);
		$r_razem_brutto=round($razem_brutto, 2);
		$pdf->Cell(18,15,number_format($r_razem_netto, 2, ',',''),1,0,'R'); // Netto
		$pdf->Cell(7,15,'',1,0,'C');	// % VAT
		$pdf->Cell(15,15,number_format($r_razem_vat, 2,',',''),1,0,'R');
		$pdf->SetFont('Tahoma','B',10);

		$pdf->Cell(18,15,number_format($r_razem_brutto, 2,',',''),1,1,'R');
		$pdf->SetFont('Tahoma','',8);

		$x=new slownie;
		$slownie=$x->zwroc($razem_brutto);
		$pdf->Cell(40,6,'Słownie :',1,0,'C');
		$pdf->Cell(141,6,$slownie,1,1,'C');

		$pdf->Cell(60,30,'',0,0,'C');
		$pdf->Cell(60,30,'',0,1,'C');
		
		//$pdf->text(142,148+$poz_h*$Lp,"Fakturę wystawił(a) :   $dokks[wystawil]");
		$pdf->SetXY(87,140+$poz_h*$Lp);
		$pdf->SetTextColor(128,128,128); 
		$pdf->Cell(72,10,"Fakturę wystawił(a) :",0,0,'R');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(45,10,"$dokks[wystawil]",0,1,'L');

		$pdf->SetXY(87,145+$poz_h*$Lp);
		$pdf->SetTextColor(128,128,128); 
		$pdf->Cell(60,10,"Jako tytuł przelewu prosimy podać:",0,0,'R');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(60,10,"$dokks[id_abon] za FV nr $dokks[nr_d]",0,0,'L');
		$pdf->SetFont('Tahoma','B',6);

		$pdf->Image('/home/szmsk/public_html/graphics/krdsmall.jpg',18,143+$poz_h*$Lp,15);
		$pdf->SetXY(30,143+$poz_h*$Lp);
		$pdf->SetTextColor(200,0,0);
		$pdf->MultiCell(47,3,"Nieregulowanie zobowiązań będzie skutkowało wpisem do Krajowego Rejestru Długów www.krd.pl Biuro Informacji Gospodarczej S.A.",0,'C',0);
		
		if (!empty($dokks[uwagi]))
		{
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Tahoma','',8);
			$pdf->Text($x1,165+$poz_h*$Lp, "UWAGI:  $dokks[uwagi]");	
		}
		return($pdf);
	}




	function poj($pdf, $ks, $mies, $y=0)
	{
		include "../func/config.php";

		$x=new slownie;
		$slownie=$x->zwroc($ks[kwota]);

		$cw=130;
		$ch=5;
		$X1=14;
		$X2=73;
		$tytul="$ks[id_abon] za $mies";

		$pdf->SetFont('Tahoma','',8);
					
		$pdf->Text(35,93+$y,"$ks[kwota]");
		
		$pdf->Text($X1,105+$y,"Odbiorca:");	
		$pdf->Text($X1,110+$y,"$firma[nazwa]");
		$pdf->Text($X1,115+$y,"$firma[adres]");
		$pdf->Text($X1,120+$y,"$ks[konto]");

		$pdf->Text($X1,130+$y,"Zleceniodawca:");
		$pdf->Text($X1,135+$y,"$ks[nazwa]");
		$pdf->Text($X1,140+$y,"$ks[ulica]");
		$pdf->Text($X1,145+$y,"$ks[miasto]");

					$pdf->Text($X1,155+$y,"Tytułem:");
					$pdf->Text($X1,160+$y,"$tytul");

			//    $pdf->SetTextColor(0,100,255);
	//	$pdf->SetFont('Tahoma','B',10);
			
		$pdf->SetXY($X2, 87+$y);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Tahoma','',10);
		$pdf->Cell($cw,$ch,$firma[nazwa],0,0,'L');
			
		$pdf->SetXY($X2, 96+$y);
		$pdf->Cell($cw,$ch,$firma[adres],0,0,'L');
		$pdf->SetXY($X2, 105+$y);
		$pdf->Cell($cw,$ch,$ks[konto],0,0,'L');

		$pdf->SetXY(142, 113+$y);
		$pdf->Cell(55,$ch,"$ks[kwota]",0,0,'R');
		$pdf->SetXY($X2, 122+$y);
		$pdf->Cell($cw,$ch,"$slownie",0,0,'L');
		$pdf->SetXY($X2+34, 130+$y);
		$pdf->Cell($cw,$ch,"$ks[nazwa]",0,0,'L');
		$pdf->SetXY($X2+34, 139+$y);
		$pdf->Cell($cw,$ch,"$ks[miasto],  $ks[ulica]",0,0,'L');
	//	$pdf->SetXY($X2, 150+$y);
	//	$pdf->Cell($cw,$ch,"$tytul",0,0,'L');
		$pdf->SetXY($X2, 148+$y);
		$pdf->Code39($X2, 147+$y, "$tytul");
				 
					$pdf->Text($X2+20,$y+170,"$ks[platnosc].$mies");
				 
	#	$pdf->Cell($cw,$ch,"$ks[nazwa]",0,0,'L');

	}






	function Faktura(&$pdf, $dbh, $nr, $typ)
	{
	include "../func/config.php";
	
	if ( $typ =="DUPLIKAT" )
		$data="'".$conf[data]."'";
	else
		$data="d.data_wyst";
	
		$q=" select  d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, n.nazwa,
a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod, a.id_abon,
k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi, u.cecha, k.cecha
from
((abonenci a join nazwy n on a.id_abon=n.id_abon) join (kontakty k right join dokumenty_sprzedaz d on d.id_odb=k.id_podm and k.wazne_od <= $data and k.wazne_do >=$data ) on d.id_odb=a.id_abon)
join
((budynki b join ulice u on b.id_ul=u.id_ul) join (adresy_siedzib s join konta_wirtualne kw on s.id_abon=kw.id_abon) on s.id_bud=b.id_bud)
on d.id_odb=kw.id_abon
where s.wazne_od <= d.data_wyst and s.wazne_do >= d.data_wyst and n.wazne_od <= d.data_wyst and n.wazne_do >= d.data_wyst
and d.nr_ds='$nr'";
			
		$sth=Query($dbh,$q);
		$row=$sth->fetchRow();
		
		$dokks=array
			(
				'nr_d'				=> $nr, 			'data_wyst'			=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=> $row[3],	
				'forma_plat'	=> $row[4],		'miejsce_wyst'	=> $row[5],	'nazwa'				=> $row[6],	'pesel_nip'		=> $row[7],
				'ulica'				=> $row[8],		'nr_bud'				=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
				'miasto'			=> $row[12],	'kod'						=> $row[13],'id_abon' 		=> $row[14],
				'k_nazwa' 		=> $row[15],	'k_ulica' 			=> $row[16],'k_nr_bud'		=> $row[17], 'k_nr_mieszk' => $row[18],
					'k_kod'			=> $row[19],	'k_miasto'			=> $row[20], 'konto'			=> $row[21], 'uwagi'			=> $row[22],
					'cecha'			=> $row[23],	'k_cecha'			=> $row[24]
				);
				
		if ( $typ=='DUPLIKAT')
		{
				$dokks[data_wyst_fv]=$dokks[data_wyst];
				$dokks[data_wyst]=$conf[data];
		}
		$pdf=$this->MakeFV($pdf, $dbh, $dokks, $typ, $adrk=true);
		return($pdf);

	}


	function Faktury(&$pdf, $dbh, $od, $do, $TYP, $comiesiac=false, $order)
	{

		switch ($order)
			{
			case 'Data wystawienia':
				$order=' order by d.data_wyst, d.nr_ds';
				$TYP="KOPIA";
				break;
			case 'Nazwa odbiorcy':
				$order=' order by n.nazwa, d.data_wyst, d.nr_ds';
				$TYP="ORYGINAŁ";
				break;
		 }

	 if ( !$comiesiac)
	{
					$q=" select  d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod, a.id_abon,
k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi
from
((abonenci a join nazwy n on a.id_abon=n.id_abon) join (kontakty k right join dokumenty_sprzedaz d on d.id_odb=k.id_podm and k.wazne_od <= d.data_wyst and k.wazne_do >= d.data_wyst ) on d.id_odb=a.id_abon)
join
((budynki b join ulice u on b.id_ul=u.id_ul) join (adresy_siedzib s join konta_wirtualne kw on s.id_abon=kw.id_abon) on s.id_bud=b.id_bud)
on d.id_odb=kw.id_abon
where s.wazne_od <= d.data_wyst and s.wazne_do >= d.data_wyst and n.wazne_od <= d.data_wyst and n.wazne_do >= d.data_wyst
and d.data_wyst >= '$od' and d.data_wyst <= '$do'";	

				/*		
$q=" select  d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod, a.id_abon,
k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi, u.cecha, k.cecha
from
((abonenci a join nazwy n on a.id_abon=n.id_abon) join (kontakty k right join dokumenty_sprzedaz d on d.id_odb=k.id_podm and k.wazne_od <= d.data_wyst and k.wazne_do >= d.data_wyst ) on d.id_odb=a.id_abon)
join
((budynki b join ulice u on b.id_ul=u.id_ul) join (adresy_siedzib s join konta_wirtualne kw on s.id_abon=kw.id_abon) on s.id_bud=b.id_bud)
on d.id_odb=kw.id_abon
where s.wazne_od <= d.data_wyst and s.wazne_do >= d.data_wyst and n.wazne_od <= d.data_wyst and n.wazne_do >= d.data_wyst
and d.data_wyst >= '$od' and d.data_wyst <= '$do'
and a.fv_comiesiac='N' and a.fv_email='N'";	
				*/
					$adrk=true;
		}
	else
		{
			$TYP="ORYGINAŁ";
			$q=" select  d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod, a.id_abon,
k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi, u.cecha, k.cecha
from
((abonenci a join nazwy n on a.id_abon=n.id_abon) join (kontakty k right join dokumenty_sprzedaz d on d.id_odb=k.id_podm and k.wazne_od <= d.data_wyst and k.wazne_do >= d.data_wyst ) on d.id_odb=a.id_abon)
join
((budynki b join ulice u on b.id_ul=u.id_ul) join (adresy_siedzib s join konta_wirtualne kw on s.id_abon=kw.id_abon) on s.id_bud=b.id_bud)
on d.id_odb=kw.id_abon
where s.wazne_od <= d.data_wyst and s.wazne_do >= d.data_wyst and n.wazne_od <= d.data_wyst and n.wazne_do >= d.data_wyst
and d.data_wyst >= '$od' and d.data_wyst <= '$do'
and a.fv_comiesiac='T'";	
		
			$adrk=true;
		 }                                                              
		
		$q.=$order;
		set_time_limit(3600);                                                                        
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
			{
				$dokks=array
				(
					'nr_d'			=> $row[0], 	'data_wyst'		=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=>	$row[3],	
					'forma_plat'		=> $row[4],	'miejsce_wyst'		=> $row[5],	'nazwa'			=> $row[6],	'pesel_nip'		=> $row[7],
					'ulica'			=> $row[8],	'nr_bud'		=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
					'miasto'		=> $row[12],	'kod'			=> $row[13], 'id_abon' => $row[14],
					'k_nazwa' 	=> $row[15],	'k_ulica' 			=> $row[16],'k_nr_bud'	 	=> $row[17], 'k_nr_mieszk' => $row[18],
					'k_kod'			=> $row[19],	'k_miasto'			=> $row[20], 'konto'	=> $row[21], 'uwagi'	=> $row[22],
					'cecha'			=> $row[23],	'k_cecha'			=> $row[24]
				);

				$nr_fv=explode("/", $row[0]);
		//		if( $nr_fv[1] % 4 == 1 || $nr_fv[1] % 4 == 2 )
		//		if( $nr_fv[1] % 4 == 3 || $nr_fv[1] % 4 == 0 )
		$this->MakeFV($pdf, $dbh, $dokks, $TYP, $adrk);
			//MakeFV($pdf, $dbh, $dokks, "KOPIA");
			}
		return($pdf);
		//$pdf->Output();
	}




	
	
	function MakeDebitNote(&$pdf, $dbh, $dn, $file="../func/config.php")
	{
		include $file;

		$poz_h=7;
		$y1=25;
		$x1=20;
		$y2=46;
		
		$pdf->SetLineWidth(0.3);
		$pdf->AddPage();
		$pdf->Image("$conf[pdf_logo1]",15,10,70,15);
		$pdf->SetTextColor(0,0,0);        
		$pdf->SetDrawColor(128,128,128); 

		$pdf->SetFont('Tahoma','B',14);
		$pdf->SetXY(99, 10);
		$pdf->Cell(97,7,'NOTA OBCIĄŻENIOWA',1,0,'C');

		$pdf->SetMargins(15,15,15);
		$pdf->SetFont('Tahoma','',10);
		$pdf->SetXY(99, 18);
		$pdf->Cell(48,7,"Nr: $dn[nr_nob]",1,0,'C');
		$pdf->SetXY(148, 18);
		$pdf->Cell(48,7,$typ,1,0,'C');
		$pdf->SetXY($x1, $y1);
		$pdf->SetTextColor(128,128,128);
		$pdf->Cell(33,10,"Miejsce wystawienia: ",0,0,'C');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(30,10,"$dn[miejsce_wyst]",0,0,'L');
		$pdf->SetTextColor(128,128,128);
		$pdf->Cell(30,10,"",0,0,'C');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(30,10,"",0,0,'L');
		$pdf->SetTextColor(128,128,128);
		$pdf->Cell(30,10,"Data wystawienia:",0,0,'C');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(30,10,"$dn[data_wyst]",0,1,'L');
		// Sprzedawca
		$pdf->SetXY(15,$y1+10);
		$pdf->Cell(90,29,'',1,0,'C');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Text(17,$y1+15,'Sprzedawca:');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Text(60,$y1+15,"NIP: $firma[nip]");
		
		$pdf->Text($x1,$y2,$firma[nazwa]);
		$pdf->Text($x1,$y2+4,$firma[nazwa2]);
		$pdf->Text($x1,$y2+9,$firma[adres]);
		$pdf->SetFont('Tahoma','',8);
		$pdf->Text($x1,$y2+15,"Bank: $firma[bank]  Konto: $dn[konto]");
		//$pdf->Text($x1,$y2+19,"Konto:  $firma[konto]");
		$pdf->SetFont('Tahoma','',10);

		// Nabywca
		$pdf->SetXY(15,$y1+40);
		$pdf->Cell(90,25,'',1,0,'C');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Text($x1-3,$y2+25,'Nabywca:');
		$pdf->SetTextColor(0,0,0); 

		if ( !empty($dn[pesel_nip]) && ValidateNip($dn[pesel_nip]))
		$pdf->Text(60,$y2+25,"NIP: $dn[pesel_nip]");

		$pdf->SetXY($x1-1,$y2+28);
		$pdf->MultiCell(70,4,"$dn[nazwa]",0,L,0);
		$adres=$dn[kod]." ".$dn[miasto].", $dn[cecha] ".$dn[ulica]." ".$dn[nr_bud];
		if (!empty($dn[nr_mieszk]))
			$adres.="/$dn[nr_mieszk]";
		$pdf->Text($x1,$y2+40,$adres);	
		
		// Adresat
		$pdf->SetXY(106,$y1+10);
		$pdf->Cell(90,55,'',1,1,'C');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Text(108,$y1+15,'Adresat:');
		$pdf->SetTextColor(0,0,0); 

		if ( !empty($dn[k_nazwa]) && !empty($dn[k_ulica]) 
					&& !empty($dn[k_nr_bud]) && !empty($dn[k_miasto]) )
				{						
					$dn[nazwa]=$dn[k_nazwa];
					$adres=$dn[k_kod]." ".$dn[k_miasto].", $dn[k_cecha] ".$dn[k_ulica]." ".$dn[k_nr_bud];
					if (!empty($dn[k_nr_mieszk]))
							$adres.="/$dn[k_nr_mieszk]";
				}
		else
				{
					$adres=$dn[kod]." ".$dn[miasto].", $dn[cecha] ".$dn[ulica]." ".$dn[nr_bud];
					if (!empty($dn[nr_mieszk]))
						$adres.="/$dn[nr_mieszk]";
				}
		$pdf->SetXY(111,57);
		$pdf->MultiCell(70,4,"$dn[nazwa]",0,L,0);
		$pdf->Text(112,68,$adres);	
		
		$pdf->SetXY(20,90);
		$pdf->SetTextColor(128,128,128); 
		$pdf->Cell(45,10,"Termin płatności:",0,0,'R');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(45,10,"$dn[term_plat]",0,0,'L');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Cell(45,10,"Forma płatności:",0,0,'R');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(45,10,"$dn[forma_plat]",0,1,'L');
		
		$x=new slownie;
		$slownie=$x->zwroc($dn[kwota]);
		
		$tekst0="W związku z niedotrzymaniem warunków umów zawartch na czas określony:";
		$tekst1="obciążamy Państwa zgodnie z w/w umowami kwotą: $dn[kwota] zł.";
		
		$tekst2="Do zapłaty: $dn[kwota] zł";
		$tekst3="Słownie: $slownie";
		
		$pdf->SetFont('Tahoma','',10);
		$pdf->MultiCell(140,10,"",0,L,0);
		$pdf->MultiCell(140,5,"$tekst0",0,L,0);
		
		$q1="(select nr_um, data_zaw from umowy_abonenckie where (status='Obowiązująca' or status='windykowana') and id_abon='$dn[id_abon]')
		union
		(select nr_um, data_zaw from umowy_voip where  (status='Obowiązująca' or status='windykowana') and id_abon='$dn[id_abon]')
		union
		(select nr_um, data_zaw from umowy_iptv where  (status='Obowiązująca' or status='windykowana') and id_abon='$dn[id_abon]')
		union
		(select nr_um, data_zaw from umowy_serwisowe where  (status='Obowiązująca' or status='windykowana') and id_abon='$dn[id_abon]')";
		
		$Lp=1;
		$sth1=Query($dbh,$q1);
		while ( $row1=$sth1->fetchRow() )
		{
			$pdf->MultiCell(140,5,"- umowa nr $row1[0], data zawarcia: $row1[1]",0,L,0);
			++$Lp;
		}
		
		$pdf->MultiCell(140,5,"$tekst1",0,L,0);
		$pdf->MultiCell(140,5,"",0,L,0);		
		$pdf->SetFont('Tahoma','B',10);
		$pdf->MultiCell(140,5,"$tekst2",0,L,0);
						$pdf->SetFont('Tahoma','',10);
		$pdf->MultiCell(140,5,"$tekst3",0,L,0);
		
		
		$pdf->Image('/home/szmsk/public_html/graphics/krdsmall.jpg',18,143+$poz_h*$Lp,15);
		$pdf->SetXY(35,143+$poz_h*$Lp);
		$pdf->SetTextColor(200,0,0);
		$pdf->SetFont('Tahoma','B',8);
		$pdf->MultiCell(47,3,"Nieregulowanie zobowiązań będzie skutkowało wpisem do Krajowego Rejestru Długów www.krd.pl Biuro Informacji Gospodarczej S.A.",0,'C',0);
		
		return($pdf);
	}

	
	function DebitNote(&$pdf, $dbh, $nr)
	{
	$q=" select  o.nr_nob, o.data_wyst, o.term_plat, o.forma_plat, o.miejsce_wyst, n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, o.wystawil, u.miasto, u.kod, a.id_abon,
k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, o.kwota, u.cecha, k.cecha
from
((abonenci a join nazwy n on a.id_abon=n.id_abon) join (kontakty k right join noty_obciazeniowe o on o.id_odb=k.id_podm and k.wazne_od <= o.data_wyst and k.wazne_do >= o.data_wyst ) on o.id_odb=a.id_abon)
join
((budynki b join ulice u on b.id_ul=u.id_ul) join (adresy_siedzib s join konta_wirtualne kw on s.id_abon=kw.id_abon) on s.id_bud=b.id_bud)
on o.id_odb=kw.id_abon
where s.wazne_od <= o.data_wyst and s.wazne_do >= o.data_wyst and n.wazne_od <= o.data_wyst and n.wazne_do >= o.data_wyst
and  o.nr_nob='$nr'";	

		$sth=Query($dbh,$q);
		$row=$sth->fetchRow();
		
		$dn=array
			(
				'nr_nob'				=> $nr, 			'data_wyst'			=> $row[1],	'term_plat'		=> $row[2],	
				'forma_plat'	=> $row[3],		'miejsce_wyst'	=> $row[4],	'nazwa'				=> $row[5],	'pesel_nip'		=> $row[6],
				'ulica'				=> $row[7],		'nr_bud'				=> $row[8],	'nr_mieszk'		=> $row[9],'wystawil'		=> $row[10],
				'miasto'			=> $row[11],	'kod'						=> $row[12],'id_abon' 		=> $row[13],
				'k_nazwa' 	=> $row[14],	'k_ulica' 				=> $row[15],'k_nr_bud'	 	=> $row[16], 'k_nr_mieszk' => $row[17],
					'k_kod'			=> $row[18],	'k_miasto'			=> $row[19], 'konto'		=> $row[20], 'kwota' => $row[21],
					'cecha'			=> $row[22],	'k_cecha'			=> $row[23]
				);
				

		$pdf=$this->MakeDebitNote($pdf, $dbh, $dn);
		return($pdf);

	}
	
	function PismoPoziomNaglowek(&$pdf, $nazwa, $data, $dodatek='')
	{
		include"../func/config.php";
		$mies=explode('-', $data);
		$ML=15;
		$XA="110";
		
		$pdf->SetLineWidth(0.3);
		$pdf->AddPage(L);
		$pdf->SetDrawColor(0,0,255);
		//$pdf->Line($ML,5,297-$ML,5);
		
		$pdf->Image("$conf[pdf_logo1]",15,10,70,15);
		$pdf->SetMargins($ML,15,10);
		$pdf->SetFont('Tahoma','B',8);
		$pdf->SetTextColor(0,0,255);
		$pdf->Text(230,13, $firma[nazwa]);
		$pdf->Text(230,17, $firma[nazwa2]);
		$pdf->Text(230,21, $firma[adres]);
		$pdf->Text(230,25, "NIP: $firma[nip]");
	 
	 $pdf->SetFont('Tahoma','B',11);
		$pdf->SetXY(105, 10);
		$pdf->SetMargins(105,10,10);
		$pdf->Cell(100,6,"$nazwa",0,1,'C');
		$pdf->SetFont('Tahoma','B',10);        
		$mies=split('-',$data);
		$pdf->Cell(100,6,"W miesiącu $mies[1].$mies[0]",0,1,'C');
		$pdf->SetFont('Tahoma','B',10);
		$pdf->Cell(100,6,"$dodatek",0,1,'C');

					
		$pdf->Line($ML,30,297-$ML,30);
		$pdf->SetDrawColor(128,128,128);
		$pdf->SetTextColor(0,0,0);
	}

	function EwidencjaPrzebiegu(&$pdf, $dbh, $od, $do, $pojazd)
	{			
			$data=explode("-", $od);
			//$mb=$data[1]-1;
			
			$q1="select sum(t.km)
					 from jazdy j, trasy t
					 where j.id_ts=t.id_ts and j.data < '$od' and j.data >= '$data[0]-01-01' and j.zatwierdzona='T' and j.nr_rej='$pojazd'";
			$sth1=Query($dbh,$q1);
			$row1=$sth1->fetchRow();
			if ( !empty($row1[0]) )
		$przeniesienie=$km=number_format($row1[0], 2, ',','');
			else
		$przeniesienie=0;
																											
			$q2="select j.data, t.opis, c.opis, t.km
					 from jazdy j, trasy t, cele c
					 where j.id_cel=c.id_cel and j.id_ts=t.id_ts and j.data>='$od' and j.data <= '$do' and j.zatwierdzona='T' and j.nr_rej='$pojazd' order by j.data, j.id_jzd";
																																															 
			$LP_W=9;
			$NRD_W=20;
			$O_W=90;
			$C_W=45;
			$K_W=25;
			$S_W=20;
			$W_W=20;
			$P_W=20;
			$U_W=20;
			$ML=14;
			$MT=32;
			$ilp=20;
			$razem_n=$razem_v=$razem_b=0;
				 

			$this->PismoPoziomNaglowek($pdf, "EWIDENCJA PRZEBIEGU POJAZDU", $od, "Nr rejestracyjny: $pojazd");
				$pdf->SetMargins($ML,15,10); 
				$W=12;
				$pdf->SetFont('Tahoma','',8);
			$NrStr=$pdf->PageNo();
					$pdf->Text(145, 200,"Strona $NrStr",1,0,'C');
					$pdf->SetXY($ML, $MT);
					$pdf->SetFont('Tahoma','B',7);
					//      $pdf->SetFillColor(5,5,5);
					$pdf->Cell($LP_W,  $W,'L.p.',1,0,'C');
					$pdf->Cell($NRD_W, $W,'Data wyjazdu',1,0,'C');
					//$pdf->MultiCell($TP_W,3,'Termin płatności',0,C,0);
					$pdf->Cell($O_W,   $W,'Opis trasy wyjazdu',1,0,'C');
					$pdf->Cell($C_W,   $W,'Cel wyjazdu',1,0,'C');
					$pdf->Cell($K_W, $W,'',1,0,'C');
					$pdf->Cell($S_W,  $W,'',1,0,'C');
					$pdf->Cell($W_W, $W,'',1,0,'C');
					$pdf->Cell($P_W, $W,'',1,0,'C');
					$pdf->Cell($U_W, $W,'',1,0,'C');
											
					$y=$MT+1.5;
					$pdf->SetXY($ML+$LP_W+$NRD_W+$O_W+$C_W, $y);
					$pdf->MultiCell($K_W,3,'Liczba przejechanych kilometrów',0,C,0);
					$pdf->SetXY($ML+$LP_W+$NRD_W+$O_W+$C_W+$K_W, $y);
					$pdf->MultiCell($S_W,3,'Stawka za 1 km przebiegu',0,C,0);
					$pdf->SetXY($ML+$LP_W+$NRD_W+$O_W+$C_W+$K_W+$S_W, $y);
					$pdf->MultiCell($W_W,3,'Wartość (kol. 5 X kol. 6)',0,C,0);

					$pdf->SetXY($ML+$LP_W+$NRD_W+$O_W+$C_W+$K_W+$S_W+$W_W, $y);
					$pdf->MultiCell($P_W,3,'Podpis pracodawcy i jego dane',0,C,0);
					$pdf->SetXY($ML+$LP_W+$NRD_W+$O_W+$C_W+$K_W+$S_W+$W_W+$P_W, $y);
					$pdf->MultiCell($U_W,3,'Uwagi', 0, C, 0);
					
	//        $pdf->Ln();
					$pdf->SetFont('Tahoma','',7);
		$Y=$MT+$W;
		$pdf->SetXY($ML, $Y);
		$W1=5;
			$lp=1;
			$suma_folio=0;
			$sth2=Query($dbh,$q2);
			while ($row2=$sth2->fetchRow() )
			{  
					$km=number_format($row2[3], 2, ',','');
					$suma_folio+=$row2[3];
					$pdf->Cell($LP_W,$W1, "$lp.", 1,0,'C');
					$pdf->Cell($NRD_W,$W1, "$row2[0]", 1,0,'C');
					$pdf->Cell($O_W,$W1, "$row2[1]", 1,0,'C');
					$pdf->Cell($C_W,$W1, "$row2[2]",1,0,'C');
					$pdf->Cell($K_W,$W1, "$km",1,0,'C');
					$pdf->Cell($S_W,$W1, '',1,0,'C');
					$pdf->Cell($W_W,$W1, "",1,0,'C');
					$pdf->Cell($P_W,$W1, '',1,0,'C');
					$pdf->Cell($U_W,$W1, "",1,1,'C');
									
			/*    $pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+5,$y+2,"$dokks[nazwa]");
					$adres=$dokks[kod]." ".$dokks[miasto].", ul. ".$dokks[ulica]." ".$dokks[nr_bud];
					if (!empty($dokks[nr_mieszk]))
					$adres.="/$dokks[nr_mieszk]";
		$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+5,$y+5,$adres);
		*/
					++$lp;
			}
			
			$suma_folio=number_format($suma_folio, 2, ',','');
			$pdf->SetFont('Tahoma','B',7);
			$pdf->Cell($LP_W+$NRD_W+$O_W+$C_W, $W1, "Suma folio:",1,0,'R');
			$pdf->Cell($K_W,$W1, "$suma_folio",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,1,'C');
	 
			$pdf->Cell($LP_W+$NRD_W+$O_W+$C_W, $W1, "Z przeniesienia :",1,0,'R');
			$pdf->Cell($K_W,$W1, "$przeniesienie",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,1,'C');
								 
			$razem=$km=number_format($suma_folio+$przeniesienie, 2, ',',''); 
			$pdf->Cell($LP_W+$NRD_W+$O_W+$C_W, $W1, "Razem :",1,0,'R');
			$pdf->Cell($K_W,$W1, "$razem",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,0,'C');
			$pdf->Cell($U_W,$W1, "",1,1,'C');


			$LP_W=9;
			$NDZ_W=50;
			$D_W=50;
			$O_W=120;
			$W_W=40;
			
			$ML=10;
			$MT=35;
																							
																						
			$this->PismoPoziomNaglowek($pdf, "PONIESIONE KOSZTY EKSPLOATACJI POJAZDU SAMOCHODOWEGO", $od);
			$pdf->SetMargins($ML,15,10); 
			$W=12;
			$pdf->SetFont('Tahoma','',8);
			$NrStr=$pdf->PageNo();
			$pdf->Text(145, 200,"Strona $NrStr",1,0,'C');
			$pdf->SetXY($ML, $MT);
			$pdf->SetFont('Tahoma','B',7);
			//     $pdf->SetFillColor(5,5,5);
			$pdf->Cell($LP_W,  $W,'L.p.',1,0,'C');
			$pdf->Cell($NDZ_W, $W,'Nr dok. zakupu',1,0,'C');
			$pdf->Cell($D_W,   $W,'Dokument z dnia',1,0,'C');
			$pdf->Cell($O_W,   $W,'Określenie (rodzaj) poniesionego wydatku',1,0,'C');
			$pdf->Cell($W_W, $W,'',1,0,'C');
			
			$pdf->SetXY($ML+$LP_W+$NDZ_W+$D_W+$O_W, $y+3);
			$pdf->MultiCell($W_W,4,'Wartość poniesionego wydatku',0,C,0);

			$H2=8;
			$Y=$MT+$W;
			$pdf->SetXY($ML, $Y);
									
			for( $i=1; $i<15; $i++)
			{
					$pdf->Cell($LP_W,  $H2,"$i.",1,0,'C');
					$pdf->Cell($NDZ_W, $H2,'',1,0,'C');
					$pdf->Cell($D_W,   $H2,'',1,0,'C');
					$pdf->Cell($O_W,   $H2,'',1,0,'C');
					$pdf->Cell($W_W,   $H2,'',1,1,'C');
			}                
					$pdf->Cell($LP_W+$NDZ_W+$D_W+$O_W,   $H2,'Suma folio :',1,0,'R');
		$pdf->Cell($W_W,   $H2,'',1,1,'C');
					$pdf->Cell($LP_W+$NDZ_W+$D_W+$O_W,   $H2,'Z przeniesienia :',1,0,'R');
		$pdf->Cell($W_W,   $H2,'',1,1,'C');
					$pdf->Cell($LP_W+$NDZ_W+$D_W+$O_W,   $H2,'Razem :',1,0,'R');
		$pdf->Cell($W_W,   $H2,'',1,1,'C');
									
		return($pdf);
	}

													
	function RejSprzedazy(&$pdf, $dbh, $od, $do, $ZALICZKI=NULL)
	{

	 if ( !empty($ZALICZKI) )
			{
		$q="    select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa,
			a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod
			from dokumenty_sprzedaz d, abonenci a, budynki b, ulice u 
			where d.id_odb=a.id_abon and a.id_bud=b.id_bud and u.id_ul=b.id_ul and d.data_wyst >= '$od' and d.data_wyst <= '$do' and d.nr_ds like '%/Z/%'
			order by d.nr_ds, d.data_wyst";
		$REJESTR="REJESTR SPRZEDAŻY (ZALICZKI)";
			}					 
	 else	
			{
			$q="	select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, 
			n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod
			from dokumenty_sprzedaz d, abonenci a, budynki b, ulice u, nazwy n, adresy_siedzib s 
			where n.id_abon=a.id_abon and a.id_abon=s.id_abon and d.id_odb=a.id_abon and s.id_bud=b.id_bud and u.id_ul=b.id_ul 
			and n.wazne_od <= '$od' and n.wazne_do >='$od' and s.wazne_od <= '$od' and s.wazne_do >='$od'
			and d.data_wyst >= '$od' and d.data_wyst <= '$do' and d.nr_ds not like '%/Z/%'
			order by d.nr_ds, d.data_wyst";
		$REJESTR="REJESTR SPRZEDAŻY";
			}

		$LP_W=9;
		$NRD_W=20;
		$MW_W=15;
		$DW_W=16;
		$TP_W=15;
		$N_W=85;
		$NIP_W=19;
		$WSN_W=18;
		$WSN_B=18;
		$PV_W=14;

		$WSN_W23=18;
		$WSN_B23=18;
		$PV_W23=14;
		
		$ML=10;
		$MT=30;
		
		$ilp=20;

		$lp=1;
		$razem_n=$razem_v=$razem_b=0;
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
		{

			if ( $lp%$ilp == 1)
			{
				 
				$pdf->SetMargins($ML,15,15);
																					
			$this->PismoPoziomNaglowek($pdf, "$REJESTR", $od);
			$pdf->SetMargins($ML,15,10); 
	 
				$W=7;
				$W2=13;
				
				$pdf->SetFont('Tahoma','',8);
				$NrStr=$pdf->PageNo();
				$pdf->Text(145, 200,"Strona $NrStr",1,0,'C');

				$pdf->SetXY($ML, $MT);

				$pdf->SetFont('Tahoma','B',6);
			//	$pdf->SetFillColor(5,5,5);
				$pdf->Cell($LP_W,  $W2,'Lp',1,0,'C');
				$pdf->Cell($NRD_W, $W2,'Nr dokumentu',1,0,'C');
				$pdf->Cell($MW_W,  $W2, '',1,0,'C');
				$pdf->Cell($DW_W,  $W2,'',1,0,'C');
				$pdf->Cell($TP_W,  $W2,'',1,0,'C');
				//$pdf->MultiCell($TP_W,3,'Termin płatności',0,C,0);
							
				$pdf->Cell($N_W,   $W2,'Nabywca',1,0,'C');
				$pdf->Cell($NIP_W, $W2,'NIP',1,0,'C');
							
				$pdf->Cell($WSN_W, $W2,'',1,0,'C');
				$pdf->Cell($PV_W,  $W2,'',1,0,'C');
				$pdf->Cell($WSN_W, $W2,'',1,0,'C');
				
				$pdf->Cell($WSN_W, $W2,'',1,0,'C');
				$pdf->Cell($PV_W,  $W2,'',1,0,'C');
				$pdf->Cell($WSB_B, $W2,'',1,0,'C');		
				
				$y=$MT+0.5;
				$pdf->SetXY($ML+$LP_W+$NRD_W-3, $y+3);
				$pdf->MultiCell(20,3,'Miejsce wystawienia',0,C,0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W, $y);
				$pdf->MultiCell($DW_W,3,'Data wystawienia Data sprzedazy',0,C,0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W, $y+3);
				$pdf->MultiCell($TP_W,3,'Termin płatności',0,C,0);
				
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W, $y);						
				$pdf->MultiCell($WSN_W,3,'Wartość sprzedaży netto [w zł] 8%',0,C,0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W, $y+2);
				$pdf->MultiCell($PV_W,3,'Podatek VAT [w zł] 8%', 0, C, 0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W+$PV_W, $y);
				$pdf->MultiCell($WSN_B,3,'Wartość sprzedaży brutto [w zł] 8%',0,C,0);
				
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W+$PV_W+$WSN_B, $y);						
				$pdf->MultiCell($WSN_W,3,'Wartość sprzedaży netto [w zł] 23%',0,C,0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W+$PV_W+$WSN_B+$WSN_W23, $y+2);
				$pdf->MultiCell($PV_W,3,'Podatek VAT [w zł] 23%', 0, C, 0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W+$PV_W+$WSN_B+$PV_W23+$WSN_W23-1, $y);
				$pdf->MultiCell($WSN_B,3,'Wartość sprzedaży brutto [w zł] 23%',0,C,0);
			}

			$dokks=array
				(
					'nr_d'				=> $row[0], 	'data_wyst'		=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=>	$row[3],	
					'forma_plat'	=> $row[4],		'miejsce_wyst'	=> $row[5],	'nazwa'			=> $row[6],	'pesel_nip'		=> $row[7],
					'ulica'				=> $row[8],		'nr_bud'			=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
					'miasto'			=> $row[12],	'kod'				=> $row[13]
				);

			$q2="(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, towary_sprzedaz t
						where p.id_tows=t.id_tows and p.nr_ds='$dokks[nr_d]' order by t.nazwa)
						union all
					 (select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, uslugi_voip t
						where p.id_tows=t.id_uvp  and p.nr_ds='$dokks[nr_d]' order by t.nazwa)";

			$razem_netto=$razem_vat=$razem_brutto=0;
			$razem_netto8=$razem_vat8=$razem_brutto8=0;
			$sth1=Query($dbh,$q2);

			while ( $row1=$sth1->fetchRow() )
				{	
	/*				$razem_netto+=round($netto, 2);
					$razem_vat+=round ($kwota_vat, 2);
					$razem_brutto+=round($brutto, 2); */
					
					$jedn_brutto=round($row1[4], 2);
					$cena_jedn_netto = $row1[4] / (1+$row1[5]/100);
					$brutto= $row1[2] * $jedn_brutto;
					$netto=$brutto / (1 + $row1[5]/100);
					$kwota_vat=$brutto-$netto;
			
					if ( $row1[5] == 23)
					{
						$razem_netto+=round($netto, 2);
						$razem_vat+=round ($kwota_vat, 2);
						$razem_brutto+=round($brutto, 2);
					}
					else if ( $row1[5] == 8)
					{
						$razem_netto8+=round($netto, 2);
						$razem_vat8+=round ($kwota_vat, 2);
						$razem_brutto8+=round($brutto, 2);
					}
				}

	//		$razem_n+=$razem_netto;
	//		$razem_v+=$razem_vat;
	//		$razem_b+=$razem_brutt
	
				$r_razem_netto=round($razem_netto, 2);
				$r_razem_vat=round($razem_vat, 2);
				$r_razem_brutto=round($razem_brutto, 2);
			
				$razem_b+=$r_razem_brutto;
				$razem_n+=$r_razem_netto;
				$razem_v+=$r_razem_vat;
	
				$r_razem_netto8=round($razem_netto8, 2);
				$r_razem_vat8=round($razem_vat8, 2);
				$r_razem_brutto8=round($razem_brutto8, 2);
				
				$razem_b8+=$r_razem_brutto8;
				$razem_n8+=$r_razem_netto8;
				$razem_v8+=$r_razem_vat8;
	
			
			//$pdf->Ln();
			$pdf->SetFont('Tahoma','',7);

			$k=$lp%$ilp;
			if ($k==0) $k=$ilp;
			$Y=$MT+$W2+($k-1)*$W;
			$pdf->SetXY($ML, $Y);
			$pdf->Cell($LP_W,$W, "$lp.", 1,0,'C');
			$pdf->Cell($NRD_W,$W, "$dokks[nr_d]", 1,0,'C');
			$pdf->Cell($MW_W,$W, "$dokks[miejsce_wyst]", 1,0,'C');
			$pdf->Cell($DW_W,$W, '',1,0,'C');
			$pdf->Cell($TP_W,$W, "$dokks[term_plat]",1,0,'C');
			$pdf->Cell($N_W,$W, '',1,0,'C');
			if ( !empty($dokks[pesel_nip]) && ValidateNip($dokks[pesel_nip]))
					$NIP="$dokks[pesel_nip]";
			else
					$NIP="";
			$pdf->Cell($NIP_W,$W, "$NIP",1,0,'C');
									
			$pdf->Cell($WSN_W,$W, number_format($r_razem_netto8,  2,',',''),1,0,'C');
			$pdf->Cell($PV_W, $W, number_format($r_razem_vat8,    2,',',''),1,0,'C');
			$pdf->Cell($WSN_W, $W, number_format($r_razem_brutto8,2,',',''),1,0,'C');

			$pdf->Cell($WSN_W,$W, number_format($r_razem_netto,  2,',',''),1,0,'C');
			$pdf->Cell($PV_W, $W, number_format($r_razem_vat,    2,',',''),1,0,'C');
			$pdf->Cell($WSB_B,$W, number_format($r_razem_brutto, 2,',',''),1,0,'C');
			
			$y=$Y+1;
			$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W, $y);
			$pdf->MultiCell($DW_W,3,"$dokks[data_wyst] $dokks[data_sprzed]" ,0,C,0);

			$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+1,$y+2,"$dokks[nazwa]");
			$adres=$dokks[kod]." ".$dokks[miasto].", ul. ".$dokks[ulica]." ".$dokks[nr_bud];
			if (!empty($dokks[nr_mieszk]))
			$adres.="/$dokks[nr_mieszk]";
			$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+1,$y+5,$adres);

		++$lp;
		}
		
					$k=$lp%$ilp;
					if ($k==0) $k=$ilp;
		else if ($k==1) $k=$ilp+1;	
					$Y=$MT+$W2+($k-1)*$W;
					$pdf->SetXY($ML, $Y);							
		$pdf->SetFont('Tahoma','B',7);
		$pdf->Cell($LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W, $W, "RAZEM : ", 1, 0, 'R');
					$pdf->Cell($WSN_W,$W, number_format($razem_n8, 2, ',',''),1,0,'C');
					$pdf->Cell($PV_W,$W,  number_format($razem_v8, 2,',',''),   1,0,'C');
					$pdf->Cell($WSN_W,$W, number_format($razem_b8, 2,',',''),1,0,'C');					
					$pdf->Cell($WSN_W,$W, number_format($razem_n, 2, ',',''),1,0,'C');
					$pdf->Cell($PV_W,$W,  number_format($razem_v, 2,',',''),   1,0,'C');
					$pdf->Cell($WSB_B,$W, number_format($razem_b, 2,',',''),1,0,'C');	
		return($pdf);
	}

	function Ksiazeczki(&$pdf, $dbh, $data_od, $data_do, $abon)
	{
		include "../func/config.php";
		$od_data=explode("-", $data_od);
		$rok=$od_data[0];
		$do_data=explode("-", $data_do);
		$m_od=$od_data[1];
		$m_do=$do_data[1];
		$idk=explode(" ", $abon);
		$ida=array_pop($idk);
		
		$q="select id_abon, symbol, nazwa1, kod, miasto,  nazwa2, numer1,  nr_lok, platnosc, numer2 , ksiazeczka, sum(cena) as kwota, ucecha
from
(
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, komputery k, towary_sprzedaz t, konta_wirtualne kw, pakiety p
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and k.id_komp=p.id_urz and t.id_tows=p.id_usl
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and k.id_abon=a.id_abon and k.podlaczony='T' and k.fv='T' 
 and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
 and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
 and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]'
	
	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, settopboxy st, towary_sprzedaz t, konta_wirtualne kw, pakiety p, belong bl
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and st.id_stb=p.id_urz and st.id_stb=bl.id_urz and t.id_tows=p.id_usl
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and bl.id_abon=a.id_abon and st.aktywny='T' and st.fv='T'
 and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
 and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
 and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]'
	and bl.nalezy_od <= '$conf[data]' and bl.nalezy_do >='$conf[data]' 
	
	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, telefony_voip tv, towary_sprzedaz t, konta_wirtualne kw, pakiety p
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and tv.id_tlv=p.id_urz and t.id_tows=p.id_usl
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and tv.id_abon=a.id_abon and tv.aktywny='T' and tv.fv='T'
	and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
	and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
	and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]'

	 
	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, router r, towary_sprzedaz t, konta_wirtualne kw, pakiety p, belong bl
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and r.id_rtr=p.id_urz and r.id_rtr=bl.id_urz and t.id_tows=p.id_usl
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and bl.id_abon=a.id_abon and r.aktywny='T' 
	and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
	and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
	and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]'
	and bl.nalezy_od <= '$conf[data]' and bl.nalezy_do >='$conf[data]'  
	 
	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, komputery k, towary_sprzedaz t, konta_wirtualne kw, uslugi_dodatkowe ud
	
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and ud.id_usl=t.id_tows
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and k.id_abon=a.id_abon and k.podlaczony='T' and k.fv='T' and ud.id_urz=k.id_komp and ud.fv='T'
  and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
 and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
	and ud.aktywna_od <= '$conf[data]' and ud.aktywna_do >='$conf[data]'
		 
	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, settopboxy st, towary_sprzedaz t, konta_wirtualne kw, uslugi_dodatkowe ud, belong bl
	
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and ud.id_usl=t.id_tows
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and bl.id_abon=a.id_abon and st.aktywny='T' and st.fv='T' and bl.id_urz=st.id_stb and ud.id_urz=st.id_stb and ud.fv='T'
	 and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
 and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
	and ud.aktywna_od <= '$conf[data]' and ud.aktywna_do >='$conf[data]'
		and bl.nalezy_od <= '$conf[data]' and bl.nalezy_do >='$conf[data]' 

	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, router r, towary_sprzedaz t, konta_wirtualne kw, uslugi_dodatkowe ud, belong bl
	
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and ud.id_usl=t.id_tows
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and bl.id_abon=a.id_abon and r.aktywny='T'  and ud.id_urz=r.id_rtr and bl.id_urz=r.id_rtr and ud.fv='T'
	 and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
 and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
	and ud.aktywna_od <= '$conf[data]' and ud.aktywna_do >='$conf[data]'	
		and bl.nalezy_od <= '$conf[data]' and bl.nalezy_do >='$conf[data]' 
	
 	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, umowy_abonenckie um, telefony_voip tv, towary_sprzedaz t, konta_wirtualne kw, uslugi_dodatkowe ud
	
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and um.id_abon=a.id_abon and ud.id_usl=t.id_tows
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and tv.id_abon=a.id_abon and tv.aktywny='T' and tv.fv='T' and ud.id_urz=tv.id_tlv and ud.fv='T'
	 and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
 and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
	and ud.aktywna_od <= '$conf[data]' and ud.aktywna_do >='$conf[data]'

	union all
select  a.id_abon, n.symbol, n.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, s.nr_lok, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena*z.ilosc as cena, u.cecha as ucecha
	from abonenci a, nazwy n, adresy_siedzib s, ulice u, budynki b, zobowiazania z, towary_sprzedaz t, konta_wirtualne kw
	
	where a.id_abon=n.id_abon and a.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and z.id_usl=t.id_tows
	and a.id_abon=kw.id_abon 	and z.id_abon=a.id_abon
	 and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
 and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
	and z.aktywne_od <= '$conf[data]' and z.aktywne_do >='$conf[data]'
) q where";
				
		if (!empty($abon) && $abon !=$conf[select])   		
				$q.="	id_abon='$ida'";
	else 
				$q.=" ksiazeczka='T'";

		$q.=" group by id_abon, symbol, nazwa1, kod, miasto,  nazwa2, numer1,  nr_lok, platnosc, numer2, ksiazeczka, ucecha order by 3	";
																																																			
		//echo $q;	
		set_time_limit(600);
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
			{
				
				$kwota=number_format(round($row[11], 2), 2, ',','');
		
				$ks=array( 	'nazwa'	=> Choose($row[1], $row[2]),	'term_plat'		=>	$row[3], 'kwota' => $kwota,	
						'miasto'	=> "$row[3]"." "."$row[4]", 'ulica' => "$row[12] "."$row[5]"." "."$row[6]", 'id_abon'=> strtolower($row[0]),
						'platnosc' => "$row[8]", 'konto' => "$row[9]");

				if (!empty($row[7]))		
					$ks[ulica].="/$row[7]";
				
				for ( $i=$m_od; $i<=$m_do; )
				{
					$mies1="$i.$rok";
					++$i;
					$mies2="$i.$rok";
					++$i;
					$mies3="$i.$rok";
					++$i;
							$pdf->AddPage();
							$pdf->SetMargins(0,0,0);
							$pdf->SetFont('Tahoma','',11);
								$pdf->SetTextColor(0,0,0);
								$yy=-83;
					$this->poj(&$pdf, $ks, $mies1, $yy); // 0 for old blankets
					$this->poj(&$pdf, $ks, $mies2, $yy+99); // 0 for old blankets
					$this->poj(&$pdf, $ks, $mies3, $yy+199); // 110 for old blankets
				//	$pdf->AddPage();
				}
			}
				return($pdf);
	}

	function PismoNaglowek(&$pdf, $adresat=NULL, $nazwa=NULL, $y=NULL, $file="../func/config.php")
	{
		include $file;
		$data=date("Y-m-d");
		$data_slownie=DataSlownie($data);
		
		$XA="115";
		
		$pdf->AddPage();
		$pdf->SetMargins(20,15,20);
		
		$pdf->SetDrawColor(0,0,255);
	//	$pdf->Line(20,6,190,6);
		$pdf->Image("$conf[pdf_logo1]",20,8,70,15);        
		
		$pdf->SetMargins(20,15,15);
		$pdf->SetFont('Tahoma','B',10);
		$pdf->SetTextColor(0,0,255);
				
		$pdf->Text(122,12, $firma[nazwa]);
		$pdf->Text(122,17, $firma[nazwa2]);
		$pdf->Text(122,22, $firma[adres]);		
		
		$pdf->SetDrawColor(200,200,200);
		$pdf->Line(20,25,190,25);

		$pdf->SetXY(0,24);		
		$pdf->SetFont('Tahoma','',8);
		$pdf->Cell(210,6,"$firma[strona2]              e-mail:  $firma[email2]               tel.   $firma[telefon1]             fax:   $firma[fax]  ",0,1,'C');

		$pdf->SetDrawColor(200,200,200);
		$pdf->Line(20,29,190,29);
		
		$pdf->SetXY(0,28);
		$pdf->Cell(210,6,"NIP:   $firma[nip]                 REGON:   $firma[regon]             Wpis do rejestru przedsiębiorców telekomunikacyjnych nr 5621",0,1,'C');

		$pdf->SetDrawColor(200,200,200);
		$pdf->Line(20,33,190,33);
		$pdf->SetDrawColor(0,0,0);

		$pdf->SetTextColor(0,0,0);

		if (!empty($adresat) )
		{
			$pdf->SetFont('Tahoma','',10);
			//	$pdf->SetXY($XA,62);
			$pdf->MultiCell(170,5,"",0,R,0);
			$pdf->MultiCell(170,5,"$firma[miasto], dnia $data_slownie",0,R,0);

			$pdf->SetFont('Tahoma','B',13);
			$pdf->SetXY($XA,55);
			$pdf->MultiCell(87,5,"$adresat[nazwa]",0,L,0);

			$pdf->SetXY($XA,70);
			$pdf->MultiCell(87,5,"$adresat[adres2]",0,L,0);
			$pdf->SetXY($XA,75);
			$pdf->MultiCell(87,5,"$adresat[adres1]",0,L,0);
		}
		
		if (!empty($nazwa) )
		{
			$pdf->SetFont('Tahoma','B',15);
			if ( empty($y) ) $y=100;
			$pdf->SetY($y);
			$pdf->SetFont('Tahoma','B',15);			
			$pdf->Cell(172,20,$nazwa,0,1,'C');
		}
	}

	function PismoNaglowek2(&$pdf, $adresat=NULL, $nazwa=NULL, $data=NULL, $file="../func/config.php")
	{
		include $file;
		if (empty($data) ) $data=date("Y-m-d");
		$data_slownie=DataSlownie($data);
		
		$XA="115";
		
		$pdf->AddPage();
		$pdf->SetMargins(20,15,20);
		
		$pdf->SetDrawColor(0,0,255);
	//	$pdf->Line(20,6,190,6);
		$pdf->Image("$conf[pdf_logo1]",20,8,70,15);        
		
		$pdf->SetMargins(20,15,15);
		$pdf->SetFont('Tahoma','B',10);
		$pdf->SetTextColor(0,0,255);
				
		$pdf->Text(122,12, $firma[nazwa]);
		$pdf->Text(122,17, $firma[nazwa2]);
		$pdf->Text(122,22, $firma[adres]);		
		
		$pdf->SetDrawColor(200,200,200);
		$pdf->Line(20,25,190,25);

		$pdf->SetXY(0,24);		
		$pdf->SetFont('Tahoma','',8);
		$pdf->Cell(210,6,"$firma[strona2]              e-mail:  $firma[email2]               tel.   $firma[telefon1]             fax:   $firma[fax]  ",0,1,'C');

		$pdf->SetDrawColor(200,200,200);
		$pdf->Line(20,29,190,29);
		
		$pdf->SetXY(0,28);
		$pdf->Cell(210,6,"NIP:   $firma[nip]                 REGON:   $firma[regon]             Wpis do rejestru przedsiębiorców telekomunikacyjnych nr 5621",0,1,'C');

		$pdf->SetDrawColor(200,200,200);
		$pdf->Line(20,33,190,33);
		$pdf->SetDrawColor(0,0,0);

		$pdf->SetTextColor(0,0,0);

		if (!empty($adresat) )
		{
			$pdf->SetFont('Tahoma','',10);
			//	$pdf->SetXY($XA,62);
			$pdf->MultiCell(170,5,"",0,R,0);
			$pdf->MultiCell(170,5,"$firma[miasto], dnia $data_slownie",0,R,0);

			$pdf->SetFont('Tahoma','B',13);
			$pdf->SetXY($XA,55);
			$pdf->MultiCell(87,5,"$adresat[nazwa]",0,L,0);

			$pdf->SetXY($XA,70);
			$pdf->MultiCell(87,5,"$adresat[adres2]",0,L,0);
			$pdf->SetXY($XA,75);
			$pdf->MultiCell(87,5,"$adresat[adres1]",0,L,0);
		}
		
		if (!empty($nazwa) )
		{
			$pdf->SetFont('Tahoma','B',15);
			if ( empty($y) ) $y=100;
			$pdf->SetY($y);
			$pdf->SetFont('Tahoma','B',15);			
			$pdf->Cell(172,20,$nazwa,0,1,'C');
		}
	}	
	
	function PismoStopka(&$pdf, $nr_str=NULL, $file="../func/config.php")
	{
		include $file;
		$data=date("Y-m-d");
		$data_slownie=DataSlownie($data);
		
		$ld="170";
		$x="20";
		$y="280";

		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Tahoma','',8);
		$nr_str=$pdf->PageNo();
		$pdf->Text(100, $y-4,"Strona $nr_str",1,0,'C');
		
		$pdf->SetDrawColor(0,0,255);					
		$pdf->Line($x,$y,$x+$ld,$y);
		$pdf->SetFont('Tahoma','',8);
		$pdf->SetTextColor(0,0,255);
		$pdf->SetXY($x,$y+2);
		$pdf->MultiCell($ld,5,"Dokument elektroniczny sporządzony na druku firmowym, nie wymaga pieczątki ani podpisu.",0,C,0);		
		$pdf->SetTextColor(0,0,0);
	}

	function PonaglenieZaplaty(&$pdf, $dbh, $id_spw, $file="../func/config.php")
	{
				include $file;

		$X="20";
		//wsp X danych adresowych
		
				$q="(select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, 
				um.typ_um, a.platnosc, sb.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer, k.nazwa, 
				k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				
				from ((sprawy_windykacyjne s join umowy_abonenckie um on s.id_abon=um.id_abon) 
				left join (kontakty k right join nazwy n on k.id_podm=n.id_abon and  k.wazne_od <= '$conf[data]' and k.wazne_do >= '$conf[data]') on n.id_abon=um.id_abon) 
				join (((budynki b join ulice u on b.id_ul=u.id_ul) join adresy_siedzib sb on b.id_bud=sb.id_bud) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on sb.id_abon=a.id_abon) on s.id_abon=a.id_abon 				
				where   n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' and sb.wazne_od <= '$conf[data]' and sb.wazne_do >= '$conf[data]' and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, 
				um.typ_um, a.platnosc, sb.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer, k.nazwa, 
				k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				
				from ((sprawy_windykacyjne s join umowy_serwisowe um on s.id_abon=um.id_abon) 
				left join (kontakty k right join nazwy n on k.id_podm=n.id_abon and  k.wazne_od <= '$conf[data]]' and k.wazne_do >= '$conf[data]') on n.id_abon=um.id_abon) 
				join (((budynki b join ulice u on b.id_ul=u.id_ul) join adresy_siedzib sb on b.id_bud=sb.id_bud) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on sb.id_abon=a.id_abon) on s.id_abon=a.id_abon 				
				where   n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' and sb.wazne_od <= '$conf[data]' and sb.wazne_do >= '$conf[data]' and s.id_spw='$id_spw')";
				
				


		

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
		
			$dluznik=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> number_format(-$row[3], 2, ',',''),	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	 
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18],
					'konto'		=> $row[19],
					'cecha'			=> $row[20],	'k_cecha'			=> $row[21]
				);

				
		if ( !empty($dluznik[k_nazwa]) && !empty($dluznik[k_ulica]) && !empty($dluznik[k_nr_bud]) && !empty($dluznik[k_miasto])  )
				{						
					$dluznik[nazwa]=$dluznik[k_nazwa];
					$adres1=$dluznik[k_kod]." ".$dluznik[k_miasto];
					$adres2="$dluznik[k_cecha] ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="$dluznik[cecha] ".$dluznik[ulica]." ".$dluznik[nr_bud];
					if (!empty($dluznik[nr_mieszk]))
					$adres2.="/$dluznik[nr_mieszk]";
				}
						

			$adresat=array('nazwa' => $dluznik[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
				
			//$dluznik[saldo]=-$dluznik[saldo];
				
				
			$tekst0="Szanowni Państwo.";
			$tekst1=" ";
			$tekst2="Z przykrością stwierdzamy, że konto Państwa wskazuje zaległe należności za usługi internetowe na łączną kwotę (wraz z bieżącą fakturą):";
			$tekst3="$dluznik[saldo] zł brutto."; 
			$tekst4=" ";
			$tekst5="Należności te wynikają z braku zapłaty za usługi dostępu do Internetu.";
			$tekst6="";
			$tekst7="Uprzejmie prosimy o niezwłoczne wpłacenie w/w kwoty na rachunek bankowy:";
			$tekst8="NETICO S.C.  - $dluznik[konto]";
			$tekst9="";
			$tekst10="Przypominamy, że zaleganie z płatnością wystawionych faktur lub not odsetkowych o więcej niż 14 dni od wyznaczonego terminu płatności skutkuje całkowitą utratą dostępu do infrastruktury teleinformatycznej operatora, zamknięciem konta i utratą wszystkich związanych z nim zasobów i informacji.";
			$tekst11="";		
			$tekst12="Jeśli Państwo, z powodu braku czasu, mają problemy z terminowym regulowaniem należności za wystawione przez NETICO S.C. faktury za usługi zachęcamy do korzystania z bezgotówkowych form płatności - stałe zlecenie bankowe lub przelew internetowy.";
			$tekst13="";		
			$tekst14="W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy o kontakt pod numerem telefonu: 32 745 33 33.";	
			$tekst15="";	
			$tekst16="Z poważaniem";
			$tekst17="NETICO S.C. ";
					
			
			
		$poz_h=7;
		
				$this->PismoNaglowek($pdf, $adresat, "PONAGLENIE ZAPŁATY", NULL, $file);

				$pdf->SetFont('Tahoma','',10);

				$pdf->SetXY($X,120);
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->SetFont('Tahoma','B',10);
				$pdf->MultiCell(170,5,"$tekst3",0,C,0);
				$pdf->SetFont('Tahoma','',10);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst5",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);

				$pdf->SetFont('Tahoma','B',10);
				$pdf->MultiCell(170,5,"$tekst7",0,C,0);
				$pdf->MultiCell(170,5,"$tekst8",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',10);
				$pdf->MultiCell(170,5,"$tekst10",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst12",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst14",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(160,5,"$tekst16",0,R,0);
				$pdf->MultiCell(160,5,"$tekst17",0,R,0);

				$this->PismoStopka($pdf, NULL, $file);
			return($pdf);
		}



  function WezwanieZaplata(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";
		$nazwa_dok="WEZWANIE DO ZAPŁATY";

		$X="20";
		$Y="115";
		
		//wsp X danych adresowych
				$q="(select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, 
				um.typ_um, a.platnosc, sb.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer, k.nazwa, 
				k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				
				from ((sprawy_windykacyjne s join umowy_abonenckie um on s.id_abon=um.id_abon) 
				left join (kontakty k right join nazwy n on k.id_podm=n.id_abon and  k.wazne_od <= '$conf[data]]' and k.wazne_do >= '$conf[data]') on n.id_abon=um.id_abon) 
				join (((budynki b join ulice u on b.id_ul=u.id_ul) join adresy_siedzib sb on b.id_bud=sb.id_bud) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on sb.id_abon=a.id_abon) on s.id_abon=a.id_abon 				
				where   n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' and sb.wazne_od <= '$conf[data]' and sb.wazne_do >= '$conf[data]' and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, 
				um.typ_um, a.platnosc, sb.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer, k.nazwa, 
				k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				
				from ((sprawy_windykacyjne s join umowy_serwisowe um on s.id_abon=um.id_abon) 
				left join (kontakty k right join nazwy n on k.id_podm=n.id_abon and  k.wazne_od <= '$conf[data]]' and k.wazne_do >= '$conf[data]') on n.id_abon=um.id_abon) 
				join (((budynki b join ulice u on b.id_ul=u.id_ul) join adresy_siedzib sb on b.id_bud=sb.id_bud) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on sb.id_abon=a.id_abon) on s.id_abon=a.id_abon 				
				where   n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' and sb.wazne_od <= '$conf[data]' and sb.wazne_do >= '$conf[data]' and s.id_spw='$id_spw')";		

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
						
			$dluznik=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> $row[3],	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	'aktywacja'	=> $row1[0], 'zadluzenie' => number_format(-$row[3], 2, ',',''),
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18],
					'konto'		=> $row[19],
					'cecha'			=> $row[20],	'k_cecha'			=> $row[21]
				);
				
			$pdf=$this->MakeWDZ($pdf, $dbh, $dluznik);
			$pdf=$this->MakeWDZ($pdf, $dbh, $dluznik);
			return($pdf);

		}		

		
	function PWezwanieZaplata(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";
		$nazwa_dok="PRZEDSĄDOWE WEZWANIE DO ZAPŁATY";

		$X="20";
		$Y="110";
		
		//wsp X danych adresowych
		
				$q="(select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, 
				um.typ_um, a.platnosc, sb.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer, k.nazwa, 
				k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				
				from ((sprawy_windykacyjne s join umowy_abonenckie um on s.id_abon=um.id_abon) 
				left join (kontakty k right join nazwy n on k.id_podm=n.id_abon and  k.wazne_od <= '$conf[data]]' and k.wazne_do >= '$conf[data]') on n.id_abon=um.id_abon) 
				join (((budynki b join ulice u on b.id_ul=u.id_ul) join adresy_siedzib sb on b.id_bud=sb.id_bud) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on sb.id_abon=a.id_abon) on s.id_abon=a.id_abon 				
				where   n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' and sb.wazne_od <= '$conf[data]' and sb.wazne_do >= '$conf[data]' and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, 
				um.typ_um, a.platnosc, sb.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer, k.nazwa, 
				k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				
				from ((sprawy_windykacyjne s join umowy_serwisowe um on s.id_abon=um.id_abon) 
				left join (kontakty k right join nazwy n on k.id_podm=n.id_abon and  k.wazne_od <= '$conf[data]]' and k.wazne_do >= '$conf[data]') on n.id_abon=um.id_abon) 
				join (((budynki b join ulice u on b.id_ul=u.id_ul) join adresy_siedzib sb on b.id_bud=sb.id_bud) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on sb.id_abon=a.id_abon) on s.id_abon=a.id_abon 				
				where   n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' and sb.wazne_od <= '$conf[data]' and sb.wazne_do >= '$conf[data]' and s.id_spw='$id_spw')";	

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
			
			$data_slownie=DataSlownie($dluznik[data_zaw]);
			
			$dluznik=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> $row[3],	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	'aktywacja'	=> $row1[0], 'zadluzenie' => number_format(-$row[3], 2, ',',''),
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18],
					'konto'		=> $row[19],
					'cecha'			=> $row[20],	'k_cecha'			=> $row[21]
				);
				
		$pdf=$this->MakePWDZ($pdf, $dbh, $dluznik);
		$pdf=$this->MakePWDZ($pdf, $dbh, $dluznik);
		return($pdf);
		}		

		

		
	function MakeWDZ(&$pdf, $dbh, $dluznik)
	{
		include "../func/config.php";
		$nazwa_dok="WEZWANIE DO ZAPŁATY";

		$X="20";
		$Y="115";
		
		$q="select data_rozp from windykowanie where id_spw='$dluznik[id_spw]' and krok='pismo'";
		$data=Query2($q, $dbh);
		$data_slownie=DataSlownie($dluznik[data_zaw]);

				
			if ( !empty($dluznik[k_nazwa]) && !empty($dluznik[k_ulica]) && !empty($dluznik[k_nr_bud]) && !empty($dluznik[k_miasto])  )
				{						
					$dluznik[nazwa]=$dluznik[k_nazwa];
					$adres1=$dluznik[k_kod]." ".$dluznik[k_miasto];
					$adres2="$dluznik[k_cecha] ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="$dluznik[cecha] ".$dluznik[ulica]." ".$dluznik[nr_bud];
					if (!empty($dluznik[nr_mieszk]))
					$adres2.="/$dluznik[nr_mieszk]";
				}
						
			$adresat=array('nazwa' => $dluznik[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
			
			$ostatni = DataSlownie(OstatniDzienMiesiaca(date("Y-m-d")));
						
			$dluznik[saldo]=-$dluznik[saldo];
				
			$tekst0="Szanowni Państwo.";
			$tekst1=" ";
			$tekst2="Z przykrością stwierdzamy, że konto Państwa wskazuje zaległe należności za usługi internetowe na łączną kwotę:";
			$tekst3="$dluznik[zadluzenie] zł brutto."; 
			$tekst4=" ";
			$tekst5="";
			$tekst6="";
			$tekst7="Uprzejmie prosimy o niezwłoczne wpłacenie w/w kwoty na rachunek bankowy:";
			$tekst8="$firma[nazwa] - $dluznik[konto]";
			$tekst9="";
			$tekst10="Powyższe wynika z treści  umowy  $dluznik[um_numer] z dnia $dluznik[data_zaw].  Umowa ta do dnia dzisiejszego nie została przez Państwa pisemnie wypowiedziana z zachowaniem trzymiesięcznego okresu wypowiedzenia. 
Przypominamy, że w przypadku rozwiązania umowy przed upływem minimalnego okresu jej obowiązywania na wniosek bądź też z winy Abonenta obowiązuje opłata deaktywacyjna.";
			$tekst11="";			
			$tekst12="Informacje o nieuregulowanych zobowiązaniach, zgodnie z Ustawą o udostępnianiu informacji gospodarczych i wymianie danych gospodarczych z dnia 9 kwietnia 2010 r. (Dz.U. Nr 81, poz. 530), będą przekazywane do: Krajowego Rejestru Długów Biura Informacji Gospodarczej SA ul. Armii Ludowej 21, 51-214 Wrocław www.krd.pl Informacja o zadłużeniu upubliczniona będzie w KRD do dnia zapłaty lub do 10 lat od daty dokonania wpisu.";


			$tekst13="Informujemy, że jeżeli zadłużenie  nie zostanie uregulowane do $ostatni  rozpoczniemy proces kompletowania dokumentacji celem wystąpienia z powództwem na drogę postępowania sądowego.
W rezultacie sąd wyda nakaz upoważniający komornika sądowego do wszczęcia egzekucji (zajęcia wynagrodzenia, renty bądź emerytury, zablokowania osobistego konta bankowego lub zajęcia majątku trwałego, należącego do dłużnika lub współmałżonka).";

			$tekst16="W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy o kontakt pod numerem telefonu:             $firma[telefon1].";	
			$tekst17="";	
			$tekst18="Z poważaniem";
			$tekst19="NETICO S.C. ";
					
	
		$poz_h=7;
				$this->PismoNaglowek2($pdf, $adresat, $nazwa_dok, $data[0]);

				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($X,$Y);

				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst3",0,C,0);
				$pdf->SetFont('Tahoma','',9);
			//	$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst7",0,C,0);
				$pdf->MultiCell(170,5,"$tekst8",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"$tekst10",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetLineWidth(0.5);
				$pdf->Cell(170,$X+15,'',1,1,'C');
				$pdf->SetLineWidth(0.2);
				$pdf->SetXY($X+50, $Y+70);				
				$pdf->Image("$conf[krdbig_logo]",$X+10,$Y+72,33,22);  
				$pdf->SetXY($X+50, $Y+67);
				$pdf->MultiCell(117,5,"$tekst12",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst13",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);

				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"$tekst16",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(160,5,"$tekst18",0,R,0);
				$pdf->MultiCell(160,5,"$tekst19",0,R,0);
				
				
				$this->PismoStopka($pdf);
			
				return($pdf);

		}		
		

	function MakePWDZ(&$pdf, $dbh, $dluznik)
	{
		include "../func/config.php";
		$nazwa_dok="PRZEDSĄDOWE WEZWANIE DO ZAPŁATY";

		$X="20";
		$Y="110";
		
					$q="select data_rozp from windykowanie where id_spw='$dluznik[id_spw]' and krok='krd'";
		$data=Query2($q, $dbh);
		
			$data_slownie=DataSlownie($dluznik[data_zaw]);
			
				
			if ( !empty($dluznik[k_nazwa]) && !empty($dluznik[k_ulica]) && !empty($dluznik[k_nr_bud]) && !empty($dluznik[k_miasto])  )
				{						
					$dluznik[nazwa]=$dluznik[k_nazwa];
					$adres1=$dluznik[k_kod]." ".$dluznik[k_miasto];
					$adres2="$dluznik[k_cecha] ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="$dluznik[cecha] ".$dluznik[ulica]." ".$dluznik[nr_bud];
					if (!empty($dluznik[nr_mieszk]))
					$adres2.="/$dluznik[nr_mieszk]";
				}
						
			$adresat=array('nazwa' => $dluznik[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
			
			$ostatni = DataSlownie(OstatniDzienMiesiaca(date("Y-m-d")));
						
			$dluznik[saldo]=-$dluznik[saldo];
				
			$tekst0="";
			$tekst1=" ";
			$tekst2="Zgodnie z Ustawą z dnia 9 kwietnia 2010 r. o udostępnianiu informacji gospodarczych i wymianie danych gospodarczych (Dz. U. Nr 81, poz. 530), zwaną dalej Ustawą, ostrzegamy o zamiarze przekazania informacji gospodarczej o Państwa zadłużeniu do Krajowego Rejestru Długów Biura Informacji Gospodarczej SA z siedzibą we Wrocławiu i adresem: 51-214 Wrocław, ul. Armii Ludowej 21.

W przypadku braku spłaty zadłużenia do $ostatni informacja gospodarcza zostanie ujawniona w Krajowym Rejestrze Długów.";
			$tekst3=""; 
			$tekst4=" ";
			$tekst5="Jednocześnie informujemy, że dłużnicy notowani w Krajowym Rejestrze Długów, zgodnie z art. 24 ust. 2 Ustawy mają utrudniony dostęp do usług finansowych (kredytów, leasingu, sprzedaży ratalnej), usług telekomunikacyjnych i multimedialnych (możliwość kupna telefonu w abonamencie, zawarcia umowy na szerokopasmowy dostęp do Internetu, telewizję kablową i satelitarną), wynajmu nieruchomości (np.: mieszkania, biura, magazynu, placu) i wielu innych.";

			$tekst6="";
			$tekst7="Uprzejmie prosimy o niezwłoczne wpłacenie w/w kwoty na rachunek bankowy:";
			$tekst8="$firma[nazwa] - $dluznik[konto]";
			$tekst9="";
			$tekst10="";
			$tekst11="";
			$tekst12="Jeżeli w dalszym ciągu będziecie Państwo unikać spłaty zobowiązania, podejmiemy kolejne kroki, których efektem będzie wydanie przez sąd nakazu upoważniającego komornika sądowego do wszczęcia egzekucji (zajęcia wynagrodzenia, renty bądź emerytury, zablokowania osobistego konta bankowego lub zajęcia majątku trwałego, należącego do dłużnika lub współmałżonka).";
			$tekst13="";		
			$tekst14="Aby uregulować zadłużenie prosimy o wpłacenie kwoty $dluznik[zadluzenie] zł na rachunek bankowy:";
			$tekst15="$firma[nazwa] - $dluznik[konto]";		
			$tekst16="W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy o kontakt pod numerem telefonu:             $firma[telefon1].";	
			$tekst17="";	
			$tekst18="Z poważaniem";
			$tekst19="NETICO S.C. ";
					
			
			
		$poz_h=7;
				$this->PismoNaglowek2($pdf, $adresat, $nazwa_dok, $data[0]);

				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($X,$Y);
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetFont('Tahoma','',9);
			//	$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetLineWidth(0.5);
				$pdf->Cell(170,$X+15,'',1,1,'C');
				$pdf->SetLineWidth(0.2);
				$pdf->SetXY($X+50, $Y+55);				
				$pdf->Image("$conf[krdbig_logo]",$X+10,$Y+57,33,22);  
				$pdf->SetXY($X+50, $Y+52);
				$pdf->MultiCell(117,5,"$tekst5",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst12",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);

				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst14",0,C,0);
				$pdf->MultiCell(170,5,"$tekst15",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"$tekst16",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(160,5,"$tekst18",0,R,0);
				$pdf->MultiCell(160,5,"$tekst19",0,R,0);
				
				$this->PismoStopka($pdf);
				
				return($pdf);

		}		
		
		
		
		
	function WezwaniaDoZaplaty3(&$pdf, $dbh, $krok)
	{
				$q="(select distinct s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
	
				from (((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) join windykowanie w on w.id_spw=s.id_spw) full join kontakty k on k.id_podm=um.id_abon) 
				join 
				((budynki b join ulice u on b.id_ul=u.id_ul) join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) 
				on s.id_abon=a.id_abon 
			
			where a.id_bud=b.id_bud and um.id_abon=a.id_abon  and s.zwindykowana='N' and um.status<>'Rozwiązana'
				and u.id_ul=b.id_ul and w.krok='$krok' )
				union
				
				(select distinct s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				from (((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon ) join windykowanie w on w.id_spw=s.id_spw) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon   and s.zwindykowana='N' 
				and u.id_ul=b.id_ul and w.krok='$krok' )
				union
				
				(select distinct s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				from (((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon ) join windykowanie w on w.id_spw=s.id_spw) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon   and s.zwindykowana='N'
				and u.id_ul=b.id_ul and w.krok='$krok' )
				
				union
				(select distinct s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, u.cecha, k.cecha
				from (((sprawy_windykacyjne s full join umowy_iptv um on s.id_abon=um.id_abon ) join windykowanie w on w.id_spw=s.id_spw) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon   and s.zwindykowana='N'
				and u.id_ul=b.id_ul and w.krok='$krok' )
				order by 3 ";
				
		set_time_limit(600);                                                                        
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
			{
			$dluznik=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> $row[3],	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	'aktywacja'	=> $row1[0], 'zadluzenie' => number_format(-$row[3], 2, ',',''),
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18],
					'konto'		=> $row[19],
					'cecha'			=> $row[20],	'k_cecha'			=> $row[21]
				);

			switch ($krok)
			{
			case 'pismo':
				$pdf=$this->MakeWDZ1($pdf, $dbh, $dluznik);
				break;
			case 'krd':
				$pdf=$this->MakeWDZ3($pdf, $dbh, $dluznik);
				break;
			case 'sąd':
				$pdf=$this->MakeWDZ3($pdf, $dbh, $dluznik);
				break;
		 }

	
			}
		return($pdf);
		//$pdf->Output();
	}		
		
		
		
	function DowodWplaty(&$pdf, $dbh, $id_wpl)
	{
		include "../func/config.php";
		$X="20";
		//wsp X danych adresowych
		
			$q="select n.id_abon, n.nazwa, s.nr_lok, u.nazwa, u.miasto, u.kod, b.numer, k.nazwa, k.ulica, k.nr_bud, 
					k.nr_mieszk, k.kod, k.miasto, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta , w.opis
					
				from (( kontakty k right join wplaty w on k.id_podm=w.id_kontrah and k.wazne_od <= '$conf[data]' and k.wazne_do >= '$conf[data]') join (nazwy n join adresy_siedzib s on n.id_abon=s.id_abon)   on w.id_kontrah=n.id_abon)
				join ( budynki b join ulice u on b.id_ul=u.id_ul ) on s.id_bud=b.id_bud 
				where n.wazne_od <= w.data_ksiegowania and n.wazne_do >= w.data_ksiegowania and s.wazne_od <= w.data_ksiegowania and s.wazne_do >= w.data_ksiegowania 
				and w.id_wpl='$id_wpl'";
		

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
		
			$wpl=array
				(
					'id_abon'		=> $row[0],		'nazwa' => $row[1],		 	'nr_mieszk'			=> $row[2], 'ulica'			=> $row[3],		'miasto'	=> $row[4],	'kod'	=> $row[5], 
					'nr_bud'		=> $row[6],	 	 'k_nazwa'		=> $row[7],   'k_ulica'		=> $row[8],  'k_nr_bud'		=> $row[9], 'k_nr_mieszk'		=> $row[10], 
					'k_kod'		=> $row[11],'k_miasto'		=> $row[12], 'data_ksiegowania'		=> $row[13],   'data_zlecona'		=> $row[14],  'forma'		=> $row[15], 
					'kwota'		=> $row[16], 'waluta'		=> $row[17],'opis'		=> $row[18],
					'cecha'			=> $row[19],	'k_cecha'			=> $row[20]
					);

		$x=new slownie;
		$slownie=$x->zwroc($wpl[kwota]);

		$adres1=$wpl[kod]." ".$wpl[miasto];
		$adres2="ul. ".$wpl[ulica]." ".$wpl[nr_bud];
		if (!empty($wpl[nr_mieszk]))
			$adres2.="/$wpl[nr_mieszk]";
		$odbiorca=array('nazwa' => $wpl[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);	
		$adresat=$odbiorca;
					
		if ( !empty($wpl[k_nazwa]) && !empty($wpl[k_ulica]) && !empty($wpl[k_nr_bud]) && !empty($wpl[k_miasto])  )
				{						
					$wpl[nazwa]=$wpl[k_nazwa];
					$adres1=$wpl[k_kod]." ".$wpl[k_miasto];
					$adres2="ul. ".$wpl[k_ulica]." ".$wpl[k_nr_bud];
					if (!empty($wpl[k_nr_mieszk]))
					$adres2.="/$wpl[k_nr_mieszk]";
					$adresat=array('nazwa' => $wpl[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
				}

				
			$tekst0="";
			$tekst2="Zaświadcza się, że Pan(i):";
			$tekst3="$odbiorca[nazwa], $odbiorca[adres1], $odbiorca[adres2]"; 
			$tekst4=" ";
			$tekst5="dokonał(a) dnia $wpl[data_ksiegowania] wpłaty na kwotę $wpl[kwota] $wpl[waluta].";
			$tekst6="";
			$tekst7="Słownie: $slownie .";
			$tekst9="";
			$tekst10="Forma płatności: $wpl[forma].";
			$tekst11="";		
			$tekst12="Tytuł płatności: $wpl[opis].";
			$tekst13="";		
			
				$poz_h=7;

				$this->PismoNaglowek($pdf, $adresat, "DOWÓD WPŁATY", 110);
				$pdf->SetFont('Tahoma','',10);

				$pdf->SetXY($X,130);
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetFont('Tahoma','B',10);
				$pdf->MultiCell(170,5,"$tekst3",0,C,0);
				$pdf->SetFont('Tahoma','',10);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst5",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);

				$pdf->MultiCell(170,5,"$tekst7",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',10);
				$pdf->MultiCell(170,5,"$tekst10",0,L,0);
				$pdf->MultiCell(170,5,"$tekst11",0,L,0);
				$pdf->MultiCell(160,5,"$tekst12",0,L,0);
				$pdf->MultiCell(160,5,"$tekst13",0,L,0);

				$this->PismoStopka($pdf);
							
				return($pdf);
		}
		
	

	function PojLista(&$pdf, $dbh, $q, $adm)
	{
		$ilp=51;
		
		include "../func/config.php";
		$X="20";
			
				$q="select distinct n.nazwa, u.miasto, u.nazwa, b.numer, s.nr_lok, t.cena, t.vat
				from 
				nazwy n, umowy_abonenckie um, budynki b, ulice u, komputery k, towary_sprzedaz t, nazwy n, adresy_siedzib s 
				where
				n.id_abon=k.id_abon and k.podlaczony='T' and k.fv='T' and k.id_taryfy=t.id_tows and b.id_bud=s.id_bud
				and u.id_ul=b.id_ul  and b.id_adm='$adm' and n.id_abon not in ('ABON1290', 'ABON2506') 
				and n.id_abon=s.id_abon and n.id_abon=um.id_abon and um.status='Obowiązująca'
				and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
				and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'
				order by 
				u.nazwa, b.numer, n.nazwa";
				$q1="select u.miasto, u.nazwa, b.numer from ulice u, budynki b, instytucje i where u.id_ul=b.id_ul and i.id_inst=b.id_adm and i.id_inst='$adm";
				
				
				$poz_h=7;			
				
				$pdf->SetFont('Tahoma','',10);
				$pdf->SetXY($X,130);
							
				$lp=1;
				$suma=0;

				$this->PismoNaglowek($pdf, '','','');
				$pdf->SetXY($X,45);

				$pdf->SetFont('Tahoma','B',10);
				$pdf->MultiCell(170,5,"Wykaz mieszkańców korzystających z usług NETICO S.C.",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);

				$pdf->SetFont('Tahoma','B',8);
				$pdf->Cell(10,4, "Lp.",1,0,'C');
				$pdf->Cell(85,4, "Nazwa abonenta",1,0,'C');
				$pdf->Cell(60,4, "Adres",1,0,'C');
				$pdf->Cell(15,4, "Kwota",1,1,'C');
				
				$pdf->SetFont('Tahoma','',8);
				$sth=Query($dbh,$q);
				while ($row=$sth->fetchRow() )
					{
						$pdf->Cell(10,4, "$lp.",1,0,'C');
						$pdf->Cell(85,4, "$row[0]",1,0,'C');
						$pdf->Cell(60,4, "$row[1], ul. $row[2] $row[3]/$row[4]",1,0,'C');
						// wyliczenie ceny netto
						//$row[5]=$row[5]/(1+$row[6]/100);
						$pdf->Cell(15,4, number_format($row[5], 2,',',''),1,1,'C');
						$lp++;
						$suma+=$row[5];
						
						$k=$lp%$ilp;
						if ( $k==0 )
						{
							$this->PismoStopka($pdf);
							$this->PismoNaglowek($pdf, '','','');
							$pdf->SetXY($X,40);
							$pdf->SetFont('Tahoma','B',8);
							$pdf->Cell(10,4, "Lp.",1,0,'C');
							$pdf->Cell(85,4, "Nazwa abonenta",1,0,'C');
							$pdf->Cell(60,4, "Adres",1,0,'C');
							$pdf->Cell(15,4, "Kwota",1,1,'C');
							$pdf->SetFont('Tahoma','',8);	
						}
				}
				$procent=$suma*5/100;
				$procent=round($procent,2);	
				$pdf->Cell(155,6, "RAZEM zł: ",1,0,'R');
				$pdf->Cell(15,6, number_format($suma, 2,',',''),1,1,'C');
				$pdf->SetFont('Tahoma','B',9);					
				$pdf->Cell(155,6, "Do zapłaty zł: ",1,0,'R');
				$pdf->Cell(15,6, number_format($procent, 2,',',''),1,1,'C');
				$this->PismoStopka($pdf);
											
				return($pdf);
		}	
	
	
	function ListaMSM(&$pdf, $dbh, $od, $do)
	{
		$ilp=51;
		
		include "../func/config.php";
		$X="20";
		//wsp X danych adresowych
		
	$q1="select nazwa, ulica,  nr_bud, nr_lokalu, kod, miasto from instytucje where id_inst='adm009'";

		$sth1=Query($dbh,$q1);
		$row1=$sth1->fetchRow();
		
		
		//$x=new slownie;
		//$slownie=$x->zwroc($wpl[kwota]);
		

		$adres1=$row1[4]." ".$row1[5];
					$adres2="ul. ".$row1[1]." ".$row1[2];
					if (!empty($row1[3]))
					$adres2.="/$row1[3]";

				$adresat=array('nazwa' => $row1[0], 'adres1' => $adres1, 'adres2' => $adres2);
				
				$tekst0="Dotyczy: udostępniania internetu mieszkańcom nieruchomości MSM.";
				$tekst1="Zgodnie z Umową w załączeniu wysyłamy wykaz mieszkańców korzystających z naszych usług internetowych.";
				
			
				$poz_h=7;

				$this->PismoNaglowek($pdf, $adresat,'' ,'');
				
				
				$pdf->SetFont('Tahoma','',10);
				$pdf->SetXY($X,130);
				
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst1",0,L,0);
				$this->PismoStopka($pdf);

					
				$adm="adm009";		
				$this->PojLista($pdf, $dbh, $q, $adm);
				$adm="adm018";
				$this->PojLista($pdf, $dbh, $q, $adm);				
				return($pdf);
		}	
		
	function UmowaAbonencka(&$pdf, $dbh, $nr_um, $customers)
	{
	include "../func/config.php";

	function Tn($f)
	{
		if ( !empty($f))
			$f="Tak";
		else 
			$f="Nie";
		
		return($f);
	}

 	$arr2 = array (

     'R' => array (
       'content' => '{PAGENO}',
       'font-size' => 8,
       'font-style' => 'N',
       'font-family' => 'serif',
       'color'=>'#000000'
     ),
     'line' => 0,
 );
 
	$q3="select u.id_abon, u.data_zaw, u.typ_um, u.status, u.miejsce, u.siedziba, p.nazwa, u.szablon, u.data_zycie from umowy_abonenckie u, pracownicy p 
	where u.id_prac=p.id_prac and u.nr_um='$nr_um' ";
	//WyswietlSql($q3);
	$sth3=Query($dbh,$q3);
	$row3=$sth3->fetchRow();
	
	if ( $row3[5]  == 'T' )
		$siedz="w  siedzibie";
	else 
		$siedz="poza siedzibą";
		
	$um=array
	('nr_um'=>$nr_um, 	'id_abon'=>$row3[0], 	'data_zaw'=>$row3[1], 	'typ_um'		=>$row3[2], 	'status'	=>$row3[3], 	'miejsce'	=>$row3[4], 	
	'siedziba'	=>$siedz, 'pnazwa' => $row3[6], 'szablon' => $row3[7], 'data_zycie' => $row3[8]);
	
	include("$um[szablon]/uma.php");
	include("$um[szablon]/inf.php");
	include("$um[szablon]/deklaracja.php");
	include("$um[szablon]/weksel.php");
	
	$srv=$customers->AbonServices($dbh, $um[id_abon], $um[data_zycie]);
	
	$q1="select a.id_abon, n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, a.pesel_nip, a.nrdow_regon, a.status,  
a.platnosc, a.fv_comiesiac, a.fv_email, a.ksiazeczka, w.numer, 
k.nazwa, k.kod, k.miasto, k.ulica, k.nr_bud, k.nr_mieszk, k.cecha, 
t.telefon, t.tel_kom, tl.telefon, tl.tel_kom, e.email
from 
(((abonenci a left join maile e on a.id_abon=e.id_podm) join nazwy n on a.id_abon=n.id_abon and n.wazne_od <= '$um[data_zaw]' and n.wazne_do >= '$um[data_zaw]')  
left join
(telefony t left join (kontakty k left join telefony tl on k.id_podm=tl.id_podm)  on k.id_podm=t.id_podm and k.wazne_od <= '$um[data_zaw]' and k.wazne_do >='$um[data_zaw]')
on t.id_podm=a.id_abon)
join
((ulice  u join budynki b on u.id_ul=b.id_ul ) join  (adresy_siedzib s join konta_wirtualne w on s.id_abon=w.id_abon) on b.id_bud=s.id_bud and s.wazne_od <= '$um[data_zaw]' and s.wazne_do >= '$um[data_zaw]') on a.id_abon=s.id_abon where 
a.id_abon='$um[id_abon]'";
	
	$sth1=Query($dbh,$q1);
	$row1=$sth1->fetchRow();

	/*
	$q2="select u.miasto, u.nazwa, b.numer, mi.nr_lok, b.id_bud
	     from ulice u, budynki b, miejsca_instalacji mi, komputery k 
	     where u.id_ul=b.id_ul and mi.id_msi=k.id_msi and k.id_abon='$um[id_abon]'";

	$sth2=Query($dbh,$q2);
	$row2=$sth2->fetchRow();
*/

	$adres1=$row1[3]." ".$row1[4];
	$adres2="ul. ".$row1[5]." ".$row1[6];
	if (!empty($row1[7]))
			$adres2.="/$row1[7]";

	if ( !empty($row1[16]) && !empty($row1[17]) )
	{
		$adreskn=$row1[16];
		$adresk1=$row1[17]." ".$row1[18];
		$adresk2="$row1[22] ".$row1[19]." ".$row1[20];
	//	if (!empty($row1[21]))
	//			$adresk2.="/$row1[21]";
	}
	else 
	{
		$adreskn=$row1[2];
		$adresk1=$adres1;
		$adresk2=$adres2;
	}	
		
	if ( $row1[14] == 'T')
		$forma="kiążeczka opłat";
	else
		$forma="przelew";
/*
	$mi="ul. $row2[1] ".$row2[2]." ".$row2[0];
	if (!empty($row2[3]))
			$adresk2.="/$row2[3]";
	*/	
	$abon=array
	('id_abon' 		=>$row1[0],		'symbol'			=>$row1[1],		'nazwa'		=>$row1[2], 	'adres1'				=>$adres1, 	'adres2'	=>$adres2,
		'pesel_nip'	=>$row1[8],		'nrdow_regon'	=>$row1[9],		'status'	=>$row1[10],	 
		'platnosc' 	=>$row1[11],	'fvm'  				=>$row1[12],	'fve'  			=>$row1[13], 	'forma'  			=>$forma,	'konto'		=>$row1[15],
		
		'adreskn'		=>$adreskn,	'adresk1'					=>$adresk1, 	'adresk2'	=>$adresk2,
		'tel'				=>$row1[23],	'kom'					=>$row1[24],	'ktel'		=>$row1[25],
		'kkom'			=>$row1[26], 	'email'		=>$row1[27]
	);
	
	
	$q4="select k.id_komp, t.symbol, t.nazwa, p.aktywny_od from 
	komputery k join 
	(towary_sprzedaz t join pakiety p on p.id_usl=t.id_tows and p.aktywny_od <= '$um[data_zycie]' and p.aktywny_do >='$um[data_zycie]')
	on p.id_urz=k.id_komp and k.id_abon='$um[id_abon]'";
	//		WyswietlSql($q4);
	$kmp=array(	);
	$sth4=Query($dbh,$q4);
	while ($row4=$sth4->fetchRow())
	{
		$q6="select fv from uslugi_dodatkowe where id_usl='$conf[ipzewn]'    and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row4[0]'";
		$q7="select fv from uslugi_dodatkowe where id_usl='$conf[antywirus]' and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row4[0]'";
		
		$sth6=Query($dbh,$q6);
		$row6=$sth6->fetchRow();
		$sth7=Query($dbh,$q7);
		$row7=$sth7->fetchRow();
		
		$f1=Tn($row6[0]);
		$f2=Tn($row7[0]);

		$k=array('id_komp'=>$row4[0], 'symbol' => $row4[1], 'nazwa' => $row4[2], 'aktywny_od'=> $row4[3], 'ipzewn' => $f1, 'antywirus' => $f2);
		array_push($kmp, $k);		
	}
	//print_r($kmp);

	
	$q9="select c.id_cpe, c.producent, c.typ, c.mac, c.data_aktywacji, t.symbol, t.nazwa, p.aktywny_od
					from 
					(cpe c left join (pakiety p join towary_sprzedaz t on p.id_usl=t.id_tows  and  p.aktywny_od <= '$um[data_zycie]' and p.aktywny_do >= '$um[data_zycie]') on p.id_urz=c.id_cpe)
					left join 
					(inst_vlanu iv join komputery k on k.id_ivn=iv.id_ivn )
					on iv.id_wzl=c.id_cpe where k.id_abon='$um[id_abon]'";
	
	//WyswietlSql($q9);
	$cpe=array(	);
	$sth9=Query($dbh,$q9);
	while ($row9=$sth9->fetchRow())
	{	
		$c=array(
		'id_cpe' 	=> $row9[0], 'producent'						=>$row9[1], 	'typ'	=>$row9[2],			'mac'	=>	$row9[3], 
		'data_aktywacji'	=>$row9[4],	'symbol'	=>$row9[5],	'nazwa'	=>$row9[6],	'aktywny_od'	=>$row9[7]
		);

		array_push($cpe, $c);		
	}
	//print_r($cpe);
	
	
	$q10="select tl.id_tlv, tl.numer, tl.data_aktywacji, t.symbol, t.nazwa, p.aktywny_od 
	from  telefony_voip tl join 
	(towary_sprzedaz t join pakiety p on p.id_usl=t.id_tows and p.aktywny_od <= '$um[data_zycie]' and p.aktywny_do >='$um[data_zycie]')
	on p.id_urz=tl.id_tlv and tl.id_abon='$um[id_abon]'";
	
	//	WyswietlSql($q10);
	$tlv=array(	);
	$sth10=Query($dbh,$q10);
	while ($row10=$sth10->fetchRow())
	{	
		$t=array(
		'id_tlv' 	=> $row10[0], 'numer'			=>$row10[1], 	'data_aktywacji'	=>$row10[2],			'symbol'	=>	$row10[3], 
		'nazwa'	=>$row10[4],	'aktywny_od'	=>$row10[5]);

		array_push($tlv, $t);		
	}
	//print_r($tlv);
	
	$q11="select b.id_bmk, b.producent, b.model, b.nr_seryjny, b.mac from 
	bramki_voip b join telefony_voip t on t.id_bmk=b.id_bmk
	 and t.id_abon='$um[id_abon]'";
	
//	WyswietlSql($q11);
	
	$bmk=array(	);
	$sth11=Query($dbh,$q11);
	while ($row11=$sth11->fetchRow())
	{	
		$b=array(
		'id_bmk' 	=> $row11[0], 'producent'						=>$row11[1], 	'model'	=>$row11[2],			'nr_seryjny'	=>	$row11[3], 
		'mac'	=>$row11[4]);

		array_push($bmk, $b);		
	}
//	print_r($bmk);
	
	
	$q12="select s.id_stb, s.typ, s.mac, s.sn, s.data_aktywacji, s.pin, t.nazwa, t.symbol, p.aktywny_od
				from 
				(settopboxy s join belong b on b.id_urz=s.id_stb and b.nalezy_od <= '$um[data_zycie]' and b.nalezy_do >='$um[data_zycie]')
				join 
				(towary_sprzedaz t join pakiety p on p.id_usl=t.id_tows and p.aktywny_od <= '$um[data_zycie]' and p.aktywny_do >='$um[data_zycie]')
	on p.id_urz=s.id_stb and b.id_abon='$um[id_abon]'";
	
	
	$stb=array(	);
	$sth12=Query($dbh,$q12);
	while ($row12=$sth12->fetchRow())
	{		
		$q13="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv1]'  and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row12[0]'";
		$row13=Query2($q13, $dbh);

		$q14="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv2]'  and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row12[0]'";
		$row14=Query2($q14, $dbh);

		$q15="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv3]'  and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row12[0]'";
		$row15=Query2($q15, $dbh);

		$q16="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv5]'  and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row12[0]'";
		$row16=Query2($q16, $dbh);
		
		$q17="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv6]'  and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row12[0]'";
		$row17=Query2($q17, $dbh);

		$s=array(
		'id_stb' 	=> $row12[0], 	  'typ'		  => $row12[1],    'mac'							=> $row12[2],     'aktywny_od'							=> $row12[8], 
		'sn'			=> $row12[3],			'data_aktywacji' 	=>$row12[4], 'pin' => $row12[5],
		'nazwa' 					=> $row12[6],'symbol' 					=> $row12[7],
		'addsrv1' => Tn($row13[0]), 'addsrv2' => Tn($row14[0]), 'addsrv3' => Tn($row15[0]), 'addsrv5' => Tn($row16[0]), 'addsrv6' => Tn($row17[0])
		);
		array_push($stb, $s);		

	}
	//print_r($stb);

/*
	$q20="select s.id_sim, s.sn, s.pin, s.puk, s.number, s.night_rate, t.nazwa, t.symbol, p.aktywny_od
				from 
				(settopboxy s join belong b on b.id_urz=s.id_stb and b.nalezy_od <= '$um[data_zycie]' and b.nalezy_do >='$um[data_zycie]')
				join 
				(towary_sprzedaz t join pakiety p on p.id_usl=t.id_tows and p.aktywny_od <= '$um[data_zycie]' and p.aktywny_do >='$um[data_zycie]')
	on p.id_urz=s.id_stb and b.id_abon='$um[id_abon]'";
	
	
	$stb=array(	);
	$sth20=Query($dbh,$q20);
	while ($row20=$sth20->fetchRow())
	{		
		$q21="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv1]'  and aktywna_od<= '$um[data_zycie]' and aktywna_do>= '$um[data_zycie]' and id_urz='$row20[0]'";
		$row21=Query2($q21, $dbh);

		$s=array(
		'id_stb' 	=> $row12[0], 	  'typ'		  => $row12[1],    'mac'							=> $row12[2],     'aktywny_od'							=> $row12[8], 
		'sn'			=> $row12[3],			'data_aktywacji' 	=>$row12[4], 'pin' => $row12[5],
		'nazwa' 					=> $row12[6],'symbol' 					=> $row12[7],
		'addsrv1' => Tn($row13[0]), 'addsrv2' => Tn($row14[0]), 'addsrv3' => Tn($row15[0]), 'addsrv5' => Tn($row16[0]), 'addsrv6' => Tn($row17[0])
		);
		array_push($stb, $s);		

	}
	//print_r($stb);
	*/
	
	$tresc=Uma($abon, $um, $kmp, $tlv, $bmk, $stb, $cpe);
	$tresc1=Inf($abon, $um, $kmp, $tlv, $stb, $srv );
	$tresc2=Deklaracja($abon, $um);
	$tresc3=Weksel($abon, $um);
	include('/usr/share/php/mpdf/mpdf.php');
	$mpdf=new mPDF('utf-8','A4','8','', '15', '15', '20', '15', '4', '8');
	$stylesheet = file_get_contents('../css/uma.css'); 
	$mpdf->WriteHTML($stylesheet,1); 
	$mpdf->SetHTMLHeader("<img src=\"../data/FakturaLogo.jpg\" width=\"180\" height=\"40\"/>"); 
	$mpdf->SetFooter($arr2, 'O');

	$mpdf->WriteHTML($tresc);
	$mpdf->AddPage('P','','1');
	$mpdf->WriteHTML($tresc1);
	if ( !empty ($stb) || !empty ($cpe) || !empty ($bmk) )
		{
			$mpdf->AddPage('P','','1');
			$mpdf->WriteHTML($tresc2);
		}

	$mpdf->AddPage('P','','1');
	$mpdf->WriteHTML($tresc);
	$mpdf->AddPage('P','','1');
	$mpdf->WriteHTML($tresc1);
	
	
	if ( !empty ($stb))
		{
			$mpdf->AddPage('P','','1');
			$mpdf->WriteHTML($tresc2);			
			$mpdf->AddPage('P','','1');
			$mpdf->WriteHTML($tresc);
			$mpdf->AddPage('P','','1');
			$mpdf->WriteHTML($tresc1);
			$mpdf->AddPage('P','','1');
			$mpdf->WriteHTML($tresc2);
		}
		
	if ( !empty ($stb) || !empty ($cpe) || !empty ($bmk) )
		{
			$mpdf->AddPage('P','','1');
			$mpdf->WriteHTML($tresc3);
		}

	$mpdf->Output();
	}	

	
	function PismoWychodzace(&$pdf, $dbh, $id_psw)
	{
		include "../func/config.php";
		include "pdftxt.php";

		$X="20";
		//wsp X danych adresowych
		
			$q="select  pw.id_psw, pw.data, pw.dotyczy, pw.tres, pw.autor, a.id_odb
					a.nazwa, u.nazwa, b.numer, a.nr_mieszk, u.miasto, u.kod, 
					k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto
				 
					from ((pisma_wych pw  full join abonenci a on u.id_abon=a.id_abon) full 
					join kontakty k on k.id_podm=um.id_abon) join ( (budynki b join ulice u on b.id_ul=u.id_ul) 
					join abonenci a on a.id_bud=b.id_bud) where pw.id_psw='$id_psw'";
		

		
			
	/*
			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
		
			$psw=array
				(
					'nr_uma'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> number_format(-$row[3], 2, ',',''),	
					'um_numer'	=> $row[4],		'data_zycie'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	 
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18]
				);
				
					if ( !empty($psw[k_nazwa]) && !empty($psw[k_ulica]) && !empty($psw[k_nr_bud]) && !empty($psw[k_miasto])  )
				{						
					$psw[nazwa]=$psw[k_nazwa];
					$adres1=$psw[k_kod]." ".$psw[k_miasto];
					$adres2="ul. ".$psw[k_ulica]." ".$psw[k_nr_bud];
					if (!empty($psw[k_nr_mieszk]))
					$adres2.="/$psw[k_nr_mieszk]";
				}
		else
				{
					$adres1=$psw[kod]." ".$psw[miasto];
					$adres2="ul. ".$psw[ulica]." ".$psw[nr_bud];
					if (!empty($psw[nr_mieszk]))
					$adres2.="/$psw[nr_mieszk]";
				}
						

			$adresat=array('nazwa' => $psw[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
				
			//$psw[saldo]=-$psw[saldo];
	*/		

				$poz_h=7;

				$this->PismoNaglowek($pdf, $adresat, "WEZWANIE DO ZAPŁATY");

				$pdf->SetFont('Tahoma','',10);

				$pdf->SetXY($X,120);
				
				return($pdf);
		}	
		
		
	function RaportZadluzenia(&$pdf, $dbh, $od, $do)
	{

		include "../func/config.php";
		// ilosc pozycji na stronie
		$ilp=15;
		$W=9;
		
		$data_do=explode("-", $do);
		$m=$data_do[1];
		$rb=$data_do[0];
		$rp=$rb-1;

		$mies=array( 
		"$rb-01"=>1, "$rb-02"=>2, "$rb-03"=>3, "$rb-04"=>4, "$rb-05"=>5, "$rb-06"=>6, 
		"$rb-07"=>7, "$rb-08"=>8, "$rb-09"=>9, "$rb-10"=>10, "$rb-11"=>11, "$rb-12"=>12, 
		"$rp-12"=>0, "$rp-11"=>-1, "$rp-10"=>-2, "$rp-09"=>-3, "$rp-08"-4, "$rp-07"=>-5, 
		"$rp-06"=>-6,"$rp-05"=>-7, "$rp-04"=>-8, "$rp-03"=>-9, "$rp-02"=>-10, "$rp-01"=>-11 );

			
		$q="select s.id_spw, w.id_wnd, a.id_abon, a.symbol, a.nazwa, a.saldo, w.krok, um.data_zaw, um.platnosc, t.symbol, t.cena, a.nr_mieszk, u.nazwa, u.miasto, u.kod, b.numer
			from abonenci a, sprawy_windykacyjne s, windykowanie w, ulice u, budynki b, umowy_abonenckie um, towary_sprzedaz t, komputery k
			where s.id_abon=a.id_abon  and w.id_spw=s.id_spw  and a.id_bud=b.id_bud and um.id_abon=a.id_abon and k.podlaczony='T' and k.fv='T'
			and t.id_tows=k.id_taryfy and k.id_abon=a.id_abon and u.id_ul=b.id_ul and w.data_zak is null and s.data_zgl between '$od' and '$do' order by a.nazwa";

		$LP_W=7;
		$NRD_W=60;
		$MW_W=26;
		$DW_W=13;
		$TP_W=15;
		$N_W=20;
		$NIP_W=12;
		$WSN_W=30;
		$WSN_B=30;
		$PV_W=20;

		$ML=10;
		$MT=30;
		

		$lp=1;
		$razem_n=$razem_v=$razem_b=0;

		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
		{
			if ( $lp%$ilp == 1)
			{

				$pdf->SetMargins($ML,10,15);                                        
				$this->PismoPoziomNaglowek($pdf, "RAPORT O ZADŁUŻENIACH", $data);
				
				$pdf->SetFont('Tahoma','',8);
				$NrStr=$pdf->PageNo();
				$pdf->Text(145, 205,"Strona $NrStr",1,0,'C');

				$pdf->SetXY($ML, $MT);

				$pdf->SetFont('Tahoma','B',7);
			//	$pdf->SetFillColor(5,5,5);
				$pdf->Cell($LP_W,  $W,'Lp',1,0,'C');
				$pdf->Cell($NRD_W, $W,'Dane dłużnika',1,0,'C');
				$pdf->Cell($MW_W,  $W, '',1,0,'C');
				$pdf->Cell($DW_W,  $W,'',1,0,'C');
				$pdf->Cell($TP_W,  $W,'',1,0,'C');
				//$pdf->MultiCell($TP_W,3,'Termin płatności',0,C,0);
							
				//$pdf->Cell($N_W,   $W,'Nabywca',1,0,'C');
				$pdf->Cell($NIP_W,   $W,'Krok',1,0,'C');
							
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
					
				$y=$MT+0.5;

				$pdf->SetXY($ML+$LP_W+$NRD_W-1, $y);
				$pdf->MultiCell(20,3,'Saldo',0,C,0);

				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W, $y);
				$pdf->MultiCell($DW_W,3,'Pakiet Cena',0,C,0);

				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W, $y);
				$pdf->MultiCell($TP_W,3,'Płatność Umowa',0,C,0);
				

				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W, $y);						
				$pdf->MultiCell($WSN_W,3,'',0,C,0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W, $y);
				$pdf->MultiCell($PV_W,3,'', 0, C, 0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W+$PV_W, $y);
				$pdf->MultiCell($WSN_B,3,'',0,C,0);
			}
				$dluznik=array
				(
					'id_abon' 		=> $row[2],		'nazwa'		=> substr($row[4],0,40), 	'saldo'			=> $row[5],	'data_zaw'	=> $row[7], 
					'platnosc'		=> $row[8],		'pakiet'	=> $row[9],		'cena'			=> $row[10], 
					'ulica'				=> $row[12],	'nr_bud'	=> $row[15],	'nr_mieszk'	=> $row[11],
					'miasto'			=> $row[13],	'kod'			=> $row[14], 	'krok' 			=> $row[6]
				);
				
			$il=floor(-$dluznik[saldo]/$dluznik[cena]);
			$reszta=-$dluznik[saldo]-$il*$dluznik[cena];
			$wyliczenie="$il X $dluznik[cena] + $reszta";
			
			$adres=$dluznik[kod]." ".$dluznik[miasto].", ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
			if (!empty($dluznik[nr_mieszk]))
			$adres.="/$dluznik[nr_mieszk]";
			
			$pdf->Ln();
			$pdf->SetFont('Tahoma','',7);

			$k=$lp%$ilp;
			if ($k==0) $k=$ilp;
			$Y=$MT+$k*$W;
			$y=$Y+1;
			
			$pdf->SetXY($ML, $Y);
			$pdf->Cell($LP_W,$W, "$lp.", 1,0,'C');
			
			$pdf->Cell($NRD_W,$W, '',1,0,'C');		
			$pdf->Text($ML+$LP_W+2,$y+2,"$dluznik[nazwa]");
			$pdf->Text($ML+$LP_W+2,$y+5,$adres);
			
			$pdf->Cell($MW_W,$W, "", 1,0,'C');

			$pdf->Text($ML+$LP_W+$NRD_W+2,$y+2,"$dluznik[saldo]");
			$pdf->Text($ML+$LP_W+$NRD_W+2,$y+5,$wyliczenie);
			
			$pdf->Cell($DW_W,$W, '',1,0,'C');
			$pdf->Cell($TP_W,$W, "",1,0,'C');
			
			$pdf->Cell($NIP_W,$W, "$dluznik[krok]",1,0,'C');					
			
			
				$data_do=explode("-", $do);
				$m=$data_do[1];

				$q2=" select w.kwota, w.id_wpl, w.data_ksiegowania, w.opis 
				from wplaty w
				where w.rozliczona='T' and w.id_kontrah='$row[2]' and w.data_ksiegowania>='2007-10-01'";

				$sth2=Query($dbh,$q2);

				$start=$data_do[1]-12;
				//$start=1;
				$l=$start;
					
				//echo date(do;
				$wpl="";
				$fz=1;
	/*
				while ($row2 =$sth2->fetchRow())
					{
						$fz=1;
						$mw=explode("-",$row2[2]);
						if ( $l==$mies["$mw[0]-$mw[1]"] )
							{
								if ($fz==0) 
									{
										echo "</td>";
										$fz=1;
									}
							
								echo "<td class=\"klasa4\">$row2[0] ";
							}
						else if ( $l<$mies["$mw[0]-$mw[1]"])
								{
									while ( $l<$mies["$mw[0]-$mw[1]"])
										{
											if ($fz==0) 
												{
													echo "</td>";
													$fz=1;
												}
											if( $row[7] < "$mw[0]-$mw[1]-01" )
													echo "<td class=\"klasa4\"> 0 </td>";
											else
													echo "<td class=\"klasa4\"> X </td>";										
											$l++;
										} 
									echo "<td class=\"klasa4\"> $row2[0]";
									$fz=0;
								}
						else if (  $l > $mies["$mw[0]-$mw[1]"]  )
								{
									$l--;
									echo "<br>$row2[0]";
									$fz=0;
								}
						$l++;
					}
					while ($l<$m)
								{
									echo "<td class=\"klasa4\">0 </td>";
									$l++;
								} 
						
	*/
		
				$i=0;
				while ($row2 =$sth2->fetchRow())
					{
						$mw=explode("-",$row2[2]);
						if ( $l==$mies["$mw[0]-$mw[1]"] )
							{
								$wplaty[0][$l]=$row2[0];
							}
						else if ( $l<$mies["$mw[0]-$mw[1]"] )
								{
								while ( $l<$mies["$mw[0]-$mw[1]"] )
									{
										$wplaty[0][$l]=0;
										$l++;
									} 
								}
						else if ( $l > $mies["$mw[0]-$mw[1]"]  )
								{
									$l--;
									$wplaty[$i][$l]=$row2[0];
									++$i;
								}
					$l++;
					}
		while ($l<$m)
						{
							$wplaty[0][$l]=$row2[0];
							$l++;
						} 
						
	 
				for ( $i=0; $i<12; ++$i)
					{
							 $wpl=0;
						for ( $j=0; $j<10; ++$j)
							$wpl+=$wplaty[$i][$j];
						$pdf->Cell($NIP_W, $W,"$wpl",1,0,'C');
					}
	/*						
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
				$pdf->Cell($NIP_W, $W,'',1,0,'C');
	*/
			//$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W, $y);

			//$pdf->MultiCell($DW_W,3,"$dluznik[pakiet]   $dluznik[cena] zł" ,0,C,0);
	//		$pdf->Cell($DW_W,$W, "", 1,0,'C');

			$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+2,$y+2,"$dluznik[pakiet]");
			$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+2,$y+5,$dluznik[cena]);

			
			$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W, $y);
			$pdf->MultiCell($TP_W,3,"$dluznik[platnosc]   $dluznik[data_zaw]" ,0,C,0);

			//$pdf->Cell($N_W,$W, "$dluznik[krok]", 1,0,'C');

			//$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+5,$y+2,"$dluznik[nazwa]");
			//$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+5,$y+5,$adres);

		++$lp;

		
			
			}

		return($pdf);
		}



	function Pisma(&$pdf, $dbh)
	{
		include "../func/config.php";
		
		$order=' order by n.nazwa';

		$q="select  distinct n.nazwa, u.nazwa, b.numer, s.nr_lok, u.miasto, u.kod, 
					n.id_abon, um.nr_um, k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, a.haslo, u.cecha, k.cecha 
					
					from (( umowy_abonenckie um full join kontakty k on k.id_podm=um.id_abon) join abonenci a on a.id_abon=um.id_abon)
					join ( (budynki b join ulice u on b.id_ul=u.id_ul) join (nazwy n join adresy_siedzib s on n.id_abon=s.id_abon)  on s.id_bud=b.id_bud ) 
					on um.id_abon=n.id_abon 
					
					where n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]' 
					and s.wazne_od <= '$conf[data]' and s.wazne_do >= '$conf[data]' 
					and um.status='Obowiązująca' and a.fv_comiesiac='N' and a.fv_email='N'";
					
		$q.=$order;
		
		set_time_limit(600);                                                                        
		$sth=Query($dbh,$q);

		while ( $row=$sth->fetchRow() )
			{
				$psm=array
				(
					'nazwa'			=> $row[0],		'ulica'			=> $row[1],	 'nr_bud'			=> $row[2],		'nr_mieszk'		=> $row[3],
					'miasto'		=> $row[4],		'kod'				=> $row[5], 'id_abon' 		=> $row[6],		'konto'				=> $row[7],
					'k_nazwa' 	=> $row[8],		'k_ulica' 	=> $row[9], 'k_nr_bud'	 	=> $row[10], 	'k_nr_mieszk' => $row[11],
					'k_kod'			=> $row[12],	'k_miasto'	=> $row[13],	'haslo'	=> $row[14],
					'cecha'			=> $row[15],	'k_cecha'			=> $row[16]
				);

		
		$poz_h=7;
		$y1=25;
		$x1=20;
		$y2=46;
			
		if ( !empty($psm[k_nazwa]) && !empty($psm[k_ulica]) && !empty($psm[k_nr_bud]) && !empty($psm[k_miasto])  )
				{						
					$psm[nazwa]=$psm[k_nazwa];
					$adres1=$psm[k_kod]." ".$psm[k_miasto];
					$adres2="$psm[k_cecha] ".$psm[k_ulica]." ".$psm[k_nr_bud];
					if (!empty($psm[k_nr_mieszk]))
					$adres2.="/$psm[k_nr_mieszk]";
				}
		else
				{
					$adres1=$psm[kod]." ".$psm[miasto];
					$adres2="$psm[cecha] ".$psm[ulica]." ".$psm[nr_bud];
					if (!empty($psm[nr_mieszk]))
					$adres2.="/$psm[nr_mieszk]";
				}

				include "pismo2012.php";
					
				$id=substr($psm[id_abon], 4);
				$id='0'.$id;
				
				$pismo[tekst5]=str_replace('user', $id, $pismo[tekst5]);
				$pismo[tekst5]=str_replace('password', "$psm[haslo]", $pismo[tekst5]);
				
				$adresat=array('nazwa' => $psm[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
		
				//$pdf->AddPage();
				$pdf->SetMargins(20,15,20);
				$this->PismoNaglowek($pdf, $adresat);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(0,0,255);
				$pdf->SetXY($x1,90);
				$pdf->MultiCell(170,5,"$pismo[tekst0]",0,L,0);
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$pismo[tekst1]",0,L,0);
				$pdf->MultiCell(170,5,"$pismo[tekst2]",0,L,0);
				$pdf->MultiCell(170,5,"$pismo[tekst3]",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
			//	$pdf->MultiCell(170,5,"$pismo[tekst4]",0,L,0);
				$pdf->SetFont('Tahoma','',9);				
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$pismo[tekst5]",0,L,0);
				$pdf->MultiCell(170,5,"$pismo[tekst6]",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
				$pdf->MultiCell(170,5,"$pismo[tekst7]",0,L,0);
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$pismo[tekst8]",0,L,0);
				$pdf->MultiCell(170,5,"$pismo[tekst9]",0,L,0);
			
			$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
				$pdf->MultiCell(170,5,"$pismo[tekst10]",0,L,0);
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$pismo[tekst11]",0,L,0);
				$pdf->MultiCell(170,5,"$pismo[tekst12]",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
				$pdf->MultiCell(170,5,"$pismo[tekst13]",0,L,0);
				$pdf->SetFont('Tahoma','',9);				
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$pismo[tekst14]",0,L,0);
				$pdf->MultiCell(170,5,"$pismo[tekst15]",0,L,0);
				$pdf->MultiCell(170,5,"$pismo[tekst16]",0,L,0);
		
				/*$pdf->AddPage();
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($x1,25);*/
				$pdf->MultiCell(160,5,"$pismo[tekst29]",0,R,0);
				$pdf->MultiCell(160,5,"$pismo[tekst30]",0,R,0);
				$pdf->MultiCell(160,5,"$pismo[tekst31]",0,R,0);
			}
				return($pdf);
	}
	

	function VoipBiling(&$pdf, $dbh, $od, $do, $abon, &$voip, $file="../func/config.php")
	{
		include $file;
		$idk=explode(" ", $abon);
		$ida=array_pop($idk);

		$q="select p.data, n.nazwa, n.symbol, n.id_abon, p.nr_zrodlowy, p.nr_docelowy, p.oplata, p.czas_polaczenia, p.rodzaj_polaczenia, p.vat
						from polaczenia_voip p, nazwy n, telefony_voip t
						where 
						n.wazne_od <= '$do' and n.wazne_do >='$do'
						and t.id_abon=n.id_abon and p.nr_zrodlowy=t.numer and  p.data>='$od 00:00:00' and p.data <= '$do 24:00:00'";

		if (!empty($abon) && $abon !=$conf[select])   		
				$q.="	and n.id_abon='$ida'";						
						
			$q.=" order by p.nr_zrodlowy, p.data";

//		echo "$q <br>";
		$lp=1;
		$oplata=0;
		$czas=0;
		
		$W=5;
		$LP_W=10;
		$NRD_W=30;
		$MW_W=22;
		$DW_W=25;
		$TP_W=15;
		$N_W=23;
		$NIP_W=23;


		$ML=20;
		$MT=55;
		$ilp=40;

		$lp=1;
		
		$komorki=array(
		"Lp"		=> $LP_W,		"Data"	=> $NRD_W,		"Nr źródłowy"	=> $MW_W,    "Nr docelowy"	=> $MW_W,
		"Typ połączenia"		=> $DW_W, 	"Czas"	=> $TP_W,		"Kwota netto zł" => $N_W,	"Kwota brutto zł" => $NIP_W  
		);

		$polaczenia=array
		(
			"miedzymiastowe"=>array( "oplata" => 0, "czas" => 0),
			"miedzynarodowe"=>array( "oplata" => 0, "czas" => 0),
					 "komorkowe"=>array( "oplata" => 0, "czas" => 0),
						 "lokalne"=>array( "oplata" => 0, "czas" => 0),
					 "specjalne"=>array( "oplata" => 0, "czas" => 0),
							 "razem"=>array( "oplata" => 0, "czas" => 0)
		);
		
						 
		
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
		{

			if ( $lp%$ilp == 1)
			{
				if ( $lp == 1 )
					$this->PismoNaglowek($pdf, NULL, "BILING", 35, $file);
				else
					$this->PismoNaglowek($pdf, NULL, NULL, NULL,  $file);
									
				$pdf->SetXY($ML, $MT);

				$pdf->SetFont('Tahoma','B',7);
			//	$pdf->SetFillColor(5,5,5);
				foreach ( $komorki as $nazwa => $dlugosc )
				{
					$pdf->Cell($dlugosc,  $W,"$nazwa",1,0,'C');				
				}
			}
			
		$vb=array(
			'data'				=> $row[0], 	'nazwa'		=> $row[1],	'symbol'	=> $row[2], 'id_abon'		=>	$row[3],	
			'nr_zrodlowy'	=> $row[4],		'nr_docelowy'	=> $row[5],	'oplata'			=> $row[6],	'czas'		=> $row[7],
			'rodzaj_polaczenia'			=> $row[8], 'vat' => $row[9]	);
				
			switch ($vb[rodzaj_polaczenia])
			{
				case "Międzymiastowe":
					$polaczenia[miedzymiastowe][oplata]+=$vb[oplata];
					$polaczenia[miedzymiastowe][czas]+=$vb[czas];
					break;
				case "Międzynarodowe":
					$polaczenia[miedzynarodowe][oplata]+=$vb[oplata];
					$polaczenia[miedzynarodowe][czas]+=$vb[czas];
					break;
				case "Komórkowe":
					$polaczenia[komorkowe][oplata]+=$vb[oplata];
					$polaczenia[komorkowe][czas]+=$vb[czas];
					break;
				case "Lokalne":
					$polaczenia[lokalne][oplata]+=$vb[oplata];
					$polaczenia[lokalne][czas]+=$vb[czas];
					break;
				case "Specjalne":
					$polaczenia[specjalne][oplata]+=$vb[oplata];
					$polaczenia[specjalne][czas]+=$vb[czas];
					break;
			}

			$polaczenia[razem][oplata]+=$vb[oplata];
			$polaczenia[razem][czas]+=$vb[czas];
			
			$pdf->Ln();
			$pdf->SetFont('Tahoma','',7);

			$k=$lp%$ilp;
			if ($k==0) $k=$ilp;
			$Y=$MT+$k*$W;
			$pdf->SetXY($ML, $Y);
			$pdf->Cell($LP_W,$W, "$lp.", 1,0,'C');
			$pdf->Cell($NRD_W,$W, "$vb[data]", 1,0,'C');
			$pdf->Cell($MW_W,$W, "$vb[nr_zrodlowy]", 1,0,'C');
			$pdf->Cell($MW_W,$W, "$vb[nr_docelowy]", 1,0,'C');
			$pdf->Cell($DW_W,$W, "$vb[rodzaj_polaczenia]",1,0,'C');
			$pdf->Cell($TP_W,$W, "$vb[czas]",1,0,'C');
						
			$kwota_netto=number_format(round($vb[oplata]/(1+$vb[vat]/100), 2), 2, ',','');			
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');

			$vb[oplata]=number_format(round($vb[oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, "$vb[oplata]",1,0,'C');
									
		++$lp;
			if ( $lp%$ilp == 0)
			{
				$this->PismoStopka($pdf, 1, $file);
			}

		}

			if ( $lp%$ilp < 8 )
			{
					$this->PismoNaglowek($pdf, NULL, NULL, NULL,  $file);
				$pdf->SetXY($ML, $MT);
			}	
				
			$pdf->Ln();
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W ,$W, "", 0,0,'R');
			$pdf->Ln();
			$pdf->SetFont('Tahoma','B',7);
			foreach ( $komorki as $nazwa => $dlugosc )
				{
					$pdf->Cell($dlugosc,  $W,"$nazwa",1,0,'C');				
				}
			$pdf->SetFont('Tahoma','',7);				
			$pdf->Ln();
			$polaczenia[miedzymiastowe][czas]=$voip->Minutes($polaczenia[miedzymiastowe][czas]);
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem międzymiastowe:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[miedzymiastowe][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[miedzymiastowe][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[miedzymiastowe][oplata]=number_format(round($polaczenia[miedzymiastowe][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[miedzymiastowe][oplata],1,0,'C');
			
			$pdf->Ln();
			$polaczenia[miedzynarodowe][czas]=$voip->Minutes($polaczenia[miedzynarodowe][czas]);
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem międzynarodowe:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[miedzynarodowe][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[miedzynarodowe][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[miedzynarodowe][oplata]=number_format(round($polaczenia[miedzynarodowe][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[miedzynarodowe][oplata],1,0,'C');
			
			
			$pdf->Ln();
			$polaczenia[komorkowe][czas]=$voip->Minutes($polaczenia[komorkowe][czas]);
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem komórkowe:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[komorkowe][czas],1,0,'C');
			$kwota_netto=round($polaczenia[komorkowe][oplata]/(1+$vb[vat]/100), 2);				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[komorkowe][oplata]=number_format(round($polaczenia[komorkowe][oplata],2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[komorkowe][oplata],1,0,'C');
			
			$pdf->Ln();
			$polaczenia[lokalne][czas]=$voip->Minutes($polaczenia[lokalne][czas]);
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem lokalne:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[lokalne][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[lokalne][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[lokalne][oplata]=number_format(round($polaczenia[lokalne][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[lokalne][oplata],1,0,'C');
			
			$pdf->Ln();
			$polaczenia[specjalne][czas]=$voip->Minutes($polaczenia[specjalne][czas]);
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem specjalne:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[specjalne][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[specjalne][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[specjalne][oplata]=number_format(round($polaczenia[specjalne][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[specjalne][oplata],1,0,'C');
			
			$pdf->Ln();
			$polaczenia[razem][czas]=$voip->Minutes($polaczenia[razem][czas]);
			$pdf->SetFont('Tahoma','B',8);
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W+1, "Wszystkie połączenia:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W+1, $polaczenia[razem][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[razem][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W+1, "$kwota_netto",1,0,'C');
			$polaczenia[razem][oplata]=number_format(round($polaczenia[razem][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W+1, $polaczenia[razem][oplata],1,0,'C');
	
		$this->PismoStopka($pdf, 1, $file);
	}
	
	function Code39($x, $y, $code, $ext = true, $cks = false, $w = 0.32, $h = 8, $wide = true) 
	{

			//Display code
			$this->SetFont('Arial', '', 10);
			$this->Text($x, $y+$h+4, $code);

			if($ext)
			{
					//Extended encoding
					$code = $this->encode_code39_ext($code);
			}
			else
			{
					//Convert to upper case
					$code = strtoupper($code);
					//Check validity
					if(!preg_match('|^[0-9A-Z. $/+%-]*$|', $code))
							$this->Error('Invalid barcode value: '.$code);
			}

			//Compute checksum
			if ($cks)
					$code .= $this->checksum_code39($code);

			//Add start and stop characters
			$code = '*'.$code.'*';

			//Conversion tables
			$narrow_encoding = array (
					'0' => '101001101101', '1' => '110100101011', '2' => '101100101011',
					'3' => '110110010101', '4' => '101001101011', '5' => '110100110101',
					'6' => '101100110101', '7' => '101001011011', '8' => '110100101101',
					'9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011',
					'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101',
					'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101',
					'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011',
					'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011',
					'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011',
					'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001',
					'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101',
					'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101',
					'-' => '100101011011', '.' => '110010101101', ' ' => '100110101101',
					'*' => '100101101101', '$' => '100100100101', '/' => '100100101001',
					'+' => '100101001001', '%' => '101001001001' );

			$wide_encoding = array (
					'0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111',
					'3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101',
					'6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101',
					'9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111',
					'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101',
					'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101',
					'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111',
					'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111',
					'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111',
					'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001',
					'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101',
					'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101',
					'-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101',
					'*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001',
					'+' => '100010100010001', '%' => '101000100010001');

			$encoding = $wide ? $wide_encoding : $narrow_encoding;

			//Inter-character spacing
			$gap = ($w > 0.29) ? '00' : '0';

			//Convert to bars
			$encode = '';
			for ($i = 0; $i< strlen($code); $i++)
					$encode .= $encoding[$code{$i}].$gap;

			//Draw bars
			$this->draw_code39($encode, $x, $y, $w, $h);
	}

	function checksum_code39($code) 
	{

			//Compute the modulo 43 checksum

			$chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
															'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
															'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',
															'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
			$sum = 0;
			for ($i=0 ; $i<strlen($code); $i++) {
					$a = array_keys($chars, $code{$i});
					$sum += $a[0];
			}
			$r = $sum % 43;
			return $chars[$r];
	}

	function encode_code39_ext($code) 
	{

			//Encode characters in extended mode

			$encode = array(
					chr(0) => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C',
					chr(4) => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G',
					chr(8) => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => 'LK',
					chr(12) => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O',
					chr(16) => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S',
					chr(20) => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W',
					chr(24) => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A',
					chr(28) => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E',
					chr(32) => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C',
					chr(36) => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G',
					chr(40) => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K',
					chr(44) => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O',
					chr(48) => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3',
					chr(52) => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7',
					chr(56) => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F',
					chr(60) => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J',
					chr(64) => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C',
					chr(68) => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G',
					chr(72) => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K',
					chr(76) => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O',
					chr(80) => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S',
					chr(84) => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W',
					chr(88) => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K',
					chr(92) => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O',
					chr(96) => '%W', chr(97) => '+A', chr(98) => '+B', chr(99) => '+C',
					chr(100) => '+D', chr(101) => '+E', chr(102) => '+F', chr(103) => '+G',
					chr(104) => '+H', chr(105) => '+I', chr(106) => '+J', chr(107) => '+K',
					chr(108) => '+L', chr(109) => '+M', chr(110) => '+N', chr(111) => '+O',
					chr(112) => '+P', chr(113) => '+Q', chr(114) => '+R', chr(115) => '+S',
					chr(116) => '+T', chr(117) => '+U', chr(118) => '+V', chr(119) => '+W',
					chr(120) => '+X', chr(121) => '+Y', chr(122) => '+Z', chr(123) => '%P',
					chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

			$code_ext = '';
			for ($i = 0 ; $i<strlen($code); $i++) {
					if (ord($code{$i}) > 127)
							$this->Error('Invalid character: '.$code{$i});
					$code_ext .= $encode[$code{$i}];
			}
			return $code_ext;
	}

	function draw_code39($code, $x, $y, $w, $h)
	{
			//Draw bars
			for($i=0; $i<strlen($code); $i++)
			{
					if($code{$i} == '1')
							$this->Rect($x+$i*$w, $y, $w, $h, 'F');
			}
	}	

}

?>
