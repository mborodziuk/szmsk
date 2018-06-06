<?php
	$dbh=DBConnect($DBNAME1);

	if ( $_GET[typ] == "przych")
   	$Q1="select pp.id_pp, pp.data, pp.data_przyj, pp.dotyczy, pp.lok_fiz, pp.lok_kopii, pp.id_nad, pp.numer
						from pisma_przych pp where pp.id_pp='$_GET[pismo]'";
	else
   	$Q1="sselect pw.id_pw, pw.data, pw.data_wyj, pw.dotyczy, pw.lok_fiz, pw.lok_kopii, pw.id_odb
						from pisma_wych pw where pw.id_pw='$_GET[pismo]'";

	$sth1=Query($dbh,$Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['pismo']=$pismo=array
	(
		'id_pisma' 	=> $_GET[pismo], 	'data'	=>$row1[1], 	'data_poczta'	=>$row1[2],			'dotyczy'		=>	$row1[3],
		'lok_fiz'	=>$row1[4],			'lok_kopii'	=>$row1[5],		'id_podm'	=>$row1[6],			'numer'			=>$row1[7],
	);

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

<form method="POST" action="index.php?menu=updatepismowyslij&typ=<?php echo $_GET[typ] ?>&pismo=<?php echo $_GET[pismo] ?> ">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<?php
				if ( $_GET[typ]=="przych" )
					echo "Nadawca";
				else 
					echo "Odbiorca";
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Instytucja
		</td>
		<td class="klasa4">
			<?php
				Select($QUERY11,"instytucja", $pismo[id_podm]);
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Abonent
		</td>
		<td class="klasa4">
			<?php
				SelectWlasc("abonent",$pismo[id_podm] );
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Dostawca
		</td>
		<td class="klasa4">
				<?php
					Select($QUERY10, "dostawca", $pismo[id_podm]);
				?>
		</td>
	</tr>
	<tr>
		<td class="klasa1" colspan="2">
				Dane pisma
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Numer 
		</td>
		<td class="klasa4">
				<input size="15" name="numer"   value="<?php echo $pismo[numer] ?>">
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
				Pismo z dnia
		</td>
		<td class="klasa4">
				<input size="15" name="data"   value="<?php echo $pismo[data] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			<?php
				if ( $_GET[typ]=="przych" )
					echo "Data otrzymania";
				else 
					echo "Data wysłania";
			?>
		</td>
		<td class="klasa4">
				<input size="15" name="data_poczta"  value="<?php echo $pismo[data_poczta] ?>">
		</td>	
	</tr>

	<tr>
		<td class="klasa2">
				Dotyczy
		</td>
		<td class="klasa4">
				<input size="50" name="dotyczy"  value="<?php echo $pismo[dotyczy] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Lokalizacja fizyczna
		</td>
		<td class="klasa4">
				<input size="30" name="lok_fiz"  value="<?php echo $pismo[lok_fiz] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Lokalizacja kopi elektronicznej
		</td>
		<td class="klasa4">
				<input size="30" name="lok_kopii" value="<?php echo $pismo[lok_kopii] ?>">
		</td>	
	</tr>

	<tr>
		<td colspan="2">
			<input type="submit" value="Wyślij" name="przycisk1">
			<input type="reset" value="Anuluj" name="przycisk2">
		</td>
	</tr>
<tbody>
</table>
		
</form>
		
