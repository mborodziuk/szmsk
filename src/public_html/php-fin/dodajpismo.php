<form method="POST" action="index.php?menu=newpismowyslij&typ=<?php echo $_GET[typ] ?> ">
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
				<select name="instytucja">
					<option> </option>
			<?php
				Select($QUERY11);
			?>
				</select>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Abonent
		</td>
		<td class="klasa4">
				<select name="abonent">
					<option> </option>
			<?php
				SelectWlasc();
			?>
				</select>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Dostawca
		</td>
		<td class="klasa4">
			<select name="dostawca">
				<option> </option>
				<?php
					Select($QUERY10);
				?>
			</select>
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
				<input size="15" name="numer" >
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
				Pismo z dnia
		</td>
		<td class="klasa4">
				<input size="15" name="data" >
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
				<input size="15" name="data_poczta" >
		</td>	
	</tr>

	<tr>
		<td class="klasa2">
				Dotyczy
		</td>
		<td class="klasa4">
				<input size="50" name="dotyczy" >
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Lokalizacja fizyczna
		</td>
		<td class="klasa4">
				<input size="30" name="lok_fiz" >
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Lokalizacja kopi elektronicznej
		</td>
		<td class="klasa4">
				<input size="30" name="lok_kopii" >
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
		
