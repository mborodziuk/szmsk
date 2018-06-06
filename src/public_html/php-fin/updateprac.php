<?
	$dbh=DBConnect($DBNAME1);

   $Q1="select  id_prac, nazwa, ulica, nr_bud, nr_mieszk, miasto, kod, nip, pesel, sn_dowodu, data_ur, mezczyzna, stanowisko, imie_ojca, imie_matki, nazw_pan_matki, miejsce_ur
				from pracownicy id_prac where id_prac='$_GET[prac]'";
	$sth1=Query($dbh,$Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['prac']=$prac=array
	('id_prac' 	=> $_GET[prac], 	'nazwa'	=>$row1[1], 	'ulica'	=>$row1[2],			'nr_bud'		=>	$row1[3],
	'nr_mieszk'	=>$row1[4],			'miasto'	=>$row1[5],		'kod'		=>$row1[6],			'nip'			=>$row1[7],
	'pesel'		=>$row1[8],			'sn_dowodu'=>$row1[9],	'data_ur'	=>$row1[10],
	'mezczyzna'	=>$row1[11],		'stanowisko'=>$row1[12]	,         'imie_ojca' =>$row1[13],         'imie_matki' =>$row1[14],         
	'nazw_pan_matki' =>$row1[15],         'miejsce_ur' =>$row1[16]);

	$Q3="select id_podm, telefon, tel_kom from telefony where id_podm='$_GET[prac]'";
	$sth3=Query($dbh,$Q3);
	$row3 =$sth3->fetchRow();

	$Q7="select id_podm, email from maile where id_podm='$_GET[prac]'";
	$sth7=Query($dbh,$Q7);
	$row7 =$sth7->fetchRow();

	$Q9="select nr_kb, bank from konta_bankowe where id_wlasc='$_GET[prac]'";
	$sth9=Query($dbh,$Q9);
	$row9 =$sth9->fetchRow();

$_SESSION['tel']=$tel=array
('id_podm'		=>$row3[0], 'telefon'		=>$row3[1], 	'tel_kom'		=>$row3[2]);

$_SESSION['mail']=$mail=array
('id_podm' =>$row7[0], 'email'=>$row7[1]);

$_SESSION['konto']=$konto=array
('id_wlasc' =>$_GET[dost], 'nr_kb'=>$row9[0], 'bank'=>$row9[1]);

?>

<form method="POST" action="index.php?panel=fin&menu=updatepracwyslij&prac=<? echo $_GET[prac]; ?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane pracownika
		</td>
	</tr>
	<tr>
		<td class="klasa2"> 
				Imię i nazwisko
		</td> 
		<td class="klasa4">
			<input size="40" name="nazwa" value="<? echo $prac[nazwa] ?>">
		</td>
	</tr> 
	<tr>
		<td class="klasa2">
				Kobieta
		</td>
		<td class="klasa4">
			<?
				if ( $prac[mezczyzna]=="T")
					echo " <input type=\"radio\" name=\"mezczyzna\" value=\"N\"/> ";
				else 
					echo " <input type=\"radio\" name=\"mezczyzna\" value=\"N\" checked=\"true\"/> ";
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Mężczyzna
		</td>
		<td class="klasa4">
			<?
				if ( $prac[mezczyzna]=="T")
					echo " <input type=\"radio\" name=\"mezczyzna\" value=\"T\" checked=\"true\"/> ";
				else 
					echo " <input type=\"radio\" name=\"mezczyzna\" value=\"T\"/> ";
			?>
		</td>
	</tr>
	
	
        <tr>
            <td class="klasa2">
                    Imię ojca
            </td>
            <td class="klasa4">
                    <input size="20" name="imie_ojca" value="<? echo $prac[imie_ojca] ?>">
            </td>
        </tr>
        <tr>
            <td class="klasa2">
                    Imię matki
            </td>
            <td class="klasa4">
                <input size="20" name="imie_matki" value="<? echo $prac[imie_matki] ?>">
            </td>
        </tr>
        <tr>
            <td class="klasa2">
                Nazwisko panienskie matki
            </td>
        <td class="klasa4">
            <input size="20" name="nazw_pan_matki" value="<? echo $prac[nazw_pan_matki] ?>">
        </td>
        </tr>
                                                                                                                                                                                                                                                                                                                                                            	
	
	<tr>
		<td class="klasa2"> 
				Stanowisko
		</td> 
		<td class="klasa4">
			<input size="40" name="stanowisko"  value="<? echo $prac[stanowisko] ?>">
		</td>
	</tr> 
	<tr>
		<td class="klasa2"> 
				Data urodzenia
		</td> 
		<td class="klasa4">
			<input size="40" name="data_ur"  value="<? echo $prac[data_ur] ?>">
		</td>
	</tr>
        <tr>
                <td class="klasa2">
                        Miejsce urodzenia
    		</td>
                <td class="klasa4">
                        <input size="30" name="miejsce_ur" value="<? echo $prac[miejsce_ur] ?>">
                </td>
        </tr>
                                                                                                                                        

	<tr>
		<td class="klasa2">
				NIP
		</td>
		<td class="klasa4">
				<input size="20" name="nip"  value="<? echo $prac[nip] ?>">
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
				Seria i numer dowodu
		</td>
		<td class="klasa4">
				<input size="20" name="sn_dowodu"  value="<? echo $prac[sn_dowodu] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Pesel
		</td>
		<td class="klasa4">
				<input size="20" name="pesel"  value="<? echo $prac[pesel] ?>">
		</td>	
	</tr>
			<tr>
				<td class="klasa1" colspan="2" >
					Dane adresowe
				</td>
			</tr>
	<tr>
		<td class="klasa2">
				Ulica
		</td>
		<td class="klasa4">
				<input size="20" name="ulica"  value="<? echo $prac[ulica] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Numer budynku
		</td>
		<td class="klasa4">
				<input size="2" name="nr_bud"  value="<? echo $prac[nr_bud] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Nr mieszkania
		</td>
		<td class="klasa4">
				<input size="2" name="nr_mieszk"  value="<? echo $prac[nr_mieszk] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kod pocztowy
		</td>
		<td class="klasa4">
				<input size="6" name="kod"  value="<? echo $prac[kod] ?>">
		</td>	
	</tr>
	<tr>
				<td class="klasa2">
					Miasto
				</td>
				<td class="klasa4">
					<input size="20" name="miasto"  value="<? echo $prac[miasto] ?>">
				</td>	
			</tr>
			<tr>
				<td class="klasa1" colspan="2" >
					Dane kontaktowe
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon stacjonarny
				</td>
				<td class="klasa4">
					<input size="15" name="telefon"  value="<? echo $tel[telefon] ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="15" name="telkom"   value="<? echo $tel[tel_kom] ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="15" name="email"   value="<? echo $mail[email] ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2" >
					Dane konta bankowego
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Bank
				</td>
				<td class="klasa4">
					<input size="15" name="bank"   value="<? echo $konto[bank] ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Nr konta 
				</td>
				<td class="klasa4">
					<input size="30" name="konto"   value="<? echo $konto[nr_kb] ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Wyślij" name="przycisk1">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
