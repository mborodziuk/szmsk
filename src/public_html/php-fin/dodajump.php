
<form method="POST" action="index.php?menu=newumpwyslij">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane umowy
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Numer
		</td>
		<td class="klasa4">
			<input size="15" name="nr_ump" >
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data zawarcia
		</td>
		<td class="klasa4">
			<input size="15" name="data_zawarcia" value="<?php echo date('Y-m-d'); ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2"> 
				Pracownik
		</td> 
		<td class="klasa4">
			<?php
				Select($QUERY12, "pracownik");
			?>
		</td>
	</tr> 
	<tr>
		<td class="klasa2"> 
				Typ umowy
		</td> 
		<td class="klasa4">
			<select name ="typ">
				<option> dzieło </option>
				<option> zlecenie </option>
				<option> prace </option>
			</select>
		</td>
	</tr> 
	<tr>
		<td class="klasa2"> 
				Praca
		</td> 
		<td class="klasa4">
			<?php
				Select($QUERY13, "praca");
			?>
		</td>
	</tr> 
			<tr>
				<td colspan="2">
					<input type="submit" value="Wyślij" name="przycisk1">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
