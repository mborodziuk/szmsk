<?php
	if ($_GET[typ] =="sprzedaz")
		{
			$TABLE="towary_sprzedaz";
			$ID="id_tows";
		}
	else
		{
			$TABLE="towary_zakup";
			$ID="id_towz";
		}

	$dbh=DBConnect($DBNAME1);
   $Q1="select  $ID, symbol, nazwa, pkwiu, vat, cena,  opis, okres_gwar, aktywny, utelekom
				from $TABLE where $ID='$_GET[id]'";

	$sth1=Query($dbh,$Q1);
	$row1 =$sth1->fetchRow();

		$_SESSION[$_GET[id].$_SESSION[login]]=$tow=array
	(	$ID 	=> $_GET[id], 	'symbol'		=>$row1[1], 	'nazwa'	=>$row1[2], 	'pkwiu'	=>$row1[3],
		'vat'		=>	$row1[4],		'cena'		=>$row1[5],		'opis'	=>$row1[6],		'okres_gwar'	=>$row1[7],
		'aktywny' => $row1[8], 'utelekom' => $row1[9]);

		
?>

<form method="POST" action="index.php?panel=fin&menu=updatetowwyslij&id=<?php echo $_GET[id]; ?>&typ=<?php echo $_GET[typ]?>">
<table style="width:500px" class="tbk3">
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane towaru/usługi
		</td>
	</tr>
		 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($tow[aktywny], "aktywny");
			?>
		 </td>
	 </tr>	
		 <tr>
		 <td> Usługa telekomunikacyjna </td>
		 <td>
			<?php
				echo TableToCheckbox($tow[utelekom], "utelekom");
			?>
		 </td>
	 </tr>	
	<tr>
	<tr>
		<td class="klasa2">
				Nazwa
		</td>
		<td class="klasa4">
				<input size="40" name="nazwa" value="<?php echo htmlspecialchars($tow["nazwa"]); ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Symbol
		</td>
		<td class="klasa4">
				<input size="30" name="symbol" value="<?php echo $tow[symbol] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Cenna netto
		</td>
		<td class="klasa4">
				<input size="10" name="cena" value="<?php echo $tow[cena] ?>"> zł
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Podatek VAT
		</td>
		<td class="klasa4">
			<?php
				$vat=array("zw", "-", "0", "8", "23"); 
				$www->SelectFromArray($vat, "vat", $tow[vat]);
			?>
			%
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				PKWiU
		</td>
		<td class="klasa4">
				<input size="30" name="pkwiu" value="<?php echo $tow[pkwiu] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Okres gwarancji
		</td>
		<td class="klasa4">
			<?php
				$gwar=array("12", "24", "36"); 
				$www->SelectFromArray($gwar, "okres_gwar", $tow[okres_gwar]);
			?>
			miesięcy
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Opis
		</td>
		<td class="klasa4">
			<textarea name="opis" cols="50" row="5">
				<?php 
					echo $tow[opis] 
				?>
			</textarea>
		</td>	
	</tr>
	<tr>
		<td>
		</td>
		<td colspan="2">
				<input type="submit" value="Wyślij" name="przycisk1">
		</td>
	</tr>

<tbody>
</table>
		
</form>
		
