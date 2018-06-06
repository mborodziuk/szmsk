 <?php
 
	$Q="select t.id_tlv, t.numer, t.aktywny, t.fv,  b.id_bmk, b.producent, b.nr_seryjny, p.id_usl, t.id_abon, t.data_aktywacji
	from
	(telefony_voip t left join bramki_voip b on t.id_bmk=b.id_bmk  ) 
	left join  
	(towary_sprzedaz ts join pakiety p on p.id_usl=ts.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]')
	on t.id_tlv=p.id_urz
	where 	t.id_tlv='$_GET[tlv]'";

	$row=Query2($Q, $dbh);

	$tlv=array(
	'id_tlv' 	=> $row[0], 	'numer'						=>$row[1], 	'aktywny'	=>$row[2],			'fv'	=>	$row[3], 
 	'id_bmk'					=>$row[4],	'producent'	=>$row[5],		'sn'	=>  $row[6],	'id_taryfy' => $row[7],
	'id_abon' => $row[8],	'data_aktywacji' 	=>$row[9]);
	
		$q4="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv7]' and id_urz='$_GET[tlv]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]'";
	$row4=Query2($q4, $dbh);
	WyswietlSql($q4);
	if ( !empty($row4) )
	{
		$tlv[addsrv7]='T';
		$tlv[addsrv7_fv]=$row4[0];
	}
	else
	{
		$tlv[addsrv7]='N';
		$tlv[addsrv7_fv]='N';	
	}
	$tel="tlv"."$_GET[tlv]";
	$_SESSION['$tel']=$tlv;

?>

<form method="POST" action="index.php?panel=inst&menu=trftlvsnd&tlv=<?php echo $_GET[tlv]?>">
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
			Select($QA9,"taryfa", $tlv[id_taryfy]);
		?>
			
      </td>
    </tr>
		<tr>
		<td class="klasa1" colspan="2">
			<b> Utrzymanie linii </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywne </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[addsrv7], "addsrv7");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowane </td>
		 <td>
			<?php
				echo TableToCheckbox($tlv[addsrv7_fv], "addsrv7_fv");
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
		
