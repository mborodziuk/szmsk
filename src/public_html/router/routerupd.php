 <?php
 
	$Q="select s.id_rtr,s.producent, s.typ, s.mac, b.id_abon,  p.id_usl, s.data_aktywacji, s.aktywny
				from 
				(router s left join belong b on b.id_urz=s.id_rtr and b.nalezy_od <= '$conf[data]' and b.nalezy_do >='$conf[data]')
				left join
				(pakiety  p join towary_sprzedaz t on p.id_usl=t.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]') 
				 
				on s.id_rtr=p.id_urz  where s.id_rtr='$_GET[rtr]' ";
	WyswietlSql($Q);
	
	$row=Query2($Q, $dbh);

	
	$_SESSION[$_GET[rtr].$_SESSION[login]]=$rtra=array(
	'id_rtr' 			=> $row[0], 	  'producent'		  => $row[1],    'typ'	=> $row[2], 'mac'			=> 	$row[3],			
	'id_abon' => $row[4],	'id_usl'			=>	$row[5], 
	'data_aktywacji' => $row[6],  'aktywny' => $row[7]);
	
	$www->ObjectAdd($dbh, $router, $rtra);
	
?>

