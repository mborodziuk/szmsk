

<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="	select  id_pracy, nazwa, data_rozp, data_zak, kwota, opis
			from prace where id_pracy='$_GET[praca]'";
	$sth=Query($dbh,$Q1);
	$row =$sth->fetchRow();

	$_SESSION['praca']=$praca=array
	(	
		'id_pracy' 	=> $_GET[praca], 	'nazwa'		=>$row[1], 	'data_rozp'	=>$row[2], 	
		'data_zak'=>$row[3],				'kwota'		=>	$row[4],		'opis'	=>$row[5]
	);

?>

<form method="POST" action="index.php?menu=updatepracewyslij&praca=<?php echo $_GET[praca] ?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane o pracy
		</td>
	</tr>
	<tr>
		<td class="klasa2"> 
				Nazwa
		</td> 
		<td class="klasa4">
			<input size="40" name="nazwa" value="<?php echo $praca[nazwa] ?>">
		</td>
	</tr> 
	<tr>
		<td class="klasa2"> 
				Data rozpoczęcia
		</td> 
		<td class="klasa4">
			<input size="15" name="data_rozp"  value="<?php echo $praca[data_rozp] ?>">
		</td>
	</tr> 
	<tr>
		<td class="klasa2">
				Data zakończenia
		</td>
		<td class="klasa4">
			<input size="15" name="data_zak"  value="<?php echo $praca[data_zak] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Kwota
		</td>
		<td class="klasa4">
			<input size="40" name="kwota"  value="<?php echo $praca[kwota] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2"> 
				Opis
		</td> 
		<td class="klasa4">
			<textarea name="opis" cols="40" row="5">
				 <?php echo $praca[opis] ?>"
			</textarea>
		</td>
	</tr> 
			<tr>
				<td colspan="2">
					<input type="submit" value="Wyślij" name="przycisk1">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
