<?php

function body1() 
{
	include "func/config.php";
	
	$body=<<<PDFMAIL
	<html>
	<body bgcolor="#ffffff"> 
	<p align="left" style="font-size:10pt; font-family: 	Tahoma"> 

	Szanowni Państwo<br>
	Dziękujemy za skorzystanie z naszych usług. <br>
	Przypominamy o konieczności opłacenia abonamentu za <br>
	usługi internetowe. W załączeniu przesyłamy fakturę(y) VAT.<br>
	<br>
	Termin wskazany na fakturach jest terminem,<br>
	jaki nie powinien być przekroczony, <br>
	datą decydującą jest data wpływu środków na nasze konto. <br>
	<br>
	Przypominamy, że zaleganie z płatnością wystawionych faktur <br>
	lub not odsetkowych o więcej niż 14 dni od wyznaczonego terminu <br>
	płatności skutkuje całkowitą utratą dostępu do infrastruktury <br>
	teleinformatycznej operatora, zamknięciem konta i utratą wszystkich <br>
	związanych z nim zasobów i informacji.<br>
	<br>
	W razie jakichkolwiek pytań prosimy  wysłać do nas zapytanie na adres <br>
	<a href="mailto:$firma[email3]"> $firma[email3]</a> .

	<br>
			</body> 
			</html> 
PDFMAIL;
		return $body;
}
?>