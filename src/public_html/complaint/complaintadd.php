<?php
	$data_wpl=date("Y-m-d");
	$data_wej=OstatniDzienMiesiaca(date("Y-m-d", time()+88*86400));
//	$data_wej=date($data_wej,);
?>
<form enctype="multipart/form-data"  method="POST" action="index.php?panel=inst&menu=cpladdsnd">
<table style="width:500px" >
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane reklamacji
		</td>
	</tr>

    <tr>
      <td> Zgłaszający </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "abonent", $_GET[abon]);
		?>
		</td>
    </tr>
		<tr>
		<td class="klasa2">
				Data wpływu
		</td>
		<td class="klasa4">
				<input size="10" name="data_wpl" value =<?php echo $data_wpl ?> />
		</td>	
	</tr>		<tr>
		<td class="klasa2">
				Data na piśmie
		</td>
		<td class="klasa4">
				<input size="10" name="data_pis" value =<?php echo $data_wpl ?> />
		</td>	
	</tr>	
	<tr>
	<td>
	Skan </td>
<td>
		<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <input name="complaint_img" type="file" size="25"/>

</td>
</tr>
	<tr>

	<tr>
		<td class="klasa2">
			Skrót reklamacji 
		</td>
		<td class="klasa2">
			<textarea name="tresc" cols="70" rows="3"></textarea>
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