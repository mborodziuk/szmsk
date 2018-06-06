 <?php
 
	$_SESSION[$_GET[sim].$_SESSION[login]]=$sim;
	
?>

<form method="POST" action="index.php?panel=inst&menu=cngsimabnsnd&sim=<?php echo "$_GET[sim]&abon=$_GET[abon]"?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Zmiana karty SIM </b>
		</td>
	</tr>
	  <tr>
      <td> Nowa karta SIM </td>
      <td>
		<?php
			Select($QA35,"sim");
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
		
