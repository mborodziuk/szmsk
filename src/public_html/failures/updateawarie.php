<?php

	$q1=
		"select id_awr, czas_zgl, id_zgl, opis, usunieta, komentarz
		from awarie
		where id_awr='$_GET[awr]'";

	$row1=Query2($q1, $dbh);

	$_SESSION['awaria']=$awaria=array
	(
		'id_awr'		=>$row1[0],						'czas_zgl'		=>$row1[1],		'id_zgl'	=>$row1[2], 	
		'opis'		=>$row1[3], 'usunieta' => $row1[4], 'komentarz' => $row1[5]	);

?>


<form method="POST" action="index.php?panel=inst&menu=updateawrwyslij&awr=<?php echo $_GET[awr] ?>">
<table style="width:500px" class="tbk3">
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
			$www->SelectWlasc($dbh, "zglaszajacy", $awaria[id_zgl]);
		?>
		</td>
    </tr>
	<tr>
		<td class="klasa2">
			Opis awarii
		</td>
		<td class="klasa2">
			<textarea name="opis" cols="70" rows="3"><?php echo $awaria[opis] ?></textarea>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			Komentarz
		</td>
		<td class="klasa2">
			<textarea name="komentarz" cols="70" rows="3"><?php echo $awaria[komentarz] ?></textarea>
		</td>	
	</tr>
				<tr>
			<td class="klasa2">
				Wyślij mail/sms </td>
		 <td>
			<?php
				echo TableToCheckbox("T", "mail");
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


