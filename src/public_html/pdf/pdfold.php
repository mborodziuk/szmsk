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
		$adres=$dokks[kod]." ".$dokks[miasto].", ul. ".$dokks[ulica]." ".$dokks[nr_bud];
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
					$adres=$dokks[k_kod]." ".$dokks[k_miasto].", ul. ".$dokks[k_ulica]." ".$dokks[k_nr_bud];
					if (!empty($dokks[k_nr_mieszk]))
							$adres.="/$dokks[k_nr_mieszk]";
				}
		else
				{
					$adres=$dokks[kod]." ".$dokks[miasto].", ul. ".$dokks[ulica]." ".$dokks[nr_bud];
					if (!empty($dokks[nr_mieszk]))
						$adres.="/$dokks[nr_mieszk]";
				}
		$pdf->SetXY(111,57);
		$pdf->MultiCell(70,4,"$dokks[nazwa]",0,L,0);
		$pdf->Text(112,68,$adres);	
		
		$pdf->SetXY(20,90);
		$pdf->SetTextColor(128,128,128); 
		$pdf->Cell(45,10,"Termin płatności:",0,0,'R');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(45,10,"$dokks[term_plat]",0,0,'L');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Cell(45,10,"Forma płatności:",0,0,'R');
		$pdf->SetTextColor(0,0,0); 
		$pdf->Cell(45,10,"$dokks[forma_plat]",0,1,'L');
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
		$pdf->Cell($cw,$ch,$firma[nazwa],0,0,'L');

					$pdf->SetTextColor(0,0,0);
						$pdf->SetFont('Tahoma','',10);
			
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
		$q="select  d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa,
				a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod, a.id_abon, 
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi
			 
				from ((dokumenty_sprzedaz d  full join umowy_abonenckie um on d.id_odb=um.id_abon) full join kontakty k on k.id_podm=um.id_abon) 
				join ((budynki b join ulice u on b.id_ul=u.id_ul) join (abonenci a full join konta_wirtualne kw on a.id_abon=kw.id_abon) 
				on a.id_bud=b.id_bud) 	on d.id_odb=a.id_abon 
				where d.nr_ds='$nr'";
			
		$sth=Query($dbh,$q);
		$row=$sth->fetchRow();
		
		$dokks=array
			(
				'nr_d'				=> $nr, 			'data_wyst'			=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=> $row[3],	
				'forma_plat'	=> $row[4],		'miejsce_wyst'	=> $row[5],	'nazwa'				=> $row[6],	'pesel_nip'		=> $row[7],
				'ulica'				=> $row[8],		'nr_bud'				=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
				'miasto'			=> $row[12],	'kod'						=> $row[13],'id_abon' 		=> $row[14],
				'k_nazwa' 	=> $row[15],	'k_ulica' 				=> $row[16],'k_nr_bud'	 	=> $row[17], 'k_nr_mieszk' => $row[18],
					'k_kod'			=> $row[19],	'k_miasto'			=> $row[20], 'konto'		=> $row[21], 'uwagi'		=> $row[22]
				);
				
		if ( $typ=='DUPLIKAT')
				$dokks[data_wyst]=date("Y-m-d");

		$pdf=$this->MakeFV($pdf, $dbh, $dokks, $typ, $adrk=true);
		return($pdf);

	}


	function Faktury(&$pdf, $dbh, $od, $do, $TYP, $comiesiac=false, $order)
	{

		switch ($order)
			{
			case 'Data wystawienia':
				$order=' order by d.data_wyst, d.nr_ds';
				break;
			case 'Nazwa odbiorcy':
				$order=' order by a.nazwa, d.data_wyst, d.nr_ds';
				break;
		 }

	 if ( !$comiesiac)
	{
			$q="select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa,
					a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod, a.id_abon, k.nazwa, 
					k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi
					
					from ((dokumenty_sprzedaz d  full join umowy_abonenckie um on d.id_odb=um.id_abon) full join kontakty k on k.id_podm=um.id_abon) 
					join ((budynki b join ulice u on b.id_ul=u.id_ul) join (abonenci a full join konta_wirtualne kw on a.id_abon=kw.id_abon) 
					on a.id_bud=b.id_bud) 	on d.id_odb=a.id_abon  
						where d.data_wyst >= '$od' and d.data_wyst <= '$do'
					and a.fv_comiesiac='N'"; 

				/*	$q="select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa,
					a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod, a.id_abon, k.nazwa, 
					k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi
					
					from ((dokumenty_sprzedaz d  full join umowy_abonenckie um on d.id_odb=um.id_abon) full join kontakty k on k.id_podm=um.id_abon) 
					join ((budynki b join ulice u on b.id_ul=u.id_ul) join (abonenci a full join konta_wirtualne kw on a.id_abon=kw.id_abon) 
			
					on a.id_bud=b.id_bud) 	on d.id_odb=a.id_abon  
					where d.data_wyst >= '$od' and d.data_wyst <= '$do'";
				*/
					$adrk=true;
		}
	else
		{
			$q="select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa,
					a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod, a.id_abon, k.nazwa, 
					k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, a.uwagi
					
					from ((dokumenty_sprzedaz d  full join umowy_abonenckie um on d.id_odb=um.id_abon) full join kontakty k on k.id_podm=um.id_abon) 
					join ((budynki b join ulice u on b.id_ul=u.id_ul) join (abonenci a full join konta_wirtualne kw on a.id_abon=kw.id_abon) 
					on a.id_bud=b.id_bud) 	on d.id_odb=a.id_abon  
						
					where d.data_wyst >= '$od' and d.data_wyst <= '$do' and a.fv_comiesiac='T'";
		
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
					'k_kod'			=> $row[19],	'k_miasto'			=> $row[20], 'konto'	=> $row[21], 'uwagi'	=> $row[22]
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
		$adres=$dn[kod]." ".$dn[miasto].", ul. ".$dn[ulica]." ".$dn[nr_bud];
		if (!empty($dn[nr_mieszk]))
			$adres.="/$dn[nr_mieszk]";
		$pdf->Text($x1,$y2+40,$adres);	
		
		// Adresat
		$pdf->SetXY(106,$y1+10);
		$pdf->Cell(90,55,'',1,1,'C');
		$pdf->SetTextColor(128,128,128); 
		$pdf->Text(108,$y1+15,'Adresat:');
		$pdf->SetTextColor(0,0,0); 

		if ( $adrk==true && !empty($dn[k_nazwa]) && !empty($dn[k_ulica]) 
					&& !empty($dn[k_nr_bud]) && !empty($dn[k_miasto]) )
				{						
					$dn[nazwa]=$dn[k_nazwa];
					$adres=$dn[k_kod]." ".$dn[k_miasto].", ul. ".$dn[k_ulica]." ".$dn[k_nr_bud];
					if (!empty($dn[k_nr_mieszk]))
							$adres.="/$dn[k_nr_mieszk]";
				}
		else
				{
					$adres=$dn[kod]." ".$dn[miasto].", ul. ".$dn[ulica]." ".$dn[nr_bud];
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
		$q="select  n.nr_nob, n.data_wyst,  n.term_plat, n.forma_plat, n.miejsce_wyst, a.nazwa,
				a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, n.wystawil, u.miasto, u.kod, a.id_abon, 
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, n.kwota
			 
				from ((noty_obciazeniowe n  full join umowy_abonenckie um on n.id_odb=um.id_abon) full join kontakty k on k.id_podm=um.id_abon) 
				join ((budynki b join ulice u on b.id_ul=u.id_ul) join (abonenci a full join konta_wirtualne kw on a.id_abon=kw.id_abon) 
				on a.id_bud=b.id_bud) 	on n.id_odb=a.id_abon 
				where n.nr_nob='$nr'";
			
		$sth=Query($dbh,$q);
		$row=$sth->fetchRow();
		
		$dn=array
			(
				'nr_nob'				=> $nr, 			'data_wyst'			=> $row[1],	'term_plat'		=> $row[2],	
				'forma_plat'	=> $row[3],		'miejsce_wyst'	=> $row[4],	'nazwa'				=> $row[5],	'pesel_nip'		=> $row[6],
				'ulica'				=> $row[7],		'nr_bud'				=> $row[8],	'nr_mieszk'		=> $row[9],'wystawil'		=> $row[10],
				'miasto'			=> $row[11],	'kod'						=> $row[12],'id_abon' 		=> $row[13],
				'k_nazwa' 	=> $row[14],	'k_ulica' 				=> $row[15],'k_nr_bud'	 	=> $row[16], 'k_nr_mieszk' => $row[17],
					'k_kod'			=> $row[18],	'k_miasto'			=> $row[19], 'konto'		=> $row[20], 'kwota' => $row[21]
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
		$q="    select  d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa,
			a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod
			from dokumenty_sprzedaz d, abonenci a, budynki b, ulice u 
			where d.id_odb=a.id_abon and a.id_bud=b.id_bud and u.id_ul=b.id_ul and d.data_wyst >= '$od' and d.data_wyst <= '$do' and d.nr_ds like '%/Z/%'
			order by d.nr_ds, d.data_wyst";
		$REJESTR="REJESTR SPRZEDAŻY (ZALICZKI)";
			}					 
	 else	
			{
			$q="	select  d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa, 
			a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod
			from dokumenty_sprzedaz d, abonenci a, budynki b, ulice u 
			where d.id_odb=a.id_abon and a.id_bud=b.id_bud and u.id_ul=b.id_ul and d.data_wyst >= '$od' and d.data_wyst <= '$do' and d.nr_ds not like '%/Z/%'
			order by d.nr_ds, d.data_wyst";
		$REJESTR="REJESTR SPRZEDAŻY";
			}

		$LP_W=9;
		$NRD_W=20;
		$MW_W=18;
		$DW_W=25;
		$TP_W=18;
		$N_W=85;
		$NIP_W=19;
		$WSN_W=30;
		$WSN_B=30;
		$PV_W=20;

		$ML=10;
		$MT=35;
		
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
				
				$pdf->SetFont('Tahoma','',8);
				$NrStr=$pdf->PageNo();
				$pdf->Text(145, 200,"Strona $NrStr",1,0,'C');

				$pdf->SetXY($ML, $MT);

				$pdf->SetFont('Tahoma','B',7);
			//	$pdf->SetFillColor(5,5,5);
				$pdf->Cell($LP_W,  $W,'Lp',1,0,'C');
				$pdf->Cell($NRD_W, $W,'Nr dokumentu',1,0,'C');
				$pdf->Cell($MW_W,  $W, '',1,0,'C');
				$pdf->Cell($DW_W,  $W,'',1,0,'C');
				$pdf->Cell($TP_W,  $W,'',1,0,'C');
				//$pdf->MultiCell($TP_W,3,'Termin płatności',0,C,0);
							
				$pdf->Cell($N_W,   $W,'Nabywca',1,0,'C');
				$pdf->Cell($NIP_W,   $W,'NIP',1,0,'C');
							
				$pdf->Cell($WSN_W, $W,'',1,0,'C');
				$pdf->Cell($PV_W,  $W,'',1,0,'C');
				$pdf->Cell($WSB_B, $W,'',1,0,'C');
			
				$y=$MT+0.5;
				$pdf->SetXY($ML+$LP_W+$NRD_W-1, $y);
				$pdf->MultiCell(20,3,'Miejsce wystawienia',0,C,0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W, $y);
				$pdf->MultiCell($DW_W,3,'Data wystawienia Data sprzedazy',0,C,0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W, $y);
				$pdf->MultiCell($TP_W,3,'Termin płatności',0,C,0);
				
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W, $y);						
				$pdf->MultiCell($WSN_W,3,'Wartość sprzedaży netto [w zł]',0,C,0);
													$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W, $y);
													$pdf->MultiCell($PV_W,3,'Podatek VAT [w zł]', 0, C, 0);
				$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W+$WSN_W+$PV_W, $y);
				$pdf->MultiCell($WSN_B,3,'Wartość sprzedaży brutto [w zł]',0,C,0);
			}

			$dokks=array
				(
					'nr_d'			=> $row[0], 	'data_wyst'		=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=>	$row[3],	
					'forma_plat'	=> $row[4],		'miejsce_wyst'	=> $row[5],	'nazwa'			=> $row[6],	'pesel_nip'		=> $row[7],
					'ulica'			=> $row[8],		'nr_bud'			=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
					'miasto'			=> $row[12],	'kod'				=> $row[13]
				);

			$q2="(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, towary_sprzedaz t
						where p.id_tows=t.id_tows and p.nr_ds='$dokks[nr_d]' order by t.nazwa)
						union all
					 (select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, uslugi_voip t
						where p.id_tows=t.id_uvp  and p.nr_ds='$dokks[nr_d]' order by t.nazwa)";

			$razem_netto=$razem_vat=$razem_brutto=0;
			$sth1=Query($dbh,$q2);
			while ( $row1=$sth1->fetchRow() )
				{	
					$jedn_brutto=round($row1[4], 2);
					$cena_jedn_netto = $row1[4] / (1+$row1[5]/100);
					$brutto= $row1[2] * $jedn_brutto;
					$netto=$brutto / (1 + $row1[5]/100);
					$kwota_vat=$brutto-$netto;

					$razem_netto+=round($netto, 2);
					$razem_vat+=round ($kwota_vat, 2);
					$razem_brutto+=round($brutto, 2);
				}

	//		$razem_n+=$razem_netto;
	//		$razem_v+=$razem_vat;
	//		$razem_b+=$razem_brutto;
			
			$r_razem_netto=round($razem_netto, 2);
			$r_razem_vat=round($razem_vat, 2);
			$r_razem_brutto=round($razem_brutto, 2);

			$razem_b+=$r_razem_brutto;
									$razem_n+=$r_razem_netto;
						$razem_v+=$r_razem_vat;
					
			$pdf->Ln();
			$pdf->SetFont('Tahoma','',7);

			$k=$lp%$ilp;
			if ($k==0) $k=$ilp;
			$Y=$MT+$k*$W;
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
									
			$pdf->Cell($WSN_W,$W, number_format($r_razem_netto, 2, ',',''),1,0,'C');
			$pdf->Cell($PV_W,$W,  number_format($r_razem_vat, 2,',',''),   1,0,'C');
			$pdf->Cell($WSB_B,$W, number_format($r_razem_brutto, 2,',',''),1,0,'C');

			$y=$Y+1;
			$pdf->SetXY($ML+$LP_W+$NRD_W+$MW_W, $y);
			$pdf->MultiCell($DW_W,3,"$dokks[data_wyst] $dokks[data_sprzed]" ,0,C,0);

			$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+5,$y+2,"$dokks[nazwa]");
			$adres=$dokks[kod]." ".$dokks[miasto].", ul. ".$dokks[ulica]." ".$dokks[nr_bud];
			if (!empty($dokks[nr_mieszk]))
			$adres.="/$dokks[nr_mieszk]";
			$pdf->Text($ML+$LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+5,$y+5,$adres);

		++$lp;
		}
		
					$k=$lp%$ilp;
					if ($k==0) $k=$ilp;
		else if ($k==1) $k=$ilp+1;	
					$Y=$MT+$k*$W;
					$pdf->SetXY($ML, $Y);							
		$pdf->SetFont('Tahoma','B',9);
		$pdf->Cell($LP_W+$NRD_W+$MW_W+$DW_W+$TP_W+$N_W+$NIP_W, $W, "RAZEM : ", 1, 0, 'R');
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
		
		$q="select id_abon, symbol, nazwa1, kod, miasto,  nazwa2, numer1,  nr_mieszk, platnosc, numer2 , ksiazeczka, sum(cena) as kwota
