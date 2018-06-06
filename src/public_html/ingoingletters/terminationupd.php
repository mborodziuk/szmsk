<?php

	$Q="select w.id_wyp, w.nr_um, w.data_wpl, w.data, w.data_wej, w.uwagi, w.dokonane, w.obraz, a.id_abon
								from wypowiedzenia_umow_abonenckich w, abonenci a, umowy_abonenckie u
						 where a.id_abon=u.id_abon and u.nr_um=w.nr_um  and w.id_wyp='$_GET[trm]'";
	
	$row=Query2($Q, $dbh);
	
	$nr_um=explode("/", $row[1]);
	$data_zaw=explode("-", $row[2]);

	$_SESSION['wyp']=$wyp=array(	
	'id_wyp'	  => $row[0],	'nr_um'    => $row[1],  'data_wpl'	=> $row[2],    'data'	=> $row[3],
	'data_wej'	=> $row[4],  'uwagi'   => $row[5],  'obraz'	    => $row[7], 'id_abon' => $row[8]	
	);

?>


<form enctype="multipart/form-data"  method="POST" action="index.php?panel=fin&menu=sendterminationupd&trm=<?php echo $_GET[trm];?>">
<table style="width:500px" >
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane wypowiedzenia
		</td>
	</tr>

    <tr>
      <td> Abonent </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "abonent", $wyp[id_abon]);
		?>
		</td>
    </tr>
	<tr>
		<td class="klasa2">
				Data wpływu
		</td>
		<td class="klasa4">
				<input size="10" name="data_wpl" value =<?php echo $wyp[data_wpl] ?> />
		</td>	
	</tr>		<tr>
		<td class="klasa2">
				Data na piśmie
		</td>
		<td class="klasa4">
				<input size="10" name="data_pis" value =<?php echo $wyp[data_wpl] ?> />
		</td>	
	</tr>	
		<tr>
		<td class="klasa2">
				Data wejścia w życie
		</td>
		<td class="klasa4">
				<input size="10" name="data_wej" value =<?php echo $wyp[data_wej] ?> />
		</td>	
	</tr>		
	<tr>
	<td>
	Skan </td>
<td>
      <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
			<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
			<input name="userfile" type="file" size="25" value =<?php echo $wyp[obraz] ?> />

</td>
</tr>
	<tr>
		<td class="klasa2">
			Uwagi
		</td>
		<td class="klasa2">
			<textarea name="tresc" cols="50" rows="10"><?php echo $wyp[uwagi] ?></textarea>
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