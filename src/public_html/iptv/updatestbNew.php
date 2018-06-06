 <?php
 
	$Q="select s.id_stb, s.typ, s.mac, s.sn, b.id_abon, p.id_usl, s.aktywny, s.fv, s.data_aktywacji, s.pin , s.id_msi
				from 
				(settopboxy s left join belong b on b.id_urz=s.id_stb and b.nalezy_od <= '$conf[data]' and b.nalezy_do >='$conf[data]')
				left join pakiety p on	s.id_stb=p.id_urz
				and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]'
				
				where id_stb='$_GET[stb]'";
				
	WyswietlSql($Q);
	$row=Query2($Q, $dbh);

	$stb=array(
	'id_stb' 	=> $row[0], 	  'typ'		  => $row[1],    'mac'							=> $row[2], 
	'sn'			=> $row[3],			'id_abon' => $row[4],		'id_taryfy' 					=> $row[5],
	'aktywny'	=> $row[6],			'fv'	    => $row[7],		'data_aktywacji' 	=>$row[8],
	'pin' 		=> $row[9], 	   'id_msi'	=>	$row[10],
	'pakiet1' => 'N', 'pakiet1_fv' => 'N', 'pakiet2' => 'N', 'pakiet2_fv' => 'N',
	'pakiet3' => 'N', 'pakiet3_fv' => 'N', 'pakiet5' => 'N', 'pakiet5_fv' => 'N',
	'pakiet6' => 'N', 'pakiet6_fv' => 'N'
	);
	
	
	$q2="select p.id_usl, t.symbol, p.aktywny_od, p.aktywny_do 
	from settopboxy s, pakiety p, towary_sprzedaz t 
	where s.id_stb=p.id_urz and t.id_tows=p.id_usl and s.id_stb='$_GET[stb]'";
	
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
	

	$q3="select u.id_usl, t.symbol, u.fv, u.aktywna_od, u.aktywna_do 
	from uslugi_dodatkowe u, towary_sprzedaz t 
	where t.id_tows=u.id_usl and 
	u.aktywna_od <= '$conf[data]' and u.aktywna_do >='$conf[data]'
	and u.id_urz='$_GET[stb]'";
	
	WyswietlSql($q3);
	$usd=array(	);
	$sth3=Query($dbh,$q3);
	$i=1;
	while ($row3=$sth3->fetchRow())
	{	
		$u=array(
		'pakiet'=> $i, 'id_usl' 	=> $row3[0], 'symbol'						=>$row3[1], 	'fv' => $row3[2], 'aktywny_od'	=>$row3[3],			'aktywny_do'	=>	$row3[4]
		);
		array_push($usd, $u);		
			++$i;
	}

	
	$_SESSION[ud.$_GET[stb].$_SESSION[login]]=$usd;
	print_r($usd);
	$_SESSION[$_GET[stb].$_SESSION[login]]=$stb;
	
?>

</form>

<form method="POST" action="index.php?panel=inst&menu=sendupdstb&stb=<?php echo "$_GET[stb]" ?>">
<table style="align=center">
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
      <td>
		<input type="text" name="typ" size="20" value =<?php echo $stb[typ] ?> />
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
					echo "$i. <b>$l[symbol] </b>$l[id_usl], aktywny od: $l[aktywny_od] do: $l[aktywny_do] <br>";
					$i++;
				}
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
			<b> Pakiety dodatkowe</b>
		</td>
	</tr>
	
			<?php
			if ( !empty ($usd) )
			{
				$i=1;
				foreach ($usd as $us)
				{
					echo "<tr><td> Pakiet $i </td><td>";
					Select($QA27,"pakiet$us[pakiet]", $us[id_usl]);
					echo "</td></tr>
					<tr><td> Fakturowany </td><td>";
					echo TableToCheckbox($us[fv], "pakiet$i"."_fv");
					echo "</td></tr>";
					$i++;
				}
			}
					echo "<tr><td> Pakiet $i </td><td>";
					Select($QA27,"pakiet$i");
					echo "</td></tr>
					<tr><td> Fakturowany </td><td>";
					echo TableToCheckbox($us[2], "pakiet$i"."_fv");
					echo "</td></tr>";
					$i++;

					echo "<tr><td> Pakiet $i </td><td>";
					Select($QA27,"pakiet$i");
					echo "</td></tr>
					<tr><td> Fakturowany </td><td>";
					echo TableToCheckbox($us[2], "pakiet$i"."_fv");
					echo "</td></tr>";
					$i++;
			?>
		
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