from
(
select  a.id_abon, a.symbol, a.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, a.nr_mieszk, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena
	from abonenci a, ulice u, budynki b, umowy_abonenckie um, komputery k, towary_sprzedaz t, konta_wirtualne kw
	where u.id_ul=b.id_ul and a.id_bud=b.id_bud and um.id_abon=a.id_abon and k.id_taryfy=t.id_tows
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and k.id_abon=a.id_abon and k.podlaczony='T' and k.fv='T' 
union all
select a.id_abon, a.symbol, a.nazwa as nazwa1, u.kod, u.miasto, u.nazwa as nazwa2, b.numer as numer1, a.nr_mieszk, a.platnosc, kw.numer as numer2, a.ksiazeczka, t.cena
	from abonenci a, ulice u, budynki b, umowy_abonenckie um, settopboxy s, towary_sprzedaz t, konta_wirtualne kw
	where u.id_ul=b.id_ul and a.id_bud=b.id_bud and um.id_abon=a.id_abon and s.id_taryfy=t.id_tows
	and a.id_abon=kw.id_abon and um.status='Obowiązująca' and s.id_abon=a.id_abon and s.aktywny='T' and s.fv='T' 
) q where";
				
		if (!empty($abon) && $abon !=$conf[select])   		
				$q.="	id_abon='$ida'";
	else 
				$q.=" ksiazeczka='T'";

		$q.=" group by id_abon, symbol, nazwa1, kod, miasto,  nazwa2, numer1,  nr_mieszk, platnosc, numer2, ksiazeczka order by 3	";
																																																			
				
		set_time_limit(600);
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
			{
				
				$kwota=number_format(round($row[11], 2), 2, ',','');
		
				$ks=array( 	'nazwa'	=> Choose($row[1], $row[2]),	'term_plat'		=>	$row[3], 'kwota' => $kwota,	
						'miasto'	=> "$row[3]"." "."$row[4]", 'ulica' => "ul. "."$row[5]"." "."$row[6]", 'id_abon'=> strtolower($row[0]),
						'platnosc' => "$row[8]", 'konto' => "$row[11]");

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
								$yy=-82;
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

	function PonaglenieZaplaty(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";

		$X="20";
		//wsp X danych adresowych
		
				$q="(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_iptv um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				";
		

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
		
			$dluznik=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> number_format(-$row[3], 2, ',',''),	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	 
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18],
					'konto'		=> $row[19]
				);

				
		if ( !empty($dluznik[k_nazwa]) && !empty($dluznik[k_ulica]) && !empty($dluznik[k_nr_bud]) && !empty($dluznik[k_miasto])  )
				{						
					$dluznik[nazwa]=$dluznik[k_nazwa];
					$adres1=$dluznik[k_kod]." ".$dluznik[k_miasto];
					$adres2="ul. ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
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
		
				$this->PismoNaglowek($pdf, $adresat, "PONAGLENIE ZAPŁATY");

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

				$this->PismoStopka($pdf);
			return($pdf);
		}

	function WezwanieZaplata(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";
		$nazwa_dok="WEZWANIE DO ZAPŁATY";

		$X="20";
		//wsp X danych adresowych
			
				$q="(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_iptv um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				";		

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();

			
			$data_slownie=DataSlownie($dluznik[data_zaw]);
			$q1="select cena from towary_sprzedaz where id_tows='USL0103'";
			$sth1=Query($dbh,$q1);
			$row1=$sth1->fetchRow();

			
			$dluznik=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> $row[3],	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	'aktywacja'	=> $row1[0], 'zadluzenie' => number_format(-$row[3]+$row1[0], 2, ',',''),
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18],
					'konto'		=> $row[19]
					);

				
			if ( !empty($dluznik[k_nazwa]) && !empty($dluznik[k_ulica]) && !empty($dluznik[k_nr_bud]) && !empty($dluznik[k_miasto])  )
				{						
					$dluznik[nazwa]=$dluznik[k_nazwa];
					$adres1=$dluznik[k_kod]." ".$dluznik[k_miasto];
					$adres2="ul. ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
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
			$tekst5="Należności te wynikają z braku zapłaty za usługi dostępu do Internetu oraz opłaty za aktywację połączenia z Internetem w wysokości $dluznik[aktywacja] zł.";
			$tekst6="";
			$tekst7="Uprzejmie prosimy o niezwłoczne wpłacenie w/w kwoty na rachunek bankowy:";
			$tekst8="$firma[nazwa] - $dluznik[konto]";
			$tekst9="";
			$tekst10="Powyższe wynika z treści  umowy  $dluznik[um_numer] z dnia $dluznik[data_zaw].  Umowa ta do dnia dzisiejszego nie została przez Państwa pisemnie wypowiedziana z zachowaniem trzymiesięcznego okresu wypowiedzenia. 
Przypominamy, że w przypadku rozwiązania umowy przed upływem minimalnego okresu jej obowiązywania na wniosek bądź też z winy Abonenta obowiązuje opłata deaktywacyjna. Opłata ta zgodnie z obowiązującym cennikiem wynosi : 366 zł.";
			$tekst11="";
			$tekst12="Informujemy, że jeżeli zadłużenie  nie zostanie uregulowane do $ostatni  rozpoczniemy proces kompletowania dokumentacji celem wystąpienia z powództwem na drogę postępowania sądowego.
Jeżeli w dalszym ciągu będziecie Państwo unikać spłaty zobowiązania, podejmiemy kolejne kroki, których efektem będzie wydanie przez sąd nakazu upoważniającego komornika sądowego do wszczęcia egzekucji (zajęcia wynagrodzenia, renty bądź emerytury, zablokowania osobistego konta bankowego lub zajęcia majątku trwałego, należącego do dłużnika lub współmałżonka).";
			$tekst13="";		
			$tekst14="Przypominamy ponadto, że nieregulowanie zobowiązań skutkuje wpisem do KRAJOWEGO REJESTRU DŁUGÓW. Uprzedzamy, że wszelkiego rodzaju koszty związane z postępowaniem sądowym i egzekucyjnym, obciążają dłużnika      i są naliczane przez cały czas trwania egzekucji.";
			$tekst15="";		
			$tekst16="W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy o kontakt pod numerem telefonu:             $firma[telefon1].";	
			$tekst17="";	
			$tekst18="Z poważaniem";
			$tekst19="NETICO S.C. ";
					
			
			
		$poz_h=7;

				$this->PismoNaglowek($pdf, $adresat, $nazwa_dok);
				
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($X,115);
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst3",0,C,0);
				$pdf->SetFont('Tahoma','',9);
			//	$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst5",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst7",0,C,0);
				$pdf->MultiCell(170,5,"$tekst8",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"$tekst10",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst12",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst14",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst16",0,L,0);
			//	$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(160,5,"$tekst18",0,R,0);
				$pdf->MultiCell(160,5,"$tekst19",0,R,0);

				$this->PismoStopka($pdf);
				return($pdf);
		}

  function WezwanieZaplata1(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";
		$nazwa_dok="WEZWANIE DO ZAPŁATY";

		$X="20";
		$Y="115";
		
		//wsp X danych adresowych
		
				$q="(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_iptv um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				";		

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
						
			$dluznik=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> $row[3],	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	'aktywacja'	=> $row1[0], 'zadluzenie' => number_format(-$row[3], 2, ',',''),
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18],
					'konto'		=> $row[19]
				);
				
			$pdf=$this->MakeWDZ1($pdf, $dbh, $dluznik);
			return($pdf);

		}		

		
		
		
	function WezwanieZaplata2(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";
		$nazwa_dok="WEZWANIE DO ZAPŁATY";

		$X="20";
		//wsp X danych adresowych
		
				$q="(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_iptv um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				";		

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
					'konto'		=> $row[19]
					);

				
			if ( !empty($dluznik[k_nazwa]) && !empty($dluznik[k_ulica]) && !empty($dluznik[k_nr_bud]) && !empty($dluznik[k_miasto])  )
				{						
					$dluznik[nazwa]=$dluznik[k_nazwa];
					$adres1=$dluznik[k_kod]." ".$dluznik[k_miasto];
					$adres2="ul. ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
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
			$tekst5="Należności te wynikają z braku zapłaty za usługi dostępu do Internetu.  W załączeniu przesyłamy nie uregulowane przez Państwa faktury.";
			$tekst6="";
			$tekst7="Uprzejmie prosimy o niezwłoczne wpłacenie w/w kwoty na rachunek bankowy:";
			$tekst8="$firma[nazwa] - $dluznik[konto]";
			$tekst9="";
			$tekst10="Powyższe wynika z treści  umowy  $dluznik[um_numer] z dnia $dluznik[data_zaw].  Umowa ta do dnia dzisiejszego nie została przez Państwa pisemnie wypowiedziana z zachowaniem trzymiesięcznego okresu wypowiedzenia.
Przypominamy, że w przypadku rozwiązania umowy przed upływem minimalnego okresu jej obowiązywania na wniosek bądź też z winy Abonenta obowiązuje opłata deaktywacyjna. Opłata ta zgodnie z obowiązującym cennikiem wynosi : 366 zł.";
			$tekst11="";
			$tekst12="Informujemy, że jeżeli zadłużenie  nie zostanie uregulowane do $ostatni  rozpoczniemy proces kompletowania dokumentacji celem wystąpienia z powództwem na drogę postępowania sądowego. 
Jeżeli w dalszym ciągu będziecie Państwo unikać spłaty zobowiązania, podejmiemy kolejne kroki, których efektem będzie wydanie przez sąd nakazu upoważniającego komornika sądowego do wszczęcia egzekucji (zajęcia wynagrodzenia, renty bądź emerytury, zablokowania osobistego konta bankowego lub zajęcia majątku trwałego, należącego do dłużnika lub współmałżonka).";
			$tekst13="";		
			$tekst14="Przypominamy ponadto, że nieregulowanie zobowiązań skutkuje wpisem do KRAJOWEGO REJESTRU DŁUGÓW. Uprzedzamy, że wszelkiego rodzaju koszty związane z postępowaniem sądowym i egzekucyjnym, obciążają dłużnika      i są naliczane przez cały czas trwania egzekucji.";
			$tekst15="";		
			$tekst16="W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy o kontakt pod numerem telefonu:             $firma[telefon1].";	
			$tekst17="";	
			$tekst18="Z poważaniem";
			$tekst19="NETICO S.C. ";
					
			
			
		$poz_h=7;
				$this->PismoNaglowek($pdf, $adresat, $nazwa_dok);

				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($X,115);
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst3",0,C,0);
				$pdf->SetFont('Tahoma','',9);
			//	$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst5",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst7",0,C,0);
				$pdf->MultiCell(170,5,"$tekst8",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"$tekst10",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst12",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst14",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst16",0,L,0);
//				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(160,5,"$tekst18",0,R,0);
				$pdf->MultiCell(160,5,"$tekst19",0,R,0);
				
				$this->PismoStopka($pdf);
		
			$q2="select d.nr_ds, t.cena from towary_sprzedaz t, pozycje_sprzedaz p, dokumenty_sprzedaz d  where t.id_tows=p.id_tows and d.nr_ds=p.nr_ds 
			and d.id_odb='$dluznik[id_abon]' order by d.data_wyst desc";

			$kwota=0;
			$sth2=Query($dbh,$q2);
			while ($row2=$sth2->fetchRow() and $kwota<$dluznik[saldo])
			{
				$kwota+=$row2[1];
				$this->Faktura($pdf, $dbh, $row2[0], "ORYGINAŁ");
			}
			
				return($pdf);

		}

		
			
function WezwanieZaplata3(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";
		$nazwa_dok="PRZEDSĄDOWE WEZWANIE DO ZAPŁATY";

		$X="20";
		$Y="110";
		
		//wsp X danych adresowych
		
				$q="(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_iptv um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				";		

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
					'konto'		=> $row[19]
				);
				
		$pdf=$this->MakeWDZ3($pdf, $dbh, $dluznik);
		return($pdf);
		}		

