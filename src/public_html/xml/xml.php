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
			
		$pelnomocnictwo="Pełnomocnik jest osobą pozostającą z powodami w stałym stosunku zlecenia. Dnia 1 marca 2013 r. uzyskał Pełnomocnictwo ogólne przyznane bezterminowo przez wspólników NETICO Spółka Cywilna Michał Pielorz, Krzysztof Rogacki, Jerzy Borodziuk";

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
					$uzasadnienie.="W zwiazku z nie regulowaniem przez Pozwanego(ą) płatności Powodowie rozwiązali Umowę. Z uwagi na niedotrzymanie przez Pozwanego(ą) warunków Umowy Powodowie zgodnie z Umową zażądali zwrotu zwrotu przyznanych ulg i upustów cenowych jakie były przyznane Pozwanemu(ej) i wystawili Pozwanemu(ej) następujące noty obciążeniowe: \n";
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
				$uzasadnienie.="Pomimo wezwań do zapłaty Pozwany(a) nie uregulował należności. Powodowie wielokrotnie podejmowali próbę kontaktu telefonicznego z Pozwanym(ą) celem mediacji jednak bezskutecznie. Pozwany(a) nie odbierał telefonu.";
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
					
			if ( ValidateNip($pozwany[pesel_nip]) )	
			{
				$pozwany[typ]="OsobaFizyczna";				
				$pozwany[rodzajStrony]="1";
			}/*
			else if ( ValidateNip($pozwany[pesel_nip]) && $pozwany[nazwa] 'Sp. z o.o.')	
			{
				$pozwany[typ]="OsobaPrawna";				
				$pozwany[rodzajStrony]="2";
			}*/
			else
			{
				$pozwany[typ]="OsobaFizyczna";				
				$pozwany[rodzajStrony]="0";
			}
			
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





<curr:PozewEPU ID="0" version="2.0" dataZlozenia="$dataZlozenia" xmlns:curr="http://www.currenda.pl/epu">
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



<curr:rodzajStrony>$pozwany[rodzajStrony]</curr:rodzajStrony>

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





