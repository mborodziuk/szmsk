<?php
	$fd=date("Y-m-01");
	
	$Q1="select id_usl from pakiety where id_urz='$_GET[komp]' and aktywny_od <= '$conf[data]' and aktywny_do >='$conf[data]'";
	WyswietlSql($Q1);	
	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();
	
	$q4="select fv from uslugi_dodatkowe where id_usl='$conf[ipzewn]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]'  
	and id_urz='$_GET[komp]'";
	$sth4=Query($dbh, $q4);
	$row4 =$sth4->fetchRow();
	
	$q44="select fv from uslugi_dodatkowe where id_usl='$conf[ipzewn2]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]'  
	and id_urz='$_GET[komp]'";
	$sth44=Query($dbh, $q44);
	$row44 =$sth44->fetchRow();
	

	$q5="select fv from uslugi_dodatkowe where id_usl='$conf[antywirus]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]' 
	and id_urz='$_GET[komp]'";
	$sth5=Query($dbh, $q5);
	$row5=$sth5->fetchRow();
	

	
	if ( !empty($row4) )
	{
		$komp[ipzewn]='T';
		$komp[ipzewn_fv]=$row4[0];
	}
	else
	{
		$komp[ipzewn]='N';
		$komp[ipzewn_fv]='N';	
	}

	if ( !empty($row44) )
	{
		$komp[ipzewn2]='T';
		$komp[ipzewn2_fv]=$row44[0];
	}
	else
	{
		$komp[ipzewn2]='N';
		$komp[ipzewn2_fv]='N';	
	}
	
	if ( !empty($row5) )
	{
		$komp[antywirus]='T';
		$komp[antywirus_fv]=$row5[0];
	}
	else
	{
		$komp[antywirus]='N';
		$komp[antywirus_fv]='N';	
	}	
	
?>

<form method="POST" action="index.php?panel=inst&menu=uslugaaddsnd&komp=<?php echo $_GET[komp]?>">
<table style="width:500px"  class="tbk3" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Nowa usługa</b>
		</td>
	</tr>
   <tr>
      <td> Usługa </td>
      <td>
			<?php
				$www->Select2($dbh, $QA5, "usluga", $row1[0]);
			?>
			
      </td>
    </tr>
		
	<tr>
		<td class="klasa1" colspan="2">
			<b> Zewnętrzny adres IP 5 zł</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[ipzewn], "ipzewn");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[ipzewn_fv], "ipzewn_fv");
			?>
		 </td>
	 </tr>

	 
	<tr>
		<td class="klasa1" colspan="2">
			<b> Zewnętrzny adres IP 6,99 zł</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[ipzewn2], "ipzewn2");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[ipzewn2_fv], "ipzewn2_fv");
			?>
		 </td>
	 </tr>
	 
	 
		<tr>
		<td class="klasa1" colspan="2">
			<b> Antywirus</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[antywirus], "antywirus");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[antywirus_fv], "antywirus_fv");
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
		
