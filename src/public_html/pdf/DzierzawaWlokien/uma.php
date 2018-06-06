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
	2. Regulamin świadczenia usług telewizyjnych <br>
	3. Cennik Usług   <br>
	4. Regulamin(y) promocji <br>                                             
	5. Deklaracja wekslowa oraz Weksel <br>",
			"2"=>" oraz świadczenie przez Operatora wspólnie z Dostawcą usług telewizyjnych",
			"3"=>"– ,,Regulaminem świadczenia usług telewizyjnych” zwanym dalej Regulaminem telewizyjnym,<br>",
			"4"=>"Regulamin telewizyjny,",
			"5"=>"4. Dokładna specyfikacja usług telewizyjnych oraz ich cena określone są w tabeli nr 4, w Cenniku oraz w ewentualnym regulaminie promocji.<br>",
			"6"=>"i 4 ",
			"7"=>"4. Rozpoczęcie świadczenia usług telewizyjnych objętych niniejszą Umową następuje z dniem określonym w tabeli nr 4.<br>",
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
<tr><td>Usługi dodatkowe:</td><td> Media Player: $l[addsrv5], Nagrywanie PVR: $l[addsrv6], Pakiet PLUS: $l[addsrv1], Pakiet HBO SD: $l[addsrv1], Pakiet HBO HD: $l[addsrv2] </td></tr>";
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
reprezentowanego przez $u[pnazwa] a:<br>
<br>
<div class=\"5\">	Tabela nr 1 – Dane Abonenta </div>
<table style=\"width:800px; height:500px; min-height:500px !important;\" >
<tbody>
	<tr><td class=\"1\"> Imię i Nazwisko / Nazwa firmy:</td>    					<td class=\"2\"> $a[nazwa] </td></tr>
	<tr><td class=\"1\"> Adres  zameldowania (siedziby):</td>             <td class=\"2\"> $a[adres2], $a[adres1] </td></tr>
	<tr><td class=\"1\"> PESEL i Nr dowodu osobistego / NIP i REGON:</td> <td class=\"2\"> $a[pesel_nip],  $a[nrdow_regon] </td></tr>
	<tr><td class=\"1\"> Adres do korespondencji:</td>                    <td class=\"2\"> $a[adreskn], $a[adresk2], $a[adresk1] </td></tr>
	<tr><td class=\"1\"> Telefon stacjonarny i komórkowy:</td>            <td class=\"2\"> $a[tel], $a[kom] </td></tr>
	<tr><td class=\"1\"> Adres e-mail:</td> 															<td class=\"2\"> $a[email] </td></tr>
	<tr><td class=\"1\"> Indywidualne konto do wpłat abonamentu:</td> 		<td class=\"2\"> NETICO S.C. -    $a[konto] </td></tr>
	<tr><td class=\"1\"> Kod Abonenta:</td> 															<td class=\"2\"> $a[id_abon] </td></tr>
	<tr><td class=\"1\"> Płatność do dnia miesiąca:</td> 									<td class=\"2\"> $a[platnosc] </td></tr>
	<tr><td class=\"1\"> Sposób płatności:</td> 													<td class=\"2\"> $a[forma] </td></tr>
  </tbody>		
</table>

<br>
zwanym dalej w treści umowy Abonentem.   
<br>
Abonent oświadcza, że posiada pełną zdolność do czynności prawnych.
<br><br>

$computers
$cpe 
$telefones
$gates
$stb 
<br>
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
$tresc[3]
– ,,Cennikiem usług” zwanym dalej Cennikiem,<br>
2. W przypadku skorzystania przez Abonenta z wybranej promocji określonej w tabeli 5,  regulamin tej promocji staje się także integralną częścią Umowy.<br>
3. W przypadku dzierżawy od Operatora przez Abonenta sprzętu, określonego w tabeli 2,3 lub 4, Abonent wystawia na rzecz Operatora weksel in blanco wraz z deklaracją wekslową. Po zakończeniu Umowy Sprzęt zostaje zwrócony Operatorowi, w przeciwnym razie Abonent ponosi koszty zakupu Sprzętu na podstawie Weksla.

