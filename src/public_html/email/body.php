<?php

function body1() 
{
	include "func/config.php";
	
	$body=<<<PDFMAIL
	<html>
	<body bgcolor="#ffffff"> 
	<p align="left" style="font-size:10pt; font-family: 	Tahoma"> 

	Szanowni Państwo.<br>
	Serdecznie dziękujemy za korzystanie z naszych usług. <br>
	Przypominamy o konieczności opłacenia abonamentu. <br>
	W załączeniu przesyłamy fakturę(y) VAT.<br>
	<br>
	Termin wskazany na fakturach jest terminem,<br>
	jaki nie powinien być przekroczony, <br>
	datą decydującą jest data wpływu środków na nasze konto. <br>
	<br><br>
	Jeżeli ta sama faktura (ten sam numer) została <br>
	wysłana Państwu dwukrotnie to prosimy jedną skasować. 
	<br><br>
	W razie jakichkolwiek pytań prosimy o kontakt pod adresem <br>
	<a href="mailto:$firma[email3]"> $firma[email3]</a> .
	<br>
	<br>
	Z wyrazami szacunku.
	<br>
	-- <br>
	Finanse | NETICO S.C.  <br>
	e-mail: finanse@netico.pl, tel: +48 32 745 33 33 <br>
  <br>
	NETICO S.C., ul. Szopena 26, 41-400 Mysłowice, <br>
	e-mail: biuro@netico.pl, http://www.netico.pl <br>
	tel: +48 32 745 33 33, kom. +48 500 870 870, fax: +48 32 745 33 34 <br>
	NIP: 2220839510, REGON:240792386, RPT: 05621 <br>

	</body> 
	</html> 
PDFMAIL;
		return $body;
}
?>