function JPK_VAT($xml, $dbh, $od, $do)
{

		include "../func/config.php";
		$dataZlozenia=date("Y-m-d");

			$q="	select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, 
			n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod
			from dokumenty_sprzedaz d, abonenci a, budynki b, ulice u, nazwy n, adresy_siedzib s 
			where n.id_abon=a.id_abon and a.id_abon=s.id_abon and d.id_odb=a.id_abon and s.id_bud=b.id_bud and u.id_ul=b.id_ul 
			and n.wazne_od <= '$od' and n.wazne_do >='$od' and s.wazne_od <= '$od' and s.wazne_do >='$od'
			and d.data_wyst >= '$od' and d.data_wyst <= '$do' and d.nr_ds not like '%/Z/%'
			order by d.data_wyst, d.nr_ds ";


		$razem_n=$razem_v=$razem_b=0;

		

echo <<<VAT1
<?xml version="1.0" encoding="utf-8"?>
<JPK xmlns="http://jpk.mf.gov.pl/wzor/2016/03/09/03094/" xmlns:etd="http://crd.gov.pl/xml/schematy/dziedzinowe/mf/2016/01/25/eD/DefinicjeTypy/">
      <Naglowek>
         <KodFormularza kodSystemowy="JPK_VAT (1)" wersjaSchemy="1-0">JPK_VAT</KodFormularza>
         <WariantFormularza>1</WariantFormularza>
         <CelZlozenia>1</CelZlozenia>
         <DataWytworzeniaJPK>2016-12-28T15:24:51</DataWytworzeniaJPK>
         <DataOd>$od</DataOd>
         <DataDo>$do</DataDo>
         <DomyslnyKodWaluty>PLN</DomyslnyKodWaluty>
         <KodUrzedu>0402</KodUrzedu>
      </Naglowek>
      <Podmiot1>
         <IdentyfikatorPodmiotu>
            <etd:NIP>$firma[nip]</etd:NIP>
            <etd:PelnaNazwa>$firma[nazwa] $firma[nazwa2]</etd:PelnaNazwa>
            <etd:REGON>$firma[regon]</etd:REGON>
         </IdentyfikatorPodmiotu>
         <AdresPodmiotu>
            <etd:KodKraju>PL</etd:KodKraju>
            <etd:Wojewodztwo>$firma[wojewodztwo]</etd:Wojewodztwo>
            <etd:Powiat>$firma[powiat]</etd:Powiat>
            <etd:Gmina>$firma[gmina]</etd:Gmina>
            <etd:Ulica>$firma[ulica]</etd:Ulica>
            <etd:NrDomu>$firma[nr_bud]</etd:NrDomu>
VAT1;
	if ( !empty($firma[lokal]))
		echo "            <etd:NrLokalu>$firma[lokal]</etd:NrLokalu>";

echo <<<VAT2
            <etd:Miejscowosc>$firma[miasto]</etd:Miejscowosc>
            <etd:KodPocztowy>$firma[kod]</etd:KodPocztowy>
            <etd:Poczta>$firma[miasto]</etd:Poczta>
         </AdresPodmiotu>
      </Podmiot1>
VAT2;

		$lp=0;
		$pod_należny=0;
		$s=Query($dbh,$q);
		while ($r=$s->fetchRow() )
		{
			$lp++;
			$nazwa = str_replace("&", "and", $r[6]);
			//$nazwa = str_replace("'", " ", $r[6]);
			$adres=$r[13]." ".$r[12].", ul. ".$r[8]." ".$r[9];
			if (!empty($r[10]))
			$adres.="/$r[10]";
			
			
			
			$q2="(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, towary_sprzedaz t
						where p.id_tows=t.id_tows and p.nr_ds='$r[0]' order by t.nazwa)
						union all
					 (select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, uslugi_voip t
						where p.id_tows=t.id_uvp  and p.nr_ds='$r[0]' order by t.nazwa)";

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
			$netto8=number_format($razem_netto8,2,'.','');
			  $vat8=number_format($razem_vat8,  2,'.','');
			 $netto=number_format($razem_netto, 2,'.','');
			   $vat=number_format($razem_vat,   2,'.','');
				
			$pod_należny+=$razem_vat;	
			$pod_należny+=$razem_vat8;	
			
		  echo  "<SprzedazWiersz typ=\"G\">";
      echo  "   <LpSprzedazy>$lp</LpSprzedazy>";
			echo	"		<DataSprzedazy>$r[2]</DataSprzedazy> ";
      echo  "   <DataWystawienia>$r[1]</DataWystawienia>";
      echo  "   <NrDokumentu>$r[0]</NrDokumentu>";
      echo  "   <NazwaNabywcy>$nazwa</NazwaNabywcy>";
      echo  "   <AdresNabywcy>Polska, $adres</AdresNabywcy>";
      echo  "   <K_10>0.00</K_10>";
      echo  "   <K_11>0.00</K_11>";
      echo  "   <K_12>0.00</K_12>";
      echo  "   <K_13>0.00</K_13>";
      echo  "   <K_14>0.00</K_14>";
      echo  "   <K_15>0.00</K_15>";
      echo  "   <K_16>0.00</K_16>";
      echo  "   <K_17>$netto8</K_17>";
      echo  "   <K_18>$vat8</K_18>";
      echo  "   <K_19>$netto</K_19>";
      echo  "   <K_20>$vat</K_20>";
      echo  "   <K_21>0.00</K_21>";
      echo  "   <K_22>0.00</K_22>";
      echo  "   <K_23>0.00</K_23>";
      echo  "   <K_24>0.00</K_24>";
      echo  "   <K_25>0.00</K_25>";
      echo  "   <K_26>0.00</K_26>";
      echo  "   <K_27>0.00</K_27>";
      echo  "   <K_28>0.00</K_28>";
      echo  "   <K_29>0.00</K_29>";
      echo  "   <K_30>0.00</K_30>";
      echo  "   <K_31>0.00</K_31>";
      echo  "   <K_32>0.00</K_32>";
      echo  "   <K_33>0.00</K_33>";
      echo  "   <K_34>0.00</K_34>";
      echo  "   <K_35>0.00</K_35>";
      echo  "   <K_36>0.00</K_36>";
      echo  "   <K_37>0.00</K_37>";
      echo  "   <K_38>0.00</K_38>";
      echo  "   <K_39>0.00</K_39>";
      echo  "   <K_40>0.00</K_40>";
      echo  "   <K_41>0.00</K_41>";
      echo  "   <K_42>0.00</K_42>";
      echo  "   <K_43>0.00</K_43>";
      echo  "   <K_44>0.00</K_44>";
      echo  "   <K_45>0.00</K_45>";
      echo  "   <K_46>0.00</K_46>";
      echo  "   <K_47>0.00</K_47>";
      echo  "   <K_48>0.00</K_48>";
      echo  "</SprzedazWiersz>";

		}

