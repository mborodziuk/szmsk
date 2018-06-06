 <?php

  $mac=array();
	
  $Q1="select k.id_abon, k.nazwa_smb, p.id_usl, kf.dhcp, kf.ipmac, kf.net,
			kf.proxy, kf.dg, kf.info,	k.podlaczony, k.fv,  k.data_podl, k.id_msi, ai.ip, t.id_trf from 	
			(
			(komputery k left join konfiguracje kf on k.id_konf=kf.id_konf  ) 
			left join 
			(adresy_ip ai join podsieci pd on ai.id_pds=pd.id_pds and pd.warstwa in ('dostep_pryw', 'dostep_publ') ) 
			on ai.id_urz=k.id_komp)
			left join  
			(taryfy t full join pakiety p on p.id_urz=t.id_urz and 
			p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]'  and t.aktywna_od <= '$conf[data]' and t.aktywna_do >='$conf[data]')
			on k.id_komp=t.id_urz
			where k.id_komp='$_GET[komp]'";
	
	WyswietlSql($Q1);

	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();
	
	$Q2="select i.ip from adresy_ip i, podsieci p where i.id_pds=p.id_pds and p.warstwa='dostep_zewn' and i.id_urz='$_GET[komp]'";
	WyswietlSql($Q2);
	$ipz=Query2($Q2, $dbh);
	
	$Q3="select p.warstwa from podsieci p, adresy_ip i where i.id_pds=p.id_pds and i.id_urz='$_GET[komp]'";
	WyswietlSql($Q3);
	$w=Query2($Q3, $dbh);
	
	if ( $w[0] == 'dostep_pryw')
		$ipadres='Prywatny';
	else
		$ipadres='Publiczny';
	
	
	$komp=array(
	'id_abon'	=>$row1[0],			'nazwa'	=>	$row1[1],	'id_usl'	=>$row1[2],		'dhcp'		=>$row1[3],			
	'ipmac'	=>$row1[4], 			'net'		=>$row1[5],			'proxy'		=>$row1[6],		'dg'	=>$row1[7],			
	'info'=>$row1[8], 				'podlaczony' => $row1[9]	,'fv' => $row1[10], 
	'ipzewn' => 'N', 					'ipzewn_fv' => 'N', 'antywirus' => 'N', 'antywirus_fv' => 'N', 'data_podl' => $row1[11],
	'id_msi'=> $row1[12], 		'ip' => $row1[13], 'ipz' => $ipz[0], 'ipadres' => $ipadres, 'id_trf' => $row1[14]);
	

	$q4="select fv from uslugi_dodatkowe where id_usl='$conf[ipzewn]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]'  
	and id_urz='$_GET[komp]'";
	$sth4=Query($dbh, $q4);
	$row4 =$sth4->fetchRow();

	$q5="select fv from uslugi_dodatkowe where id_usl='$conf[antywirus]' and aktywna_od <= '$conf[data]' and aktywna_do >='$conf[data]' 
	and id_urz='$_GET[komp]'";
	$sth5=Query($dbh, $q5);
	$row5=$sth5->fetchRow();

	$q2="select p.id_usl, t.symbol, p.aktywny_od, p.aktywny_do 
	from komputery k, pakiety p, towary_sprzedaz t 
	where k.id_komp=p.id_urz and t.id_tows=p.id_usl and k.id_komp='$_GET[komp]'  order by p.aktywny_od";
	
	WyswietlSql($q2);
	$usl=array(	);
	$sth2=Query($dbh,$q2);
	while ($row2=$sth2->fetchRow())
	{	
		$u=array(
		'id_usl' 	=> $row2[0], 'symbol'						=>$row2[1], 	'aktywny_od'	=>$row2[2],			'aktywny_do'	=>	$row2[3]
		);
		array_push($usl, $u);		
	}
	
	$q3="select i.id_trf, i.nazwa, t.aktywna_od, t.aktywna_do 
	from komputery k, taryfy t, taryfy_internet i 
	where k.id_komp=t.id_urz and i.id_trf=t.id_trf and k.id_komp='$_GET[komp]' order by t.aktywna_od";
	
	WyswietlSql($q3);
	$trf=array(	);
	$sth3=Query($dbh,$q3);
	while ($row3=$sth3->fetchRow())
	{	
		$t=array(
		'id_trf' 	=> $row3[0], 'nazwa'						=>$row3[1], 	'aktywna_od'	=>$row3[2],			'aktywna_do'	=>	$row3[3]
		);
		array_push($trf, $t);		
	}
	

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
	

	$_SESSION[$session[komp][update]]=$komp;
		


		$q3="select af.mac from adresy_fizyczne af, adresy_ip  ai where af.ip=ai.ip and af.ip='$komp[ip]'";
		WyswietlSql($q3);
		$sth3=Query($dbh,$q3);
		while ($row3=$sth3->fetchRow() )
		{
			array_push( $mac, $row3[0] );
		}
		
$fiz="$_GET[komp]".$session[mac][update];
$_SESSION['$fiz']=$mac;



		
	$q1="select id_ifc1 from trakty where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$_GET[onu]')";
	WyswietlSql($q1);



?>

