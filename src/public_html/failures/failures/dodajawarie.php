<form method="POST" action="index.php?panel=inst&menu=dodajawariewyslij">
<table style="width:500px" >
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane awarii
		</td>
	</tr>

    <tr>
      <td> Zgłaszający </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "zglaszajacy", $_GET[abon]);
		?>
		</td>
    </tr>
	<tr>
		<td class="klasa2">
			Opis awarii
		</td>
		<td class="klasa2">
			<textarea name="opis" cols="70" rows="3"></textarea>
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