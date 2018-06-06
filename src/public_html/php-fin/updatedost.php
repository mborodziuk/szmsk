<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="select id_dost, nazwa, symbol, ulica, nr_bud, nr_mieszk, miasto, kod, nip, regon, aktywny, pl_vat
			from dostawcy where id_dost='$_GET[dost]'";
	$sth1=Query($dbh,$Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['dost']=$dost=array
	('id_dost' 	=> $_GET[dost], 	'symbol'		=>$row1[2], 	'nazwa'	=>$row1[1], 	'ulica'	=>$row1[3],
	'nr_bud'		=>	$row1[4],		'nr_mieszk'	=>$row1[5],		'miasto'	=>$row1[6],		'kod'		=>$row1[7],
	'nip'			=>$row1[8],			'regon'		=>$row1[9],		'aktywny'=>$row1[10],	'pl_vat'	=>$row1[11]);

	$Q2="select * from kontakty where id_podm='$_GET[dost]'";
	$sth2=Query($dbh,$Q2);
	$row2 =$sth2->fetchRow();

	$Q3="select id_podm, telefon, tel_kom from telefony where id_podm='$_GET[dost]'";
	$sth3=Query($dbh,$Q3);
	$row3 =$sth3->fetchRow();


	$Q6="select k.id_kontakt, t.telefon, t.tel_kom from telefony t, kontakty k where t.id_podm=k.id_kontakt and k.id_podm='$_GET[dost]'";
	$sth6=Query($dbh,$Q6);
	$row6 =$sth6->fetchRow();

	$Q7="select id_podm, email from maile where id_podm='$_GET[dost]'";
	$sth7=Query($dbh,$Q7);
	$row7 =$sth7->fetchRow();

	$Q8="select m.id_podm, m.email from maile m, kontakty k where m.id_podm=k.id_kontakt and k.id_podm='$_GET[dost]'";
	$sth8=Query($dbh,$Q8);
	$row8 =$sth8->fetchRow();

	$Q9="select nr_kb, bank from konta_bankowe where id_wlasc='$_GET[dost]'";
	$sth9=Query($dbh,$Q9);
	$row9 =$sth9->fetchRow();


$_SESSION['teld']=$teld=array
('id_podm'		=>$row3[0], 'telefon'		=>$row3[1], 	'tel_kom'		=>$row3[2]);

$_SESSION['maild']=$maild=array
('id_podm' =>$row7[0], 'email'=>$row7[1]);

$_SESSION['kontod']=$kontod=array
('id_wlasc' =>$_GET[dost], 'nr_kb'=>$row9[0], 'bank'=>$row9[1]);

$_SESSION['kontakty']=$kontakty=array
('id_kontakt'	=>$row2[0], 	'nazwa'	=>$row2[1], 	'kod'			=>$row2[2], 	'miasto'		=>$row2[3], 	'ulica'=>$row2[4], 
 'nr_bud'	=>$row2[5], 	'nr_mieszk'=>$row2[6]);

$_SESSION['telk']=$telk=array
('id_kontakt' =>$row6[0],'telefon'	=>$row6[1], 	'tel_kom'		=>$row6[2]);

$_SESSION['mailk']=$mailk=array
('id_podm' =>$row8[0], 'email'=>$row8[1]);

?>

<form method="POST" action="index.php?menu=updatedostwyslij&dost=<?php echo $_GET[dost] ?>">
<table style="width:550px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane dostawcy
		</td>
	</tr>
	<tr>
			<td class="klasa2"> 
					Nazwa przedsiębiorstwa
			</td> 
			<td class="klasa4">
				<input size="50" name="d_nazwa" value="<?php echo $dost[nazwa]?>">
			</td>
		</tr> 
		<tr>
		<td class="klasa2"> 
				Nazwa skrócona (symbol)
		</td> 
		<td class="klasa4">
				<input size="20" name="d_symbol" value="<?php echo $dost[symbol]?>">
		</td>
	</tr> 
	<tr>
		<td class="klasa2">
				Aktywny
		</td>
		<td class="klasa4">
			<?php 
			 echo	TableToCheckbox($dost[aktywny], "d_aktywny");
			?> 
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Płatnik VAT
		</td>
		<td class="klasa4">
			<?php 
				echo TableToCheckbox($dost[pl_vat], "d_pl_vat");
			?> 

		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				NIP
		</td>
		<td class="klasa4">
				<input size="20" name="d_nip" value="<?php echo $dost[nip]?>" >
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
				REGON
		</td>
		<td class="klasa4">
				<input size="20" name="d_regon"  value="<?php echo $dost[regon]?>">
		</td>	
	</tr>

	<tr>
		<td class="klasa2">
				Ulica
		</td>
		<td class="klasa4">
				<input size="20" name="d_ulica" value="<?php echo $dost[ulica]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Numer budynku
		</td>
		<td class="klasa4">
				<input size="6" name="d_nrbud" value="<?php echo $dost[nr_bud]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Nr mieszkania
		</td>
		<td class="klasa4">
				<input size="4" name="d_nrmieszk" value="<?php echo $dost[nr_lokalu]?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kod pocztowy
		</td>
		<td class="klasa4">
				<input size="6" name="d_kod" value="<?php echo $dost[kod]?>">
		</td>	
	</tr>
	<tr>
				<td class="klasa2">
					Miasto
				</td>
				<td class="klasa4">
					<input size="20" name="d_miasto" value="<?php echo $dost[miasto]?>">
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Telefon stacjonarny
				</td>
				<td class="klasa4">
					<input size="15" name="d_telefon" value="<?php echo $teld[telefon]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="15" name="d_telkom"  value="<?php echo $teld[tel_kom]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="20" name="d_email" value="<?php echo $maild[email]?>" >
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
					<input size="30" name="d_bank"  value="<?php echo $kontod[bank]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Nr konta 
				</td>
				<td class="klasa4">
					<input size="35" name="d_konto"  value="<?php echo $kontod[nr_kb]?>" >
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2" >
					Dane kontaktowe</font></b></td>
			</tr>
			<tr>
				<td class="klasa2">
					Imię i nazwisko osoby kontaktowej
				</td>
				<td class="klasa4">
					<input size="20" name="k_nazwa" value="<?php echo $kontakty[nazwa]?>">
				</td>
			</tr>
	<tr>
		<td class="klasa2">
				Ulica
		</td>
		<td class="klasa4">
				<input size="20" name="k_ulica" value="<?php echo $kontakty[ulica]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Numer budynku
		</td>
		<td class="klasa4">
				<input size="4" name="k_nrbud" value="<?php echo $kontakty[nr_bud]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Nr mieszkania
		</td>
		<td class="klasa4">
				<input size="4" name="k_nrlokalu" value="<?php echo $kontakty[nr_mieszk]?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kod pocztowy
		</td>
		<td class="klasa4">
				<input size="6" name="k_kod" value="<?php echo $kontakty[kod]?>">
		</td>	
	</tr>
	<tr>
				<td class="klasa2">
					Miasto
				</td>
				<td class="klasa4">
					<input size="20" name="k_miasto" value="<?php echo $kontakty[miasto]?>">
				</td>	
			</tr>

			<tr>
				<td class="klasa2">
					Telefon stacjonarny
				</td>
				<td class="klasa4">
					<input size="20" name="k_telefon" value="<?php echo $telk[telefon]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="18" name="k_telkom" value="<?php echo $telk[tel_kom]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="30" name="k_email" value="<?php echo $mailk[email]?>">
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
		