<div class=\"3\"> § 2 </div>

1. Sposób i miejsca świadczonych usług określają odpowiadające im ewentualne załączniki oraz niniejsza Umowa. <br>
2. Regulamin, $tresc[4] Cennik oraz ewentualne regulaminy promocji stanowią integralną część Umowy. <br>
3. Dokładna specyfikacja usług internetowych i telefonicznych oraz ich cena określone są w tabelach nr 2,3 w Cenniku oraz w ewentualnym regulaminie promocji.<br>
$tresc[5]


<div class=\"3\">§ 3 </div>
1. Daty uruchomienia i aktywacji Usług określone w tabelach 2, 3 $tresc[6] są datami rozpoczęcia naliczania należności za dane Usługi.<br>
2. Rozpoczęcie świadczenia usług internetowych objętych niniejszą Umową następuje z dniem określonym w tabeli nr 2.<br>
3. Rozpoczęcie świadczenia usług telefonicznych objętych niniejszą Umową następuje z dniem określonym w tabeli nr 3.<br>
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
5. Za termin uregulowania należności uważa się dzień wpływu na rachunek bankowy NETICO S.C. określony w tabeli nr 1.<br>


<div class=\"3\">§ 6 </div>
1. Operator może dokonywać zmian Regulaminu i Cennika. $tresc[8]<br>
2. Wszelkie zmiany Regulaminu$tresc[9] i Cennika, dokonywane w czasie obowiązywania Umowy, doręczane będą Abonentowi wraz z podaniem dnia ich wejścia w życie z wyprzedzeniem jednego okresu rozliczeniowego.       W przypadku braku akceptacji zmian Abonent ma prawo rozwiązania Umowy za wypowiedzeniem dokonanym w terminie jednego miesiąca od dnia otrzymania informacji. Okres wypowiedzenia liczony jest od dnia doręczenia wypowiedzenia Operatorowi.<br>
3. W przypadku gdy Abonent nie zgłosi rezygnacji z usług, zmiany Regulaminu$tresc[9] i Cennika obowiązują od dnia podanego w informacji  przesłanej do Abonenta.<br>


<div class=\"3\">§ 7 </div>
1. Umowa zostaje zawarta na czas $tresc[14].<br>
2. Umowa zawarta na czas określony ulega cyklicznemu przedłużeniu  na czas określony 6 miesięcy, zgodnie z warunkami przewidzianymi dla danej Usługi zamawianej na czas określony w Cenniku doręczonym Abonentowi przy zawarciu Umowy,  o ile Abonent nie złoży na piśmie przeciwnego oświadczenia woli w terminie 30 dni, przed upływem terminu obowiązywania Umowy na czas określony.<br>
3. Umowa zawarta na czas określony może ulec przedłużeniu na czas nieokreślony, o ile Abonent złoży stosowne oświadczenie woli w terminie 30 dni przed upływem terminu obowiązywania Umowy. Z chwilą przedłużenia Umowy na czas nieokreślony Abonent będzie zobowiązany do uiszczania opłaty abonamentowej w wysokości określonej w aktualnie obowiązującym Cenniku w części dotyczącej Umów Abonenckich na czas nieokreślony.<br>
4. Umowa zawarta na czas nieokreślony może być rozwiązana przez Abonenta w każdym czasie, z zachowaniem 90 dniowego okresu wypowiedzenia, ze skutkiem na koniec okresu rozliczeniowego, przez złożenie oświadczenia w formie pisemnej, doręczonego osobiście do Operatora lub przesłanego listem poleconym.<br>
5. Umowa zawarta na czas nieokreślony może być rozwiązana przez Operatora z 90 dniowym okresem wypowiedzenia, ze skutkiem na koniec okresu rozliczeniowego, przez złożenie oświadczenia Abonentowi w formie pisemnej, doręczonego osobiście do Abonenta lub przesłanego listem poleconym.<br>
6. W przypadku wcześniejszego rozwiązania przez Abonenta lub wcześniejszego rozwiązania z przyczyn określonych w Regulaminie,$tresc[10] Cenniku lub regulaminie promocji, uzasadniających wcześniejsze rozwiązanie, a leżących po stronie Abonenta Umowy zawartej:<br>
- Na czas określony, gdy z zawarciem Umowy związane było przyznanie Abonentowi ulgi, Operator ma prawo żądać od Abonenta, z tytułu wcześniejszego rozwiązania Umowy, kwoty w wysokości udzielonej Abonentowi ulgi.<br>
- Na warunkach określonych w regulaminie promocji, gdy z zawarciem Umowy związane było przyznanie Abonentowi ulgi, Operator ma prawo żądać od Abonenta, z tytułu wcześniejszego rozwiązania umowy, kwoty w wysokości udzielonej Abonentowi ulgi określonej w warunkach promocji.<br>


