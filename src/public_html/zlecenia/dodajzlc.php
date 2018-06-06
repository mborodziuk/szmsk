<?php
	include "func/config.php";
							 

	$data_zak=date("Y-m-d",time()+7*86400);
?>

<form method="POST" action="index.php?panel=inst&menu=dodajzlcwyslij">
<table style="width:500px" class="tbk3" >
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane zlecenia
		</td>
	</tr>

    <tr>
      <td> Zlecający </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "zlecajacy");
		?>
		</td>
    </tr>
	<tr>
		<td class="klasa2"> 
				Wykonawca
		</td> 
		<td class="klasa4">
			<?php
				Select($Q15, "wykonawca");
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Wartość w zł
		</td>
		<td class="klasa4">
				<input size="10" name="wartosc" value ='0' >
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Wykonać przed
		</td>
		<td class="klasa4">
				<input size="10" name="data_zak" value =<?php echo $data_zak ?>>
		</td>	
	</tr>		
	<tr>
		<td class="klasa2">
				Rodzaj
		</td>
		<td class="klasa4">
	<?php
		$www->SelectFromArray($conf[zlecenia_rodzaje], "rodzaj", "inny");
	?>
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
			Opis zlecenia
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