<?php

class XML
{
		
function CreatePlaint($xml, $dbh, $id_spw)
{

		include "../func/config.php";
		$dataZlozenia=date("Y-m-d");
		$paczka=date("m/Y");
		$nr_paczki="PZW/$paczka";
				//$powod1=array( 'nazwisko' => '', 'imie' => ', ''miasto'=>'',  'kod'=>'', 'ulica'=>'', 'budynek'=>'', 'lokal'=>'',
			//							'pesel' =>'',	'nip'=>'');
			
		$pelnomocnictwo="Pełnomocnictwo ogólne z dnia 1 marca 2013 r. przyznane przez wspólników NETICO Spółka Cywilna Michał Pielorz, Krzysztof Rogacki, Jerzy Borodziuk";

			function Uzasadnienie($dbh, $un, $ud, $up, $roszczenia, $no)
			{
				$uzasadnienie="Powodowie prowadzą działalność gospodarczą pod nazwą NETICO Spółka Cywilna M.Pielorz, K.Rogacki, J.Borodziuk. Powodowie dnia $ud zawarli z Pozwanym(ą) umowę abonencką nr $un o świadczenie usług telekomunikacyjnych.\n Termin płatności został określony w Umowie do $up dnia danego miesiąca. \n Za świadczone usługi w ramach prowadzonej przez siebie działalności gospodarczej Powodowie wystawili Pozwanemu(ej) następujące faktury VAT:\n ";
				
				$n=1;
				$suma=0;
				if (!empty($roszczenia))
				{
					foreach ($roszczenia as $n => $v)
					{
						$oznaczenie=$roszczenia[$n]["oznaczenie"];
						$kwota=$roszczenia[$n]["wartosc"];
						$pozostalo=$roszczenia[$n]["pozostalo"];
						$d=$n;
						if ( $pozostalo>0)
							{ 
								$suma+=$pozostalo;
								$kwota=number_format($kwota, 2,',','');
								$pozostalo=number_format($pozostalo, 2,',','');
								$uzasadnienie.="$oznaczenie na kwotę $kwota zł, pozostało do zapłaty $pozostalo zł. \n";
							}
						else
							{
							$suma+=$kwota;
							$kwota=number_format($kwota, 2,',','');
							$uzasadnienie.="$oznaczenie na kwotę $kwota zł; \n";
							}
					}
				}
				if (!empty($no))
				{
					$uzasadnienie.="W zwiazku z nie regulowaniem przez Pozwanego(ą) płatności Powodowie rozwiązali Umowę. Z uwagi na niedotrzymanie przez Pozwanego(ą) warunków Umowy Powodowie zgodnie z Umową zażądali zwrotu zwrotu przyznanych ulg i upustów cenowych jakie były przyznane Pozwanemu(ej) i wystawili Pozwanemu(ej) następujące noty obciążaniowe: \n";
					$n=1;
					foreach ($no as $n => $v)
					{
						$oznaczenie=$no[$n]["oznaczenie"];
						$kwota=$no[$n]["wartosc"];
						$d=$n;
						$suma+=$kwota;
						$kwota=number_format($kwota, 2,',','');
						$uzasadnienie.="$oznaczenie na kwotę $kwota zł; \n";
					}
				}
				
				$suma=number_format($suma, 2,',','');
				$uzasadnienie.="Razem $suma zł.\n";
				$uzasadnienie.="Pomimo wezwań do zapłaty Pozwany(a) nie uregulował należności.";
				return($uzasadnienie);
			}

		

$q="select s.id_spw, a.id_abon, n.nazwa, a.saldo, um.nr_um, um.data_zaw, um.typ_um, a.platnosc, ad.nr_lok, u.nazwa, u.miasto, 		u.kod, b.numer,
				k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kn.numer, a.pesel_nip, u.wojewodztwo
				
				from 
				(
					(nazwy n join adresy_siedzib ad on n.id_abon=ad.id_abon and 
					n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]' and ad.wazne_od <= '$conf[data]' and ad.wazne_do >='$conf[data]' )
					join (budynki b join ulice u on b.id_ul=u.id_ul) on ad.id_bud=b.id_bud
				)
					join
				(
				((sprawy_windykacyjne s right join umowy_abonenckie um on s.id_abon=um.id_abon and s.id_spw='$id_spw') left join kontakty k on k.id_podm=um.id_abon 
				and k.wazne_od <= '$conf[data]' and k.wazne_do >='$conf[data]') 
				join 
				(abonenci a join konta_wirtualne kn on a.id_abon=kn.id_abon ) on s.id_abon=a.id_abon
				) 
				on n.id_abon=s.id_abon";		

				$sth=Query($dbh,$q);
				$row=$sth->fetchRow();
			
			
			$pozwany=array
				(
					'id_spw'		=> $row[0],		'id_abon' => $row[1],		'nazwa'			=> $row[2], 	'saldo'			=> $row[3],	
					'um_numer'	=> $row[4],		'data_zaw'=> $row[5], 	'typ_um'		=> $row[6],		'platnosc'	=> $row[7],		
					'ulica'			=> $row[9],		'nr_bud'	=> $row[12],	'nr_mieszk'	=> $row[8],
					'miasto'		=> $row[10],	'kod'			=> $row[11], 	'aktywacja'	=> $row1[0], 'zadluzenie' => number_format(-$row[3], 2, ',',''),
					'k_nazwa'		=> $row[13],   'k_ulica'		=> $row[14],  'k_nr_bud'		=> $row[15], 'k_nr_mieszk'		=> $row[16], 'k_kod'		=> $row[17],
					'k_miasto'		=> $row[18],
					'konto'		=> str_replace(' ', '', $row[19]), 'pesel_nip' => $row[20], 'wojewodztwo' => $row[21]
					);
					
				
			$pozwany[typ]="OsobaFizyczna";
			if ($pozwany[typ]=="OsobaFizyczna")
				{
					$pozwany_nazwa=explode(" ", $pozwany[nazwa]);
					$pozwany[imie]=$pozwany_nazwa[1];
					$pozwany[nazwisko]=$pozwany_nazwa[0];
				}
				
			if ( !empty($pozwany[k_nazwa]) && !empty($pozwany[k_ulica]) && !empty($pozwany[k_nr_bud]) && !empty($pozwany[k_miasto])  )
				{						
					$pozwany[nazwa]=$pozwany[k_nazwa];
					$pozwany[kod]=$pozwany[k_kod];
					$pozwany[miasto]=$pozwany[k_miasto];
					$pozwany[ulica]=$pozwany[k_ulica];
					$pozwany[nr_bud]=$pozwany[k_nr_bud];
					$pozwany[nr_mieszk]=$pozwany[k_nr_mieszk];
				}
			else
				{
					$adres1=$pozwany[kod]." ".$pozwany[miasto];
					$adres2="ul. ".$pozwany[ulica]." ".$pozwany[nr_bud];
					if (!empty($pozwany[nr_mieszk]))
					$adres2.="/$pozwany[nr_mieszk]";
				}
			
			$adresat=array('nazwa' => $pozwany[nazwa], 'adres1' => $adres1, 'adres2' => $adres2);
			
			$ostatni = DataSlownie(OstatniDzienMiesiaca(date("Y-m-d")));
						
			$pozwany[saldo]=-$pozwany[saldo];

			$q22="select nr_nob, kwota, term_plat, data_wyst from noty_obciazeniowe where zaplacona='N' and id_odb='$pozwany[id_abon]' order by data_wyst";

			$kwota=0;
			$n=1;
			$sth22=Query($dbh,$q22);
			while ($row22=$sth22->fetchRow()  and $kwota<$pozwany[saldo])
			{
				$kwota+=$row22[1];
				$no[$n]= array( 'oznaczenie' => $row22[0], 'wartosc'=>$row22[1], 'dataOd' =>CountDate($row22[2],2), 'dataDowodu'=>$row22[3], 'pozostalo' => 0,
				'dataDo' =>$row22[2]);
				$n++;
			}
			
			$q2="select d.nr_ds, sum(t.cena), d.term_plat, d.data_wyst from towary_sprzedaz t, pozycje_sprzedaz p, dokumenty_sprzedaz d  where t.id_tows=p.id_tows and d.nr_ds=p.nr_ds 
			and d.id_odb='$pozwany[id_abon]' group by d.nr_ds, d.term_plat, d.data_wyst order by d.data_wyst desc";

			$sth2=Query($dbh,$q2);
			while ($row2=$sth2->fetchRow() and $kwota<$pozwany[saldo])
			{
				$kwota+=$row2[1];
				$roszczenia[$n]= array( 'oznaczenie' => $row2[0], 'wartosc'=>$row2[1], 'dataOd' =>CountDate($row2[2],2), 'dataDowodu'=>$row2[3], 'pozostalo' => 0, 'dataDo' =>$row2[2]);
				$n++;
			}
			$roznica=$kwota-$pozwany[saldo];
			if ($roznica > 0)
			{
				--$n;
				$roszczenia[$n][pozostalo]=$roszczenia[$n][wartosc]-$roznica;
			}

			$n=0;
			$q3="(select nr_um, data_zaw from umowy_abonenckie where id_abon='$pozwany[id_abon]' and status='windykowana'order by data_zaw)
					union
					(select nr_um, data_zaw from umowy_serwisowe where id_abon='$pozwany[id_abon]' and status='windykowana'order by data_zaw)";

			$sth3=Query($dbh,$q3);
			while ($row3=$sth3->fetchRow())
			{
				$um[$n]= array( 'nr_um' => $row3[0], 'data_zaw'=>$row3[1]);
				$n++;
			}
			
			$q4="select data_rozp from windykowanie where id_spw='$id_spw' and krok='pismo'";
		  $datap=Query2($q4, $dbh);
			$q4="select data_rozp from windykowanie where id_spw='$id_spw' and krok='krd'";
		  $datak=Query2($q4, $dbh);
			$q5="select platnosc from abonenci where id_abon='$pozwany[id_abon]'";
			$platnosc=Query2($q5, $dbh);
			
echo <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Pozwy OznaczeniePaczki="$nr_paczki">





<curr:PozewEPU ID="0" version="1.0" dataZlozenia="$dataZlozenia" xmlns:curr="http://www.currenda.pl/epu">
<curr:Adresat ID="1">
<curr:Nazwa>Sąd Rejonowy Lublin-Zachód w Lublinie</curr:Nazwa>
<curr:Wydzial>VI Wydział Cywilny</curr:Wydzial>
<curr:Adres ulica="ul. Boczna Lubomelskiej" nr_domu="13" kod="20070" miejscowosc="Lublin" poczta="Lublin" kraj="Polska" powiat="Lublin" gmina="Lublin" /></curr:Adresat>

<curr:SadWlasciwy ID="12141910">
<curr:Nazwa>Sąd Rejonowy w Mysłowicach</curr:Nazwa>
<curr:Wydzial></curr:Wydzial>
<curr:Adres kod="41-400" miejscowosc="Mysłowice" kraj="PL" ulica="Krakowska" nr_domu="2"  /></curr:SadWlasciwy>

<curr:OsobaSkladajaca pelnomocnik="0" podstawa="$pelnomocnictwo">
<curr:Osoba>
<curr:Imie>Mirosław</curr:Imie>
<curr:Imie2>Marcin</curr:Imie2><curr:Nazwisko>Borodziuk</curr:Nazwisko>
<curr:PESEL>80042603474</curr:PESEL>
<curr:stanowisko>Pełnomocnik NETICO Spółka Cywilna</curr:stanowisko>
</curr:Osoba>
<curr:Adres ulica="Wielka Skotnica" nr_domu="94" nr_mieszkania="9" kod="41-400" miejscowosc="Mysłowice" poczta="Mysłowice" wojewodztwo="śląskie" powiat="" gmina="" /></curr:OsobaSkladajaca>
<curr:ListaPowodow>

<curr:Powod ID="1">
<curr:ObcokrajowiecString>obywatelstwo polskie</curr:ObcokrajowiecString>
<curr:Obcokrajowiec>false</curr:Obcokrajowiec>
<curr:BrakNumerowIdentyfikacyjnych>false</curr:BrakNumerowIdentyfikacyjnych>
<curr:reprezentacja>1</curr:reprezentacja>
<curr:rodzajStrony>1</curr:rodzajStrony>
<curr:OsobaFizyczna>
<curr:Imie>Michał</curr:Imie>
<curr:Imie2 />
<curr:Nazwisko>Pielorz</curr:Nazwisko>
<curr:Nazwa>NETICO Michał Pielorz</curr:Nazwa>
<curr:PESEL>80022218151</curr:PESEL></curr:OsobaFizyczna>
<curr:NIP>2220775141</curr:NIP>
<curr:Adres ulica="Malczewskiego" nr_domu="7A" nr_mieszkania="" kod="41-407" miejscowosc="Imielin" poczta="" wojewodztwo="śląskie" powiat="" /></curr:Powod>

<curr:Powod ID="2">
<curr:ObcokrajowiecString>obywatelstwo polskie</curr:ObcokrajowiecString>
<curr:Obcokrajowiec>false</curr:Obcokrajowiec>
<curr:BrakNumerowIdentyfikacyjnych>false</curr:BrakNumerowIdentyfikacyjnych>
<curr:reprezentacja>1</curr:reprezentacja>
<curr:rodzajStrony>1</curr:rodzajStrony>
<curr:OsobaFizyczna><curr:Imie>Krzysztof</curr:Imie><curr:Imie2 /><curr:Nazwisko>Rogacki</curr:Nazwisko>
<curr:Nazwa>NETICO Krzysztof Rogacki</curr:Nazwa>
<curr:PESEL>82072902334</curr:PESEL></curr:OsobaFizyczna>
<curr:NIP>6342513415</curr:NIP>
<curr:Adres ulica="Leśmiana" nr_domu="2" nr_mieszkania="" kod="41-400" miejscowosc="Mysłowice" poczta="" wojewodztwo="śląskie" powiat="" /></curr:Powod>

<curr:Powod ID="3">
<curr:ObcokrajowiecString>obywatelstwo polskie</curr:ObcokrajowiecString>
<curr:Obcokrajowiec>false</curr:Obcokrajowiec>
<curr:BrakNumerowIdentyfikacyjnych>false</curr:BrakNumerowIdentyfikacyjnych>
<curr:reprezentacja>1</curr:reprezentacja>
<curr:rodzajStrony>1</curr:rodzajStrony>
<curr:OsobaFizyczna><curr:Imie>Jerzy</curr:Imie>
<curr:Imie2 /><curr:Nazwisko>Borodziuk</curr:Nazwisko>
<curr:Nazwa>NETICO Jerzy Borodziuk</curr:Nazwa>
<curr:PESEL>49042706754</curr:PESEL></curr:OsobaFizyczna>
<curr:NIP>2220503371</curr:NIP>
<curr:Adres ulica="Różyckiego" nr_domu="3" nr_mieszkania="9" kod="41-400" miejscowosc="Mysłowice" poczta="Mysłowice" wojewodztwo="śląskie" powiat="" />
<curr:numerKonta>$pozwany[konto]</curr:numerKonta>
</curr:Powod>



</curr:ListaPowodow>

<curr:ListaPozwanych>
<curr:Pozwany ID="1">
<curr:ObcokrajowiecString>obywatelstwo polskie</curr:ObcokrajowiecString>
<curr:Obcokrajowiec>false</curr:Obcokrajowiec>
<curr:BrakNumerowIdentyfikacyjnych>false</curr:BrakNumerowIdentyfikacyjnych>
<curr:reprezentacja>4</curr:reprezentacja>


<curr:rodzajStrony>0</curr:rodzajStrony>

<curr:OsobaFizyczna>
<curr:Imie>$pozwany[imie]</curr:Imie>
<curr:Imie2 />
<curr:Nazwisko>$pozwany[nazwisko]</curr:Nazwisko>
<curr:PESEL>$pozwany[pesel_nip]</curr:PESEL>
</curr:$pozwany[typ]>
<curr:Adres ulica="$pozwany[ulica]" nr_domu="$pozwany[nr_bud]" nr_mieszkania="$pozwany[nr_mieszk]" kod="$pozwany[kod]" miejscowosc="$pozwany[miasto]" poczta="" wojewodztwo="$pozwany[wojewodztwo]" powiat="" /></curr:Pozwany>
</curr:ListaPozwanych>

<curr:SprawaWgPowoda>$pozwany[id_spw]</curr:SprawaWgPowoda>
<curr:WartoscSporu>$pozwany[saldo]</curr:WartoscSporu>
<curr:OplataSadowa wartosc="30" zwolnienie="0" zasadzenie="1" />
<curr:KosztyZastepstwa wartosc="0" zasadzenie="0" wgNorm="0" />
<curr:InneKoszty wartosc="0" zasadzenie="0" wgNorm="0" />
<curr:RachunekDoZwrotuOplat>
	<curr:NumerRachunkuDoZwrotuOplat>$pozwany[konto]</curr:NumerRachunkuDoZwrotuOplat>
	<curr:WlascicielRachunku>$firma[nazwa] $firma[nazwa2]</curr:WlascicielRachunku>
</curr:RachunekDoZwrotuOplat>

<curr:ListaRoszczen>
XML;

$n=1;

if (!empty($no))
	{
	foreach ($no as $n => $v)
		{
			$rw=$no[$n][wartosc];
				
			$rw=number_format($rw, 2,'.','');
			$rd=$no[$n][dataOd];
			$rdo=$no[$n][dataDo];
			$d=$n;
			echo "		<curr:Roszczenie numer=\"$n\" wartosc=\"$rw\" waluta=\"PLN\" odsetki=\"1\" solidarnie=\"0\" dataWymagalnosci=\"$rdo\" typ=\"1\">";
			echo "		<curr:Odsetki><curr:OkresOdsetkowy dataOd=\"$rd\" kwota=\"$rw\" czyUstawowe=\"0\" doZaplaty=\"1\" /></curr:Odsetki><curr:Dowody><curr:Dowod>$d</curr:Dowod></curr:Dowody></curr:Roszczenie>";
		}
	}

	if (!empty($roszczenia))
	{
		foreach ($roszczenia as $n => $v)
			{
				if ( $roszczenia[$n][pozostalo]>0 )
					$rw=$roszczenia[$n][pozostalo];
				else
					$rw=$roszczenia[$n][wartosc];
					
				$rw=number_format($rw, 2,'.','');
				$rd=$roszczenia[$n][dataOd];
				$rdo=$roszczenia[$n][dataDo];
				$d=$n;

			echo "		<curr:Roszczenie numer=\"$n\" wartosc=\"$rw\" waluta=\"PLN\" odsetki=\"1\" solidarnie=\"0\" dataWymagalnosci=\"$rdo\" typ=\"1\">";
			echo "		<curr:Odsetki><curr:OkresOdsetkowy dataOd=\"$rd\" kwota=\"$rw\" czyUstawowe=\"0\" doZaplaty=\"1\" /></curr:Odsetki><curr:Dowody><curr:Dowod>$d</curr:Dowod></curr:Dowody></curr:Roszczenie>";
			}
}

echo <<<XML
</curr:ListaRoszczen>


<curr:ListaDowodow>
XML;


$n=1;

if (!empty($no))
	{
	foreach ($no as $n => $v)
		{
			$ro=$no[$n]["oznaczenie"];
			$rdd=$no[$n]["dataDowodu"];
			$d=$n;

			echo "<curr:Dowod numer=\"$d\" typDowodu=\"inny\" oznaczenie=\"$ro\" dataDowodu=\"$rdd\">";
			echo "<curr:FaktStwierdzany>Żądanie zwrotu przyznanych ulg i upustów cenowych w zwiazku z niedotrzymaniem warunków Umowy</curr:FaktStwierdzany><curr:Opis>Nota Obciążeniowa</curr:Opis></curr:Dowod>";
		}
	}
if (!empty($roszczenia))
	{
		foreach ($roszczenia as $n => $v)
		{
			$ro=$roszczenia[$n]["oznaczenie"];
			$rdd=$roszczenia[$n]["dataDowodu"];
			$d=$n;
			echo "<curr:Dowod numer=\"$d\" typDowodu=\"faktura\" oznaczenie=\"$ro\" dataDowodu=\"$rdd\">";
			echo "<curr:FaktStwierdzany>Sprzedaż usług, termin i sposób zapłaty.</curr:FaktStwierdzany></curr:Dowod>";
		}
}

$d++;
$n=0;
foreach ($um as $n => $v)
	{
		$un=$um[$n]["nr_um"];
		$ud=$um[$n]["data_zaw"];
		$up=$um[$n]["platnosc"];

echo "<curr:Dowod numer=\"$d\" typDowodu=\"umowa\" oznaczenie=\"$un\" dataDowodu=\"$ud\">";
echo "<curr:FaktStwierdzany>Zobowiązanie się do regulowania należności.</curr:FaktStwierdzany><curr:Opis>Umowa abonencka o świadczenie usług telekomunikacyjnych. Termin płatności za usługi rozumiany jako należność na koncie Powodów ustalony został na $platnosc[0] dni. Płatność do $platnosc[0] dnia miesiąca.</curr:Opis></curr:Dowod>";
	$d++;
	$dd=$d+1;
	}
	
echo <<<XML


<curr:Dowod numer="$d" typDowodu="inny" oznaczenie="" dataDowodu="$datap[0]">
<curr:FaktStwierdzany>Żądanie zapłaty za usługi.</curr:FaktStwierdzany>
<curr:Opis>Wezwanie do zapłaty.</curr:Opis></curr:Dowod>


<curr:Dowod numer="$dd" typDowodu="inny" oznaczenie="" dataDowodu="$datak[0]">
<curr:FaktStwierdzany>Żądanie zapłaty za usługi.</curr:FaktStwierdzany>
<curr:Opis>Przedsądowe wezwanie do zapłaty.</curr:Opis></curr:Dowod>


</curr:ListaDowodow>

XML;
$uzasadnienie=Uzasadnienie($dbh, $un, $ud, $pozwany[platnosc], $roszczenia, $no);
echo "<curr:Uzasadnienie> $uzasadnienie </curr:Uzasadnienie>";

	
echo <<<XML
</curr:PozewEPU>





</Pozwy>
XML;
}

}

?>
