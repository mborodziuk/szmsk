<form method="POST" action="index.php?panel=fin&menu=dodajfabon1">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane faktur abonamentowych
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data wystawienia
		</td>
		<td class="klasa4">
				<input size="15" name="data_wyst" value="<?php echo date("Y-m-01") ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data sprzedaży
		</td>
		<td class="klasa4">
				<input size="15" name="data_sprzed" value="<?php echo date("Y-m-01") ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Miejsce wystawienia
		</td>
		<td class="klasa4">
			<select name="miejsce_wyst">
				<option> Mysłowice </option>
				<option> Katowice </option>
				<option> Gliwice </option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Wystawił
		</td>
		<td class="klasa4">
		   <?php
			 $wystawil=explode(";", $firma[wystawil]);
			$www->SelectFromArray($wystawil, 'wystawil', $wystawil[0]);
				?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
		</td>
		<td colspan="2">
				<input type="submit" class="button1" value="Dalej >>>" name="przycisk1">
		</td>
	</tr>

<tbody>
</table>
		
</form>
		
