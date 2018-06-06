<?php
	$m=date("m");
	$Y=date("Y");
  $y=substr($Y,2,2);
	$ip=array();
  $mac=array();
	
   $Q1="select k.nazwa_smb, t.symbol, kf.dhcp, kf.ipmac, kf.net, kf.proxy, kf.dg, kf.info,	k.podlaczony, k.fv, k.id_taryfy, k.id_komp
			from ( konfiguracje kf full join komputery k on kf.id_konf=k.id_konf) 
			full join towary_sprzedaz t on t.id_tows=k.id_taryfy  
			where k.id_abon='$_GET[abon]'";
			
	$Q2="select s.id_stb, s.typ, s.mac, s.sn, s.id_abon, p.id_usl, s.aktywny, s.fv, s.data_aktywacji, s.pin 
				from settopboxy s where s.id_abon='$_GET[abon]'";
				

	$Q3="select t.id_tlv, t.numer, t.aktywny, t.fv, b.id_bmk, b.producent, b.nr_seryjny, t.id_tvoip, 
	t.id_abon, t.data_aktywacji from   
	(telefony_voip t left join towary_sprzedaz tw on t.id_tvoip=tw.id_tows ) left join 
	bramki_voip b on t.id_bmk=b.id_bmk
	where t.id_abon='$_GET[abon]'";
	
?>

<form method="POST" action="index.php?panel=inst&menu=ctrprladdsnd&ctr=<?php echo $_GET[ctr]?>">
<table style="width:500px"  class="tbk3">
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Dane umowy abonenckiej</b>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
			Numer umowy
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="2" name="nr_um1">
					</td>
					<td>
					<select name="rodzaj">
						<option selected>UMA</option>
						<option>UMR</option>
						<option>UMS</option>
					</td>
					<td>
						<input size="2" name="nr_um2" value ="<?php echo $y; ?>" >
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data zawarcia umowy (dzień/miesiąc/rok)
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="2" name="dzien">
					</td>
					<td>
						<input size="2" name="miesiac" value ="<?php echo $m; ?>">
					</td>
					<td>
						<input size="4" name="rok"value ="<?php echo $Y; ?>">
					</td>
				</tr>
			</table>
			</td>
			</tr>
	<tr>
		<td class="klasa2">
				Data wejścia w życie, data uruchomienia usługi (dzień/miesiąc/rok)
		</td>
		<td class="klasa4">
			<table class="klasa3">
				<tr>
					<td>
						<input size="2" name="dzienz">
					</td>
					<td>
						<input size="2" name="miesiacz" value ="<?php echo $m; ?>">
					</td>
					<td>
						<input size="4" name="rokz"value ="<?php echo $Y; ?>">
					</td>
				</tr>
			</table>
			</td>
			</tr>
				<tr>
				<td class="klasa2">
					Ulga w zł
				</td>
				<td class="klasa4">
					<input size="10" name="ulga" 	 >
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="klasa2">
					Okres obowiązywania umowy
				</td>
				<td class="klasa4">
					<select name="typ_um">
								<option>36</option>
								<option>30</option>
								<option selected>24</option>
								<option>18</option>
								<option>12</option>
								<option>9</option>
					</select> 
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Status
				</td>
				<td class="klasa4">
					<?php
						$status=array("Przedłużana", "Obowiązująca", "Rozwiązana", "Zawieszona", "windykowana", "Nie podpisana");
						$www->SelectFromArray($status, "status_uma")
					?>					
					</select>
				</td>
			</tr>
				<tr>
				<td class="klasa2">
					Miejsce zawarcia
				</td>
				<td class="klasa4">
					<select name="miejsce">
								<option selected>Mysłowice</option>
								<option>Oświęcim</option>
								<option>Katowice</option>
								<option>Bieruń</option>
								<option>Babice</option>
								<option>Sosnowiec</option>
					</select> 
				</td>
			</tr>
	 <tr>

			<td class="klasa2">
					Zawarta w siedzibie </td>
		 <td>
			 <input type="checkbox" checked="true" name="siedziba" value="ON" />
		 </td>
		 </tr>
			<tr>
				<td class="klasa2">
					Szablon
				</td>
				<td class="klasa4">
					<?php
						$szablon=array("Dom2016", "Dom2015", "Dom2014", "Dom2013", "Biznes2013", "Transmisja", "DzierzawaWlokien");
						$www->SelectFromArray($szablon, "szablon")
					?>					
					</select>
				</td>
			</tr>
		<tr>
				<td class="klasa2">
					Zawarta przez 
			</td>

				<td style="width: 200px;">
			<?php
				Select($QUERY12, "id_prac", $_SESSION['id_prac']);
			?>
		</td>

		</tr>
	 </tr>
			</tr>
