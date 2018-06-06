<?php

   $Q="	select w.id_wyp, w.data_ksiegowania, w.forma, w.kwota, w.opis, w.id_kontrah
			from wyplaty w where w.id_wyp='$_GET[wyp]'";
	
	$row=Query2($Q);

	$_SESSION[wpl]=$wpl=array
	('id_wpl' 	=> $_GET[wpl], 	'data'		=>$row[1], 	'forma'	=>$row[2], 	'kwota'		=>$row[3],
	'id_kontrah'		=>	$row[5],	'opis'		=>$row[4] );
?>

<form method="POST" action="index.php?panel=fin&menu=payoutupdsnd&wyp=<?php echo $_GET[wyp] ?>">
<table style="width:400px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Wypłata
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Wypłacający
		</td>
		<td class="klasa4">
			<?php
							Select($QUERY12, "id_prac", $wpl[id_kontrah]);
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
					<input type="reset" class="button1" value="Anuluj" name="przycisk2">
				</td>
			</tr>
<tbody>
</table>
</form>