echo <<<VAT2
      <SprzedazCtrl>
         <LiczbaWierszySprzedazy>$lp</LiczbaWierszySprzedazy>
         <PodatekNalezny>$pod_należny</PodatekNalezny>
      </SprzedazCtrl>

   </JPK>
VAT2;

/*
   <ZakupWiersz typ="G">
         <LpZakupu>1</LpZakupu>
         <NazwaWystawcy>-------------------------------------</NazwaWystawcy>
         <AdresWystawcy>-------------------------------------</AdresWystawcy>
         <NrIdWystawcy>1111111111</NrIdWystawcy>
         <NrFaktury>FVZ_1</NrFaktury>
         <DataWplywuFaktury>2017-01-01</DataWplywuFaktury>
         <K_44>3.00</K_44>
         <K_45>2.41</K_45>
      </ZakupWiersz>
      <ZakupWiersz typ="G">
         <LpZakupu>2</LpZakupu>
         <NazwaWystawcy>-------------------------------------</NazwaWystawcy>
         <AdresWystawcy>-------------------------------------</AdresWystawcy>
         <NrIdWystawcy>1111111111</NrIdWystawcy>
         <NrFaktury>wewewewe</NrFaktury>
         <DataWplywuFaktury>2017-01-01</DataWplywuFaktury>
         <K_42>4.00</K_42>
         <K_43>5.00</K_43>
         <K_44>2.00</K_44>
         <K_45>1.00</K_45>
      </ZakupWiersz>
      <ZakupCtrl>
         <LiczbaWierszyZakupow>2</LiczbaWierszyZakupow>
         <PodatekNaliczony>12.21</PodatekNaliczony>
      </ZakupCtrl>
*/


}





