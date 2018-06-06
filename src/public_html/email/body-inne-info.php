<?php

function body1() 
{
	include "func/config.php";
	
	$body=<<<PDFMAIL
	<html>
	<body bgcolor="#ffffff"> 
	<p align="left" style="font-size:10pt; font-family: 	Tahoma"> 

	Szanowni Państwo<br>
	Z powodu błędu systemu informatycznego wysłaliśmy <br>
	do Państwa dwa razy faktury za kwiecień 2014.  <br>
	Prosimy o WYKASOWANIE tych faktur z Państwa komputerów.<br>
	<br>
	Wysyłamy teraz faktury właściwe tj. za maj 2014.<br>
	Uprzejmie przepraszamy za problemy. <br>
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