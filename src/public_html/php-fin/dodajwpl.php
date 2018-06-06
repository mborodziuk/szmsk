<form method="POST" action="index.php?panel=fin&menu=newwplwyslij">
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
				SelectWlasc('abon');
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kwota
		</td>
		<td class="klasa4">
	<?php
		$forma=array(50, 60, 45, 1.22);
		$www->SelectFromArray($forma, "kwota1");
	?>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Inna kwota
		</td>
		<td class="klasa4">
				<input size="10" name="kwota2">
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
				Data wpłaty
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
			<textarea name="opis" cols="40" row="4">
			</textarea>
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
		
