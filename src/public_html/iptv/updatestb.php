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
	'addsrv1' => 'N', 'addsrv1_fv' => 'N', 'addsrv2' => 'N', 'addsrv2_fv' => 'N',
	'addsrv3' => 'N', 'addsrv3_fv' => 'N', 'addsrv5' => 'N', 'addsrv5_fv' => 'N',
	'addsrv6' => 'N', 'addsrv6_fv' => 'N',
	'addsrv7' => 'N', 'addsrv7_fv' => 'N', 'addsrv8' => 'N', 'addsrv8_fv' => 'N',
	'addsrv9' => 'N', 'addsrv9_fv' => 'N', 'addsrv10' => 'N', 'addsrv10_fv' => 'N',
	'addsrv11' => 'N', 'addsrv11_fv' => 'N', 	'addsrv12' => 'N', 'addsrv12_fv' => 'N',
	'addsrv13' => 'N', 'addsrv13_fv' => 'N', 
	'addsrv15' => 'N', 'addsrv15_fv' => 'N', 	'addsrv16' => 'N', 'addsrv16_fv' => 'N',
 	'addsrv17' => 'N', 'addsrv17_fv' => 'N'

	);
	
	
$q2="select p.id_usl, t.symbol, p.aktywny_od, p.aktywny_do 
	from settopboxy s, pakiety p, towary_sprzedaz t 
	where s.id_stb=p.id_urz and t.id_tows=p.id_usl and s.id_stb='$_GET[stb]' order by p.aktywny_od, p.aktywny_do";
	
	WyswietlSql($q2);
	$trf=array(	);

	$sth2=Query($dbh,$q2);
	while ($row2=$sth2->fetchRow())
	{	
		$t=array(
		'id_usl' 	=> $row2[0], 'symbol'						=>$row2[1], 	'aktywny_od'	=>$row2[2],			'aktywny_do'	=>	$row2[3]
		);
		array_push($trf, $t);		
	}
	
$q3="select p.id_usl, t.symbol, p.aktywna_od, p.aktywna_do 
	from uslugi_dodatkowe p, towary_sprzedaz t 
	where t.id_tows=p.id_usl and p.id_urz='$_GET[stb]' and t.nazwa ilike '%dzierżawa%' order by p.aktywna_od, p.aktywna_do";
	
	WyswietlSql($q3);
	$ud=array(	);

	$sth3=Query($dbh,$q3);
	while ($row3=$sth3->fetchRow())
	{	
		$t=array(
		'id_usl' 	=> $row3[0], 'symbol'						=>$row3[1], 	'aktywna_od'	=>$row3[2],			'aktywna_do'	=>	$row3[3]
		);
		array_push($ud, $t);		
	}
	
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
	
	for ( $j=1; $j<=17; ++$j )
	{
		$st=AddSrv($dbh, $j);
		$stb[addsrv.$j]=$st[addsrv.$j];
		$stb[addsrv.$j._fv]=$st[addsrv.$j._fv];
	}
	
	$_SESSION[$_GET[stb].$_SESSION[login]]=$stb;
?>

</form>

<form method="POST" action="index.php?panel=inst&menu=sendupdstb&stb=<?php echo "$_GET[stb]" ?>">
<table class="tbk3">
  <tbody>
	<tr>
		<td class="klasa1" colspan="2">
				Dane Dekodera
		</td>
		<tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[aktywny], "aktywny");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[fv], "fv");
			?>
		 </td>
	 </tr>
    <tr>
      <td> Typ </td>
						<td class="klasa4">
						<option> </option>
						<?php
							$typ=array('Soiav', 'Ultra', 'Magic', 'Korbox 3.0', 'Jabkor', 'Korbox Wave', 'MAG200', 'MAG250', 'Korbox');
							$www->SelectFromArray($typ, 'typ', $stb[typ]);
						?>
				</td>   
		
    </tr>
    <tr>
      <td> Numer seryjny </td>
      <td>
		<input type="text" name="sn" size="20" value =<?php echo $stb[sn] ?> />
		</td>
    </tr>
    <tr>
      <td> Adres fizyczny </td>
      <td>
		<input type="text" name="mac" size="20" value =<?php echo $stb[mac] ?> />
		</td>
    </tr>
    <tr>
      <td> Abonent </td>
      <td>
		<?php
			$www->SelectWlasc($dbh, "abonent", $stb[id_abon]);
		?>
		</td>
    </tr>
     <tr>
      <td> Taryfa aktualna</td>
      <td>
		<?php
			Select($QA11,"taryfa", $stb[id_taryfy]);
		?>
      </td>
    </tr>
 <tr>
      <td> Taryfy wszystkie </td>
      <td>
			<?php
			if ( !empty ($trf) )
			{
				$i=1;
				foreach ($trf as $l)
				{
					echo " $i. <b>$l[symbol] </b>$l[id_usl], aktywny od: $l[aktywny_od] do: $l[aktywny_do] <br>";
					$i++;
				}
					echo "Kasuj ostatnią taryfę";
					echo TableToCheckbox("N", "$l[id_usl]_$l[aktywny_od]_$l[aktywny_do]_trf");
			}
			?>
      </td>
</tr>
     <tr>
      <td> Dzierżawa aktualna</td>
      <td>
		<?php
			Select($QA17,"dzierzawa", $stb[id_dzr]);
		?>
      </td>
    </tr>
 <tr>
      <td> Dzierżawy wszystkie </td>
      <td>
			<?php
			if ( !empty ($ud) )
			{
				$i=1;
				foreach ($ud as $l)
				{
					echo "$i. <b>$l[symbol] </b>$l[id_usl], aktywna od: $l[aktywna_od] do: $l[aktywna_do] <br>";
					$i++;
				}
					echo "Kasuj ostatnią dzierżawę";
					echo TableToCheckbox("N", "$l[id_usl]_$l[aktywna_od]_$l[aktywna_do]_dzr");
			}
			?>
      </td>
</tr>
    <tr>
      <td> PIN </td>
      <td>
		<input type="text" name="pin" size="20" value="<?php echo "$stb[pin]";  ?>"/>
		</td>
    </tr
    <tr>
      <td> Data aktywacji </td>
      <td>
		<input type="text" name="data_aktywacji" size="20" value="<?php echo "$stb[data_aktywacji]";  ?>"/>
		</td>
    </tr
		
			    
			<tr>
				<td class="klasa1" colspan="2">
					Miejsce instalacji
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres
				</td>
				<td class="klasa4">
						<option> </option>
						<?php
							$format=array(0=>'', 1=>'', 2=>'lok. ', 3=>'', 4=>'');
							$www->Select3($dbh, $QUERY14, "mi", $stb[id_msi], $format);
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
		<td class="klasa1" colspan="2">
			<b> eXXXtra </b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv17], "addsrv17");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($stb[addsrv17_fv], "addsrv17_fv");
			?>
		 </td>
	 </tr> 
	 
	 <tr>
	 <td> 
  	 </td>
	<td> 
	 <a href="index.php?panel=inst&menu=trfstbadd&stb=<?php echo "$_GET[stb]" ?>">Nowa taryfa >>> </a>
	 </td>
	 </tr>
		 	<tr>
	 <td> 
  	 </td>
	<td> 
	 <a href="index.php?panel=inst&menu=cngstbabn&stb=<?php echo "$_GET[stb]&abon=$stb[id_abon]" ?>">Zmiana dekodera >>> </a>
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
</table>

</form>

