<?php
	
	$Q4="select id_prac from pracownicy where nazwa='$_SESSION[nazwa]' limit 1";
	$prc=Query2($Q4, $dbh);

?>

<form method="POST" action="index.php?panel=fin&menu=payoutaddsnd">
<table style="width:400px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Nowa wypłata
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Wypłacający
		</td>
		<td class="klasa4">
			<?php
				Select($QUERY12, "id_prac", $prc[0]);
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kwota
		</td>
		<td class="klasa4">
				<input size="10" name="kwota">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Forma
		</td>
		<td class="klasa4">
	<?php
		$forma=array(gotówka, przelew);
		$www->SelectFromArray($forma, "forma");
	?>
		</td>	
	</tr>

	<tr>
		<td class="klasa2">
				Data wypłaty
		</td>
		<td class="klasa4">
				<input size="10" name="data" value="<?php echo date("Y-m-d") ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			Opis
		</td>
		<td class="klasa4">
			<textarea name="opis" cols="40" row="4"></textarea>
		</td>	
	</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="button1" value="Wyślij" name="przycisk1">
					<input type="reset" class="button1"  value="Anuluj" name="przycisk2">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