<form method="POST" action="index.php?panel=inst&menu=updatekompwyslij&komp=<?php echo "$_GET[komp]" ?>">
<table style="align=center">
  <tbody>
			<tr>
		<td class="klasa1" colspan="2">
			<b> Dane komputera (hosta)</b>
		</td>
	</tr>
    <tr>
      <td class="klasa1">
			 <strong> Id komputera </strong>
		</td>
      <td class="klasa1">
			<?php	
				echo "$_GET[komp]";	
			?>
		</td>
    </tr>
		<tr>
      <td> Data podłączenia </td>
      <td>
		<input type="text" name="data_podl" size="30" value="<?php echo "$komp[data_podl]";  ?>"/>
		</td>
    </tr>		
	 <tr>
		 <td> Podłączony </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[podlaczony], "podlaczony");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Fakturowany </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[fv], "fv");
			?>
		 </td>
	 </tr>
    <tr>
      <td> Właściciel </td>
      <td>
			<?php
				$www->SelectWlasc($dbh, "wlasciciel", $komp[id_abon]);
			?>
		</td>
    </tr>
		 <tr>
				<td> Usługa aktualna</td>
				<td>
				<?php
					$www->Select2($dbh, $QA5, "usluga", $komp[id_usl]);
				?>
				</td>
			</tr>
		<tr>
				<td> Usługi wszystkie </td>
				<td>
				<?php
				if ( !empty ($usl) )
				{
					$i=1;
					foreach ($usl as $l)
					{
						echo "$i. <b>$l[symbol] </b>$l[id_usl], aktywny od: $l[aktywny_od] do: $l[aktywny_do] <br>";
						$i++;
					}
				}
				?>
				</td>
			</tr>
	<tr>
	 <td> 
  	 </td>
	<td> 
	 <a href="index.php?panel=inst&menu=uslugaadd&komp=<?php echo "$_GET[komp]" ?>">Nowa usługa >>> </a>
	 </td>
	 </tr>			
   <tr>
      <td> Taryfa aktualna</td>
      <td>
			<?php
				$www->Select2($dbh, $QA21, "taryfa", $komp[id_trf]);
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
					echo "$i. <b>$l[nazwa] </b>$l[id_trf], aktywna od: $l[aktywna_od] do: $l[aktywna_do] <br>";
					$i++;
				}
			}
			?>
      </td>
    </tr> 
 	<tr>
	 <td> 
  	 </td>
	<td> 
	 <a href="index.php?panel=inst&menu=taryfaadd&komp=<?php echo "$_GET[komp]" ?>">Nowa taryfa >>> </a>
	 </td>
	 </tr>
    <tr>
    <tr>
      <td> Nazwa komputera </td>
      <td>
		<input type="text" name="nazwa" size="30" value="<?php echo "$komp[nazwa]";  ?>"/>
		</td>
    </tr>
	  <tr>
      <td> Adres IP </td>
      <td>
		<?php
			$ip=array("Prywatny", "Publiczny");
			$www->SelectFromArray($ip, "ipadres", $ipadres);
		?>
      </td>
    </tr>	
	 <tr>
      <td> Adresy fizyczne </td>
      <td>

			<table class="tbk1">
			  <tbody>
  				  <tr>
					<td>
						<input type="text" name="mac0" size="17" value="<?php	echo "$mac[0]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="mac1" size="17" value="<?php	echo "$mac[1]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="mac2" size="17" value="<?php	echo "$mac[2]";	?>"/>
					</td>
				</tr>
				</tbody>
			</table>

		</td>
    </tr>
    <tr>
      <td> Adresy IP </td>
      <td>
			<table class="tbk1">
			  <tbody>
  				  <tr>
					<td>
						<?php	echo "$komp[ip]";	?>
					</td>
				</tr>

				</tbody>
			</table>
		</td>
    </tr>
	 <tr>
		 <td> DHCP </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[dhcp], "dhcp");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Powiąż IP z MAC </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[ipmac], "ipmac");
			?>
	 </td>
	 </tr>
	 <tr>
		 <td> Dostęp do Internetu </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[net], "net");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> WWW przez proxy </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[proxy], "proxy");
			?>
		 </td>
	 </tr>
	 <tr>
		 <td> Blokada treści erotycznych </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[dg], "dg");
			?>
		 </td>
	 </tr>

	 <tr>
		 <td> Informacja o nieuregulowanych płatnościach  </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[info], "info");
			?>
		 </td>
	 </tr>
	
	    
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
							$www->Select3($dbh, $QUERY14, "mi", $komp[id_msi], $format);
						?>
				</td>
			</tr>
		<tr>
			<td>
			<a href="index.php?panel=inst&menu=msiadd&komp=<?php echo "$_GET[komp]" ?>"> Inny adres >>> </a>
			</td>
			</tr>	 
		<tr>
		<td class="klasa1" colspan="2">
			<b> Zewnętrzny adres IP</b>
		</td>
	</tr>
	 <tr>
		 <td> Aktywny </td>
		 <td>
			<?php
				echo TableToCheckbox($komp[ipzewn], "ipzewn");
				echo "$komp[ipz]";
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
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Uaktualnij" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>