<div class=\"3\">§ 8 </div>
1. Umowa zostaje sporządzona w $tresc[11] jednobrzmiących egzemplarzach po jednym dla każdej ze stron. Wszelkie zmiany niniejszej Umowy wymagają formy pisemnej pod rygorem nieważności.<br>
2. W sprawach nieregulowanych niniejszą Umową, Regulaminem$tresc[12] stosuje się przepisy kodeksu cywilnego.<br>
3. Warunki zawierania Umowy poza siedzibą Operatora lub na odległość określają zapisy Regulaminu, rozdział II, §10. <br>
<br>
Abonent oświadcza, że został poinformowany o prawie kontroli przetwarzania danych, które go dotyczą, w szczególności o prawie do dostępu do treści swoich danych oraz ich poprawiania, żądania ich uzupełnienia, uaktualnienia i sprostowania. <br>
<br>
Oświadczam, że:<br>
- otrzymałem(am) Regulamin$tresc[13] oraz Cennik Usług i zgadzam się z ich treścią,<br>
- otrzymałem(am) regulaminy promocji (dotyczy oferty promocyjnej) i zgadzam się z ich treścią.<br>
<br><br><br><br><br><br>

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

             

<br><br>

Załączniki:*<br>
$tresc[1]
<br>
* Niepotrzebne skreślić<br>
<br><br><br>



