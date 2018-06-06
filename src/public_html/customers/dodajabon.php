<?php
$R=date("Y");
$r=substr($R,2,2);
?>
<form method="POST" action="index.php?panel=inst&menu=newabonwyslij">
<table style="width:650px" class="tbk3">
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
						<input size="2" name="nr_uma1">
					</td>
					<td>
					<select name="rodzaj">
						<option selected>UMA</option>
						<option>UMR</option>
						<option>UMS</option>
						
					</td>
					<td>
						<input size="2" name="nr_uma2" value ="<?php echo $r; ?>" >
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
						<input size="2" name="dzien">
					</td>
					<td>
						<input size="2" name="miesiac">
					</td>
							<td>
								<input size="4" name="rok" value="<?php echo "$R"?>">
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
						<option>Niekrótszy niż 30 m-cy</option>					
						<option selected>Niekrótszy niż 24 m-ce</option>
						<option>Niekrótszy niż 12 m-cy</option>
						<option>Czas nieokreślony</option>
					</select> 
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Status umowy
				</td>
				<td class="klasa4">
					<select name="status_uma">
						<option selected>Obowiązująca</option>
						<option>Rozwiązana</option>
						<option>Zawieszona</option>
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
					Aktywny ?
				</td>
				<td class="klasa4">
					<input type="checkbox" checked="true" name="aktywny" value="ON">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Książeczka abonamentowa ?
				</td>
				<td class="klasa4">
					<input type="checkbox" name="ksiazeczka" value="ON">
				</td>
			</tr>

      <tr>
				<td class="klasa2">
				Co miesięczna wysyłka FV ?
                            </td>
        <td class="klasa4">
        <input type="checkbox" name="fv_comiesiac" value="ON">
        </td>
			</tr>   
      <tr>
				<td class="klasa2">
				Wysyłka FV e-mailem ?
                            </td>
        <td class="klasa4">
        <input type="checkbox" name="fv_email" value="ON">
        </td>
			</tr>   

			<tr>
				<td class="klasa2">
					Płatność do dnia miesiąca
				</td>
				<td class="klasa4">
					<?php
						$dni=range(1,31);
						$www->SelectFromArray($dni, "platnosc", 7)
					?>					
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Status
				</td>
				<td class="klasa4">
					<select name="status_abonenta">
						<option selected>Podłączony</option>
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
					<input size="60" name="a_nazwa" >
				</td>
			</tr> 
			<tr>
				<td class="klasa2">
						Nazwa skrócona (firmy i instytucje)
				</td> 
				<td class="klasa4">
					<input size="30" name="a_symbol" >
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
				<td class="klasa1" colspan="2">
					Adres siedziby
				</td>
			</tr>	
			<tr>
			    <td class="klasa2">
					Budynek
				</td>
				<td class="klasa4">
						<?php
	  						Select($QUERY1,"a_budynek");
						?>
					
				</td>
			</tr>
    <tr>
          <td class="klasa2">
             Ulica <i>(jeśli nie ma odpowiedniego bud. powyżej)<i/>
           </td>
           <td class="klasa4">
          <?php
						Select($QUERY9, "a_ulica");
				    ?>
	                        </td>
		        </tr>
			<tr>
				<td class="klasa2">
					Nr budynku <i>(jeśli nie ma odpowiedniego bud. powyżej)<i/>
				</td>
				<td class="klasa4">
					<input size="2" name="a_nrbud" >
				</td>
			</tr>
                        <tr>
                                <td class="klasa2">
                                        Nr mieszkania
	                                </td>
	                                <td class="klasa4">
                                    <input size="2" name="a_nrmieszk" >
                                </td>
	                        </tr>	
			<tr>
				<td class="klasa1" colspan="2">
					Dane kontaktowe
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
					Tel. stacj. lub druga komórka
				</td>
				<td class="klasa4">
					<input size="15" name="a_teldom" >
				</td>
			</tr>

			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="18" name="a_email"  >
				</td>
			</tr>

			<tr>
				<td class="klasa1" colspan="2" >
					Dane do korespondencji (jeżeli inne niż dane abonenta)</font></b></td>
			</tr>
			<tr>
				<td class="klasa2">
					Nazwa kontaktu
				</td>
				<td class="klasa4">
					<input size="70" name="k_nazwa" >
				</td>
			</tr>
			<tr>

        <td class="klasa2">
              <?php
               $cecha=array($conf[select],"ul.", "al.", "pl.");
                $www->SelectFromArray($cecha,"kcecha", "ul.");
            ?>
         </td>	
				<td class="klasa4">
					<input size="30" name="k_ulica" >
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
					Uwagi dodawane na fakturze
				</td>
			</tr>

	<tr>
		<td class="klasa1" colspan="2">
			<textarea name="uwagi" cols="70" rows="5"></textarea>
		</td>	
	</tr> 
			
			
			<tr>
				<td class="klasa1" colspan="2">
					Opis abonenta
				</td>
			</tr>

	<tr>
		<td class="klasa1" colspan="2">
			<textarea name="opis" cols="70" rows="10"></textarea>
		</td>	
	</tr>  	  
	<td>

					<input type="submit" value="Wyślij" name="przycisk1">
					<input type="reset" value="Anuluj" name="przycisk2">
	 </td>
	 </tr>
  </tbody>
</table>

</form>