function WezwanieZaplata4(&$pdf, $dbh, $id_spw)
	{
		include "../func/config.php";
		$nazwa_dok="PRZEDSĄDOWE WEZWANIE DO ZAPŁATY";

		$X="20";
		$Y="110";
		
		//wsp X danych adresowych
		
				$q="(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				union
				(select s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from ((sprawy_windykacyjne s full join umowy_iptv um on s.id_abon=um.id_abon) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon 
				and u.id_ul=b.id_ul and s.id_spw='$id_spw')
				";		

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
					'konto'		=> $row[19]
				);
				
			if ( !empty($dluznik[k_nazwa]) && !empty($dluznik[k_ulica]) && !empty($dluznik[k_nr_bud]) && !empty($dluznik[k_miasto])  )
				{						
					$dluznik[nazwa]=$dluznik[k_nazwa];
					$adres1=$dluznik[k_kod]." ".$dluznik[k_miasto];
					$adres2="ul. ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
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
			$tekst12="Informujemy, że jeżeli zadłużenie  nie zostanie uregulowane do $ostatni  rozpoczniemy proces kompletowania dokumentacji celem wystąpienia z powództwem na drogę postępowania sądowego. 
			Jeżeli w dalszym ciągu będziecie Państwo unikać spłaty zobowiązania, podejmiemy kolejne kroki, których efektem będzie wydanie przez sąd nakazu upoważniającego komornika sądowego do wszczęcia egzekucji (zajęcia wynagrodzenia, renty bądź emerytury, zablokowania osobistego konta bankowego lub zajęcia majątku trwałego, należącego do dłużnika lub współmałżonka).";
			$tekst13="";		
			$tekst14="Aby uregulować zadłużenie prosimy o wpłacenie kwoty $dluznik[zadluzenie] zł na rachunek bankowy:";
			$tekst15="$firma[nazwa] - $dluznik[konto]";		
			$tekst16="W razie jakichkolwiek wątpliwości dotyczących zaległych płatności prosimy o kontakt pod numerem telefonu:             $firma[telefon1].";	
			$tekst17="";	
			$tekst18="Z poważaniem";
			$tekst19="NETICO S.C. ";
					
			
			
		$poz_h=7;
				$this->PismoNaglowek($pdf, $adresat, $nazwa_dok);

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

		

		
 function MakeWDZ1(&$pdf, $dbh, $dluznik)
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
					$adres2="ul. ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
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
		

function MakeWDZ3(&$pdf, $dbh, $dluznik)
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
					$adres2="ul. ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
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
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
	
				from (((sprawy_windykacyjne s full join umowy_abonenckie um on s.id_abon=um.id_abon) join windykowanie w on w.id_spw=s.id_spw) full join kontakty k on k.id_podm=um.id_abon) 
				join 
				((budynki b join ulice u on b.id_ul=u.id_ul) join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) 
				on s.id_abon=a.id_abon 
			
			where a.id_bud=b.id_bud and um.id_abon=a.id_abon  and s.zwindykowana='N' and um.status<>'Rozwiązana'
				and u.id_ul=b.id_ul and w.krok='$krok' )
				union
				
				(select distinct s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from (((sprawy_windykacyjne s full join umowy_serwisowe um on s.id_abon=um.id_abon ) join windykowanie w on w.id_spw=s.id_spw) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon   and s.zwindykowana='N' 
				and u.id_ul=b.id_ul and w.krok='$krok' )
				union
				
				(select distinct s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
				from (((sprawy_windykacyjne s full join umowy_voip um on s.id_abon=um.id_abon ) join windykowanie w on w.id_spw=s.id_spw) 
				full join kontakty k on k.id_podm=um.id_abon) join ((budynki b join ulice u on b.id_ul=u.id_ul) 
				join (abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on a.id_bud=b.id_bud) on s.id_abon=a.id_abon 
				where s.id_abon=a.id_abon  and a.id_bud=b.id_bud and um.id_abon=a.id_abon   and s.zwindykowana='N'
				and u.id_ul=b.id_ul and w.krok='$krok' )
				
				union
				(select distinct s.id_spw, a.id_abon, a.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, a.nr_mieszk, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer
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
					'konto'		=> $row[19]
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
		
			$q="select a.id_abon, a.nazwa, a.saldo, a.nr_mieszk, u.nazwa, u.miasto, u.kod, b.numer, k.nazwa, k.ulica, k.nr_bud, 
					k.nr_mieszk, k.kod, k.miasto, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta , w.opis
				from (( kontakty k full join abonenci a on k.id_podm=a.id_abon) join ( budynki b join ulice u on b.id_ul=u.id_ul ) on a.id_bud=b.id_bud )
				join wplaty w on w.id_kontrah=a.id_abon where w.id_wpl='$id_wpl'";
		

			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
		
			$wpl=array
				(
					'id_abon'		=> $row[0],		'nazwa' => $row[1],		 	'saldo'			=> number_format(-$row[2], 2, ',',''),	'nr_mieszk'			=> $row[3],
					'ulica'			=> $row[4],		'miasto'	=> $row[5],	'kod'	=> $row[6], 'nr_bud'		=> $row[7],	 	 
					'k_nazwa'		=> $row[8],   'k_ulica'		=> $row[9],  'k_nr_bud'		=> $row[10], 'k_nr_mieszk'		=> $row[11], 'k_kod'		=> $row[12],'k_miasto'		=> $row[13],
					'data_ksiegowania'		=> $row[14],   'data_zlecona'		=> $row[15],  'forma'		=> $row[16], 'kwota'		=> $row[17], 'waluta'		=> $row[18],'opis'		=> $row[19]
					);

		$x=new slownie;
		$slownie=$x->zwroc($wpl[kwota]);
		
		if ( !empty($wpl[k_nazwa]) && !empty($wpl[k_ulica]) && !empty($wpl[k_nr_bud]) && !empty($wpl[k_miasto])  )
				{						
					$wpl[nazwa]=$wpl[k_nazwa];
					$adres1=$wpl[k_kod]." ".$wpl[k_miasto];
					$adres2="ul. ".$wpl[k_ulica]." ".$wpl[k_nr_bud];
					if (!empty($wpl[k_nr_mieszk]))
					$adres2.="/$wpl[k_nr_mieszk]";
				}
		else
				{
					$adres1=$wpl[kod]." ".$wpl[miasto];
					$adres2="ul. ".$wpl[ulica]." ".$wpl[nr_bud];
					if (!empty($wpl[nr_mieszk]))
					$adres2.="/$wpl[nr_mieszk]";
				}
						

			$adresat=array('nazwa' => $wpl[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
				
			//$wpl[saldo]=-$wpl[saldo];
				
				
			$tekst0="";
			$tekst2="Zaświadcza się, że Pan(i):";
			$tekst3="$adresat[nazwa], $adresat[adres1], $adresat[adres2]"; 
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
			
				$q="select distinct a.nazwa, u.miasto, u.nazwa, b.numer, a.nr_mieszk, t.cena, t.vat
				from 
				abonenci a, umowy_abonenckie um, budynki b, ulice u, komputery k, towary_sprzedaz t 
				where
				a.id_abon=k.id_abon and k.podlaczony='T' and k.fv='T' and k.id_taryfy=t.id_tows and b.id_bud=a.id_bud
				and u.id_ul=b.id_ul  and b.id_adm='$adm' and a.id_abon not in ('ABON1290', 'ABON2506') and a.id_abon=um.id_abon and um.status='Obowiązująca'
				order by 
				u.nazwa, b.numer, a.nazwa";
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
		
	function UmowaAbonencka(&$pdf, $dbh, $id_abon)
	{
		include "../func/config.php";
		include "pdftxt.php";

		$X="20";
		//wsp X danych adresowych
		
			$q="select   u.nr_uma, u.data_zaw, u.fv_comiesiac, a.ksiazeczka,
					a.nazwa, a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod, a.id_abon, 
					k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto
				 
					from ((umowy_abonenckie u  full join abonenci a on u.id_abon=a.id_abon) full 
					join kontakty k on k.id_podm=um.id_abon) join ( (budynki b join ulice u on b.id_ul=u.id_ul) 
					join abonenci a on a.id_bud=b.id_bud) where a.id_abon='$id_abon'";
		
	/*
			$sth=Query($dbh,$q);
			$row=$sth->fetchRow();
		
			$uma=array
				(
					'nr_uma'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> number_format(-$row[3], 2, ',',''),	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	 
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],'k_miasto'		=> $row[18]
				);

				
		if ( !empty($wpl[k_nazwa]) && !empty($wpl[k_ulica]) && !empty($wpl[k_nr_bud]) && !empty($wpl[k_miasto])  )
				{						
					$wpl[nazwa]=$wpl[k_nazwa];
					$adres1=$wpl[k_kod]." ".$wpl[k_miasto];
					$adres2="ul. ".$dluznik[k_ulica]." ".$dluznik[k_nr_bud];
					if (!empty($dluznik[k_nr_mieszk]))
					$adres2.="/$dluznik[k_nr_mieszk]";
				}
		else
				{
					$adres1=$dluznik[kod]." ".$dluznik[miasto];
					$adres2="ul. ".$dluznik[ulica]." ".$dluznik[nr_bud];
					if (!empty($dluznik[nr_mieszk]))
					$adres2.="/$dluznik[nr_mieszk]";
				}
						

			$adresat=array('nazwa' => $dluznik[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
				
			//$dluznik[saldo]=-$dluznik[saldo];
				


				*/



			
		$poz_h=7;
				$pdf->AddPage();
				$pdf->SetMargins(20,15,20);
				$this->PismoNaglowek($pdf, $adresat, "umowa");

				//$uma[0]=substr( $umowa, 0, strpos($umowa, " ", 100) );
				$uma[0]=mb_substr( $umowa, 0, 1000);
				
	//			$pdf->SetFont('Tahoma','B',16);
		//		$pdf->Text(70,110, "WEZWANIE DO ZAPŁATY");

				$pdf->SetFont('Tahoma','',10);

				$pdf->SetXY($X,10);

				
				$pdf->AddPage();
				$pdf->SetMargins(20,15,20);
				$this->PismoNaglowek($pdf, $adresat);


	include('/usr/share/php/mpdf/mpdf.php');
	$mpdf=new mPDF();
	$mpdf->WriteHTML('<p>Hallo World</p>');
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
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
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




/*
	function Pisma(&$pdf, $dbh)
	{
		include "../func/config.php";

		$order=' order by a.nazwa';

		$q="select  distinct a.nazwa, u.nazwa, b.numer, a.nr_mieszk, u.miasto, u.kod, a.id_abon, um.nr_um,
					k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto
					from ( umowy_abonenckie um full join kontakty k on k.id_podm=um.id_abon) 
					join ( (budynki b join ulice u on b.id_ul=u.id_ul) join abonenci a on a.id_bud=b.id_bud ) 
					on um.id_abon=a.id_abon where um.status='Obowiązująca' ";
					
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
					'k_kod'			=> $row[12],	'k_miasto'	=> $row[13]
				);

		$tekst0="Szanowni Państwo.";
		$tekst1="";	
		$tekst2="Uprzejmie informujemy, że od 1 stycznia 2010 zmianie ulegają numery kont bankowych, na które należy wpłacać abonament internetowy. Każdy klient będzie posiadał swój indywidualny numer rachunku.";
		$tekst3=""; 
		$tekst4="";
		$tekst5="";
		$tekst6="";
		$tekst7="Państwa indywidualne konto do przelewu: ";
		$tekst8="$firma[nazwa] - $psm[konto]";
		$tekst9="";
		$tekst10="W tym roku możemy pochwalić się dalszą rozbudową naszej sieci, uruchomieniem nowych traktów światłowodowych oraz połączeniem sieci mysłowickiej z oświęcimską.";
		$tekst11="";

		$tekst12="Przypominamy także o dodatkowych usługach uruchomionych w naszej sieci:";
		
		$tekst13="- CZAT DC (Direct Connect)  WĘZEŁ WYMIANY RUCHU P2P - usługa polegająca na możliwości komunikacji z innymi użytkownikami oraz wymiany ruchu (danych) pomiędzy abonentami naszej sieci, niezależnie od pasma przeznaczonego do realizacji dostępu do Internetu.";
		
		$tekst133="Uruchomiony hub DC dostępny jest dla wszystkich abonentów podłączonych do naszej sieci. Aktualnie z usługi tej korzysta około 600 osób, mających udostępnione w sumie około 20 TB (tera bajtów - 1TB = 1024GB) danych. Program instalacyjny do połączenia z czatem można ściągnąć ze strony Live.Netico.pl z działu Czat DC.";
		
		$tekst14="- SERWERY GIER  -  dla wszystkich fanów sportów elektronicznych uruchomiliśmy własne publiczne serwery gier. Ze względu na ich bezpośrednie wpięcie do naszej sieci szkieletowej zapewniona jest bardzo dobra jakość połączeń. Więcej informacji na temat dostępnych gier oraz adresów serwerów na portalu Live.Netico.pl.";
		
		$tekst15="- Portal Live.Netico.pl  -   na którym zamieszczone są wszelkie informacje na temat naszych usług internetowych  (telefonia internetowa, hosting, serwery gier, Czat DC), a także porady, informacje oraz wiele innych. W portalu znajduje się ankieta, która pozwoli poznać nam Państwa opinie i potrzeby. Zapraszamy do wypełniania ankiety, główna nagroda to aparat cyfrowy.";

		$tekst16="- TELEFONIA INTERNETOWA VoIP - koszt miesięcznego abonamentu za numer wynosi 12,90 zł. Koszt połączenia w obrębie kraju i do wybranych krajów za granicą 9 gr za minutę połączenia brutto. Więcej informacji na portalu abonenta Live.Netico.pl.";		

		$tekst17="Przedłużamy promocje dla naszych użytkowników. W związku z wielkim zainteresowaniem promocją Zaproś sąsiada (ponad 200  osób skorzystało z naszej promocji) Przedłużamy ją o kolejny rok. Zasięg naszej sieci oraz warunki promocji na naszej stronie internetowej.";	

		$tekst18="W tym roku uruchomiliśmy przedstawicielstwa prowadzone przez naszych autoryzowanych partnerów w Oświęcimiu:
	1. PCMEDIA TEAM - tel: 033 841 05 45, ul. Mayzla 7, 32-600 Oświęcim (koło kościoła parafialnego na rynku).
	2. PROWAIDER Żaneta Miler - tel: 033 842 20 52, ul. Piastowska 13, 32-600 Oświęcim.";	

		$tekst19="Mamy nadzieję, że podejmowane przez nas działania oceniają Państwo pozytywnie, a nasz internet oraz nowe usługi cieszyć się będą Państwa niesłabnącym zainteresowaniem.

	Wszelkie pytania, awarie i problemy w dostępie do Internetu prosimy zgłaszać pod numerem telefonu infolinii: 
	0 801 000 155 (można na nią dzwonić również z telefonów komórkowych Orange i Play).";
		
		$tekst20="";
		$tekst30="Z poważaniem";
		$tekst31="NETICO S.C. ";
				
				
		$poz_h=7;
		$y1=25;
		$x1=20;
		$y2=46;
			
		if ( !empty($psm[k_nazwa]) && !empty($psm[k_ulica]) && !empty($psm[k_nr_bud]) && !empty($psm[k_miasto])  )
				{						
					$psm[nazwa]=$psm[k_nazwa];
					$adres1=$psm[k_kod]." ".$psm[k_miasto];
					$adres2="ul. ".$psm[k_ulica]." ".$psm[k_nr_bud];
					if (!empty($psm[k_nr_mieszk]))
					$adres2.="/$psm[k_nr_mieszk]";
				}
		else
				{
					$adres1=$psm[kod]." ".$psm[miasto];
					$adres2="ul. ".$psm[ulica]." ".$psm[nr_bud];
					if (!empty($psm[nr_mieszk]))
					$adres2.="/$psm[nr_mieszk]";
				}
						

				$adresat=array('nazwa' => $psm[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
		
				$pdf->AddPage();
				$pdf->SetMargins(20,15,20);
				$this->PismoNaglowek($pdf, $adresat);
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($x1,110);
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
	//			$pdf->MultiCell(170,5,"$tekst3",0,C,0);
				$pdf->SetFont('Tahoma','',9);
			//	$pdf->MultiCell(170,5,"",0,L,0);
		//		$pdf->MultiCell(170,5,"$tekst5",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->MultiCell(170,5,"$tekst7",0,C,0);
				$pdf->MultiCell(170,5,"$tekst8",0,C,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				
				$pdf->SetFont('Tahoma','',9);
				$pdf->MultiCell(170,5,"$tekst10",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst12",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst13",0,L,0);
				$pdf->MultiCell(170,5,"$tekst133",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst14",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst15",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
				$pdf->MultiCell(170,5,"$tekst16",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);
		
				$pdf->AddPage();
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($x1,25);
				$pdf->MultiCell(170,5,"$tekst17",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);			
				$pdf->MultiCell(170,5,"$tekst18",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);			
				$pdf->MultiCell(170,5,"$tekst19",0,L,0);
				$pdf->MultiCell(170,5,"",0,L,0);			
				$pdf->MultiCell(160,5,"$tekst30",0,R,0);
				$pdf->MultiCell(160,5,"$tekst31",0,R,0);
			}
				return($pdf);
	}
*/

function Pisma(&$pdf, $dbh)
	{
		include "../func/config.php";

		$order=' order by a.nazwa';

		$q="select  distinct a.nazwa, u.nazwa, b.numer, a.nr_mieszk, u.miasto, u.kod, a.id_abon, um.nr_um,
					k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto
					from ( umowy_abonenckie um full join kontakty k on k.id_podm=um.id_abon) 
					join ( (budynki b join ulice u on b.id_ul=u.id_ul) join abonenci a on a.id_bud=b.id_bud ) 
					on um.id_abon=a.id_abon where um.status='Obowiązująca'";
					
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
					'k_kod'			=> $row[12],	'k_miasto'	=> $row[13]
				);

		$tekst0="Szanowni Państwo.";
		$tekst1="";	
		$tekst2="Uprzejmie informujemy, że w bieżącym roku uruchomiliśmy w naszej sieci CYFROWĄ TELEWIZJĘ KABLOWĄ HD, stając się KABLÓWKĄ 3 GENERACJI. Telewizja ta poza bogatą ofertą programową jest atrakcyjna finansowo i wprowadza dodatkowe usługi interaktywne niedostępne dotychczas na polskim rynku. Telewizja dostępna jest wszędzie tam gdzie są nasze światłowody. ";
		$tekst3=""; 
		$tekst4="Nowe promocje.";
		$tekst5="Usługi telewizyjne najkorzystniej finansowo wypadają w pakietach usług. Prosimy zapoznać się z promocyjnymi cenami usług w DWUPAKU i TRÓJPAKU usług. Szczegóły na naszej stronie internetowej.";
		$tekst6=""; 	
		$tekst7="Internet z rabatem.";
		$tekst8="Aby jeszcze obniżyć ceny abonamentów kontynuujemy promocję - Internet z rabatem - w której np. łącze 20/4 Mbits (ściąganie/wysyłanie) kosztuje 59 zł. Więcej o aktualnych promocjach dla abonentów na stronie http://live.netico.pl oraz w biurach obsługi klienta.";
		$tekst9="";
		$tekst10="Zmiany w Regulaminie świadczenia usług internetowych.";
		$tekst11="Z dniem 1 lutego 2012 wprowadzamy zmiany do Regulaminu świadczenia usług internetowych.  W celu poprawy jakości świadczonych usług z Regulaminu usunęliśmy niekorzystne dla Abonenta klauzule niedozwolone. Zmieniony Regulamin przesyłamy w załączeniu. ";
		$tekst12=""; 
		$tekst13="Dodatkowe usługi.";		
		$tekst14="Przypominamy także o naszych dodatkowych usługach:
- CYFROWA TELEFONIA VOIP - miesięczny abonament za numer to kwota już od 5 zł. Koszt połączenia
w obrębie kraju i do wybranych krajów za granicą to tylko 9 gr brutto za minutę połączenia. 
- CZAT DC (Direct Connect)  - węzeł wymiany ruchu p2p .
- SERWERY GIER.";	
		$tekst15="";	
		$tekst16="Mamy nadzieję, że podejmowane przez nas działania oceniają Państwo pozytywnie, a nasz internet oraz inne usługi cieszyć się będą Państwa niesłabnącym zainteresowaniem.
Wszelkie pytania, awarie i problemy w dostępie do sieci prosimy zgłaszać pod numerem  infolinii:       
801 000 155 lub 500 870 870.";
		$tekst29="";
		$tekst30="Z poważaniem";
		$tekst31="NETICO S.C. ";
				
				
		$poz_h=7;
		$y1=25;
		$x1=20;
		$y2=46;
			
		if ( !empty($psm[k_nazwa]) && !empty($psm[k_ulica]) && !empty($psm[k_nr_bud]) && !empty($psm[k_miasto])  )
				{						
					$psm[nazwa]=$psm[k_nazwa];
					$adres1=$psm[k_kod]." ".$psm[k_miasto];
					$adres2="ul. ".$psm[k_ulica]." ".$psm[k_nr_bud];
					if (!empty($psm[k_nr_mieszk]))
					$adres2.="/$psm[k_nr_mieszk]";
				}
		else
				{
					$adres1=$psm[kod]." ".$psm[miasto];
					$adres2="ul. ".$psm[ulica]." ".$psm[nr_bud];
					if (!empty($psm[nr_mieszk]))
					$adres2.="/$psm[nr_mieszk]";
				}
						

				$adresat=array('nazwa' => $psm[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
		
				//$pdf->AddPage();
				$pdf->SetMargins(20,15,20);
				$this->PismoNaglowek($pdf, $adresat);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(0,0,255);
				$pdf->SetXY($x1,100);
				$pdf->MultiCell(170,5,"$tekst0",0,L,0);
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$tekst1",0,L,0);
				$pdf->MultiCell(170,5,"$tekst2",0,L,0);
				$pdf->MultiCell(170,5,"$tekst3",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
				$pdf->MultiCell(170,5,"$tekst4",0,L,0);
				$pdf->SetFont('Tahoma','',9);				
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$tekst5",0,L,0);
				$pdf->MultiCell(170,5,"$tekst6",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
				$pdf->MultiCell(170,5,"$tekst7",0,L,0);
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$tekst8",0,L,0);
				$pdf->MultiCell(170,5,"$tekst9",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
				$pdf->MultiCell(170,5,"$tekst10",0,L,0);
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$tekst11",0,L,0);
				$pdf->MultiCell(170,5,"$tekst12",0,L,0);
				$pdf->SetFont('Tahoma','B',9);
				$pdf->SetTextColor(252,3,0);
				$pdf->MultiCell(170,5,"$tekst13",0,L,0);
				$pdf->SetFont('Tahoma','',9);				
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(170,5,"$tekst14",0,L,0);
				$pdf->MultiCell(170,5,"$tekst15",0,L,0);
				$pdf->MultiCell(170,5,"$tekst16",0,L,0);
		
				/*$pdf->AddPage();
				$pdf->SetFont('Tahoma','',9);
				$pdf->SetXY($x1,25);*/
				$pdf->MultiCell(160,5,"$tekst29",0,R,0);
				$pdf->MultiCell(160,5,"$tekst30",0,R,0);
				$pdf->MultiCell(160,5,"$tekst31",0,R,0);
			}
				return($pdf);
	}
	

	function VoipBiling(&$pdf, $dbh, $od, $do, $abon, $file="../func/config.php")
	{
		include $file;
		$idk=explode(" ", $abon);
		$ida=array_pop($idk);

		$q="select p.data, a.nazwa, a.symbol, a.id_abon, p.nr_zrodlowy, p.nr_docelowy, p.oplata, p.czas_polaczenia, p.rodzaj_polaczenia, p.vat
						from polaczenia_voip p, abonenci a, telefony_voip t
						where t.id_abon=a.id_abon and p.nr_zrodlowy=t.numer and  p.data>='$od 00:00:00' and p.data <= '$do 24:00:00'";

		if (!empty($abon) && $abon !=$conf[select])   		
				$q.="	and a.id_abon='$ida'";						
						
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
		"Typ połączenia"		=> $DW_W, 	"Ilość sek."	=> $TP_W,		"Kwota netto zł" => $N_W,	"Kwota brutto zł" => $NIP_W  
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
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem międzymiastowe:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[miedzymiastowe][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[miedzymiastowe][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[miedzymiastowe][oplata]=number_format(round($polaczenia[miedzymiastowe][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[miedzymiastowe][oplata],1,0,'C');
			
			$pdf->Ln();
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem międzynarodowe:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[miedzynarodowe][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[miedzynarodowe][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[miedzynarodowe][oplata]=number_format(round($polaczenia[miedzynarodowe][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[miedzynarodowe][oplata],1,0,'C');
			
			$pdf->Ln();
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem komórkowe:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[komorkowe][czas],1,0,'C');
			$kwota_netto=round($polaczenia[komorkowe][oplata]/(1+$vb[vat]/100), 2);				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[komorkowe][oplata]=number_format(round($polaczenia[komorkowe][oplata],2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[komorkowe][oplata],1,0,'C');
			
			$pdf->Ln();
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem lokalne:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[lokalne][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[lokalne][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[lokalne][oplata]=number_format(round($polaczenia[lokalne][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[lokalne][oplata],1,0,'C');
			
			$pdf->Ln();
			$pdf->Cell($LP_W+$NRD_W+$MW_W+$MW_W+$DW_W ,$W, "Razem specjalne:  ", 1,0,'R');
			$pdf->Cell($TP_W,$W, $polaczenia[specjalne][czas],1,0,'C');
			$kwota_netto=number_format(round($polaczenia[specjalne][oplata]/(1+$vb[vat]/100), 2), 2, ',','');				
			$pdf->Cell($N_W,$W, "$kwota_netto",1,0,'C');
			$polaczenia[specjalne][oplata]=number_format(round($polaczenia[specjalne][oplata], 2), 2, ',','');
			$pdf->Cell($NIP_W,$W, $polaczenia[specjalne][oplata],1,0,'C');
			
			$pdf->Ln();
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

	function checksum_code39($code) {

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

	function encode_code39_ext($code) {

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