<div class=\"4\"> Informacja </div>
NETICO S.C. z siedzibą w Mysłowicach, przy ul. Szopena 26, działając na podstawie art. 24 ust. 1 ustawy o ochronie danych osobowych oraz art. 163 i art. 165 ust. 3 ustawy – Prawo telekomunikacyjne informuje, że:<br>
- jest administratorem danych osobowych swoich Abonentów;<br>
- w okresie obowiązywania Umowy, a po jej zakończeniu – w okresie dochodzenia roszczeń wynikających z Umowy, jak też wykonania innych zadań przewidzianych w ustawie – Prawo telekomunikacyjne lub przepisach odrębnych, przetwarza dane osobowe Abonentów oraz inne dane, niezbędne dla celów wykonania świadczonej Usługi, przekazywania komunikatów w sieciach telekomunikacyjnych, naliczania opłat Abonenta oraz opłat z tytułu rozliczeń międzyoperatorskich (dane transmisyjne);<br>
- jeśli Abonent wyrazi zgodę, dotyczące go dane transmisyjne, w okresie obowiązywania Umowy, przetwarzane będą również dla celów marketingu usług telekomunikacyjnych;<br>
- za zgodą Abonenta jego dane osobowe przetwarzane będą również w celu marketingu produktów i usług podmiotów współpracujących z NETICO S.C., jak też będą tym podmiotom udostępniane;<br>
- Abonent ma prawo dostępu do treści swoich danych przetwarzanych przez NETICO S.C. oraz do ich poprawiania;<br>
przetwarzanie danych osobowych w celu realizacji umowy o świadczenie publicznie dostępnych usług telekomunikacyjnych, w zakresie obejmującym nazwisko i imiona, imiona rodziców, miejsce i datę urodzenia, adres zameldowania na pobyt stały, numer ewidencyjny PESEL, nazwę, serię i numer dokumentów potwierdzających tożsamość, a w przypadku cudzoziemca - który nie jest obywatelem państwa członkowskiego albo Konfederacji Szwajcarskiej - numer paszportu lub karty pobytu, oraz informacje zawarte w dokumentach potwierdzających możliwość wykonania zobowiązania wobec dostawcy publicznie dostępnych usług telekomunikacyjnych wynikającego z umowy o świadczenie usług telekomunikacyjnych, nie wymaga zgody Abonenta i wynika z art. 161 ust. 2 ustawy – Prawo telekomunikacyjne; przetwarzanie innych, niż ww. danych osobowych wymaga zgody Abonenta.
<br><br>
<div class=\"4\"> Oświadczenia Abonenta </div><br>
<br>
Wyrażenie zgody jest dobrowolne. Zgoda może być wycofana w każdym czasie, w dowolny sposób. Wycofanie zgody jest wolne od opłat. Ja, niżej podpisany/a, wyrażam swoja wolę zgodnie z zaznaczeniami poniżej.<br>
<br>
1. Przetwarzanie danych osobowych w rozszerzonym zakresie.<br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na przetwarzanie przez NETICO S.C. moich danych określonych w tabeli nr 1 w zakresie adresu e-mail i numeru telefonu kontaktowego w celach związanych ze świadczonymi usługami, w szczególności wysyłania zmian cenników i regulaminów, potwierdzeń zmiany umowy, e-faktur, rozpatrywania reklamacji.<br>
<br>
2. Przesyłanie informacji handlowej dotyczącej NETICO S.C. środkami komunikacji elektronicznej. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na przesyłanie informacji handlowych środkami komunikacji elektronicznej.<br>
<br>
3. Przetwarzanie danych transmisyjnych w celach marketingowych. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na przetwarzanie przez NETICO S.C. – przez okres obowiązywania umowy, dla celów marketingu usług telekomunikacyjnych – dotyczących mnie danych transmisyjnych (przez które należy rozumieć dane przetwarzane dla celów przekazywania komunikatów w sieciach telekomunikacyjnych i naliczania opłat za usługi telekomunikacyjne).<br>
<br>
4. Zamieszczenie danych osobowych w spisach abonentów. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na zamieszczenie identyfikujących mnie danych (w zakresie obejmującym numer/y telefonu,
nazwisko i imiona, nazwę miejscowości oraz ulicy) w spisach abonentów prowadzonych przez NETICO S.C. i innych przedsiębiorców telekomunikacyjnych oraz na udostępnienie niżej wymienionego numeru/numerów telefonów w ramach usług informacji o numerach telefonicznych świadczonych przez NETICO S.C. i innych przedsiębiorców telekomunikacyjnych.<br>
<br>
5. Używanie automatycznych systemów wywołujących dla celów marketingu bezpośredniego. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na używanie przez NETICO S.C. automatycznych systemów wywołujących dla celów marketingu bezpośredniego.<br>
<br>
6. Przetwarzanie danych osobowych w celach marketingowych innych podmiotów, niż NETICO S.C. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na przetwarzanie przez NETICO S.C. moich danych osobowych w celach marketingu produktów i usług  podmiotów współpracujących z NETICO S.C., w szczególności usług finansowych, bankowych i ubezpieczeniowych, i przesyłanie dotyczących ich informacji handlowych środkami komunikacji elektronicznej.<br>
<>
7. Udostępnianie danych osobowych. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na udostępnianie przez NETICO S.C. moich danych osobowych podmiotów współpracujących z NETICO S.C. <br>

 <br> <br> <br><br><br>



...................................................................... <br>
Data i podpis  Abonenta
$pb";

return ($umowa);
}

?>