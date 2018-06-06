 <?php
  $ip=array();
  $mac=array();
 
   $Q1="select a.symbol, a.nazwa, a.id_abon, k.nazwa_smb, k.system, t.symbol,
			kf.dhcp, kf.powiaz_ipmac, kf.inet, kf.proxy, kf.antyporn, kf.przekier_gg, kf.przekier_ftp, kf.przekier_emule, kf.przekier_inne 
			from abonenci a, komputery k , konfiguracje kf, towary_sprzedaz t 
			where a.id_abon=k.id_abon and k.id_komp='$_GET[komp]' and kf.id_konf=k.id_konf and k.id_taryfy=t.id_tows";
 
	$dbh=DBConnect($DBNAME1);
	$sth1=Query($dbh, $Q1);
	$row1 =$sth1->fetchRow();

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
      <td> Właściciel </td>
      <td>
			<?php
			 	echo Choose ($row1[0], $row1[1])." $row1[2]";
			?>
		</td>
    </tr>
    <tr>
      <td> Taryfa </td>
      <td>
			<?php
				echo "$row1[5]";
			?>
        </select> 
      </td>
    </tr>
    <tr>
      <td> Nazwa komputera </td>
      <td>
			<?php 
				echo "$row1[3]";  
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
						<input type="text" name="mac0" size="20" value="<?php	echo "$mac[0]";	?>"/>
					</td>
				</tr>
  				  <tr>
					<td>
						<input type="text" name="mac1" size="20" value="<?php	echo "$mac[1]";	?>"/>
					</td>
				</tr>
				</tbody>
			</table>
		</td>
    </tr>
    <tr>
      <td> Adresy IP </td>
      <td>
			<?php
				for ( $i=0; $i<=count($ip); $i++)
				echo "$ip[$i] <br>";
			?>
		</td>
    </tr>
	 <tr>
      <td> System operacyjny </td>
      <td>
		<?php
			echo "$row1[4]";
		?>

		</td>
    </tr>
	 <tr>
		 <td> Blokada treści erotycznych </td>
		 <td>
			 <input type="checkbox" name="antyporn" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie GG </td>
		 <td>
			 <input type="checkbox"  name="przekiergg" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie FTP </td>
		 <td>
			 <input type="checkbox" name="przekierftp" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie EMULE </td>
		 <td>
			 <input type="checkbox" name="przekieremule" value="OFF" />
		 </td>
	 </tr>
	 <tr>
		 <td> Przekierowanie inne </td>
		 <td>
			 <input type="checkbox"  name="przekierinne" value="OFF" />
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