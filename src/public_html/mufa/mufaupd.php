 <?php
 
	$Q="select n.id_wzl, n.typ, n.nazwa, n.id_bud,  n.data_aktywacji, n.szkieletowy, n.dystrybucyjny, n.dostepowy, n.mac, a.ip, iv.id_ivn
					from (wezly n left join inst_vlanu iv on iv.id_wzl=n.id_wzl) left join adresy_ip a on a.id_urz=iv.id_ivn where n.id_wzl='$_GET[node]'";
	
	$row=Query2($Q, $dbh);

	$_SESSION['node']=$nodea=array(
	'id_wzl' 	=> $row[0], 	  'typ'		  => $row[1],    'nazwa'							=> $row[2], 
	'budynek'			=> $row[3],			'data_aktywacji' => $row[4],				'szkieletowy' 					=> $row[5],
	'dystrybucyjny'	=> $row[6], 	'dostepowy'	=> $row[7], 	'mac'	=> $row[8], 'ip' => $row[9], 'id_ivn' =>$row[10] );
	
	$www->ObjectAdd($dbh, $node, $nodea);
	
?>

