<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="	select  nr_ump, id_prac, id_pracy, data_zawarcia, typ
			from umowypracy where nr_ump='$_GET[ump]'";
	$sth=Query($dbh,$Q1);
	$row =$sth->fetchRow();

	$_SESSION['ump']=$ump=array
	(	
		'nr_ump' 			=> $_GET[ump], 	'id_prac'		=> $row[1], 	'id_pracy'	=>$row[2], 	
		'data_zawarcia'	=>	$row[3],			'typ'				=>	$row[4]
	);

?>
<form method="POST" action="index.php?menu=updateumpwyslij&ump=<?php echo $_GET[ump]?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane umowy
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Numer
		</td>
		<td class="klasa4">
			<input size="15" name="nr_ump"  value="<?php echo $ump[nr_ump] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data zawarcia
		</td>
		<td class="klasa4">
			<input size="15" name="data_zawarcia" value="<?php echo $ump[data_zawarcia] ?>">
		</td>
	</tr>
	<tr>
		<td class="klasa2"> 
				Pracownik
		</td> 
		<td class="klasa4">
			<?php
				Select($QUERY12, "pracownik", $ump[id_prac]);
			?>
		</td>
	</tr> 
	<tr>
		<td class="klasa2"> 
				Typ umowy
		</td> 
		<td class="klasa4">
			<?php
				$typ=array('dzieło', 'zlecenie', 'prace');
				$www->SelectFromArray($typ, "typ", $ump[typ]);
			?>
		</td>
	</tr> 
	<tr>
		<td class="klasa2"> 
				Praca
		</td> 
		<td class="klasa4">
			<?php
				Select($QUERY13, "praca", $ump[id_pracy]);
			?>
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
		
