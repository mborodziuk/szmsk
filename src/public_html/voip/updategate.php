<?php
	$dbh=DBConnect($DBNAME1);
	$q1="select id_bmk, producent, model, nr_seryjny, mac, id_msi from bramki_voip 
		where id_bmk='$_GET[bmk]'";
	$row1=Query2($q1, $dbh);

	$_SESSION['gate']=$gate=array
	(
		'id_bmk'		=>$row1[0],						'producent'		=>$row1[1],		
		'model'			=>$row1[2], 					'nr_seryjny'	=>$row1[3], 
		'mac'				=>$row1[4],						'id_msi'			=>$row1[5]
	);

?>

<form method="POST" action="index.php?panel=inst&menu=sendupdgate&gate=<?php echo "$_GET[bmk]" ?>">
<table style="align=center">
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane Bramki Voip
		</td>
    <tr>
      <td> Producent </td>
      <td>
		<input type="text" name="producent" size="30" value =<?php echo $gate[producent] ?> />
		</td>
    </tr>
	 <tr>
      <td> Model </td>
      <td>
		<input type="text" name="model" size="20" value =<?php echo $gate[model] ?> />
		</td>
    </tr>
    <tr>
      <td> Numer seryjny </td>
      <td>
		<input type="text" name="nr_seryjny" size="20" value =<?php echo $gate[nr_seryjny] ?> />
		</td>
    </tr>
    <tr>
      <td> Adres fizyczny </td>
      <td>
		<input type="text" name="mac" size="20" value =<?php echo $gate[mac] ?> />
		</td>
    </tr>
			<tr>
				<td class="klasa1" colspan="2">
					Miejsce instalacji
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres
				</td>
				<td class="klasa4">
						<option> </option>
						<?php
							$format=array(0=>'', 1=>'', 2=>'lok. ', 3=>'', 4=>'');
							$www->Select3($dbh, $QUERY14, "mi", $gate[id_msi], $format);
						?>
				</td>
			</tr>		
	<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Uaktualnij" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>