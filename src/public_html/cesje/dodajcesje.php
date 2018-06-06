<form method="POST" action="index.php?panel=fin&menu=dodajcesjewyslij">
<table style="width:500px" >
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane cesji
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Numer cesji
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="3" name="nr_csj1"  >
					</td>
					<td>
						/CSJ/&nbsp; 
					</td>
					<td>
						<input size="4" name="nr_csj2">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data sporządzenia cesji (dzień/miesiąc/rok)
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
								<input size="4" name="rok">
							</td>
				</tr>
			</table>
			</td>
			</tr>
    <tr>
      <td> Stary abonent </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "stary_abon");
		?>
		</td>
    </tr>
    <tr>
      <td> Nowy abonent </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "nowy_abon");
		?>
		</td>
    </tr>

	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Wprowadź" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>