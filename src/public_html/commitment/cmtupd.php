 <?php
 
	$Q="select id_cmt, id_usl, ilosc, id_abon, aktywne_od, aktywne_od
				from 
				zobowiazania  
				where id_cmt='$_GET[cmt]'  and aktywne_od <= '$conf[data]' and aktywne_do >='$conf[data]'";
	WyswietlSql($Q);
	
	$row=Query2($Q, $dbh);

	
	$_SESSION[$_GET[cmt].$_SESSION[login]]=$cmta=array(
	'id_cmt' 	=> $row[0], 'id_usl'		  => $row[1],    'ilosc'	=> $row[2],		
	'id_abon' => $row[3],	'aktywne_od' => $row[4],  'aktywne_do' => $row[5]
	);
	
	$www->ObjectAdd($dbh, $cmt, $cmta);
	
?>

