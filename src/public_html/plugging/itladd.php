<?php

	
	$Q="select data_zgl, id_abon, opis, trudnosc from instalacje where id_itl='$_GET[itl]'";			
	WyswietlSql($Q);
	$row=Query2($Q, $dbh);
	
	$_SESSION[$_GET[itl].$_SESSION[login]]=$itla=array(
	'id_itl' 			=> $_GET[itl], 	  'data_zgl'		  => $row[0],    'id_abon'	=> $row[1], 'opis'			=> 	$row[2],
	'trudnosc' => $row[3]
	);	


?>


<form method="POST" action="index.php?panel=inst&menu=snditlupd&itl=<?php echo "$_GET[itl]" ?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Instalacja </b>
		</td>

		</tr>
<!-- 
		<tr>
			<td class="klasa4" colspan="2">
				<table class="tbk1" style="text-align: left; width: 500px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
				  <tbody>
    					<tr class="tr1">
					      <td style="width: 5px;">
      						L.p.
	      				</td>
					      <td style="width: 100px;">
      						Id rozmowy
	      				</td>
 					     <td style="width: 100px;">
      					Data rozmowy
				       </td>
							</tr>
	
	<?php
		//$customers->ContractList($dbh, $_GET[abon]);
	?>
					  </tbody>
				</table>
		</td>	
		</tr>
			<tr>
			<td>
			<a href="index.php?panel=inst&menu=addum&abon=<?php echo "$_GET[abon]" ?>">Nowa umowa >>> </a>
			</td>
			</tr>		
-->			 		
		<tr>
      <td> Data zgłoszenia </td>
      <td>
		<input type="text" name="data_zgl" size="30" value="<?php echo "$itla[data_zgl]";?>"/>
		</td>
    </tr>
	<tr>
		<td class="klasa2">
				Stopień trudności
		</td>
		<td class="klasa4">
	<?php
		$stopien=array(1, 2, 3, 4, 5, 6);
		$www->SelectFromArray($stopien, "trudnosc", $itla[trudnosc]);
	?>
		</td>	
	</tr>
				<tr>
				<td class="klasa1" colspan="2">
					Opis 
				</td>
			</tr>

	<tr>
		<td class="klasa1" colspan="2">
			<textarea name="opis" cols="60" rows="30"><?php echo "$itla[opis]\n";?></textarea>
		</td>	
	</tr>  	  
			<tr>
				<td colspan="2">
					<input type="submit" class="button1" value="Wyślij >>>" name="przycisk">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
