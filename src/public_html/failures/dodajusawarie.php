<?php
	$Q4="select id_prac from pracownicy where nazwa='$_SESSION[nazwa]' limit 1";
	$prc=Query2($Q4, $dbh);
?>

<form method="POST" action="index.php?panel=inst&menu=dodajusawrwyslij&awr=<?php echo $_GET[awr] ?>">
<table style="width:500px" class="tbk3">
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane awarii
		</td>
	</tr>
	<tr>
		<td class="klasa2"> 
				Usuwający
		</td> 
		<td class="klasa4">
			<?php
				Select($QUERY12, "usuwajacy", $prc[0]);
			?>
		</td>
	</tr> 	<tr>
		<td class="klasa2">
			Opis usunięcia
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
