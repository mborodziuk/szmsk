 <?php
 
	$Q="select n.id_olt, n.typ, n.nazwa, n.id_bud,  n.data_aktywacji, n.szkieletowy, n.dystrybucyjny, n.dostepowy, n.mac, a.ip, iv.id_ivn,
	n.producent, n.rodzaj
					from (olt n left join inst_vlanu iv on iv.id_wzl=n.id_olt) left join adresy_ip a on a.id_urz=iv.id_ivn where n.id_olt='$_GET[olt]'";

	
	$row=Query2($Q, $dbh);


	$_SESSION[$session[olt][update]]=$olta=array(
	'id_olt' 				=> $row[0], 	'typ'		  				=> $row[1],   'nazwa'							=> $row[2], 
	'budynek'				=> $row[3],		'data_aktywacji' 	=> $row[4],		'szkieletowy' 			=> $row[5],
	'dystrybucyjny'	=> $row[6], 	'dostepowy'				=> $row[7], 	'mac'	=> $row[8], 'ip' => $row[9], 'id_ivn' =>$row[10],
	'producent'		  => $row[11], 	'rodzaj'		  		=> $row[12]
	);

	$www->ObjectAdd($dbh, $olt, $olta);

	
?>

