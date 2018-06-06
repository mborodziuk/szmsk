<?php
   $Q="	select w.id_wpl, w.data_ksiegowania, w.forma, w.kwota, w.opis
			from wplaty w where w.id_wpl='$_GET[wpl]'";

	$Q2="	select a.id_abon from abonenci a where a.id_abon in (select id_kontrah from wplaty where id_wpl='$_GET[wpl]')";


	
	$row=Query2($Q);
	$row2=Query2($Q2);

	$_SESSION[wpl]=$wpl=array
	('id_wpl' 	=> $_GET[wpl], 	'data'		=>$row[1], 	'forma'	=>$row[2], 	'kwota'		=>$row[3],
	'id_kontrah'		=>	$row2[0],	'opis'		=>$row[4] );
?>

<form method="POST" action="index.php?panel=fin&menu=updatewplwyslij&wpl=<?php echo $_GET[wpl] ?>">
<table style="width:400px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Nowa wpłata
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Wpłacający
		</td>
		<td class="klasa4">
			<?php
				SelectWlasc('abon', $wpl[id_kontrah]);
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kwota
		</td>
		<td class="klasa4">
				<input size="10" name="kwota" value="<?php echo $wpl[kwota] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Forma
		</td>
		<td class="klasa4">
	<?php
		$forma=array(przelew,  gotówka);
		$www->SelectFromArray($forma, "forma", $wpl[forma]);
	?>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Data wpłaty
		</td>
		<td class="klasa4">
				<input size="10" name="data" value="<?php echo $wpl[data] ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			Opis
		</td>
		<td class="klasa4">
			<textarea name="opis" cols="40" row="10"><?php echo $wpl[opis] ?></textarea>
		</td>	
	</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="button1" value="Wyślij" name="przycisk1">
					<input type="reset" value="Anuluj" name="przycisk2">
				</td>
			</tr>
<tbody>
</table>
</form>