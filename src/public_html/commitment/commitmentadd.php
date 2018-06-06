<?php
	$fd=date("Y-m-01");
	
	$Q1="select id_usl from pakiety where id_urz='$_GET[router]'";
	WyswietlSql($Q1);	
	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();
	

	
?>

<form method="POST" action="index.php?panel=inst&menu=trfroutersnd&router=<?php echo $_GET[router]?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Nowa taryfa</b>
		</td>
	</tr>
   <tr>
      <td> Taryfa </td>
      <td>
			<?php
				$www->Select2($dbh, $QA11, "dzierzawa", $row1[0]);
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
		
