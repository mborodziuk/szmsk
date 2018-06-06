<?php

	
	$Q="select data_zgl, nr_um1, opis,  data_zak from ustalenia where id_neg='$_GET[neg]'";			
	WyswietlSql($Q);
	$row=Query2($Q, $dbh);
	
	$_SESSION[$_GET[neg].$_SESSION[login]]=$nega=array(
	'id_neg' 			=> $_GET[neg], 	  'data_zgl'		  => $row[0],    'nr_um1'	=> $row[1], 'opis'			=> 	$row[2],
	 'data_zak' => $row[3]
	);	


?>


<form method="POST" action="index.php?panel=inst&menu=sndnegupd&neg=<?php echo "$_GET[neg]" ?>">
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
			<a href="index.php?panel=inst&menu=addum&abon=<?php echo "$_GET[ctr]]" ?>">Nowa umowa >>> </a>
			</td>
			</tr>		
-->			 		
		<tr>
      <td> Data zgłoszenia </td>
      <td>
		<input type="text" name="data_zgl" size="10" value="<?php echo "$nega[data_zgl]";?>"/>
		</td>
    </tr>
		<tr>
      <td> Data zakończenia </td>
      <td>
		<input type="text" name="data_zak" size="10" value="<?php echo "$nega[data_zak]";?>"/>
		</td>
    </tr>
	
				<tr>
				<td class="klasa1" colspan="2">
					Opis 
				</td>
			</tr>

	<tr>
		<td class="klasa1" colspan="2">
			<textarea name="opis" cols="60" rows="30"><?php echo "$nega[opis]\n";?></textarea>
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
		
