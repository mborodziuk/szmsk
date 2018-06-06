<?php
	$dbh=DBConnect($DBNAME1);
	$q1="select id_zlc, data_zgl, id_zcy, opis, wykonane, id_wyk, data_zak, wartosc, rodzaj, komentarz from zlecenia
		where id_zlc='$_GET[zlc]'";

	$row1=Query2($q1, $dbh);

	$_SESSION['zlecenie']=$zlecenie=array
	(
		'id_zlc'		=>$row1[0],						'data_zgl'		=>$row1[1],		'id_zlc'	=>$row1[2], 	'opis'		=>$row1[3], 
		'wykonane' => $row1[4], 'id_wyk' => $row1[5], 'data_zak' => $row1[6], 'wartosc' => $row1[7], 'rodzaj' => $row1[8], 'komentarz' => $row1[9]	);

?>


<form method="POST" action="index.php?panel=inst&menu=updatezlcwyslij&zlc=<?php echo $_GET[zlc] ?>">
<table style="width:500px"  class="tbk3">
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane Zlecenia
		</td>
	</tr>

    <tr>
      <td> Zlecajacy </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "zlecajacy", $zlecenie[id_zlc]);
		?>
		</td>
    </tr>
	<tr>
		<td class="klasa2"> 
				Wykonawca
		</td> 
		<td class="klasa4">
			<?php
				Select($Q15, "wykonawca", $zlecenie[id_wyk]);
			?>
		</td>
	</tr>		
	<tr>
		<td class="klasa2">
				Wartość w zł
		</td>
		<td class="klasa4">
				<input size="10" name="wartosc" value =<?php echo $zlecenie[wartosc] ?>>
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
				Wykonać przed
		</td>
		<td class="klasa4">
				<input size="10" name="data_zak" value =<?php echo $zlecenie[data_zak] ?>>
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
				Rodzaj
		</td>
		<td class="klasa4">
	<?php
		$www->SelectFromArray($conf[zlecenia_rodzaje], "rodzaj", $zlecenie[rodzaj]);
	?>
		</td>	
	</tr>	
	<tr>
		<td class="klasa2">
			Opis Zlecenia
		</td>
		<td class="klasa2">
			<textarea name="opis" cols="70" rows="3"><?php echo $zlecenie[opis] ?></textarea>
		</td>	
	</tr>
	<tr>
		<td class="klasa2">
			Komentarz
		</td>
		<td class="klasa2">
			<textarea name="komentarz" cols="70" rows="3"><?php echo $zlecenie[komentarz] ?></textarea>
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