<?php
/*
		$sth1=Query($dbh,$Q1);
	  while ($row1=$sth1->fetchRow())
		{
			$_SESSION['komp']=$komp=array(
			'nazwa_smb'	=>	$row1[0], 't_symbol'	=>$row1[1],		'dhcp'		=>$row1[2],		'ipmac'	=>$row1[3],
			'net'		=>$row1[4],			'proxy'		=>$row1[5],		'dg'	=>$row1[6],			'info'=>$row1[7], 'podlaczony' => $row1[8]	,
			'fv' => $row1[9], 'id_taryfy' => $row1[10], 'id_komp'=>$row1[11]	);

			$q2="select ip from adresy_ip, komputery where id_urz=id_komp and id_komp='$komp[id_komp]'";
			$sth2=Query($dbh,$q2);
			while ($row2=$sth2->fetchRow() )
			{
				array_push( $ip, $row2[0] );
			}
			foreach ($ip as $i)
			{
				$q3="select af.mac from adresy_fizyczne af, adresy_ip ai where af.ip=ai.ip and af.ip='$i'";
				$sth3=Query($dbh,$q3);
				while ($row3=$sth3->fetchRow() )
				array_push( $mac, $row3[0] );
			}
			include "customers/komp.php";
		}
		if ( empty($komp))
		{
		  $_SESSION['komp']=$komp;
			echo "empty";
			include "customers/komp.php";
			}
		$_SESSION['ip']=$ip;
		$_SESSION['mac']=$mac;	
		
		$sth2=Query($dbh,$Q2);
	  while ($row2=$sth2->fetchRow())
		{
			$q4="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv1]' and id_urz='$row2[0]'";
			$row4=Query2($q4, $dbh);

			$q5="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv2]' and id_urz='$row2[0]'";
			$row5=Query2($q5, $dbh);

			$q6="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv3]' and id_urz='$row2[0]'";
			$row6=Query2($q6, $dbh);

			$q7="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv5]' and id_urz='$row2[0]'";
			$row7=Query2($q7, $dbh);
			
			$q8="select fv from uslugi_dodatkowe where id_usl='$conf[addsrv6]' and id_urz='$row2[0]'";
			$row8=Query2($q8, $dbh);
	
			$_SESSION['stb']=$stb=array(
			'id_stb' 	=> $row2[0], 	  	'typ'		  => $row2[1],    'mac'							=> $row2[2], 
			'sn'			=> $row2[3],			'id_abon' => $row2[4],		'taryfa' 					=> $row2[5],
			'aktywny'	=> $row2[6],			'fv'	    => $row2[7],		'data_aktywacji' 	=> $row2[8],
			'pin' => $row2[9],
			'addsrv1' => 'N', 'addsrv1_fv' => 'N', 'addsrv2' => 'N', 'addsrv2_fv' => 'N',
			'addsrv3' => 'N', 'addsrv3_fv' => 'N', 'addsrv5' => 'N', 'addsrv5_fv' => 'N',
			'addsrv6' => 'N', 'addsrv6_fv' => 'N');

			if ( !empty($row4) )
			{
				$stb[addsrv1]='T';
				$stb[addsrv1_fv]=$row4[0];
			}
			else
			{
				$stb[addsrv1]='N';
				$stb[addsrv1_fv]='N';	
			}

			if ( !empty($row5) )
			{
				$stb[addsrv2]='T';
				$stb[addsrv2_fv]=$row5[0];
			}
			else
			{
				$stb[addsrv3]='N';
				$stb[addsrv3_fv]='N';	
			}	
			if ( !empty($row6) )
			{
				$stb[addsrv3]='T';
				$stb[addsrv3_fv]=$row6[0];
			}
			else
			{
				$stb[addsrv3]='N';
				$stb[addsrv3_fv]='N';	
			}		
			
			if ( !empty($row7) )
			{
				$stb[addsrv5]='T';
				$stb[addsrv5_fv]=$row7[0];
			}
			else
			{
				$stb[addsrv5]='N';
				$stb[addsrv5_fv]='N';	
			}
			
			if ( !empty($row8) )
			{
				$stb[addsrv6]='T';
				$stb[addsrv6_fv]=$row8[0];
			}
			else
			{
				$stb[addsrv6]='N';
				$stb[addsrv6_fv]='N';	
			}
	
	$_SESSION['stb']=$stb;
	
			include "customers/stb.php";
		}
		if ( empty($stb))
		{
		  $_SESSION['stb']=$stb;
			include "customers/stb.php";
			}
			
		$sth3=Query($dbh,$Q3);
	  while ($row3=$sth3->fetchRow())
		{
			$_SESSION['tlv']=$tlv=array(
			'id_tlv' 	=> $row3[0], 	'numer'						=>$row3[1], 	'aktywny'	=>$row3[2],			'fv'	=>	$row3[3], 
			'id_bmk'	=>$row3[4],		'producent'		=>$row3[5], 	'nr_seryjny'	=>$row3[6],		'taryfa'	=>$row3[7],			
			'id_abon' => $row3[8],	'data_aktywacji' 	=>$row3[9]); 
			include "customers/tel.php";
		}
		if ( empty($tlv))
			{
			$_SESSION['tlv']=$tlv;
			include "customers/tel.php";
			}
			*/
?>		
		<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Przedłuż" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>		
<tbody>
</table>
		
</form>
		
