<?php

function Uma($a, $u, $k, $t, $g, $s, $c)
{
	include "../func/config.php";
		
	$ilosc=count($k)+count($t)+count($g)+count($s)+count($c);
	
	if ( empty ($s))
	{
		$tresc=array
		(
			"0"=>"zwaną dalej w treści umowy Operatorem, <br>",
			"1"=>	"1. Regulamin świadczenia usług telekomunikacyjnych       <br>
	2. Cennik Usług   <br>
	3. Regulamin(y) promocji <br>                                             
	4. Deklaracja wekslowa oraz Weksel <br>",
			"2"=>"","3"=>"","4"=>"","5"=>"", "6"=>"", "7"=>"", "8"=>"", "9"=>"", "10"=> "", "11"=>"dwóch", "12"=>"", "13"=>"", "14"=>"", "15"=>""
		);	
	}
	else
	{
		$tresc=array
		(
			"0"=>"zwaną dalej Operatorem w zakresie świadczenia usług internetowych i telefonicznych (Operator) <br>
	oraz <br>
	KORBANK Media Cyfrowe Spółką z ograniczoną odpowiedzialnością z siedzibą we Wrocławiu przy ul. Nabycińskiej 19 zarejestrowaną przez Sąd Rejonowy we Wrocławiu VI Wydział Gospodarczy Krajowego Rejestru Sądowego w Rejestrze Przedsiębiorców pod numerem KRS: 0000263862,  NIP: 897-17-21-120, REGON: 020373926, z kapitałem zakładowym 50 000 zł, zwaną dalej Dostawcą w zakresie świadczenia usług telewizyjnych (Dostawca),<br>",
			"1"=>	"1. Regulamin świadczenia usług telekomunikacyjnych <br>      
	2. Cennik Usług   <br>
	3. Regulamin(y) promocji <br>                                             
	4. Deklaracja wekslowa oraz Weksel <br>",
			"2"=>" oraz świadczenie przez Operatora wspólnie z Dostawcą usług telewizyjnych",
			"3"=>"– ,,Regulaminem świadczenia usług telewizyjnych” zwanym dalej Regulaminem telewizyjnym,<br>",
			"4"=>"Regulamin telewizyjny,",
			"5"=>"4. Dokładna specyfikacja usług telewizyjnych oraz ich cena określone są w tabeli nr 4, w Cenniku oraz w ewentualnym regulaminie promocji.<br>",
			"6"=>"i 4 ",
			"7"=>"5. Rozpoczęcie świadczenia usług telewizyjnych objętych niniejszą Umową następuje z dniem określonym w tabeli nr 4.<br>",
			"8"=>"Operator wspólnie z Dostawcą może dokonywać zmian Regulaminu telewizyjnego.",
			"9"=>", Regulaminu telewizyjnego ",
			"10"=>" Regulaminie telewizyjnym i",
			"11"=>"trzech",
			"12"=>", Regulaminem telewizyjnym",
			"13"=>", Regulamin telewizyjny", 
			"14"=>"", "15"=>""
		);
	};
	
	if ( $u[typ_um] =='0')
		$tresc[14]="nieokreślony";
	else
		$tresc[14]="określony,  który upływa z końcem $u[typ_um] miesiąca, liczony od dnia rozpoczęcia świadczenia usługi";

	if ( $u[status] =='Rozwiązana')
		$tresc[15]="ROZWIĄZANA";
	else if ( $u[status] =='Zawieszona')
		$tresc[15]="ZAWIESZONA";
	else if ( $u[status] =='windykowana')
		$tresc[15]="WINDYKOWANA";
		
	if ( !empty ($k) )
	{
		$computers="<div class=\"5\"> Tabela nr 2 - specyfikacja usług internetowych </div>
		<table class=\"1\"> <tbody>";
		$i=1;
		foreach ($k as $l)
		{
			$computers.="
<tr><td>Komputer $i.</td><td></td></tr>

<tr><td>Pakiet internetowy:</td><td>$l[nazwa]</td></tr>
<tr><td>Data aktywacji usługi:</td><td>$l[aktywny_od]</td></tr>
<tr><td>Usługi dodatkowe:</td><td>Zewnętrzny adres IP: $l[ipzewn], Antywirus: $l[antywirus] </td></tr>";
			$i++;
		}
		$computers.="</tbody></table>";
	}
	
	if ( !empty($c) )
	{
		$cpe="<div class=\"5\"> Sprzęt Operatora dzierżawiony przez Abonenta* </div>
					<table class=\"1\">
<tbody>";
		$i=1;
		foreach ($c as $l)
		{
			$cpe.="<tr><td>Zestaw kliencki $i.</td><td></td></tr>

<tr><td>Producent:</td><td>$l[producent]</td></tr>
<tr><td>Model:</td><td>$l[typ]</td></tr>
<tr><td>Adres fizyczny (MAC):</td><td>$l[mac] </td></tr>";
			$i++;
		}
		$cpe.="</tbody></table>";
	}
	
	if ( !empty ($t) )
	{
		$telefones="<div class=\"5\"> Tabela nr 3 - specyfikacja usług telefonicznych </div>
						<table class=\"1\">
<tbody>";
		$i=1;
		foreach ($t as $l)
		{
			$telefones.="<tr><td>Telefon $i.</td><td></td></tr>
<tr><td>Numer:</td><td>$l[numer]</td></tr>
<tr><td>Data uruchomienia i aktywacji:</td><td>$l[data_aktywacji]</td></tr>
<tr><td>Taryfa:</td><td>$l[nazwa] </td></tr>
<tr><td>Taryfa aktywna od:</td><td>$l[aktywny_od] </td></tr>";
			$i++;
		}
				$telefones.="</tbody></table>";
	}



	if ( !empty ($g))
	{
		$gates="<div class=\"5\"> Sprzęt Operatora dzierżawiony przez Abonenta* </div>
					<table class=\"1\">
<tbody>";
		$i=1;
		foreach ($g as $l)
		{
			$gates.="<tr><td>Bramka $i.</td><td></td></tr>

<tr><td>Producent:</td><td>$l[producent]</td></tr>
<tr><td>Model:</td><td>$l[model]</td></tr>
<tr><td>Numer Seryjny:</td><td>$l[nr_seryjny] </td></tr>
<tr><td>Adres fizyczny (MAC):</td><td>$l[mac] </td></tr>";
			$i++;
		}
		$gates.="</tbody></table>";
	}
	
	
	if ( !empty ($s))
	{
		$stb="<div class=\"5\"> Tabela nr 4 - specyfikacja usług telewizyjnych </div>
		<table class=\"1\">
<tbody>";
		$i=1;
		foreach ($s as $l)
		{
			$stb.="
			<tr><td>Dekoder $i.*</td><td></td></tr>

<tr><td>Typ:</td><td>$l[typ]</td></tr>
<tr><td>Numer Seryjny: </td><td>$l[sn]</td></tr>
<tr><td>Adres fizyczny (MAC):</td><td>$l[mac] </td></tr>
<tr><td>PIN:</td><td>$l[pin] </td></tr>
<tr><td>Pakiet telewizyjny:</td><td>$l[nazwa] </td></tr>
<tr><td>Data aktywacji usługi:</td><td>$l[aktywny_od] </td></tr>
<tr><td>Usługi dodatkowe:</td><td> Media Player: $l[addsrv5], WiFi: $l[addsrv6], Nagrywanie PVR: $l[addsrv7], Pakiet PLUS: $l[addsrv1], Pakiet HBO SD: $l[addsrv2], Pakiet HBO HD: $l[addsrv3], Cinemax: $l[addsrv8], Canal+ Silver: $l[addsrv9], Canal+ Gold: $l[addsrv10], Canal+ Platinum: $l[addsrv11], Canal+ Premium: $l[addsrv12] </td></tr>";
			$i++;
		}
				$stb.="</tbody></table>";
	}

if ( $ilosc<=2 )
	$pb="<pagebreak>";
else
	$pb="";
	
		
$umowa="
<div class=\"1\"> UMOWA ABONENCKA $tresc[15]</div> 
<div class=\"2\">o świadczenie usług telekomunikacyjnych <br>
nr $u[nr_um] </div><br>

Zawarta w dniu $u[data_zaw] pomiędzy:	<br>
$firma[nazwa] $firma[nazwa2]  z siedzibą w $firma[adres],
NIP: $firma[nip], REGON: $firma[regon],<br>
$tresc[0]
zawarta  $u[siedziba] Operatora, <br>
reprezentowanego przez $u[pnazwa] (przedstawiciela Operatora) a:<br>
<br>
<div class=\"5\">	Tabela nr 1 – Dane Abonenta </div>
<table style=\"width:800px; height:500px; min-height:500px !important;\" >
<tbody>
	<tr><td class=\"1\"> Imię i Nazwisko / Nazwa firmy:</td>    					<td class=\"2\"> $a[nazwa] </td></tr>
	<tr><td class=\"1\"> Adres  zameldowania (siedziby):</td>             <td class=\"2\"> $a[adres2], $a[adres1] </td></tr>
	<tr><td class=\"1\"> PESEL i Nr dowodu osobistego / NIP i REGON:</td> <td class=\"2\"> $a[pesel_nip],  $a[nrdow_regon] </td></tr>
	<tr><td class=\"1\"> Adres do korespondencji:</td>                    <td class=\"2\"> $a[adreskn], $a[adresk2], $a[adresk1] </td></tr>
	<tr><td class=\"1\"> Telefon stacjonarny i komórkowy | Adres e-mail:</td>            <td class=\"2\"> $a[tel], $a[kom] | $a[email]</td></tr>

	<tr><td class=\"1\"> Indywidualne konto do wpłat abonamentu:</td> 		<td class=\"2\"> NETICO S.C. -    $a[konto] </td></tr>
	<tr><td class=\"1\"> Kod Abonenta:</td> 															<td class=\"2\"> $a[id_abon] </td></tr>
	<tr><td class=\"1\"> Sposób płatności | Płatność do dnia miesiąca :</td> 									<td class=\"2\"> $a[forma] | $a[platnosc] </td></tr>

	<tr><td class=\"1\"> Data wejścia w życie umowy:</td> 								<td class=\"2\"> $u[data_zycie] </td></tr>
  </tbody>		
</table>

zwanym dalej w treści umowy Abonentem.   
<br>
Abonent oświadcza, że posiada pełną zdolność do czynności prawnych.
<br><br>

$computers
$cpe 
$telefones
$gates
$sim
$stb 

<br>

<div class=\"5\">Tabela nr 5 - promocje </div>
<table class=\"1\">
<tbody>
<tr>
<td>Zakabluj sąsiada [   ]</td><td>Internet z rabatem  [    ]</td><td>Dwupak [    ]</td><td>Trójpak [    ]</td><td> Zmień operatora [   ]</td>
</tr>
</tbody>
</table>

<br>

<div class=\"5\">*Urządzenia należy zwrócić Operatorowi po wypowiedzeniu Umowy.  </div>
<br>

Zapłacono <br>
<br>
.......................................... zł <br>
<br>



<pagebreak>

<div class=\"4\"> Postanowienia umowy </div>
<br>

<div class=\"3\">§ 1 </div>
1. Przedmiotem niniejszej Umowy jest świadczenie przez Operatora na rzecz Abonenta usług telekomunikacyjnych $tresc[2]. Usługi świadczone są w zakresie i warunkach określonych:<br>
–  niniejszą Umową czyli „Umową abonencką o świadczenie usług telekomunikacyjnych”,<br>
– ,,Regulaminem świadczenia usług telekomunikacyjnych” zwanym dalej Regulaminem,<br>
– ,,Cennikiem usług” zwanym dalej Cennikiem,<br>
2. W przypadku skorzystania przez Abonenta z wybranej promocji określonej w tabeli 5,  regulamin tej promocji staje się także integralną częścią Umowy.<br>
3. W przypadku dzierżawy od Operatora przez Abonenta Sprzętu, Abonent wystawia na rzecz Operatora weksel in blanco wraz z deklaracją wekslową. Po zakończeniu Umowy Sprzęt zostaje zwrócony Operatorowi, w przeciwnym razie Abonent ponosi koszty zakupu Sprzętu na podstawie Weksla.

<div class=\"3\"> § 2 </div>

1. Sposób i miejsca świadczonych usług określają odpowiadające im ewentualne załączniki oraz niniejsza Umowa. <br>
2. Regulamin, Cennik oraz ewentualne regulaminy promocji stanowią integralną część Umowy. <br>
3. Dokładna specyfikacja usług internetowych i telefonicznych oraz ich cena określone są w tabelach nr 2,3, w Cenniku oraz w ewentualnym regulaminie promocji.<br>
$tresc[5]


<div class=\"3\">§ 3 </div>
1. Daty uruchomienia i aktywacji Usług określone w tabelach 2, 3 $tresc[6] są datami rozpoczęcia naliczania należności za dane Usługi.<br>
2. Rozpoczęcie świadczenia usług internetowych objętych niniejszą Umową następuje z dniem określonym w tabeli nr 2.<br>
3. Rozpoczęcie świadczenia usług telefonicznych objętych niniejszą Umową następuje z dniem określonym w tabeli nr 3.<br>
4. Operator może uruchomić Usługi przed terminem określonym w tabeli nr 2, 3 $tresc[6] celem zestawienia pełnych parametrów transmisji. <br>
$tresc[7]


<div class=\"3\">§ 4 </div>
1. Abonent zobowiązuje się do udostępnienia lokalizacji, w której ma być zainstalowane zakończenie sieci, w celu dokonania instalacji
w terminie ustalonym z Operatorem.<br>
2. W przypadku odmowy udostępnienia lokalizacji, Operator uzna niniejszą umowę za rozwiązaną.<br>


<div class=\"3\">§ 5 </div>
1. Faktura za Usługi będzie wystawiana każdego pierwszego dnia miesiąca objętego abonamentem (obciążenie z góry).<br>
2. Abonent zobowiązuje się do regulowania należności abonamentowych za świadczone mu usługi oraz do przestrzegania terminów ich płatności.<br>
3. Wysokość abonamentu określona jest w Cenniku lub ewentualnym regulaminie promocji. Należności naliczane są z góry, od momentu uruchomienia i aktywacji Usług.<br>
4. Termin płatności za Usługi określony jest w tabeli nr 1.<br>
5. Za termin uregulowania należności uważa się dzień wpływu na rachunek bankowy $firma[nazwa] określony w tabeli nr 1.<br>


<div class=\"3\">§ 6 </div>
1. Operator może dokonywać zmian Regulaminu i Cennika.<br>
2. Wszelkie zmiany Regulaminu i Cennika, dokonywane w czasie obowiązywania Umowy, doręczane będą Abonentowi wraz z podaniem dnia ich wejścia w życie z wyprzedzeniem jednego okresu rozliczeniowego.       W przypadku braku akceptacji zmian Abonent ma prawo rozwiązania Umowy za wypowiedzeniem dokonanym w terminie jednego miesiąca od dnia otrzymania informacji. Okres wypowiedzenia liczony jest od dnia doręczenia wypowiedzenia Operatorowi.<br>
3. W przypadku gdy Abonent nie zgłosi rezygnacji z usług, zmiany Regulaminu i Cennika obowiązują od dnia podanego w informacji  przesłanej do Abonenta.<br>


<div class=\"3\">§ 7 </div>
1. Umowa zostaje zawarta na czas $tresc[14].<br>
2. Warunkiem skorzystania z warunków promocyjnych (dotyczy umów terminowych) jest obowiązywanie Umowy przez cały jej czas oznaczony.<br>

3. Umowa zawarta na czas określony ulega przedłużeniu  na czas nieokreślony, zgodnie z warunkami przewidzianymi dla danej Usługi w Cenniku doręczonym Abonentowi przy zawarciu Umowy,  o ile Abonent nie złoży na piśmie przeciwnego oświadczenia woli w terminie 30 dni, przed upływem terminu obowiązywania Umowy na czas określony.<br>
4. Umowa, która uległa przedłużeniu na czas nieokreślony może być rozwiązana przez Abonenta w każdym czasie, z zachowaniem 90 dniowego okresu wypowiedzenia, ze skutkiem na koniec okresu rozliczeniowego, przez złożenie oświadczenia w formie pisemnej, doręczonego osobiście do Operatora lub przesłanego listem poleconym.<br>
5. Umowa zawarta na czas nieokreślony może być rozwiązana przez Abonenta w każdym czasie, z zachowaniem 90 dniowego okresu wypowiedzenia, ze skutkiem na koniec okresu rozliczeniowego, przez złożenie oświadczenia w formie pisemnej, doręczonego osobiście do Operatora lub przesłanego listem poleconym.<br>
6. Umowa zawarta na czas nieokreślony może być rozwiązana przez Operatora z 90 dniowym okresem wypowiedzenia, ze skutkiem na koniec okresu rozliczeniowego, przez złożenie oświadczenia Abonentowi w formie pisemnej, doręczonego osobiście do Abonenta lub przesłanego listem poleconym.<br>
7. W przypadku wcześniejszego rozwiązania przez Abonenta lub wcześniejszego rozwiązania z przyczyn określonych w Regulaminie, Cenniku lub regulaminie promocji, uzasadniających wcześniejsze rozwiązanie, a leżących po stronie Abonenta Umowy zawartej:<br>
- Na czas określony, gdy z zawarciem Umowy związane było przyznanie Abonentowi ulgi, Operator ma prawo żądać od Abonenta, z tytułu wcześniejszego rozwiązania Umowy, kwoty w wysokości udzielonej Abonentowi ulgi określonej
w Cenniku, pomniejszonej o proporcjonalną jej wartość za okres od dnia wejścia w życie Umowy do dnia jej rozwiązania.<br>
- Na warunkach określonych w regulaminie promocji, gdy z zawarciem Umowy związane było przyznanie Abonentowi ulgi, Operator ma prawo żądać od Abonenta, z tytułu wcześniejszego rozwiązania Umowy, kwoty w wysokości udzielonej Abonentowi ulgi określonej w warunkach promocji, pomniejszonej o proporcjonalną jej wartość za okres od wejścia w życie Umowy do dnia jej rozwiązania.<br>


<div class=\"3\">§ 8 </div>
1. Umowa zostaje sporządzona w $tresc[11] jednobrzmiących egzemplarzach po jednym dla każdej ze stron. Wszelkie zmiany niniejszej Umowy wymagają formy pisemnej pod rygorem nieważności.<br>
2. W sprawach nieregulowanych niniejszą Umową i Regulaminem stosuje się przepisy kodeksu cywilnego.<br>
3. Dane, o których mowa w Ustawie z dnia 16 lipca 2004 roku Prawo telekomunikacyjne (Dz. U. Nr 171, poz. 1800 z późn. zm.) Art. 56 ust. 3 pkt 6–8 i 10–21 zawarte zostały w Regulaminie.<br>
4. Warunki zawierania Umowy poza siedzibą Operatora lub na odległość określają zapisy Regulaminu, dział II pkt. 10. <br>
<br>
Abonent oświadcza, że został poinformowany o prawie kontroli przetwarzania danych, które go dotyczą, w szczególności o prawie do dostępu do treści swoich danych oraz ich poprawiania, żądania ich uzupełnienia, uaktualnienia i sprostowania. <br>
<br>
Oświadczam, że:<br>
- otrzymałem(am) Regulamin oraz Cennik Usług i zgadzam się z ich treścią,<br>
- otrzymałem(am) regulaminy promocji (dotyczy oferty promocyjnej) i zgadzam się z ich treścią.<br>
<br><br><br><br><br>

<table class=\"1\" >
<tbody>
<tr>
<td class=\"3\">..........................................................................</td>
<td class=\"3\">..........................................................................</td>
</tr><tr>
<td class=\"3\">Data i podpis  Abonenta </td>
<td class=\"3\">Podpis osoby upoważnionej przez Operatora</td></tr>
</tbody>
</table>

Załączniki:*<br>
$tresc[1]
<br>
* Niepotrzebne skreślić<br>
<br><br><br>
";

return ($umowa);
}


?>