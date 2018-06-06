<?
	$dbh=DBConnect($DBNAME1);

   $Q1="select i.id_inst, i.nazwa, i.symbol, i.ulica, i.nr_bud, i.nr_lokalu, i.miasto, i.kod
			from instytucje i where id_inst='$_GET[inst]'";
	$sth1=Query($dbh,$Q1);
	$row1 =$sth1->fetchRow();
	$_SESSION['inst']=$inst=array
	('id_inst' 	=> $_GET[inst], 	'symbol'		=>$row1[2], 	'nazwa'	=>$row1[1], 	'ulica'=>$row1[3],
	'nr_bud'		=>	$row1[4],		'nr_lokalu'	=>$row1[5],		'miasto'	=>$row1[6],		'kod'	=>$row1[7]);

	$Q2="select * from kontakty where id_podm='$_GET[inst]'";
	$sth2=Query($dbh,$Q2);
	$row2 =$sth2->fetchRow();

	$Q3="select id_podm, telefon, tel_kom from telefony where id_podm='$_GET[inst]'";
	$sth3=Query($dbh,$Q3);
	$row3 =$sth3->fetchRow();


	$Q6="select k.id_kontakt, t.telefon, t.tel_kom from telefony t, kontakty k where t.id_podm=k.id_kontakt and k.id_podm='$_GET[inst]'";
	$sth6=Query($dbh,$Q6);
	$row6 =$sth6->fetchRow();

	$Q7="select id_podm, email from maile where id_podm='$_GET[inst]'";
	$sth7=Query($dbh,$Q7);
	$row7 =$sth7->fetchRow();

	$Q8="select m.id_podm, m.email from maile m, kontakty k where m.id_podm=k.id_kontakt and k.id_podm='$_GET[inst]'";
	$sth8=Query($dbh,$Q8);
	$row8 =$sth8->fetchRow();


$_SESSION['teli']=$teli=array
('id_podm'		=>$row3[0], 'telefon'		=>$row3[1], 	'tel_kom'		=>$row3[2]);

$_SESSION['maili']=$maili=array
('id_podm' =>$row7[0], 'email'=>$row7[1]);

$_SESSION['kontakty']=$kontakty=array
('id_kontakt'	=>$row2[0], 	'nazwa'	=>$row2[1], 	'kod'			=>$row2[2], 	'miasto'		=>$row2[3], 	'ulica'=>$row2[4], 
 'nr_bud'	=>$row2[5], 	'nr_mieszk'=>$row2[6]);

$_SESSION['telk']=$telk=array
('id_kontakt' =>$row6[0],'telefon'	=>$row6[1], 	'tel_kom'		=>$row6[2]);

$_SESSION['mailk']=$mailk=array
('id_podm' =>$row8[0], 'email'=>$row8[1]);

?>

<form method="POST" action="index.php?menu=updateinstwyslij&inst=<? echo $_GET[inst] ?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane instytucji
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Rodzaj
		</td>
		<td class="klasa4">
			<select name="rodzaj">
				<?
				if ( preg_match('/adm/', $_GET[inst]) )
					{
					 	echo "<option selected> Instytucja mieszkaniowa </option>";
						echo "<option> Jednosta samorządu terytorialnego</option>";
						echo "<option> Inna </option>";
					}
				else 	if ( preg_match('/jst/', $_GET[inst]) )
					{
		 				echo "<option> Instytucja mieszkaniowa </option>";
						echo "<option selected> Jednosta samorządu terytorialnego</option>";
						echo "<option> Inna </option>";
					}
				else
					{
		 				echo "<option> Instytucja mieszkaniowa </option>";
						echo "<option> Jednosta samorządu terytorialnego</option>";
						echo "<option selected> Inna </option>";
					}
				?>
			</select>
		</td>
		</tr>
		<tr>
			<td class="klasa2"> 
					Nazwa instytucji
			</td> 
			<td class="klasa4">
				<input size="40" name="i_nazwa" value="<? echo $inst[nazwa]?>">
			</td>
		</tr> 
		<tr>
		<td class="klasa2"> 
				Nazwa skrócona (symbol)
		</td> 
		<td class="klasa4">
				<input size="20" name="i_symbol" value="<? echo $inst[symbol]?>">
		</td>
	</tr> 
	<tr>
		<td class="klasa2">
				Ulica
		</td>
		<td class="klasa4">
				<input size="20" name="i_ulica" value="<? echo $inst[ulica]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Numer budynku
		</td>
		<td class="klasa4">
				<input size="2" name="i_nrbud" value="<? echo $inst[nr_bud]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Nr mieszkania
		</td>
		<td class="klasa4">
				<input size="2" name="i_nrmieszk" value="<? echo $inst[nr_lokalu]?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kod pocztowy
		</td>
		<td class="klasa4">
				<input size="6" name="i_kod" value="<? echo $inst[kod]?>">
		</td>	
	</tr>
	<tr>
				<td class="klasa2">
					Miasto
				</td>
				<td class="klasa4">
					<input size="20" name="i_miasto" value="<? echo $inst[miasto]?>">
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Telefon stacjonarny
				</td>
				<td class="klasa4">
					<input size="15" name="i_telefon" value="<? echo $teli[telefon]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="15" name="i_telkom"  value="<? echo $teli[tel_kom]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="15" name="i_email" value="<? echo $maili[email]?>" >
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
					<input size="20" name="k_nazwa" value="<? echo $kontakty[nazwa]?>">
				</td>
			</tr>
	<tr>
		<td class="klasa2">
				Ulica
		</td>
		<td class="klasa4">
				<input size="20" name="k_ulica" value="<? echo $kontakty[ulica]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Numer budynku
		</td>
		<td class="klasa4">
				<input size="2" name="k_nrbud" value="<? echo $kontakty[nr_bud]?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Nr mieszkania
		</td>
		<td class="klasa4">
				<input size="2" name="k_nrlokalu" value="<? echo $kontakty[nr_mieszk]?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kod pocztowy
		</td>
		<td class="klasa4">
				<input size="6" name="k_kod" value="<? echo $kontakty[kod]?>">
		</td>	
	</tr>
	<tr>
				<td class="klasa2">
					Miasto
				</td>
				<td class="klasa4">
					<input size="20" name="k_miasto" value="<? echo $kontakty[miasto]?>">
				</td>	
			</tr>

			<tr>
				<td class="klasa2">
					Telefon stacjonarny
				</td>
				<td class="klasa4">
					<input size="20" name="k_telefon" value="<? echo $telk[telefon]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="18" name="k_telkom" value="<? echo $telk[tel_kom]?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="18" name="k_email" value="<? echo $mailk[email]?>">
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
		
