 <?php
 
	$Q="select c.id_cmt, t.id_usl, c.ilosc, c.id_abon, c.aktywny_od, c.aktywny_od
				from 
				zobowiazania c left join towary_sprzedaz t on 
				c.id_usl=t.id_tows and c.aktywne_od <= '$conf[data]' and c.aktywne_do >='$conf[data]'
				where c.id_cmt='$_GET[cmt]' ";
	WyswietlSql($Q);
	
	$row=Query2($Q, $dbh);

	
	$_SESSION[$_GET[cmt].$_SESSION[login]]=$cmta=array(
	'id_cmt' 	=> $row[0], 'id_usl'		  => $row[1],    'ilosc'	=> $row[2],
	'id_abon' => $row[3],	
	'aktywne_od' => $row[4],  'aktywne_do' => $row[5]);
	
	$www->ObjectAdd($dbh, $cmt, $cmta);
	
?>

