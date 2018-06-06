
<form method="POST" action="index.php?panel=inst&menu=dodajwkzcwyslij&zlc=<?php echo $_GET[zlc] ?>">
<table style="width:500px" class="tbk3" >
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane zlecenia
		</td>
	</tr>
		<td class="klasa2">
			Opis wykonania
		</td>
		<td class="klasa2">
			<textarea name="opis" cols="60" rows="3"></textarea>
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
