<form method="POST" action="index.php?panel=fin&menu=newtspwyslij">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane towaru/usługi
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Towar
		</td>
		<td class="klasa4">
				<input type="radio" name="typ" value="towar"/>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Usługa
		</td>
		<td class="klasa4">
				<input type="radio" name="typ" value="usluga" checked="true" />
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Nazwa
		</td>
		<td class="klasa4">
				<input size="50" name="nazwa" >
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Symbol
		</td>
		<td class="klasa4">
				<input size="30" name="symbol" >
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Cenna bruto
		</td>
		<td class="klasa4">
				<input size="10" name="cena" > zł
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Podatek VAT
		</td>
		<td class="klasa4">
				<select name="vat">
					<option> zw </option>
					<option> 0  </option>
					<option> 8 </option>
					<option> 22 </option>
					<option selected > 23  </option>
				</select> 
			%
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				PKWiU
		</td>
		<td class="klasa4">
				<input size="30" name="pkwiu" >
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Opis
		</td>
		<td class="klasa4">
			<textarea name="opis" cols="40" row="5">
			</textarea>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
		</td>
		<td colspan="2">
				<input type="submit" value="Wyślij" name="przycisk1">
		</td>
	</tr>

<tbody>
</table>
		
</form>
		
