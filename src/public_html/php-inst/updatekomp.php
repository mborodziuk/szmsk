 <?php
  $ip=array();
  $mac=array();
 
   $Q1="select a.symbol, a.nazwa, a.id_abon, k.nazwa_smb, k.system, t.symbol,
			kf.dhcp, kf.ipmac, kf.net, kf.proxy, kf.dg, kf.info,	k.podlaczony, k.fv, k.id_taryfy
			from abonenci a, komputery k , konfiguracje kf, towary_sprzedaz t 
			where a.id_abon=k.id_abon and k.id_komp='$_GET[komp]' and kf.id_konf=k.id_konf and k.id_taryfy=t.id_tows";
 
	$dbh=DBConnect($DBNAME1);
	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();

	$_SESSION['komp']=$komp=array(
	'a_symbol' => $row1[0], 		'a_nazwa'	=>$row1[1], 	'id_abon'	=>$row1[2],			'nazwa_smb'	=>	$row1[3],
	'system'	=>$row1[4],				't_symbol'	=>$row1[5],		'dhcp'		=>$row1[6],			'ipmac'	=>$row1[7],
	'net'		=>$row1[8],			'proxy'		=>$row1[9],		'dg'	=>$row1[10],			'info'=>$row1[11], 'podlaczony' => $row1[12]	,
	'fv' => $row1[13], 'id_taryfy' => $row1[14]	);

	$q2="select ip from adresy_ip, komputery where id_urz=id_komp and id_komp='$_GET[komp]'";
	$sth2=Query($dbh,$q2);
	while ($row2=$sth2->fetchRow() )
	{
		array_push( $ip, $row2[0] );
	}
	foreach ($ip as $i)
	{
		$q3="select af.mac from adresy_fizyczne af, adresy_ip  ai where af.ip=ai.ip and af.ip='$i'";
		$sth3=Query($dbh,$q3);
		while ($row3=$sth3->fetchRow() )
		array_push( $mac, $row3[0] );
	}


$_SESSION['ip']=$ip;
$_SESSION['mac']=$mac;


?>

<form method="POST" action="index.php?panel=inst&menu=updatekompwyslij&komp=<?php echo "$_GET[komp]" ?>">
<table style="align=center">
  <tbody>
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
				SelectWlasc("wlasciciel", $row1[2]);
			?>
		</td>
    </tr>
    <tr>
      <td> Taryfa </td>
      <td>
      	<select name="taryfa">
			<?php
				echo "<option> $row1[5] </option>";
				Select($QA5);
			?>
        </select> 
      </td>
    </tr>
    <tr>
      <td> Nazwa komputera </td>
      <td>
		<input type="text" name="nazwa" size="30" value="<?php echo "$row1[3]";  ?>"/>
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
						<input type="text" name="ip0" size="10" value="<?php	echo "$ip[0]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="ip1" size="10" value="<?php	echo "$ip[1]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="ip2" size="10" value="<?php	echo "$ip[2]";	?>"/>
					</td>
				</tr>
				</tbody>
			</table>
		</td>
    </tr>
	 <tr>
      <td> System operacyjny </td>
      <td>
			<select name="system">
		<?php
			echo "<option> $row1[4] </option>";
		?>
				<option>Inny  </option>
				<option>Windows 9X</option>
				<option>Windows 2000 </option>
				<option>Windows XP </option>
				<option>Windows 2003 </option>
				<option>Linux  </option>
			</select>
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
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Uaktualnij" size="30"> 
	 </td>
	 </tr>
  </tbody>
</table>

</form>