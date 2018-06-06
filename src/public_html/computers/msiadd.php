<?php
	
	$Q="select m.id_bud, m.nr_lok from miejsca_instalacji m, komputery k 
	where k.id_msi=m.id_msi and k.id_komp='$_GET[komp]'";
	WyswietlSql($Q);	
	$sth1=Query($dbh, $Q);
	$row1 =$sth1->fetchRow();

	
?>

<form method="POST" action="index.php?panel=inst&menu=msiaddsnd&komp=<?php echo $_GET[komp]?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Nowe miejsce instalacji</b>
		</td>
	</tr>
   <tr>
      <td> Budynek </td>
      <td>
			<?php
				$www->Select2($dbh, $QUERY1, "budynek", $row1[0]);
			?>
			
      </td>
    </tr>
		

			<tr>
				<td class="klasa2"> 
						Lokal nr
				</td> 
				<td class="klas4">
					<input size="10" name="nr_lok" >
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
<tbody>
</table>
		
</form>
		
