<?php
	$dbh=DBConnect($DBNAME1);
   $Q1="select  id_tows, symbol, nazwa, pkwiu, vat, cena,  opis, aktywny
				from towary_sprzedaz where id_tows='$_GET[tsp]'";
	$sth1=Query($dbh,$Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['tow']=$tow=array
	('id_tows' 	=> $_GET[tsp], 	'symbol'		=>$row1[1], 	'nazwa'	=>$row1[2], 	'pkwiu'	=>$row1[3],
		'vat'		=>	$row1[4],		'cena'		=>$row1[5],		'opis'	=>$row1[6], 'aktywny' => $row1[7]);

?>

<form method="POST" action="index.php?panel=fin&menu=updatetspwyslij&tsp=<?php echo $_GET[tsp]; ?>">
<table style="width:500px" >
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
				$vat=array("zw", "0", "8", "14", "22", "23"); 
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
		
