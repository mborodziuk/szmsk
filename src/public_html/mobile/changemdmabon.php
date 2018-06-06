 <?php
 	$_SESSION[$_GET[modem].$_SESSION[login]]=$mdm;
?>

<form method="POST" action="index.php?panel=inst&menu=cngmdmabnsnd&modem=<?php echo "$_GET[modem]&abon=$_GET[abon]"?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Zmiana modemu </b>
		</td>
	</tr>
	  <tr>
      <td> Nowy modem </td>
      <td>
		<?php
			Select($QA36,"mdm");
		?>
      </td>
    </tr>
			<tr>
				<td class="klasa2"> 
						Ma być przypisany od
				</td> 
				<td class="klas4">
					<input size="10" name="nalezy_od" value ="<?php 	echo "$conf[data]"; ?>">
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
		
