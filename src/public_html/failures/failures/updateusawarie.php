<?php
	$dbh=DBConnect($DBNAME1);

	$q1="select aw.id_awr, aw.czas_zgl, aw.id_zgl, aw.opis, ab.id_abon, au.czas_us, au.opis, au.usuwajacy, au.licznik_przed, au.licznik_po, au.id_usaw
		from awarie aw, abonenci ab, usuwanie_awarii au
		where ab.id_abon=aw.id_zgl and au.id_awr=aw.id_awr and aw.id_awr='$_GET[awr]'";

	$row1=Query2($q1, $dbh);

	$_SESSION['awaria']=$awaria=array
	(
		'id_awr'		=>$row1[0],	'czas_zgl'		=>$row1[1],		'id_zgl'	=>$row1[2], 	
		'opis'		=>$row1[3], 'usunieta' => $row1[4]	);

	$_SESSION['usuwanie_awarii']=$usuwanie_awarii=array
	(
		'czas_us'	=>$row1[5],	'opis'		=>$row1[6],		'usuwajacy'	=>$row1[7], 	
		'licznik_przed'		=>$row1[8], 'licznik_po' => $row1[9], 'id_usaw' =>$row1[10] );
?>


<form method="POST" action="index.php?panel=admin&menu=updateusawrwyslij">
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
			$www->SelectWlasc($dbh, "zglaszajacy", $awaria[id_zgl]);
		?>
		</td>
    </tr>
	<tr>
		<td class="klasa2">
			Opis awarii
		</td>
		<td class="klasa2">
			<textarea name="opis_awarii" cols="63" rows="3"><?php echo $awaria[opis] ?></textarea>
		</td>	
	</tr>
	<tr>
		<td class="klasa2"> 
				Usuwający
		</td> 
		<td class="klasa4">
			<?php
				Select($QUERY12, "usuwajacy", $usuwanie_awarii[usuwajacy]);
			?>
		</td>
	</tr> 	<tr>
		<td class="klasa2">
			Opis usunięcia
		</td>
		<td class="klasa2">
			<textarea name="opis_usuwania" cols="63" rows="3"><?php echo "$usuwanie_awarii[opis]"; ?></textarea>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Stan licznika przed
		</td>
		<td class="klasa4">
				<input size="15" name="licznik_przed" value="<?php echo "$usuwanie_awarii[licznik_przed]" ?>">
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
				Stan licznika po
		</td>
		<td class="klasa4">
				<input size="15" name="licznik_po" value="<?php echo "$usuwanie_awarii[licznik_po]" ?>">
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


