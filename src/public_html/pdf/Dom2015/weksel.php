<?php

function Weksel($a, $u)
{
	include "../func/config.php";

$weksel="

<br><br>
<div class=\"1\"> Weksel </div>

<br><br><br><br><br><br>

…..............................................................., dnia..................................... roku ........................................................zł <br>
(miejsce i data wystawienia)				

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(suma pieniężna) <br>




<br><br><br><br><br><br>





….......................................roku zapłacę za ten weksel własny na zlecenie: <br>
(data płatności) <br>


<br><br><br><br><br><br>



$firma[nazwa] $firma[nazwa2]  <br>
$firma[adres], <br>
NIP: $firma[nip], <br>
REGON: $firma[regon],<br>
(wierzyciel wekslowy / remitent) <br>

<br><br><br><br><br>

Sumę:..............................................................................................................................................................................................<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
(suma pieniężna słownie)<br>

<br><br><br>


Klauzule wekslowe: bez protestu <br>

<br><br><br><br><br>


<table class=\"1\" >
<tbody>
<tr>
<td class=\"3\">..........................................................................</td>
<td class=\"3\">..........................................................................</td>
</tr><tr>
<td class=\"3\">Odręczny podpis wystawcy weksla </td>
<td class=\"3\">Miejsce płatności weksla</td></tr>
</tbody>
</table>

";

return($weksel);
}

?>
