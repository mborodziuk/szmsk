<?php

	
	$Q="select p.id_psp, p.data_wpl, p.data, p.uwagi, p.obraz, n.id_abon, i.id_inst
								from 	( pisma_przychodzace p left join nazwy n on p.id_nad=n.id_abon) join
								( pisma_przychodzace p2 left join instytucje i on p2.id_nad=i.id_inst) on p.id_psp=p2.id_psp 	and p.id_psp='$_GET[inltr]'	";			 
						 
						 
	
	$row=Query2($Q, $dbh);
	
	$nr_um=explode("/", $row[1]);
	$data_zaw=explode("-", $row[2]);

	$_SESSION['psp']=$psp=array(	
	'id_psp'	  => $row[0],	'data_wpl'	=> $row[1],    'data'	=> $row[2],
	'uwagi'   => $row[3],  'obraz'	    => $row[4], 'id_abon' => $row[5], 'id_inst' => $row[6]	
	);

?>


<form enctype="multipart/form-data"  method="POST" action="index.php?panel=fin&menu=inltrupdsnd&inltr=<?php echo $_GET[inltr];?>">
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
			$www->SelectWlasc($dbh, "abonent", $psp[id_abon]);
		?>
		</td>
    </tr>
    <tr>
      <td> Instytucja</td>
      <td>
		<?php
			$www->Select2($dbh, $QUERY8, "instytucja", $psp[id_inst]);
		?>
		</td>
    </tr>		
	<tr>
		<td class="klasa2">
				Data wpływu
		</td>
		<td class="klasa4">
				<input size="10" name="data_wpl" value =<?php echo $psp[data_wpl] ?> />
		</td>	
	</tr>		<tr>
		<td class="klasa2">
				Data na piśmie
		</td>
		<td class="klasa4">
				<input size="10" name="data_pis" value =<?php echo $psp[data_wpl] ?> />
		</td>	
	</tr>	
	<tr>
	<td>
	Skan </td>
<td>
      <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
			<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
			<input name="userfile" type="file" size="25" value =<?php echo $psp[obraz] ?> />

</td>
</tr>
	<tr>
		<td class="klasa2">
			Uwagi
		</td>
		<td class="klasa2">
			<textarea name="tresc" cols="50" rows="10"><?php echo $psp[uwagi] ?></textarea>
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