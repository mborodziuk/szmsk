 <?php
 
	$Q="select s.id_stb, s.typ, s.mac, s.sn, b.id_abon, p.id_usl, s.aktywny, s.fv, s.data_aktywacji, s.pin , s.id_msi
				from 
				(settopboxy s left join belong b on b.id_urz=s.id_stb and b.nalezy_od <= '$conf[data]' and b.nalezy_do >='$conf[data]')
				left join pakiety p on	s.id_stb=p.id_urz
				and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]'
				
				where id_stb='$_GET[stb]'";
				
	$Q1="select d.id_usl from uslugi_dodatkowe d, towary_sprzedaz t where  
				t.id_tows=d.id_usl and d.aktywna_od <= '$conf[data]' and d.aktywna_do >='$conf[data]' and t.nazwa ilike 'Dzierżawa%'
				and d.id_urz='$_GET[stb]'";
				
	WyswietlSql($Q);
	$row=Query2($Q, $dbh);

	WyswietlSql($Q1);
	$d=Query2($Q1, $dbh);

	$stb=array(
	'id_stb' 	=> $row[0], 	  'typ'		  => $row[1],    'mac'							=> $row[2], 
	'sn'			=> $row[3],			'id_abon' => $row[4],		'id_taryfy' 					=> $row[5],
	'aktywny'	=> $row[6],			'fv'	    => $row[7],		'data_aktywacji' 	=>$row[8],
	'pin' 		=> $row[9], 	   'id_msi'	=>	$row[10],	'id_dzr'					=>$d[0],
	'pakiet1' => 'N', 	'pakiet1_fv' => 'N', 'pakiet2' => 'N', 'pakiet2_fv' => 'N',
	'pakiet3' => 'N', 	'pakiet3_fv' => 'N', 'pakiet5' => 'N', 'pakiet5_fv' => 'N',
	'pakiet6' => 'N', 	'pakiet6_fv' => 'N',
	'pakiet7' => 'N', 	'pakiet7_fv' => 'N', 'pakiet8' => 'N', 'pakiet8_fv' => 'N',
	'pakiet9' => 'N', 	'pakiet9_fv' => 'N', 
	'pakiet10' => 'N', 'pakiet10_fv' => 'N',
	'pakiet11' => 'N', 'pakiet11_fv' => 'N',
	'pakiet12' => 'N', 'pakiet12_fv' => 'N',
	'pakiet13' => 'N', 'pakiet13_fv' => 'N'
	);
	
	function AddSrv($dbh, $j)
	{
		include "func/config.php";
		$addsrv=$conf[addsrv.$j];
		$q="select fv from uslugi_dodatkowe where id_usl='$addsrv' and id_urz='$_GET[stb]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]'";
		WyswietlSql($q);
		$row=Query2($q, $dbh);

		if ( !empty($row) )
		{
			$s[addsrv.$j]='T';
			$s[addsrv.$j._fv]=$row[0];
		}
		else
		{
			$s[addsrv.$j]='N';
			$s[addsrv.$j._fv]='N';	
		}	
		return ($s);
	}
	
	for ( $j=1; $j<=16; ++$j )
	{
		$st=AddSrv($dbh, $j);
		$stb[addsrv.$j]=$st[addsrv.$j];
		$stb[addsrv.$j._fv]=$st[addsrv.$j._fv];
	}
	
	$_SESSION[$_GET[stb].$_SESSION[login]]=$stb;
?>

<form method="POST" action="index.php?panel=inst&menu=trfstbsnd&stb=<?php echo $_GET[stb]?>">
<table style="width:500px" class="tbk3">
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
			Select($QA11,"taryfa", $stb[id_taryfy]);
		?>
      </td>
    </tr>
    <tr>
      <td> Dzierżawa</td>
      <td>
		<?php
			Select($QA17,"dzierzawa", $stb[id_dzr]);
		?>
      </td>
    </tr>
 	
		<tr>
		<td class="klasa1" colspan="2">
			<b> Media Player </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv5], "addsrv5");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv5_fv], "addsrv5_fv");
			?>
		 </td>
	 </tr>
	 
		<tr>
		<td class="klasa1" colspan="2">
			<b> WiFi </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv6], "addsrv6");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv6_fv], "addsrv6_fv");
			?>
		 </td>
	 </tr>
		<tr>
		<td class="klasa1" colspan="2">
			<b> PVR </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv7], "addsrv7");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv7_fv], "addsrv7_fv");
			?>
		 </td>
	 </tr>

	 

	 		<tr>
		<td class="klasa1" colspan="2">
			<b> Pakiet PLUS </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv1], "addsrv1");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv1_fv], "addsrv1_fv");
			?>
		 </td>
	 </tr>
	 
		<tr>
		<td class="klasa1" colspan="2">
			<b> Pakiet HBO SD</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv2], "addsrv2");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv2_fv], "addsrv2_fv");
			?>
		 </td>
	 </tr>

	 
	 
			<tr>
		<td class="klasa1" colspan="2">
			<b> Pakiet HBO HD</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv3], "addsrv3");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv3_fv], "addsrv3_fv");
			?>
		 </td>
	 </tr> 

			<tr>
		<td class="klasa1" colspan="2">
			<b> Cinemax </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv8], "addsrv8");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv8_fv], "addsrv8_fv");
			?>
		 </td>
	 </tr> 
	 
	 
			<tr>
		<td class="klasa1" colspan="2">
			<b> Canal+ Silver </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv9], "addsrv9");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv9_fv], "addsrv9_fv");
			?>
		 </td>
	 </tr> 
	 
	 			<tr>
		<td class="klasa1" colspan="2">
			<b> Canal+ Gold </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv10], "addsrv10");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv10_fv], "addsrv10_fv");
			?>
		 </td>
	 </tr> 
	 
	 
	 			<tr>
		<td class="klasa1" colspan="2">
			<b> Canal+ Platinum </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv11], "addsrv11");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv11_fv], "addsrv11_fv");
			?>
		 </td>
	 </tr> 

	 
	  <tr>
		<td class="klasa1" colspan="2">
			<b> Republika TV </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv13], "addsrv13");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv13_fv], "addsrv13_fv");
			?>
		 </td>
	 </tr>
	 
		 			<tr>
		<td class="klasa1" colspan="2">
			<b> Discovery HD </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv12], "addsrv12");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv12_fv], "addsrv12_fv");
			?>
		 </td>
	 </tr>
	

	
	
	
		 			<tr>
		<td class="klasa1" colspan="2">
			<b> Canal+ Select </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv15], "addsrv15");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv15_fv], "addsrv15_fv");
			?>
		 </td>
	 </tr> 
	 
	 
	 			<tr>
		<td class="klasa1" colspan="2">
			<b> Canal+ Prestige </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv16], "addsrv16");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv16_fv], "addsrv16_fv");
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
		
