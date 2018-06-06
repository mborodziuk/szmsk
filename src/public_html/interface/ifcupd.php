 <?php
 
	$Q="select i.id_ifc, i.nazwa, i.medium, i.technologia, i.przepustowosc, i.ssid,  i.rdzen, i.dystrybucja, i.dostep, i.id_wzl
			from interfejsy_wezla i where id_ifc='$_GET[ifc]'";
	
	$Q2="select id_trt, id_ifc1 from trakty where id_ifc2='$_GET[ifc]'";
	WyswietlSql($Q2);	
	
	$Q3="select id_plc, id_ifc1 from polaczenia where id_ifc2='$_GET[ifc]'";
	WyswietlSql($Q3);	
	
	$row=Query2($Q, $dbh);
	$row2=Query2($Q2, $dbh);
	$row3=Query2($Q3, $dbh);

	$_SESSION[$session[ifc][update]]=$ifca=array(
	'id_ifc' 	=> $row[0], 	  'nazwa'		  => $row[1],    'medium'							=> $row[2], 
	'technologia'			=> $row[3],			'przepustowosc' => $row[4],				'ssid' 					=> $row[5],
	'rdzen'	=> $row[6],  'dystrybucja'	=> $row[7], 'dostep'	=> $row[8], 	'id_wzl'	=> $row[9], 
	'id_trt' => $row2[0], 'id_skt1' => $row2[1], 'id_plc' => $row3[0], 'id_ifc1' => $row3[1]);


	$www->ObjectAdd($dbh, $ifc, $ifca);
	
?>

