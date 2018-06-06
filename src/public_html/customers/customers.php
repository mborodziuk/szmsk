<?php

class CUSTOMERS
{

	private function ContractType($nr_um)
	{
		$nr=explode("/", $nr_um);
		switch ( $nr[1] )
			{
				case "UMA":
					$um="UMOWY_ABONENCKIE";
					break;
				case "UMV":
					$um="UMOWY_VOIP";
					break;
				case "UMT":
					$um="UMOWY_IPTV";
					break;
				case "UMS":
					$um="UMOWY_SERWISOWE";
					break;
			} 
		return $um;
	}
	
	

	
	function PasswdGen($dlugosc)
	{
    $pattern='1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    for($i=0; $i<$dlugosc; $i++){
        $key.=$pattern{rand(0,strlen($pattern)-1)};
    }
    return $key;
}

	function AbonServices($dbh, $id_abon, $date)
	{
		$srv=array(	'desc' 		=> '', 'sum' => 0);
		
				$q1=" ( 		select p.id_usl, t.cena, k.id_komp, t.nazwa from komputery k, towary_sprzedaz t, pakiety p  where p.id_usl=t.id_tows 
										and p.id_urz=k.id_komp and k.fv='T' and	k.podlaczony='T' 
										and p.aktywny_od <= '$date' and p.aktywny_do >='$date' and k.id_abon='$id_abon')
										union all 
										( select p.id_usl, t.cena, v.id_tlv, t.nazwa from telefony_voip v, towary_sprzedaz t, pakiety p where p.id_usl=t.id_tows 
										and p.id_urz=v.id_tlv and v.fv='T' and v.aktywny='T' 
										and p.aktywny_od <= '$date' and p.aktywny_do >='$date' and v.id_abon='$id_abon')
										union all 
										( select p.id_usl, t.cena, s.id_stb, t.nazwa from settopboxy s, towary_sprzedaz t, pakiety p, belong b 
										where p.id_usl=t.id_tows and p.id_urz=s.id_stb and b.id_urz=s.id_stb and s.fv='T' and s.aktywny='T' 
										and p.aktywny_od <= '$date' and p.aktywny_do >='$date' 
										and b.nalezy_od <= '$date' and b.nalezy_do >='$date' 
										and b.id_abon='$id_abon')
										union all 
										( select p.id_usl, t.cena, r.id_rtr, t.nazwa from router r, towary_sprzedaz t, pakiety p, belong b
										where p.id_usl=t.id_tows and p.id_urz=r.id_rtr  and b.id_urz=r.id_rtr and r.aktywny='T' 
										and p.aktywny_od <= '$date' and p.aktywny_do >='$date' 
										and b.nalezy_od  <= '$date' and b.nalezy_do  >='$date' 
										and b.id_abon='$id_abon')
										union all
										( select p.id_usl, t.cena, id_srv, t.nazwa from serwisy s, towary_sprzedaz t, pakiety p where p.id_usl=t.id_tows 
										and p.id_urz=s.id_srv and p.aktywny_od <= '$date' and p.aktywny_do >='$date' and s.id_abon='$id_abon')
										union all 
										( select p.id_usl, t.cena, s.id_sim, t.nazwa from sim s, towary_sprzedaz t, pakiety p, belong b 
										where p.id_usl=t.id_tows and p.id_urz=s.id_sim and b.id_urz=s.id_sim and s.active='T' 
										and p.aktywny_od <= '$date' and p.aktywny_do >='$date' 
										and b.nalezy_od <= '$date' and b.nalezy_do >='$date' 
										and b.id_abon='$id_abon')
										union all
										( select p.id_usl, t.cena, m.id_mdm, t.nazwa from modem m, towary_sprzedaz t, pakiety p, belong b 
										where p.id_usl=t.id_tows and p.id_urz=m.id_mdm and b.id_urz=m.id_mdm and m.active='T' 
										and p.aktywny_od <= '$date' and p.aktywny_do >='$date' 
										and b.nalezy_od <= '$date' and b.nalezy_do >='$date' 
										and b.id_abon='$id_abon')
										union all
										( select id_uvp, cena, id_abon, id_abon from uslugi_voip where id_abon='$id_abon' and fv='N')
										"; 
												
		WyswietlSql($q1);
		$sth1=Query($dbh,$q1);
		while ($row1=$sth1->fetchRow())
			{
				$id_usl=$row1[0];
				$srv[desc].="- <b>$row1[3] </b> w cenie <b> $row1[1] zł </b> brutto <br>";
				$srv[sum]+=$row1[1];			
										
				$q4="select ud.id_usl, ud.fv, ts.cena, ts.nazwa from uslugi_dodatkowe ud, towary_sprzedaz ts 
								where ts.id_tows=ud.id_usl  and ud.aktywna_od <= '$date' and ud.aktywna_do >='$date' and ud.id_urz='$row1[2]' "; 
				WyswietlSql($q4);
						
				$sth4=Query($dbh,$q4);
				while ($row4=$sth4->fetchRow())
				{
					if ( $row4[1] == 'T' )
						{
							$srv[desc].="- <b>$row4[3] </b>w cenie <b>$row4[2] zł </b>brutto <br>";
							$srv[sum]+=$row4[2];
						}
				}


		$q11=" select z.id_usl, t.cena, z.ilosc, t.nazwa from zobowiazania z, towary_sprzedaz t where z.id_usl=t.id_tows 
							and z.aktywne_od <= '$date' and z.aktywne_do >='$date' and z.id_abon='$id_abon'"; 
												
		WyswietlSql($q11);
		$sth11=Query($dbh,$q11);
		while ($row11=$sth11->fetchRow())
		{
			$srv[desc].="- $row11[3] ilość: $row11[2] w cenie: $row11[1] za sztukę <br>";
			$srv[sum]+=$row11[1]*$row11[2];			
		}
		}
	return($srv);

	}
	
	
	function AddNewAbon($dbh, $dbh2, &$plg)
	{
		include "func/config.php";
		// nazwy, siedziby i kontakty nowych abonentow maja waznosc od daty poczatku dzialania systemu tj: 2002-01-01
		$data=$conf[wazne_od];
		$id_abon=IncValue($dbh,$QA1,"ABON0000");

		if ( !empty($_POST[nr_uma1]) && !empty($_POST[nr_uma2]) && !empty($_POST[dzien]) && !empty($_POST[miesiac]) && !empty($_POST[rok]) )
		{
			$this->ContractAdd($dbh, $id_abon);
		}
		
		$passwd=$this->PasswdGen(8);
		
		$abon=array(
		'id_abon' 			=> $id_abon, 	
		'pesel_nip' 		=> IsNull($_POST[pesel_nip]), 
		'nrdow_regon' 	=> IsNull($_POST[nrdow_regon]), 		'status'		=> $_POST[status_abonenta], 		
		'saldo' 				=> 0, 'aktywny' => CheckboxToTable($_POST[aktywny]), 'platnosc'=>$_POST[platnosc], 'fv_comiesiac' => CheckboxToTable($_POST[fv_comiesiac]),
		'fv_email' 			=> CheckboxToTable($_POST[fv_email]), 'ksiazeczka' => CheckboxToTable($_POST[ksiazeczka]), 'uwagi'		=> $_POST[uwagi],'opis'		=> $_POST[opis], 'saldo_dop' 		=> 0,  'haslo' 		=> $passwd
		);
		Insert($dbh, "ABONENCI", $abon);

		
		$this->NameAdd($dbh, $id_abon, $data);
		$sdb=$this->AddressAdd($dbh, $id_abon, $data);
			
		if ( !empty($_POST[a_teldom]) || !empty($_POST[a_telkom]))
		{

			$tela=array('id_podm' => $id_abon, 'telefon'=> IsNull($_POST[a_teldom]), 'tel_kom'=> IsNull($_POST[a_telkom]));			
			Insert($dbh, "TELEFONY", $tela);
		}

			if ( !empty($_POST[a_email]) && isEmail($_POST[a_email])  )
				{
					$Q20="insert into MAILE values ('$_POST[a_email]', '$id_abon')";
					Query($dbh, $Q20);
				}
		
		if ( !empty($_POST[k_nazwa]) )
		{
			$this->KtkAdd($dbh, $id_abon, $data);
		}
		
  	if ( $abon[status] ==  "Oczekujący" )
			$plg->Pierwszyetap($dbh, $id_abon);
		
		////// L M S
		$this->LmsAddNewAbon($dbh2, $abon);
	}

	function NameAdd($dbh, $id_abon, $wazne_od=Null)
	{
		include "func/config.php";
		$id_nzw=IncValue($dbh,$QA2,"NZW0000");
		$symbol=CreateSymbol($_POST[a_nazwa]);
		if ($wazne_od == Null)
		{
			$wazne_od=$_POST[wazne_od];
			$q="select id_nzw from nazwy where id_abon='$id_abon' and wazne_do='$conf[wazne_do]'";
			$row=Query2($q, $dbh);
			$id_nzwold=$row[0];
			$wazne_do2=date('Y-m-d', strtotime('-1 day', strtotime($wazne_od))); 
			$nzw=array('id_nzw' 		=> $id_nzwold,  'wazne_do' => $wazne_do2);
			Update($dbh, "Nazwy", $nzw);
		}
		
		$nzw=array(
		'id_nzw' 		=> $id_nzw, 'id_abon' 		=> $id_abon, 	'symbol'		=> $symbol,		'nazwa' 		=> $_POST[a_nazwa], 'wazne_od' => $wazne_od, 'wazne_do' => $conf[wazne_do]
		);
		Insert($dbh, "Nazwy", $nzw);
	}

	function AddressAdd($dbh, $id_abon, $wazne_od=Null)
	{
		include "func/config.php";
		$id_sdb=IncValue($dbh,$QA3,"SDB0000");
		
		if ($wazne_od == Null)
		{
			$wazne_od=$_POST[wazne_od];
			$q="select id_sdb from adresy_siedzib where id_abon='$id_abon' and wazne_do='$conf[wazne_do]'";
			$row=Query2($q, $dbh);
			$id_sdbold=$row[0];
			$wazne_do2=date('Y-m-d', strtotime('-1 day', strtotime($wazne_od))); 
			$sdb=array('id_sdb' 		=> $id_sdbold,  'wazne_do' => $wazne_do2);
			Update($dbh, "adresy_siedzib", $sdb);
		}
				
		if ($_POST[a_budynek] != $conf[select])
		{
				$id_bud=FindId2($_POST[a_budynek]);
		}
		else if ( $_POST[a_ulica] != $conf[select] )
			{					    
				$Q33="select id_bud from budynki order by id_bud desc limit 1";
				$id_bud=IncValue($dbh, $Q33, "bud00");
				$bud=array ('id_bud'    =>$id_bud,      'id_ul' =>      FindId2( $_POST[a_ulica] ), 'numer'=>$_POST[a_nrbud], 'id_adm' => 'INS0013');			
				Insert($dbh, "budynki", $bud);
			}		
				
		$sdb=array(
		'id_sdb' 		=> $id_sdb, 'id_abon' 		=> $id_abon, 	 
		'id_bud' 		=> $id_bud,	'nr_lok' => IsNull($_POST[a_nrmieszk]), 'wazne_od' => $wazne_od, 'wazne_do' => $conf[wazne_do]
		);
		Insert($dbh, "Adresy_siedzib", $sdb);
		return ($sdb);
	}
	
	function KtkAdd($dbh, $id_abon, $wazne_od=Null)
	{
		include "func/config.php";
		$Q="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
		$id_kontakt=IncValue($dbh,$Q,"KTK0000");
		
		if ($wazne_od == Null)
		{
			$wazne_od=$_POST[wazne_od];
			$q="select id_kontakt from kontakty where id_podm='$id_abon' and wazne_do='$conf[wazne_do]'";
			$row=Query2($q, $dbh);
			$id_ktkold=$row[0];
			$wazne_do2=date('Y-m-d', strtotime('-1 day', strtotime($wazne_od))); 
			$ktk=array('id_kontakt' 		=> $id_ktkold,  'wazne_do' => $wazne_do2);
			Update($dbh, "kontakty", $ktk);
		}

		$ktk=array
			('id_kontakt'=> $id_kontakt, 'nazwa'=>$_POST[k_nazwa], 'kod'=>IsNull($_POST[k_kod]), 'miasto'=>IsNull($_POST[k_miasto]) , 
			'ulica'=>IsNull($_POST[k_ulica]), 'nr_bud'=>IsNull($_POST[k_nrbud]), 'nr_mieszk'=>IsNull($_POST[k_nrmieszk]), 'id_podm'=>$id_abon, 
			'wazne_od' => $wazne_od, 'wazne_do' => $conf[wazne_do], 'cecha' => $_POST[kcecha]);

		Insert($dbh, "KONTAKTY", $ktk);

		if ( !empty($_POST[k_teldom]) || !empty($_POST[k_telkom]))
				{
				$telk=array('id_podm' => $id_kontakt, 'telefon'=> IsNull($_POST[k_teldom]), 'tel_kom'=> IsNull($_POST[k_telkom]));			
				Insert($dbh, "TELEFONY", $telk);				
				}
				
		if ( !empty($_POST[k_email]) && isEmail($_POST[a_email])  )
				{
					$Q11="insert into MAILE values ('$_POST[k_email]', '$id_kontakt')";
	// echo $Q11;
					Query($dbh, $Q11);
				}
		if ( !empty($_POST[abonenci_email]) )
			{
			$Q11="insert into MAILE values ('$_POST[k_email]', '$id_abon')";
	// echo $Q11;
			Query($dbh, $Q11);
			}
	}	
	
	
	function LmsAddNewAbon($dbh2, $abon)
	{
		include "func/config.php";
		$id=explode("N", $abon['id_abon']);
		$name1=str_replace("&", "and", $_POST[a_nazwa]);
		$name2=explode(" ", $name1);

		if ($_POST[a_budynek] != $conf[select] )
		{
				$id_bud=FindId2($_POST[a_budynek]);
				$q="select u.nazwa, u.miasto, u.kod, b.numer from budynki b, ulice u where u.id_ul=b.id_ul and b.id_bud='$id_bud'";
				WyswietlSql($q);
				$r=Query2($q, $dbh);
				$address="$r[0] $r[3]";
				if ( !empty($_POST[a_nrmieszk]) )
				{
					$address.="/$_POST[a_nrmieszk]";
				}
				$zip="$r[2]";
				$city="$r[1]";
		}
		else if ( $_POST[a_ulica] != $conf[select] )
		{					    
				$id_ul=FindId2($_POST[a_ulica]);
				$q="select nazwa, miasto, kod from ulice where id_ul='$id_ul'";
				WyswietlSql($q);
				$r=Query2($q, $dbh);
				$address="$r[0] $_POST[a_nrbud]";
				if ( !empty($_POST[a_nrmieszk]) )
				{
					$address.="/$_POST[a_nrmieszk]";
				}
				$zip="$r[2]";
				$city="$r[1]";
		}		
		
		if ( ValidateNip($abon[pesel_nip]) )
		{
			$abon_lms=array(
			'id' 				=> $id[1], 	
			'lastname' 	=> $name1,
			'name' 			=> '',
			'status' 		=> '3',
			'type'			=> '1',
			'street'		=> $address,
			'zip'				=> $zip,
			'city'			=> $city
			);
		}
		else
		{
			$abon_lms=array(
			'id' 				=> $id[1], 	
			'lastname' 	=> $name2[0],
			'name' 			=> $name2[1],
			'status' 		=> '3',
			'type'			=> '0',
			'street'		=> $address,
			'zip'				=> $zip,
			'city'			=> $city
			);
		}

		Insert($dbh2, "CUSTOMERS", $abon_lms);
	}
	
	function UpdateAbon($dbh, $dbh2, $id_abon, &$plg)
	{
		include "func/config.php";

		$id_bud=FindId2($_POST[a_budynek] );
		
		$a="$id_abon"."$session[abonent][update]";	
  	$ta="$id_abon"."_telefony_a";
		$ma="$id_abon"."_maile_a";
		$mia="$id_abon"."_miejsca_instalacji";
		$k="$id_abon"."_kontakty";
		$tk="$id_abon"."_telefony_k";
		$mk="$id_abon"."_maile_k";

		$ab1			=$_SESSION["$a"];
		$mi1			=$_SESSION["$mia"];
		$wl1			=$_SESSION['wlasciciele'];
		$tela1		=$_SESSION["$ta"];
		$mailea1	=$_SESSION["$ma"];
		$kontakt1	=$_SESSION["$k"];
		$telk1		=$_SESSION["$tk"];
		$mailek1	=$_SESSION["$mk"];
		$um1			=$_SESSION[umowy];
		


		foreach ($_POST as $k => $v)
		{
			$idk=explode(" ", $v);
			$ida=array_pop($idk);
			$id=explode("_", $k);
			if ( $k!="przycisk" && $id[1] == "check" && isset($_POST[$k]))
			{
				$umowy=$this->ContractType($id[0]);	
				$q3="delete from umowy_abonenckie where nr_um='$id[0]'";
				WyswietlSql($q3);
				Query($dbh, $q3);
			}
		}
		
		
		$ab2=array 
		(
		'id_abon'=>$ab1[id_abon], 'pesel_nip' => IsNull($_POST[pesel_nip]), 'nrdow_regon' => IsNull($_POST[nrdow_regon]), 
		'status' => $_POST[status_abonenta], 'saldo' => $_POST[saldo], 'aktywny' => CheckboxToTable($_POST[aktywny]), 
		 'platnosc'=>$_POST[platnosc], 'fv_comiesiac' => CheckboxToTable($_POST[fv_comiesiac]),
		'fv_email' => CheckboxToTable($_POST[fv_email]), 'ksiazeczka' => CheckboxToTable($_POST[ksiazeczka]) , 'uwagi'		=> $_POST[uwagi],'opis'		=> $_POST[opis], 'saldo_dop' => $_POST[saldo_dop]
		);

		if ( $ab1[status] == "Oczekujący" &&  $ab2[status] == "Podłączony") 
		{
				$ab2[aktywny]='T';
		}
		
  	if ( $ab1[status] ==  "Podłączony" &&  $ab2[status] ==  "Oczekujący" ) 
		{
				$plg->PierwszyEtap($dbh, $id_abon);
		}
		
		if ( $um1[status] == "Obowiązująca" && $_POST[status_uma] == "Rozwiązana") 
		{
				$ab2[aktywny]='N';
		}
		else if ( $um1[status] == "Rozwiązana" && $_POST[status_uma] == "Obowiązująca") 
		{
				$ab2[aktywny]='T';
		}	
		Update($dbh, "ABONENCI", $ab2);

		
		$nzw=array(
		'id_nzw' 		=> $ab1[id_nzw], 'symbol'=> IsNull($_POST[a_symbol]), 'nazwa' => $_POST[a_nazwa]
		);
		Update($dbh, "Nazwy", $nzw);

		$sdb=array(
		'id_sdb' 		=> $ab1[id_sdb], 	'id_bud' => $id_bud, 'nr_lok' => IsNull($_POST[a_nrmieszk]),
		);
		Update($dbh, "Adresy_siedzib", $sdb);

		
		if ( !empty($_POST[saldo_dop]) && !empty($_POST[saldo_data]) )
			{
				if ( !empty($ab1[saldo_dop]) && !empty($ab1[saldo_data]) )
				{
					$sch=array( 'id_sch'=>$ab1[id_sch], 'data'=>$_POST[saldo_data] );
					Update($dbh, "SCHEDULER", $sch);
				}
				else
				{
					$id_sch=IncValue($dbh,$Q11,  "SCH00000"); 
					$sch=array( 'id_sch'=> $id_sch, 'data'=>$_POST[saldo_data], 'encja' => 'abonenci', 
					'kolumna' => 'saldo_dop', 'wartosc' => 0, 'cecha' => 'id_abon', 'argument' =>$ab1['id_abon'] );
					
					Insert($dbh, "SCHEDULER", $sch);
				}
			}
		else
			{
			if ( !empty($ab1[saldo_dop]) && !empty($ab1[saldo_data]) )
				{
					$Q="delete from scheduler where id_sch='$ab1[id_sch]'";
					WyswietlSql($Q); 
					Query($dbh, $Q);
				}
			}
			
		
		$tela2=array 
		(
			'id_podm' => $ab1[id_abon], 'telefon'=> IsNull($_POST[a_teldom]), 'tel_kom'=> IsNull($_POST[a_telkom]) 
		);

		if ( !empty($tela1[telefon]) || !empty($tela1[tel_kom]) )
			{
				if ( !empty($tela2[telefon]) || !empty($tela2[tel_kom]) )
					Update($dbh, "TELEFONY", $tela2);
				else
					Insert($dbh, "TELEFONY", $tela2);
			}

		if ( !empty($_POST[a_email])  && isEmail($_POST[a_email])  )
			{
				if ( !empty($mailea1[email]) )
					$Q="update MAILE set email='$_POST[a_email]' where id_podm='$ab1[id_abon]'";
				else
					$Q="insert into MAILE values ('$_POST[a_email]', '$ab1[id_abon]' )";
				WyswietlSql($Q); 
				Query($dbh, $Q);
			}

		$id_kontakt=$kontakt1[id_kontakt];
		if ( !empty($_POST[k_nazwa]) )
			{
				$k_kod=IsNull($_POST[k_kod]);
				$k_miasto=IsNull($_POST[k_miasto]);
				$k_ulica=IsNull($_POST[k_ulica]);
				$k_kod=IsNull($_POST[k_nrbud]);
				$k_nrbud=IsNull($_POST[k_nrbud]);
				$k_nrmieszk=IsNull($_POST[k_nrmieszk]);
				$k_cecha=IsNull($_POST[kcecha]);				
				if ( !empty($kontakt1[nazwa]) )
					{
						$ktk=array
						('id_kontakt'=> $id_kontakt, 'nazwa'=>$_POST[k_nazwa], 'kod'=>IsNull($_POST[k_kod]), 'miasto'=>IsNull($_POST[k_miasto]) , 
						'ulica'=>IsNull($_POST[k_ulica]), 'nr_bud'=>IsNull($_POST[k_nrbud]), 'nr_mieszk'=>IsNull($_POST[k_nrmieszk]), 
						'id_podm'=>$ab1[id_abon], 'cecha' => $_POST[kcecha]);
						Update($dbh, "KONTAKTY", $ktk);					
					}
				else
					{
						$Q1="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
						$id_kontakt=IncValue($dbh,$Q1);
				
						$ktk=array
						('id_kontakt'=> $id_kontakt, 'nazwa'=>$_POST[k_nazwa], 'kod'=>IsNull($_POST[k_kod]), 'miasto'=>IsNull($_POST[k_miasto]) , 
						'ulica'=>IsNull($_POST[k_ulica]), 'nr_bud'=>IsNull($_POST[k_nrbud]), 'nr_mieszk'=>IsNull($_POST[k_nrmieszk]), 'id_podm'=>$ab1[id_abon],
						'wazne_od' => $conf[wazne_od], 'wazne_do' => $conf[wazne_do]);
						Insert($dbh, "KONTAKTY", $ktk);
					}
					
				if ( !empty($_POST[k_teldom]) || !empty($_POST[k_telkom]) )
					{
						$teldom=IsNull($_POST[k_teldom]);
						$telkom=IsNull($_POST[k_telkom]);
						if ( !empty($telk1[telefon]) || !empty($telk2[tel_kom]) )
							$Q="update TELEFONY set telefon='$teldom', tel_kom='$telkom' where id_podm='$ID_K'";
						else
							$Q="insert into TELEFONY values ('0-32', '$teldom', '$telkom', '$ID_K')";
						WyswietlSql($Q);
						Query($dbh, $Q);
					}
				if ( empty($_POST[k_teldom]) && empty($_POST[k_telkom]) && (!empty($telk1[telefon]) || !empty($telk1[tel_kom])) )
					{
						$Q="delete from TELEFONY where id_podm='$ID_K'";
				WyswietlSql($Q); 
						Query($dbh, $Q);
					}
				if ( !empty($_POST[k_email])  && isEmail($_POST[a_email])  )
					{
						if ( !empty($mailek1[email]) )
							$Q="update MAILE  set email='$_POST[k_email]' where id_podm='$ID_K'";
						else
							$Q="insert into MAILE values ('$_POST[k_email]','$ID_K' )";
				WyswietlSql($Q); 
						Query($dbh, $Q);
					}
				if ( empty($_POST[k_email]) && !empty($mailek1[email]) )
					{
						$Q="delete from MAILE where email='$mailek1[email]'";
				WyswietlSql($Q); 
						Query($dbh, $Q);
					}
			}
		else 	if ( empty($_POST[k_nazwa]) && !empty($kontakt1[nazwa]) )
			{
				if ( !empty($telk1[telefon]) || !empty($telk1[tel_kom]) )
					{
						$Q="delete from TELEFONY where id_podm='$ID_K'";
						WyswietlSql($Q); 
						Query($dbh, $Q);
					}

				if ( !empty($mailek1[email]) )
					{
						$Q="delete from MAILE where email='$mailek1[email]'";
				WyswietlSql($Q); 
						Query($dbh, $Q);
					}

				$Q="delete from kontakty where id_kontakt='$ID_K'";
				WyswietlSql($Q); 
				Query($dbh, $Q);

			}
			
		////// L M S
		$this->LmsUpdAbon($dbh2, $ab2);
			
}

	function LmsUpdAbon($dbh2, $abon)
	{
		include "func/config.php";
		$id=explode("N", $abon['id_abon']);
		$name1 = str_replace("&", "and", $_POST[a_nazwa]);
		$name2=explode(" ", $name1);


		if ($_POST[a_budynek] != $conf[select] )
		{
				$id_bud=FindId2($_POST[a_budynek]);
				$q="select u.nazwa, u.miasto, u.kod, b.numer from budynki b, ulice u where u.id_ul=b.id_ul and b.id_bud='$id_bud'";
				WyswietlSql($q);
				$r=Query2($q, $dbh);
				$address="$r[0] $r[3]";
				if ( !empty($_POST[a_nrmieszk]) )
				{
					$address.="/$_POST[a_nrmieszk]";
				}
				$zip="$r[2]";
				$city="$r[1]";
		}
		else if ( $_POST[a_ulica] != $conf[select] )
		{					    
				$id_ul=FindId2($_POST[a_ulica]);
				$q="select nazwa, miasto, kod from ulice where id_ul='$id_ul'";
				WyswietlSql($q);
				$r=Query2($q, $dbh);
				$address="$r[0] $_POST[a_nrbud]";
				if ( !empty($_POST[a_nrmieszk]) )
				{
					$address.="/$_POST[a_nrmieszk]";
				}
				$zip="$r[2]";
				$city="$r[1]";
		}		
		
		if ( ValidateNip($abon[pesel_nip]) )
		{
			$abon_lms=array(
			'id' 				=> $id[1], 	
			'lastname' 	=> $name1,
			'name' 			=> '',
			'status' 		=> '3',
			'type'			=> '1',
			'street'		=> $address,
			'zip'				=> $zip,
			'city'			=> $city
			);
		}
		else
		{
			$abon_lms=array(
			'id' 				=> $id[1], 	
			'lastname' 	=> $name2[0],
			'name' 			=> $name2[1],
			'status' 		=> '3',
			'type'			=> '0',
			'street'		=> $address,
			'zip'				=> $zip,
			'city'			=> $city
			);
		}

		Update($dbh2, "CUSTOMERS", $abon_lms);
	}


  function ListaAbonentow($dbh, $p)
	{
		 include "func/config.php";
		 
		 switch ( $p[usluga] )
		 {
				case "Internet":
					$device="komputery";
					break;
				case "VoIP":
					$device="bramki_voip";
					break;
				case "IpTV":
					$device="settopboxy";
					break;
				case "Serwis":
					$device="serwisy";
					break;
				case "Wirtualni":
					$device="abonenci_wirtualni";
					break;
			}
			
			function transform1($p)
			{	
				include "func/config.php";
				if ($p[nazwa]!=$conf[select])
					$q.=" and n.nazwa ilike '%$p[nazwa]%'";

				if ($p[ulice]!=$conf[select])
					$q.=" and u.nazwa='$p[ulice]'";
					
							if ($p[miasto]!=$conf[select])
											$q.=" and u.miasto='$p[miasto]'";
															
				if ($p[budynki]!=$conf[select])
					$q.=" and b.numer='$p[budynki]'";

							if ($p[umowa]=="oczekujący")
								$q.=" and a.status='Oczekujący'";
														
				if ($p[saldo]!=$conf[select])
					{
						switch ( $p[saldo] )
							{
								case "< -200" :
										$q.=" and a.saldo < -200";
										break;
								case "-150 do -100" :
										$q.=" and a.saldo between -200 and -101";
										break;
								case "-100 do 0" :
										$q.=" and a.saldo between -100 and -1";
										break;
								case "0" :
										$q.=" and a.saldo=0";
										break;
								case "0 do 100" :
										$q.=" and a.saldo between 1 and 100";
										break;
								case "100 do 200" :
										$q.=" and a.saldo between 101 and 200";
										break;
								case "> 200" :
										$q.=" and a.saldo > 200";
										break;
							}
					}
					return $q;
			}
			
			function transform2($p)
			{
				include "func/config.php";
				$q="";	 
				if ($p[umowa]!=$conf[select])
					{
						switch ( $p[umowa] )
							{
								case "obowiązująca" :
									$q.=" and um.status='Obowiązująca'";
									break;
								case "rozwiązana" :
									$q.=" and um.status='Rozwiązana'";
									break;
								case "zawieszona" :
									$q.=" and um.status='Zawieszona'";
									break;
								case "windykowana" :
									$q.=" and um.status='windykowana'";
									break;
								case "czas nieokreślony" :
									$q.=" and um.typ_um='0'";
									break;
								case "czas określony" :
									$q.=" and um.typ_um='24'";
									break;					    
							}
					}
					 return $q;	
			}
		
		
		if ($p[umowa]=="brak umowy")
		{
					$q="select distinct a.id_abon, n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, a.saldo
							from abonenci a,ulice u, budynki b, nazwy n, adresy_siedzib s
							where  u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=n.id_abon and a.id_abon=s.id_abon 
							and  n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
							and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'
							and a.id_abon not in (select id_abon from umowy_abonenckie)";
					$q.=transform1($p);		

		}										    
		else	if ( $p[umowa]=="oczekujący" )
		{
					$q="select distinct a.id_abon, n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, a.saldo
							from abonenci a,ulice u, budynki b, nazwy n, adresy_siedzib s
							where  u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=n.id_abon and a.id_abon=s.id_abon 
							and  n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
							and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'";
					$q.=transform1($p);		

		}		
		else if ($p[umowa]==$conf[select])
		{
					$q="select distinct a.id_abon, n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, a.saldo
							from abonenci a,ulice u, budynki b, nazwy n, adresy_siedzib s
							where  u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=n.id_abon and a.id_abon=s.id_abon 
							and  n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
							and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'";
					$q.=transform1($p);	
		}	
		
		else 
		{
			if ( $p[usluga] != "VoIP" )
				$q="select distinct  a.id_abon, n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, a.saldo
				from abonenci a,ulice u, budynki b , umowy_abonenckie um, nazwy n, miejsca_instalacji s, $device d
				where u.id_ul=b.id_ul and um.id_abon=a.id_abon and a.id_abon=d.id_abon and n.id_abon=a.id_abon and d.id_msi=s.id_msi and s.id_bud=b.id_bud
				and um.data_zaw between '$p[data_od]' and '$p[data_do]' 
				and  n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'";
			else
				$q="select distinct  a.id_abon, n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, a.saldo
				from abonenci a,ulice u, budynki b , umowy_abonenckie um, nazwy n, miejsca_instalacji s, $device d, telefony_voip t
				where u.id_ul=b.id_ul and um.id_abon=a.id_abon and a.id_abon=t.id_abon and t.id_bmk=d.id_bmk and n.id_abon=a.id_abon and d.id_msi=s.id_msi and s.id_bud=b.id_bud
				and um.data_zaw between '$p[data_od]' and '$p[data_do]' 
				and  n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'";
				
				$q.=transform1($p);
				$q.=transform2($p);	
		}
			
		if ( isset ($_POST[nowi]) ) 
						$q.=" and a.id_abon not in (select id_abon from umowy_abonenckie where status='Rozwiązana')";

		$q.=" order by n.nazwa";

		
		WyswietlSql($q);	
		$sth=Query($dbh,$q);
		$lp=1;
		 while ($row =$sth->fetchRow())
			{
				$q2="select telefon, tel_kom from telefony where id_podm='$row[0]'";
				$sth2=Query($dbh,$q2);
				$row2=$sth2->fetchRow();
				$q3="select email from maile where id_podm='$row[0]'";
				$sth3=Query($dbh,$q3);
				$row3=$sth3->fetchRow();
				$q5="select nazwa from kontakty where id_podm='$row[0]'";
				$sth5=Query($dbh,$q5);
				$row5=$sth5->fetchRow();
				$q6="select t.telefon, t.tel_kom from telefony t, kontakty k where k.id_kontakt=t.id_podm and k.id_podm='$row[0]'";
				$sth6=Query($dbh,$q6);
				$row6=$sth6->fetchRow();
				$q7="select email from maile m, kontakty k where k.id_kontakt=m.id_podm and k.id_podm='$row[0]'";
				$sth7=Query($dbh,$q7);
				$row7=$sth7->fetchRow();
				
				 switch ( $p[usluga] )
				{
					case "Internet":
						$q4="select count(id_komp) from komputery k, abonenci a where k.id_abon=a.id_abon and a.id_abon='$row[0]'"; 
						$sth4=Query($dbh,$q4);
						$row4=$sth4->fetchRow();
						$q8="select t.symbol from komputery k, towary_sprzedaz t, abonenci a, pakiety p where k.id_komp=p.id_urz and p.id_usl=t.id_tows and k.id_abon=a.id_abon and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' and a.id_abon='$row[0]'"; 
						$sth8=Query($dbh,$q8);
						break;
					case "VoIP":
						$q4="select count(id_tlv) from telefony_voip tl, abonenci a where tl.id_abon=a.id_abon and a.id_abon='$row[0]'"; 
						$sth4=Query($dbh,$q4);
						$row4=$sth4->fetchRow();
						$q8="select t.symbol from telefony_voip tl, towary_sprzedaz t, abonenci a, pakiety p where tl.id_tlv=p.id_urz and p.id_usl=t.id_tows and tl.id_abon=a.id_abon and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' and a.id_abon='$row[0]'"; 
						$sth8=Query($dbh,$q8);
						break;
					case "IpTV":
						$q4="select count(id_stb) from settopboxy s, abonenci a where s.id_abon=a.id_abon and a.id_abon='$row[0]'"; 
						$sth4=Query($dbh,$q4);
						$row4=$sth4->fetchRow();
						$q8="select t.symbol from settopboxy k, towary_sprzedaz t, abonenci a, pakiety p where k.id_stb=p.id_urz and p.id_usl=t.id_tows and k.id_abon=a.id_abon and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' and a.id_abon='$row[0]'"; 
						$sth8=Query($dbh,$q8);					
						break;
					case "Serwis":
						$q4="select count(id_komp) from komputery k, abonenci a where k.id_abon=a.id_abon and a.id_abon='$row[0]'"; 
						$sth4=Query($dbh,$q4);
						$row4=$sth4->fetchRow();
						$q8="select t.symbol from komputery k, towary_sprzedaz t, abonenci a, pakiety p where k.id_komp=p.id_urz and p.id_usl=t.id_tows and k.id_abon=a.id_abon and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]' and a.id_abon='$row[0]'"; 
						$sth8=Query($dbh,$q8);					
						break;
				}
				
				DrawTable($lp++,$conf[table_color]);
				$liczbaporzad=$lp-1;
				echo "<td><i>$liczbaporzad.</i></td>";
				if ( $_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin')
					echo "<td class=\"klasa4\"> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[0]\"> $row[0] </a> </td>";
				else
					echo "<td class=\"klasa4\"> <a href=\"index.php?panel=sprzedaz&menu=updateabon&abon=$row[0]\"> $row[0] </a> </td>";	
					
				$s=Choose($row[1], $row[2]);
					echo "<td class=\"klasa4b\"> $s </td>";
					echo "<td class=\"klasa4\"> $row[4], ul. $row[5] $row[6]";
					if (!empty($row[7]))
						echo "/$row[7] </td>";
					echo "<td class=\"klasa4\">";
				if ( !empty($row2[0]) )
						echo " $row2[0] ";
				if ( !empty($row2[1]) )
						echo "&nbsp $row2[1] ";
				if ( !empty($row3[0]) )
						echo "<br> <a href=\"mailto:$row3[0]\"> e-mail </a>";
				echo "</td>";
				/*	
					echo "<td class=\"klasa4\">";
				if ( !empty($row5[0]) )
					echo "$row5[0] <br/>";
				if ( !empty($row6[0]) )
					echo " $row6[0] <br/>";
				if ( !empty($row6[1]) )
					echo " $row6[1] <br/>";
				if ( !empty($row7[0]) )
					echo "<a href=\"mailto:$row7[0]\"> e-mail </a> <br/>";
				echo "</td>";
				*/
					echo "<td class=\"klasa4\">";
				echo "$row4[0]";
				while ($row8 =$sth8->fetchRow())
				{
				echo "<br> $row8[0]";
				}
				echo "</td>";
				
				$saldo=round( $row[8], 2 );
				echo "<td class=\"klasa4\"> $saldo </td>";
				if ( $_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin' )
				{
					echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"K-$row[0]\"/></td>";
					echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"W-$row[0]\"/></td>";
					echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"P-$row[0]\"/></td>";
				}
				echo "</tr>";
			}
	}		
	
	
	
	function ZastosujAbon($dbh, &$windykacja, &$plg)
	{
		include "func/config.php";

		$from="windykacja@netico.pl";

		$data=date("Y-m-d");

		foreach ($_POST as $k => $v)
			{
			if ( $k!="przycisk" )
				{
						$t=explode("-", $k);
						if ($t[0]=="K")
						{
							$q2="delete from kontakty where id_podm='$t[1]';
							delete from telefony where id_podm='$t[1]';
							delete from nazwy where id_abon='$t[1]';
							delete from adresy_siedzib where id_abon='$t[1]';
							delete from abonenci where id_abon='$t[1]'";
							WyswietlSql($q2);	
							Query($dbh, $q2);
						}
					 else if ($t[0]=="W" &&  $t[1]!="przycisk" )
						{		
								$windykacja->PierwszyKrok($dbh, $t[1]);
								
							}
					 else if ($t[0]=="P" &&  $t[1]!="przycisk" )
						{		
								$plg->PierwszyEtap($dbh, $t[1]);
								
							}
				}
		//		else echo "przycisk";
			}
			
		echo "Wprowadzono zmiany do systemu.";
	}
	
	function ValidateAbon($dbh)
	{
		$flag=1;

	/*	if ( empty ($_POST["nr_uma1"]) || empty ($_POST["nr_uma1"]))
			{ 
			echo "Błąd pola 'Numer umowy' : pole jest puste <br>";
			$flag=0;
			}	
		if ( empty ($_POST["dzien"]) || empty ($_POST["miesiac"]) || empty ($_POST["rok"])) 
		{
			echo "Błąd pola 'Data zawarcia umowy' : pole jest puste <br>";
			$flag=0;
		}
	*/
		if (  empty ($_POST["a_nazwa"]) ) 
		{
			echo "Błąd pola 'Imię i nazwisko (nazwa) abonenta' : pole jest puste <br>";
			$flag=0;
		}
		if (  !empty ($_POST[saldo_data]) ) 
			$flag=ValidateDate($_POST[saldo_data]);

	/*
		if (  empty ($_POST["abonenci_pr"]) ) 
		{
			echo "Błąd pola 'PESEL (NIP) Abonenta' : pole jest puste <br>";
			$flag=0;
		}

		if (  empty ($_POST["abonenci_sn"]) ) 
		{
			echo "Błąd pola 'Nr dowodu osobistego (REGON) Abonenta' : pole jest puste <br>";
			$flag=0;
		}

		if (  empty ($_POST["abonenci_nr_miesz"]) ) 
		{
			echo "Błąd pola 'Numer mieszkania Abonenta' : pole jest puste <br>";
			$flag=0;
		}
	*/
		if ( empty ($_POST["a_teldom"]) && empty ($_POST["a_telkom"])&& empty ($_POST["k_telkom"])&& empty ($_POST["k_telkom"]) )
		{ 	 
			echo "Nie podano żadnego numeru telefonu Abonenta";
			$flag=0;
		}
		
		return ($flag);	
	}
	
	function ContractList($dbh, $id_abon)
	{
			
				$q1="(select nr_um, data_zaw, data_zycie, typ_um, status, ulga from umowy_abonenckie 
						 where id_abon='$id_abon'  order by data_zycie)
						 union
						 (select nr_um, data_zaw, data_zycie, typ_um, status, ulga from umowy_serwisowe 
						 where id_abon='$id_abon' order by data_zycie)
						 order by 3";
				
			  WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				WyswietlSql($q1);
				unset($q1);
				while ( $row =$sth1->fetchRow() )
					{
						$q2="select count(d.nr_ds) from dokumenty_sprzedaz d, umowy_abonenckie u where 
							u.id_abon=d.id_odb and d.id_odb='$id_abon' and d.data_wyst>=u.data_zycie and u.nr_um='$row[0]'";
						$r2=Query2($q2, $dbh);

						//ulga na miesiac
						if ( !empty($row[5]) && $row[3]!=0)
						{
							$unm=$row[5]/$row[3];
							// pozostala ulga
							$pozostalo=($row[3]-$r2[0])*$unm;
							$pozostalo=number_format($pozostalo, 2, '.','');
							$ulga=number_format($row[5], 2, '.','');
						}
						else
						{
							$ulga=0;
							$pozostalo=0;
						}
						echo "<tr>";
						echo "<tr><td> $lp.</td>";
						echo "<td colspan=\"1\"> <a href=\"index.php?panel=inst&menu=updateum&um=$row[0]&abon=$id_abon\">$row[0]</a> </td>";
						echo "<td> $row[1] </td>";
						echo "<td> $row[2] </td>";
						echo "<td> $row[3] </td>";
						echo "<td> $ulga <br> $pozostalo</td>";
						echo "<td> $row[4] </td>";
						echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"$row[0]_check\"/></td>";	
						echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=uma&uma=$row[0]',800,1100, '38')\"> 
						<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
						echo "</tr>";
						++$lp;
					}

	}
	
	function ContractUpdate($dbh, $nr_um, &$zlc, &$szmsk)
	{
		include "func/config.php";
		$nr=explode("/", $nr_um);
		
		$um="umowa"."$nr_um";
		$um2=$_SESSION['$um'];
	
		
		$q="select id_abon from umowy_abonenckie where nr_um='$nr_um'";
		$r=Query2($q,$dbh);
		$id_abon=$r[0];
																												
		if ( !empty($_POST["nr_um1"]) && !empty($_POST["nr_um2"]))
			{
				$data_zawarcia="$_POST[rok]"."-"."$_POST[miesiac]"."-"."$_POST[dzien]";
				if ($data_zawarcia[0] !="2" && $data_zawarcia[1] !="0") 
						$data_zawarcia="20"."$data_zawarcia";
				
				$data_zycie="$_POST[rokz]"."-"."$_POST[miesiacz]"."-"."$_POST[dzienz]";
				if ($data_zycie[0] !="2" && $data_zycie[1] !="0")
						$data_zycie="20"."$data_zycie";
						
				$nr_um2="$_POST[nr_um1]/$_POST[rodzaj]/$_POST[nr_um2]";
				
				$um = array(
				'nr_um' 	=> $nr_um, 							'			data_zaw' 		=> $data_zawarcia, 	'typ_um' 		=> $_POST[typ_um], 
				'status' 	=> $_POST[status_uma], 				'miejsce' 		=> $_POST[miejsce], 'siedziba' 	=> CheckboxToTable($_POST[siedziba]),				
				'id_prac' => 	FindId2($_POST[id_prac]), 	'data_zycie' 	=> $data_zycie , 'szablon' => $_POST[szablon], 'ulga' => $_POST[ulga]
				 );	
				
				$umowy=$this->ContractType($nr_um);
				Update($dbh, "umowy_abonenckie", $um);
				
				if ( $nr_um != $nr_um2)
				{
					$q4="update umowy_abonenckie set nr_um='$nr_um2' where nr_um='$nr_um'";
					WyswietlSql($q4);
					Query($dbh, $q4);
				}
				
				if ( $um2[status]=="Obowiązująca" && $_POST[status_uma]=="Rozwiązana" )
				{
					$wyp=array( 'nr_um'=> $nr_um,'dokonane' => 'T');
					Update($dbh, "wypowiedzenia_umow_abonenckich", $wyp);
					
					$q2="select id_abon from umowy_abonenckie where id_abon='$r[0]' and status='Obowiązująca'";
					WyswietlSql($q2);
					$r2=Query2($q2,$dbh);
					if ( empty($r2[0]) )
						$zlc->Demontaz($dbh, $id_abon, $szmsk);
				}
				else if ( $um2[status]=="Obowiązująca" && $_POST[status_uma]=="Zawieszona" )
				{
					$zlc->Demontaz($dbh, $id_abon, $szmsk);
				}
				else if ( $um2[status]=="Obowiązująca" && $_POST[status_uma]=="windykowana" )
				{
					$zlc->Demontaz($dbh, $id_abon, $szmsk);
				}				
				else if ( $um2[status]=="Rozwiązana" && $_POST[status_uma]=="Obowiązująca" )
				{
					$wyp=array( 'nr_um'=> $nr_um,'dokonane' => 'N');
					Update($dbh, "wypowiedzenia_umow_abonenckich", $wyp);
				}
			}
	}
	

	
	
	function FindLastUm($dbh, $date)
{
    $d=substr($date, 2, 2);
    $Q="select nr_um from umowy_abonenckie where nr_um like '%/UMA/$d' order by nr_um desc limit 1";
		WyswietlSql($Q);
    $row=Query2($Q, $dbh);
    if (empty($row[0]))
        $nr="0001/UMA/$d";
    else
    $nr=$this->IncNrUm($row[0]);
    return ($nr);
}
	
	function IncNrUm($nr)
{
    $nry=explode("/", $nr);
    ++$nry[0];
    if ($nry[0] < 10)
        $nry[0]="000"."$nry[0]";
    else if ($nry[0] < 100)
        $nry[0]="00"."$nry[0]";
		else if ($nry[0] < 1000)
				$nry[0]="0"."$nry[0]";
		$nry[0]="$nry[0]";
	
    $new_nr="$nry[0]"."/UMA/"."$nry[2]";
	   return($new_nr);
}

	function UpdateNrUm($nr)
{

			$nry=explode("/", $nr);
			++$nry[0];
			--$nry[0];
			if ($nry[0] < 10)
					$nry[0]="000"."$nry[0]";
			else if ($nry[0] < 100)
					$nry[0]="00"."$nry[0]";
			else if ($nry[0] < 1000)
					$nry[0]="0"."$nry[0]";
					
			$nry[0]="$nry[0]";
		
			$new_nr="$nry[0]";
			return($new_nr);
}
	
	function ContractAdd($dbh, $id_abon)
	{
			$data_zawarcia="$_POST[rok]"."-"."$_POST[miesiac]"."-"."$_POST[dzien]";
			if ($data_zawarcia[0] !="2" && $data_zawarcia[1] !="0")
						$data_zawarcia="20"."$data_zawarcia";

			$data_zycie="$_POST[rokz]"."-"."$_POST[miesiacz]"."-"."$_POST[dzienz]";
			if ($data_zycie[0] !="2" && $data_zycie[1] !="0")
						$data_zycie="20"."$data_zycie";
						
			if ( empty ($_POST["nr_um1"]) )
				$nr_um=$this->FindLastUm($dbh, $data_zawarcia);
			else
			{
				$nr1=$this->UpdateNrUm($_POST["nr_um1"]);
				$nr_um="$nr1"."/".$_POST["rodzaj"]."/".$_POST["nr_um2"];
			}

						
				$um=array(
				'nr_um' => $nr_um, 'data_zaw' => $data_zawarcia, 'typ_um' => $_POST[typ_um], 'id_abon' => $id_abon, 
				'status' => $_POST[status_uma], 'miejsce' => $_POST[miejsce], 'siedziba' => CheckboxToTable($_POST[siedziba]),
				'id_prac' => 	FindId2($_POST[id_prac]), 'data_zycie' => $data_zycie, 'szablon' => $_POST[szablon], 'ulga' => $_POST[ulga]
				 );
				
				$umowy=$this->ContractType( $nr_um );
				Insert($dbh, "umowy_abonenckie", $um);
				
				/*
				if ( $umowy == "UMOWY_VOIP" )
				{
						$abon=array('id_abon' => $id_abon, 'fv_comiesiac' => 'N', 'fv_email' => 'T', 'ksiazeczka' => 'N'	 );
						Update($dbh, "ABONENCI", $abon);
				}
				
				$komp=$_SESSION['komp'];
				$stb=$_SESSION['stb'];
				$tlv=$_SESSION['tlv'];
				
				$computers= new COMPUTERS();
				if (empty($komp[t_symbol]) && empty($komp[podlaczony]))
				{
					echo "empty";
					$computers->AddNewKomp($dbh, $id_abon);
				}
				else
				{		
					$computers->UpdateKomp($dbh, $komp[id_komp]);
				}
			
				if (empty($stb[stb]) && empty($stb[taryfas]))
				{
					$id_stb= FindId2($_POST[stb]);
					$iptv=new IPTV();
					$iptv->UpdateCtrSTB($dbh, $id_stb, $id_abon);
				}
				*/
	}
	
	function ContractValidate($dbh)
	{
		$flag=1;
		$flag=ValidateDate ("$_POST[rok]-$_POST[miesiac]-$_POST[dzien]"); 
		
		if ( empty ($_POST["nr_um2"]) || empty ($_POST["nr_um2"]))
			{ 
			echo "Błąd pola 'Numer umowy' : pole jest puste <br>";
			$flag=0;
			}	
		if ( empty ($_POST["dzien"]) || empty ($_POST["miesiac"]) || empty ($_POST["rok"])) 
		{
			echo "Błąd pola 'Data zawarcia umowy' : pole jest puste <br>";
			$flag=0;
		}
		if ( empty ($_POST["dzienz"]) || empty ($_POST["miesiacz"]) || empty ($_POST["rokz"])) 
		{
			echo "Błąd pola 'Data wejscia w życie umowy' : pole jest puste <br>";
			$flag=0;
		}		
		if (!is_numeric($_POST[ulga])) 
		{
			echo "Błąd pola 'Ulga' : wpisana kwota nie jest liczbą rzeczywistą postaci np. 467.90 <br>";
			$flag=0;
		}		
		
		
		return ($flag);	
	}
	

	function AddNameValidate()
	{
		$flag=1;
		
		if (  empty ($_POST["a_nazwa"]) ) 
		{
			echo "Błąd pola 'Imię i nazwisko (nazwa) abonenta' : pole jest puste <br>";
			$flag=0;
		}

		return ($flag);	
	}

	function AddAddressValidate()
	{
		$flag=1;
		return ($flag);	
	}	

	function AddKtkValidate()
	{
		$flag=1;
		return ($flag);	
	}	

	
	function GenHasla($dbh)
	{
	 include "func/config.php";
		 	
		$q=" select id_abon from abonenci order by id_abon";
		$Q="";
		WyswietlSql($q);	
		$sth=Query($dbh,$q);
	  while ($row =$sth->fetchRow())
			{
				$pass=$this->PasswdGen(8);		
				$qq="update abonenci set haslo='$pass' where id_abon='$row[0]';";		
				$Q.=$qq;
				//Query2($Q, $dbh);
			}
			echo "\n $Q \n\n";
			//Query2($qq, $dbh);
	}
	
	
	function KonwertujAbon2($dbh)
	{
		 include "func/config.php";
		 $data=$conf[data];
		 	
				
		$q="select  sum.id_abon , sum.nazwa, sum.saldo, sum(tcena), sum.status, sum.platnosc, sum.id_spw, sum.id_wnd, sum.krok, sum.saldo_dop from
(
select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status='Obowiązująca')
join (nazwy n full join (komputery k join pakiety p on p.id_urz=k.id_komp and p.aktywny_od<='$data' and p.aktywny_do>='$data') on n.id_abon=k.id_abon and k.fv='T' and n.wazne_od <= '$data' and n.wazne_do >='$data' )
on a.id_abon=n.id_abon) join towary_sprzedaz t on p.id_usl=t.id_tows)
left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana='N') on s.id_abon=a.id_abon)
group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
union
select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status='Obowiązująca')
join (nazwy n full join (telefony_voip v  join pakiety p on p.id_urz=v.id_tlv and p.aktywny_od<='$data' and p.aktywny_do>='$data') on n.id_abon=v.id_abon and v.fv='T' and n.wazne_od <= '$data' and n.wazne_do >='$data' )
on a.id_abon=n.id_abon) join towary_sprzedaz t on p.id_usl=t.id_tows)
left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana='N') on s.id_abon=a.id_abon)
group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
union
select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status='Obowiązująca')
join (nazwy n full join (settopboxy x  join pakiety p on p.id_urz=x.id_stb and p.aktywny_od<='$data' and p.aktywny_do>='$data') on n.id_abon=x.id_abon and x.fv='T' and n.wazne_od <= '$data' and n.wazne_do >='$data' )
on a.id_abon=n.id_abon) join towary_sprzedaz t on p.id_usl=t.id_tows)
left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana='N') on s.id_abon=a.id_abon)
group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
union
select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status='Obowiązująca')
join (nazwy n full join komputery k on n.id_abon=k.id_abon and k.fv='T' and n.wazne_od <= '$data' and n.wazne_do >='$data' )
on a.id_abon=n.id_abon) join (uslugi_dodatkowe ud join towary_sprzedaz t on ud.id_usl=t.id_tows and ud.aktywna_od<='$data' and ud.aktywna_do>='$data') on k.id_komp=ud.id_urz and ud.fv='T')
left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana='N') on s.id_abon=a.id_abon)
group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
union
select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status='Obowiązująca')
join (nazwy n full join settopboxy x on n.id_abon=x.id_abon and x.fv='T' and n.wazne_od <= '$data' and n.wazne_do >='$data' )
on a.id_abon=n.id_abon) join (uslugi_dodatkowe ud join towary_sprzedaz t on ud.id_usl=t.id_tows and ud.aktywna_od<='$data' and ud.aktywna_do>='$data') on x.id_stb=ud.id_urz and ud.fv='T')
left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana='N') on s.id_abon=a.id_abon)
group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
)
as sum group by sum.id_abon, sum.nazwa, sum.saldo, sum.status, sum.platnosc, sum.id_spw, sum.id_wnd, sum.krok, sum.saldo_dop order by 2
";
		WyswietlSql($q);	

	}
	
	
}

?>
