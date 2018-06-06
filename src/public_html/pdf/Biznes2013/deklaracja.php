<?php
function Deklaracja($a, $u)
{
	include "../func/config.php";

$deklaracja="
<br>
<div class=\"1\"> Deklaracja Wekslowa </div>
<br>
Zawarta w dniu $u[data_zaw] pomiędzy:	<br>
$firma[nazwa] $firma[nazwa2]  z siedzibą w $firma[adres],
NIP: $firma[nip], REGON: $firma[regon],<br>
zawarta  $u[siedziba] zwaną dalej Remitentem, <br>
a <br>
<br>
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
	<tr><td class=\"1\"> Miejsce(a) instalacji:</td> 											<td class=\"2\"> $a[mi] </td></tr>
  </tbody>		
</table>

zwanym dalej Wystawcą weksla.  			<br>
<br><br>
<div class=\"3\">§ 1 </div>
Porozumienie to reguluje sposób w jaki Remitent wypełni weksel niezupełny w chwili wystawienia (weksel in blanco), wystawiony na zabezpieczenie sumy wierzytelności powstałej w wyniku umowy nr $u[nr_um] zawartej dnia $u[data_zaw] pomiędzy Remitentem a Wystawcą weksla. <br>
<div class=\"3\">§ 2 </div>
Remitent ma prawo wpisać sumę wekslową w wysokości zobowiązania wynikającego z ww. Umów pomniejszonego odpowiednio o wpłaty dokonane na poczet tego zobowiązania, oraz powiększonego o odsetki umowne należne w dacie płatności weksla;<br>
Remitent jako dzień płatności weksla wpisze dzień następujący po 14 dniach od daty wymagalności wierzytelności z tytułu ww. Umów; <br>
Remitent jako miejsce płatności wpisze miejsce swojej siedziby właściwej w dniu płatności weksla; <br>
Remitent  w miejsce podmiotu, na którego rzecz ma nastąpić zapłata wpisze siebie; <br>
Remitent jako dzień wystawienia weksla wpisze dzień następujący po dniu wymagalności wierzytelności z tytułu ww. umowy; <br>
<div class=\"3\">§ 3 </div>
Wystawca weksla na blankiecie wekslowym złoży swój podpis oraz wpisze miejsce wystawienia weksla. <br>
<div class=\"3\">§ 4 </div>
W przypadku gdy Wystawca weksla spłaci Remitentowi cała sumę wierzytelności z tytułu Umów, o której mowa w § 1 niniejszego Porozumienia w dniu, w którym stanie się ona wymagalna Remitent zwróci Wystawcy weksla weksel, o którym mowa w § 1 niniejszego Porozumienia. <br>
<div class=\"3\">§ 5 </div>
W sprawach nieuregulowanych co do weksla stosuje się przepisy Prawa wekslowego, w sprawach dotyczących niniejszej umowy stosuje się przepisy Kodeksu Cywilnego i Prawa Wekslowego.

<br><br><br><br><br>
<table class=\"1\" >
<tbody>
<tr>
<td class=\"3\">..........................................................................</td>
<td class=\"3\">..........................................................................</td>
</tr><tr>
<td class=\"3\">Remitent </td>
<td class=\"3\">Wystawca weksla</td></tr>
</tbody>
</table>
<pagebreak>

";
return($deklaracja);
}
?>