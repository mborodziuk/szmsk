<form method="POST" action="index.php?panel=fin&menu=buildaddsnd&order=id_bud">
<table style="width:400px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane budynku
		</td>
	</tr>
	    <tr>
      <td> Data podłączenia </td>
      <td>
		<input type="text" name="data_podl" size="7" value="<?php echo $conf[pierwszy]; ?>"/>
		</td>
    </tr> 
	<tr>
		<td class="klasa2">
				Administracja / spółdzielnia
		</td>
		<td class="klasa4">
			<?php
				Select($QUERY8, "administracja", 'INS0013');
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
	<tr>
		<td class="klasa2">
				Cecha
		</td>
		<td class="klasa4">
				<select name="cecha">
					<option selected> ul. 	</option>
					<option> 					pl.  	</option>
					<option> 					rynek </option>
					<option> 					rondo	</option>
				</select>
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
				<input size="2" name="il_mieszk" value="1">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Przepustowość przyłącza w Mbit/s
		</td>
		<td class="klasa4">
				<select name="przylacze">
					<option selected> 1000 	</option>
					<option> 					100  	</option>
					<option> 					50 		</option>
					<option> 					25 		</option>
				</select>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			Instancja Vlanu 1
		</td>
		<td class="klasa4">
			<?php
					Select($QA19, "ivn1", "$bud[id_ivn1]");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Instancja Vlanu 2
		</td>
		<td class="klasa4">
			<?php
					Select($QA19, "ivn2", "$bud[id_ivn2]");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Instancja Vlanu 3
		</td>
		<td class="klasa4">
			<?php
					Select($QA19, "ivn3", "$bud[id_ivn3]");
			?>
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
		
