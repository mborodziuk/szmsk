<form method="POST" action="index.php?panel=inst&menu=newabonwyslij">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Dane umowy abonenckiej</b>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Numer umowy
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="5" name="nr_uma1"  >
					</td>
					<td>
						/UMA/&nbsp; 
					</td>
					<td>
						<input size="5" name="nr_uma2"  >
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data zawarcia umowy (dzień/miesiąc/rok)
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="3" name="dzien" >
					</td>
					<td>
						<input size="3" name="miesiac"  >
					</td>
							<td>
								<input size="3" name="rok"  >
							</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr>
				<td class="klasa2">
					Okres obowiązywania umowy
				</td>
				<td class="klasa4">
					<select name="typ_um">
						<option selected>Niekrótszy niż 24 miesiące</option>
						<option>Czas nieokreślony</option>
					</select> 
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2">
					Dane abonenta
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Abonent instytucjonalny (firma) ?
				</td>
				<td class="klasa4">
					<input type="checkbox" name="a_inst" value="ON">
				</td>
			</tr>	
			<tr>
				<td class="klasa2">
					Status
				</td>
				<td class="klasa4">
					<select name="status">
						<option>Podłączony</option>
						<option>Oczekujący</option>
						<option>Zainteresowany</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="klasa2"> 
						Nazwisko i imię (nazwa instytucji)
				</td> 
				<td class="klasa4">
					<input size="40" name="a_nazwa" >
				</td>
			</tr> 
			<tr>
				<td class="klasa2"> 
						Nazwa skrócona (firmy i instytucje)
				</td> 
				<td class="klasa4">
					<input size="20" name="a_symbol" >
				</td>
			</tr> 
			<tr>
				<td class="klasa2">
					PESEL (NIP)
				</td>
				<td class="klasa4">
					<input size="20" name="pesel_nip"  >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Nr dowodu osobistego (REGON)
				</td>
				<td class="klasa4">
					<input size="20" name="nrdow_regon"  ></td>
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Budynek
				</td>
				<td class="klasa4">
					<select name="a_budynek">
						<?php
	  						Select($QUERY1);
						?>
					</select> 
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Nr mieszkania
				</td>
				<td class="klasa4">
					<input size="3" name="a_nrmieszk" >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon stacjonarny
				</td>
				<td class="klasa4">
					<input size="15" name="a_teldom" >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="15" name="a_telkom"  >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="15" name="a_email"  >
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2">
					Adres instalacji (jeżeli inny niż adres Abonenta)
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Budynek
				</td>
				<td class="klasa4">
					<select name="mi_budynek">
						<option> </option>
						<?php
							Select($QUERY1);
						?>
					</select> 
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Nr mieszkania	</td>
				<td class="klasa4">
					<input size="3" name="mi_nrmieszk"  >
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2" >
					Dane do korespondencji (jeżeli inna niż dane abonenta)</font></b></td>
			</tr>
			<tr>
				<td class="klasa2">
					Imię i nazwisko osoby kontaktowej
				</td>
				<td class="klasa4">
					<input size="20" name="k_nazwa" >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Ulica
				</td>
				<td class="klasa4">
					<input size="20" name="k_ulica" >
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Numer budynku
				</td>
				<td class="klasa4">
					<input size="2" name="k_nrbud" >
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Nr mieszkania
				</td>
				<td class="klasa4">
					<input size="2" name="k_nrmieszk" >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Kod pocztowy
				</td>
				<td class="klasa4">
					<input size="6" name="k_kod" >
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Miasto
				</td>
				<td class="klasa4">
					<input size="20" name="k_miasto" >
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Telefon domowy
				</td>
				<td class="klasa4">
					<input size="20" name="k_teldom">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="18" name="k_telkom" >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="18" name="k_email">
				</td>
			</tr>

			<tr>
				<td class="klasa1" colspan="2">
					Właściciel lokalu // Główny lokator (jeżeli inny niż Abonent)
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Imię i nazwisko (nazwa)
				</td>
				<td class="klasa4">
					<input size="18" name="w_nazwa">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Zgoda na montaż instalacji dostępu do Internetu ?
				</td>
				<td class="klasa4">
					<input type="checkbox" name="w_zgoda" value="ON" CHECKED>
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
		
