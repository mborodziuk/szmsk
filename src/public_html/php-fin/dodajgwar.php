<form method="POST" action="index.php?panel=fin&menu=dodajgwar1&typ=<?php echo $_GET[typ]?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane gwarancji
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Numer
		</td>
		<td class="klasa4">
				<input size="20" name="nr_gwar" >
		</td>
	</tr>
	<tr>
		<td class="klasa2">
		<?php
			if($_GET[typ]=="sprzedaz")
				echo "Odbiorca";
			else
				echo "Dostawca";
		?>
		</td>
		<td class="klasa4">
			<?php
				if($_GET[typ]=="sprzedaz")
					SelectWlasc("odbiorca");
				else
					Select($QUERY10, "dostawca");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data wystawienia
		</td>
		<td class="klasa4">
				<input size="15" name="data_wyst" value="<?php echo date("Y-m-d") ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
		</td>
		<td colspan="2">
				<input type="submit" value="Dalej >>>" name="przycisk1">
		</td>
	</tr>

<tbody>
</table>
		
</form>
		
