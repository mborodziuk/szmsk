<form method="POST" action="index.php?panel=fin&menu=dodajfv1&typ=<? echo $_GET[typ]?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane Faktury
		</td>
	</tr>
	<tr>
		<td class="klasa2">
		<?
			if($_GET[typ]=="sprzedaz")
				echo "Odbiorca";
			else
				echo "Dostawca";
		?>
		</td>
		<td class="klasa4">
			<?
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
				<input size="15" name="data_wyst" value="<?php echo PierwszyRoboczy(date("Y-m")); ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data sprzedaży
		</td>
		<td class="klasa4">
				<input size="15" name="data_sprzed" value="<?php echo PierwszyRoboczy(date("Y-m")); ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Termin platności
		</td>
		<td class="klasa4">
			<select name="term_plat">
				<option> 0 </option>
        <option selected> 7 </option>
				<option> 14 </option>
				<option> 21 </option>
				<option> 28 </option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Forma platności
		</td>
		<td class="klasa4">
			<select name="forma_plat">
				<option> przelew </option>
				<option> gotówka </option>
			</select>
		</td>
	</tr>	
	<tr>
		<td class="klasa2">
				Stan
		</td>
		<td class="klasa4">
			<select name="stan">
				<option> nieuregulowana </option>
				<option> uregulowana </option>
			</select>
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
		
