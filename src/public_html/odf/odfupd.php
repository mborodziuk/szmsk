 <?php
	
		$Q="select o.id_odf, o.typ, o.nazwa, o.id_bud,  o.data_aktywacji, o.szkieletowy, o.dystrybucyjny, o.dostepowy
					from odf o where o.id_odf='$_GET[odf]'";
	WyswietlSql($Q);					
	$row=Query2($Q, $dbh);

	
	$_SESSION[$session[odf][update]]=$odfa=array(
	'id_odf' 	=> $row[0], 	  'typ'		  => $row[1],    'nazwa'							=> $row[2], 
	'budynek'			=> $row[3],			'data_aktywacji' => $row[4],				'szkieletowy' 					=> $row[5],
	'dystrybucyjny'	=> $row[6], 	'dostepowy'	=> $row[7]);
	
	if ( empty($odfa[data_aktywacji]))
		$odfa[data_aktywacji]=$conf[data];

	$www->ObjectAdd($dbh, $odf, $odfa);
?>