function JPK_FA($xml, $dbh, $od, $do)
{

		include "../func/config.php";
		$data=date("Y-m-d");
		$czas=date("H:i:s");
		$dataWytworzena=$data."T".$czas;
		
			$q="	select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, 
			n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod
			from dokumenty_sprzedaz d, abonenci a, budynki b, ulice u, nazwy n, adresy_siedzib s 
			where n.id_abon=a.id_abon and a.id_abon=s.id_abon and d.id_odb=a.id_abon and s.id_bud=b.id_bud and u.id_ul=b.id_ul 
			and n.wazne_od <= '$od' and n.wazne_do >='$od' and s.wazne_od <= '$od' and s.wazne_do >='$od'
			and d.data_wyst >= '$od' and d.data_wyst <= '$do' and d.nr_ds not like '%/Z/%'
			order by d.data_wyst, d.nr_ds ";


		$razem_n=$razem_v=$razem_b=0;

		

echo <<<FA1
<?xml version="1.0" encoding="utf-8"?>
<JPK xmlns="http://jpk.mf.gov.pl/wzor/2016/03/09/03095/" xmlns:etd="http://crd.gov.pl/xml/schematy/dziedzinowe/mf/2016/01/25/eD/DefinicjeTypy/">
      <Naglowek>
					<KodFormularza kodSystemowy="JPK_FA (1)" wersjaSchemy="1-0">JPK_FA</KodFormularza>
         <WariantFormularza>1</WariantFormularza>
         <CelZlozenia>1</CelZlozenia>
         <DataWytworzeniaJPK>$dataWytworzena</DataWytworzeniaJPK>
         <DataOd>$od</DataOd>
         <DataDo>$do</DataDo>
         <DomyslnyKodWaluty>PLN</DomyslnyKodWaluty>
         <KodUrzedu>2422</KodUrzedu>
      </Naglowek>
      <Podmiot1>
         <IdentyfikatorPodmiotu>
            <etd:NIP>$firma[nip]</etd:NIP>
            <etd:PelnaNazwa>$firma[nazwa] $firma[nazwa2]</etd:PelnaNazwa>
            <etd:REGON>$firma[regon]</etd:REGON>
         </IdentyfikatorPodmiotu>
         <AdresPodmiotu>
            <etd:KodKraju>PL</etd:KodKraju>
            <etd:Wojewodztwo>$firma[wojewodztwo]</etd:Wojewodztwo>
            <etd:Powiat>$firma[powiat]</etd:Powiat>
            <etd:Gmina>$firma[gmina]</etd:Gmina>
            <etd:Ulica>$firma[ulica]</etd:Ulica>
            <etd:NrDomu>$firma[nr_bud]</etd:NrDomu>  
FA1;

	if ( !empty($firma[lokal]) )
		echo "            <etd:NrLokalu>$firma[lokal]</etd:NrLokalu>";

echo <<<FA2
            <etd:Miejscowosc>$firma[miasto]</etd:Miejscowosc>
            <etd:KodPocztowy>$firma[kod]</etd:KodPocztowy>
            <etd:Poczta>$firma[miasto]</etd:Poczta>
         </AdresPodmiotu>
      </Podmiot1>
FA2;

		$lp=0;  // liczba faktur
		$lw=0; // liczba wierszy faktur
		$jpk_fa="";
		$pod_należny=0;
		$suma_brutto=0;
		$wwf=0; //wartosc wierszy faktur
		$s=Query($dbh,$q);
		while ($r=$s->fetchRow() )
		{
			$lp++;
			$nazwa = str_replace("&", "and", $r[6]);
			//$nazwa = str_replace("'", " ", $r[6]);
			$adres=$r[13]." ".$r[12].", ul. ".$r[8]." ".$r[9];
			if (!empty($r[10]))
			$adres.="/$r[10]";
			
			
			
			$q2="(select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, towary_sprzedaz t
						where p.id_tows=t.id_tows and p.nr_ds='$r[0]' order by t.nazwa)
						union all
					 (select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat from pozycje_sprzedaz p, uslugi_voip t
						where p.id_tows=t.id_uvp  and p.nr_ds='$r[0]' order by t.nazwa)";

			$razem_netto=$razem_vat=$razem_brutto=0;
			$razem_netto8=$razem_vat8=$razem_brutto8=0;
			$razem_brutto_oo=0;

			
			$sth1=Query($dbh,$q2);
			while ( $row1=$sth1->fetchRow() )
				{	
	/*				$razem_netto+=round($netto, 2);
					$razem_vat+=round ($kwota_vat, 2);
					$razem_brutto+=round($brutto, 2); */

					$lw++;

					$jedn_brutto=round($row1[4], 2);
					$cena_jedn_netto = $row1[4] / (1+$row1[5]/100);
					$brutto= $row1[2] * $jedn_brutto;
					// Odwrotne obciążenie
					if ( $row1[5] == "-")
					{
						$rnetto=$netto=$brutto;
					}
					else
					{
						$netto=$brutto / (1 + $row1[5]/100);
						$rnetto=round($netto, 2);
					}
					
					$kwota_vat=$brutto-$netto;
			
					$wwf+=$rnetto;
					
					// VAT 23%
					if ( $row1[5] == 23)
					{
						$razem_netto+=$rnetto;
						$razem_vat+=round ($kwota_vat, 2);
						$razem_brutto+=round($brutto, 2);
					}
					// VAT 8%
					else if ( $row1[5] == 8)
					{
						$razem_netto8+=$rnetto;
						$razem_vat8+=round ($kwota_vat, 2);
						$razem_brutto8+=round($brutto, 2);
					}
					// Odwrotne obciążenie
					else if ( $row1[5] == "-")
					{
						$razem_brutto_oo+=round($brutto, 2);
						$oo=1;
					}
					
					$cjn=number_format($cena_jedn_netto,2,'.','');
					$jb=number_format($jedn_brutto,2,'.','');
					$net=number_format($netto,2,'.','');
					$bru=number_format($brutto,2,'.','');
								
					$jpk_fa.="<FakturaWiersz typ=\"G\">";
					$jpk_fa.="	<P_2B>$r[0]</P_2B>"; 		// nr ds
					$jpk_fa.="	<P_7>$row1[0]</P_7>"; 	// nazwa towaru
					$jpk_fa.="	<P_8A>$row1[3]</P_8A>"; // jm
					$jpk_fa.="	<P_8B>$row1[2]</P_8B>"; //ilość
					$jpk_fa.="	<P_9A>$cjn</P_9A>";
					$jpk_fa.="	<P_9B>$jb</P_9B>";
					$jpk_fa.="	<P_11>$net</P_11>";
					$jpk_fa.="	<P_11A>$bru</P_11A>";
					// Odwrotne obciążenie
					if ( $row1[5] != "-")
					{
						$jpk_fa.="	<P_12>$row1[5]</P_12>";
					}
					$jpk_fa.="</FakturaWiersz>";					
				}
			
			$razem=$razem_brutto+$razem_brutto8+$razem_brutto_oo;
			$suma+=$razem;
			
			$netto8=number_format($razem_netto8,2,'.','');
			  $vat8=number_format($razem_vat8,  2,'.','');
			 $netto=number_format($razem_netto, 2,'.','');
			   $vat=number_format($razem_vat,   2,'.','');
			 $razem=number_format($razem,   2,'.','');
				
			$pod_należny+=$razem_vat;	
			$pod_należny+=$razem_vat8;	
			
		  echo  "<Faktura typ=\"G\">";
      echo  "   <P_1>$r[1]</P_1>";
      echo  "   <P_2A>$r[0]</P_2A>";
      echo  "   <P_3A>$nazwa</P_3A>";
      echo  "   <P_3B>Polska, $adres</P_3B>";
      echo  "   <P_3C>$firma[nazwa] $firma[nazwa2]</P_3C>";
			echo	"		<P_3D>$firma[adres]</P_3D> ";
			echo	"		<P_4B>$firma[nip]</P_4B> ";
      echo  "   <P_6>$r[2]</P_6>";
			if (!$oo)
			{
				echo  "   <P_13_1>$netto</P_13_1>";
				echo  "   <P_14_1>$vat</P_14_1>";
				echo  "   <P_13_2>$netto8</P_13_2>";
				echo  "   <P_14_2>$vat8</P_14_2>";
			}
      echo  "   <P_15>$razem</P_15>";
			echo  "		<P_16>false</P_16>";
      echo  "		<P_17>false</P_17>";
			if ($oo)
			{
				echo  "		<P_18>true</P_18>";
			}
			else
			{
				echo  "		<P_18>false</P_18>";
			}
			echo  "		<P_19>false</P_19>";
			echo  "		<P_20>false</P_20>";
			echo  "		<P_21>false</P_21>";
			echo  "		<P_23>false</P_23>";
			echo  "		<P_106E_2>false</P_106E_2>";
			echo  "		<P_106E_3>false</P_106E_3>";
			echo  "		<RodzajFaktury>VAT</RodzajFaktury>";
      echo  "</Faktura>";
			
		}

echo <<<VAT2
      <FakturaCtrl>
         <LiczbaFaktur>$lp</LiczbaFaktur>
         <WartoscFaktur>$suma</WartoscFaktur>
      </FakturaCtrl>
			<StawkiPodatku>
            <Stawka1>0.23</Stawka1>
            <Stawka2>0.08</Stawka2>
            <Stawka3>0.05</Stawka3>
            <Stawka4>0.00</Stawka4>
            <Stawka5>0.00</Stawka5>
      </StawkiPodatku>
VAT2;

echo "$jpk_fa";

echo <<<JPK_FA2
      <FakturaWierszCtrl>
            <LiczbaWierszyFaktur>$lw</LiczbaWierszyFaktur>
            <WartoscWierszyFaktur>$wwf</WartoscWierszyFaktur>
      </FakturaWierszCtrl>
		</JPK>
JPK_FA2;

}







}

?>
