<form method="POST" action="index.php?panel=inst&menu=sendgate">
<table style="align=center">
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane Bramki Voip
		</td>
    <tr>
      <td> Producent </td>
      <td>
		<input type="text" name="producent" size="30" />
		</td>
    </tr>
	 <tr>
      <td> Model </td>
      <td>
		<input type="text" name="model" size="20" />
		</td>
    </tr>
    <tr>
      <td> Numer seryjny </td>
      <td>
		<input type="text" name="nr_seryjny" size="20" />
		</td>
    </tr>
    <tr>
      <td> Adres fizyczny </td>
      <td>
		<input type="text" name="mac" size="20" />
		</td>
    </tr>
			<tr>
				<td class="klasa1" colspan="2">
					Miejsce instalacji
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres
				</td>
				<td class="klasa4">
						<option> </option>
						<?php
							$format=array(0=>'', 1=>'', 2=>'lok. ', 3=>'', 4=>'');
							$www->Select3($dbh, $QUERY14, "mi", $gate[id_msi], $format);
						?>
				</td>
			</tr>		
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Dodaj" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>