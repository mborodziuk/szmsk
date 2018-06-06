<?php

function Inf($a, $u, $k, $t, $s, $srv, $r)
{
	include "../func/config.php";
	
	$sum=number_format($srv[sum], 2, ',','');
	
	if (! empty ($k))
	{
		$kmp=$k[0];
		$internet="- Dostęp do Internetu $kmp[aktywny_od];";
	}	
	if (! empty ($t))
	{
		$tel=$k[0];
		$telstac="- Telefon stacjonarny $tel[aktywny_od];";
	}	
	if (! empty ($s))
	{
		$tv=$t[0];
		$telewizja="- Telewizja $tv[aktywny_od];";
	}	
	
	$util_day=OstatniDzienMiesiaca(add_date($u[data_zycie], 0, ($u[typ_um]-1), 0));
	$term_day=OstatniDzienMiesiaca(add_date($u[data_zycie], -30, ($u[typ_um]-1), 0));
	
	if ( $u[typ_um] =='0')
		$time="Umowa zawarta zostanie na <b>czas nieokreślony</b>. Może ona zostać pisemnie wypowiedziana przez każdą ze Stron bez podawania przyczyny z zachowaniem 90-dniowego okresu wypowiedzenia ze skutkiem na koniec Okresu Rozliczeniowego. Okresem Rozliczeniowym jest 1 miesiąc kalendarzowy.";
	else
		$time="Umowa zawarta została na <b>czas określony </b>do dnia <b>$util_day</b>. Po upływie okresu na jaki Umowa została zawarta przekształca się ona w Umowę na czas nieokreślony na warunkach wynikających z Cennika. Abonent na 30 dni przed upływem okresu na jaki została zawarta Umowa, tj. do dnia <b>$term_day</b>, może złożyć Operatorowi oświadczenie o braku chęci kontynuowania Umowy. W takiej sytuacji Umowa ulega rozwiązaniu ostatniego dnia okresu na jaki została zawarta.";


	$information="
	
<div class=\"1\"> INFORMACJA </div>
<br>
W trybie ustawy z dnia 30 maja 2014 r. o prawach konsumenta (Dz. U. 2014 poz. 827)  $firma[nazwa] $firma[nazwa2]  z siedzibą w $firma[adres],
NIP: $firma[nip], REGON: $firma[regon] (Operator ) informuje Abonenta: <br>
<b>$a[nazwa], $a[adres2], $a[adres1]</b>, że: 
<br><br>

1. W ramach niniejszej Umowy Operator będzie świadczył na rzecz Abonenta następujące usługi: <br>
$srv[desc]
2. Łączna wysokość wynagrodzenia za świadczenie Usług wraz z podatkami wynosi: <b> $sum zł </b> brutto. Ww kwotę Abonent powinien uiszczać do $a[platnosc] dnia miesiąca. Szczegółowe informacje o opłatach jakie zobowiązany jest ponosić konsument w związku z zawartą Umową znajdują się w Cenniku usług Operatora lub w ewentualnym regulaminie promocji. <br>
3. W trakcie trwania Umowy Operator będzie porozumiewał się z Abonentem za pośrednictwem swoich upoważnionych przedstawicieli w siedzibie Operatora lub za pośrednictwem poczty elektronicznej, bądź telefonu oraz poprzez informacje publikowane na swojej stronie internetowej: <b>www.netico.pl </b>oraz <b>http://live.netico.pl</b>.<br>
4.Usługi zamówione przez Abonenta zostaną aktywowane w następujacym terminie:<br>
  $internet<br> 
	$telstac<br>
	$telewizja<br>
	Pełne parametry ww usług uruchomione zostaną wraz z wejściem Umowy w życie tj. <b>$u[data_zycie]</b>.
Usługa będzie świadczona w sposób ciągły w trakcie trwania Umowy.  <br>
5. Operator stosuje procedurę reklamacyjną wynikającą z Rozporządzenia Ministra Administracji i Cyfryzacji z dnia 24 lutego 2014 r. w sprawie reklamacji usługi telekomunikacyjnej, szczegółowo opisaną w Dziale XII Regulaminu. <br>
6. Operator ponosi odpowiedzialność względem Abonenta za jakość świadczenia usług telekomunikacyjnych na zasadach określonych w ustawie z dnia z dnia 16 lipca 2004 r. Prawo telekomunikacyjne (Dz.U. 2004 Nr 171, poz. 1800) oraz Kodeksie Cywilnym. Zasady te zostały szczegółowo opisane w Dziale XI Regulaminu. <br>
7. Operator nie udziela dodatkowej gwarancji na świadczone prze siebie usługi telekomunikacyjne. Operator zapewnia Abonentowi obsługę serwisową w trakcie trwania Umowy. Warunki świadczenia obsługi serwisowej wskazane są w Dziale X Regulaminu, zaś opłaty z nimi związane wynikają z Cennika usług Operatora.  <br>
8. Abonent może zawrzeć z Operatorem Umowę na czas nieokreślony lub czas określony. <br>
<br>
$time
<br><br>
Abonent oświadcza, iż Opertor przed podpisaniem niniejszej Informacji wręczył Abonentowi i zapoznał go z treścią Umowy, Regulaminu świadczenia usług telekomunikacyjnych i Cennika usług stosowanych przez Operatora, w szczególności poinformował go o zasadach stosowanej u Operatora procedury reklamacyjnej, zasadach odpowiedzialności Operatora względem Abonenta za jakość świadczonych usług, zasadach usług serwisowych, warunkach i kosztach obsługi serwisowej, jakie zobowiązany będzie ponosić konsument wskazanych w Cenniku, sposobie wypowiadania Umowy oraz warunkach jej automatycznego przedłużenia. 

<br><br>

$firma[nazwa] działając na podstawie art. 24 ust. 1 ustawy o ochronie danych osobowych oraz art. 163 i art. 165 ust. 3 ustawy – Prawo telekomunikacyjne informuje, że:<br>
- jest administratorem danych osobowych swoich Abonentów;<br>
- w okresie obowiązywania Umowy, a po jej zakończeniu – w okresie dochodzenia roszczeń wynikających z Umowy, jak też wykonania innych zadań przewidzianych w ustawie – Prawo telekomunikacyjne lub przepisach odrębnych, przetwarza dane osobowe Abonentów oraz inne dane, niezbędne dla celów wykonania świadczonej Usługi, przekazywania komunikatów w sieciach telekomunikacyjnych, naliczania opłat Abonenta oraz opłat z tytułu rozliczeń międzyoperatorskich (dane transmisyjne);<br>
- jeśli Abonent wyrazi zgodę, dotyczące go dane transmisyjne, w okresie obowiązywania Umowy, przetwarzane będą również dla celów marketingu usług telekomunikacyjnych;<br>
- za zgodą Abonenta jego dane osobowe przetwarzane będą również w celu marketingu produktów i usług podmiotów współpracujących z $firma[nazwa], jak też będą tym podmiotom udostępniane;<br>
- Abonent ma prawo dostępu do treści swoich danych przetwarzanych przez $firma[nazwa] oraz do ich poprawiania;<br>
przetwarzanie danych osobowych w celu realizacji umowy o świadczenie publicznie dostępnych usług telekomunikacyjnych, w zakresie obejmującym nazwisko i imiona, imiona rodziców, miejsce i datę urodzenia, adres zameldowania na pobyt stały, numer ewidencyjny PESEL, nazwę, serię i numer dokumentów potwierdzających tożsamość, a w przypadku cudzoziemca - który nie jest obywatelem państwa członkowskiego albo Konfederacji Szwajcarskiej - numer paszportu lub karty pobytu, oraz informacje zawarte w dokumentach potwierdzających możliwość wykonania zobowiązania wobec dostawcy publicznie dostępnych usług telekomunikacyjnych wynikającego z umowy o świadczenie usług telekomunikacyjnych, nie wymaga zgody Abonenta i wynika z art. 161 ust. 2 ustawy – Prawo telekomunikacyjne; przetwarzanie innych, niż ww. danych osobowych wymaga zgody Abonenta.

<br><br><br><br><br>

...................................................................... <br>
Data i podpis  Abonenta


<pagebreak>

<br><br>
<div class=\"4\"> Oświadczenia Abonenta </div><br>
<br>
Wyrażenie zgody jest dobrowolne. Zgoda może być wycofana w każdym czasie, w dowolny sposób. Wycofanie zgody jest wolne od opłat. Ja, niżej podpisany/a, wyrażam swoja wolę zgodnie z zaznaczeniami poniżej.<br>
<br>
1. Przetwarzanie danych osobowych w rozszerzonym zakresie.<br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na przetwarzanie przez $firma[nazwa] moich danych określonych w tabeli nr 1 w zakresie adresu e-mail i numeru telefonu kontaktowego w celach związanych ze świadczonymi usługami, w szczególności wysyłania zmian cenników i regulaminów, potwierdzeń zmiany umowy, e-faktur, rozpatrywania reklamacji.<br>
<br>
2. Komunikacja i przesyłanie faktur drogą elektroniczną.<br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na odbiór przez mnie faktur za usługi oraz udzielanie przez $firma[nazwa] odpowiedzi na reklamacje i komunikacji ze mną poprzez Elektroniczne Biuro Obsługi Klienta lub pocztę elektroniczną (skrzynkę e-mail).<br>
<br>

3. Przesyłanie informacji handlowej dotyczącej $firma[nazwa]. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na przesyłanie informacji handlowych środkami komunikacji elektronicznej i za pośrednictwem telekomunikacyjnych urządzeń końcowych (m. in. telefonów w celu np. przedłużenia umowy).<br>
<br>


4. Sprawdzenie wiarygodności finansowej. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
stosownie do przepisów ustawy z dnia 9 kwietnia 2010 r. o udostępnieniu informacji gospodarczych i wymianie informacji gospodarczych do wystąpienia przez $firma[nazwa] do biur informacji gospodarczej o ujawnienie informacji gospodarczych dotyczących mojej osoby, w tym również informacji dotyczących zobowiązań powstałych przed dniem wejścia w życie ww. ustawy. Upoważnienie obejmuje wielokrotne wystąpienie do biur informacji gospodarczej w ciągu 30 dni od dnia jego złożenia.<br>
<br>


5. Przetwarzanie danych transmisyjnych w celach marketingowych. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na przetwarzanie przez $firma[nazwa] – przez okres obowiązywania umowy, dla celów marketingu usług telekomunikacyjnych – dotyczących mnie danych transmisyjnych (przez które należy rozumieć dane przetwarzane dla celów przekazywania komunikatów w sieciach telekomunikacyjnych i naliczania opłat za usługi telekomunikacyjne).<br>
<br>
6. Zamieszczenie danych osobowych w spisach abonentów. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na zamieszczenie identyfikujących mnie danych (w zakresie obejmującym numer/y telefonu,
nazwisko i imiona, nazwę miejscowości oraz ulicy) w spisach abonentów prowadzonych przez $firma[nazwa] i innych przedsiębiorców telekomunikacyjnych oraz na udostępnienie niżej wymienionego numeru/numerów telefonów w ramach usług informacji o numerach telefonicznych świadczonych przez $firma[nazwa] i innych przedsiębiorców telekomunikacyjnych.<br>
<br>
7. Używanie automatycznych systemów wywołujących dla celów marketingu bezpośredniego. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na używanie przez $firma[nazwa] automatycznych systemów wywołujących dla celów marketingu bezpośredniego.<br>
<br>
8. Udostępnianie danych osobowych. <br>
Ja, niżej podpisany/a,  wyrażam zgodę  [    ]  /  nie wyrażam zgody [    ] <br>
na udostępnianie przez $firma[nazwa] moich danych osobowych podmiotom współpracującym z $firma[nazwa] <br>

 <br> <br> <br><br><br>



...................................................................... <br>
Data i podpis  Abonenta
";

return ($information);
}



?>