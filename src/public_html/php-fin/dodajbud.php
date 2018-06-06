<form method="POST" action="index.php?panel=fin&menu=newbudwyslij">
<table style="width:400px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane budynku
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Administracja / spółdzielnia
		</td>
		<td class="klasa4">
			<?php
				Select($QUERY8, "administracja");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Ulica
		</td>
		<td class="klasa4">
			<select name="ulica">
				<?php
					Select($QUERY9);
				?>
					<option selected>
						Inna
					</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Inna ulica
		</td>
		<td class="klasa4">
				<input size="30" name="inna_ul" >
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Inne miasto
		</td>
		<td class="klasa4">
				<input size="30" name="miasto" >
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Inny kod
		</td>
		<td class="klasa4">
				<input size="10" name="kod" >
		</td>	
	</tr>	
	<tr>
	<tr>
		<td class="klasa2">
				Numer budynku
		</td>
		<td class="klasa4">
				<input size="4" name="nr_bud" >
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Ilość mieszkańców
		</td>
		<td class="klasa4">
				<input size="2" name="il_mieszk" value="15">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Przyłącze
		</td>
		<td class="klasa4">
				<select name="przylacze">
					<option> 1 Mbit/s </option>
					<option> 2 Mbit/s </option>
					<option> 10 Mbit/s </option>
					<option selected > 100 Mbit/s  </option>
					<option> 1 Gbit/s </option>
				</select>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			Adresacja IP
		</td>
		<td class="klasa4">
				<input size="15" name="adres_ip" value="10.">
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
		
