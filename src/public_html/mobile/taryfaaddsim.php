<?php
	$fd=date("Y-m-01");
	
	$Q1="select p.id_usl, u.id_usl from pakiety p  left join uslugi_dodatkowe u on p.id_urz=u.id_urz and 
					p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]' and 
					u.aktywna_od <= '$conf[data]' and u.aktywna_do >= '$conf[data]' where p.id_urz='$_GET[sim]'";
	WyswietlSql($Q1);	
	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();
	
	
	
?>

<form method="POST" action="index.php?panel=inst&menu=trfsimsnd&sim=<?php echo $_GET[sim]?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Nowa taryfa</b>
		</td>
	</tr>
   <tr>
      <td> Prędkość </td>
      <td>
			<?php
				$www->Select2($dbh, $QA29, "speed", $row1[0]);
			?>
			
      </td>
    </tr>
   <tr>
      <td> Doładowanie </td>
      <td>
			<?php
				$www->Select2($dbh, $QA30, "basic_load", $row1[1]);
			?>
			
      </td>
    </tr>
		
			<tr>
				<td class="klasa2"> 
						Aktywna od
				</td> 
				<td class="klas4">
					<input size="10" name="aktywny_od" value ="<?php 	echo "$conf[data]"; ?>">
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
		
