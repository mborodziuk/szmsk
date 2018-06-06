 <?php
 
 
	$Q="select s.id_mdm, s.vendor, s.model, s.imei, s.sn, b.id_abon,  p.id_usl, s.date_active, s.active
				from 
				(modem s left join belong b on b.id_urz=s.id_mdm and b.nalezy_od <= '$conf[data]' and b.nalezy_do >='$conf[data]')
				left join
				(pakiety  p join towary_sprzedaz t on p.id_usl=t.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]') 
				 
				on s.id_mdm=p.id_urz  where s.id_mdm='$_GET[modem]' ";
	WyswietlSql($Q);
	
	$row=Query2($Q, $dbh);

	
	$_SESSION[$_GET[modem].$_SESSION[login]]=$modema=array(
	'id_mdm' 			=> $row[0], 	  'vendor'		  => $row[1],    'model'	=> $row[2], 'imei'			=> 	$row[3],			
	'sn'			=> 	$row[4], 'id_abon' => $row[5],	'id_usl'			=>	$row[6], 
	'date_active' => $row[7],  'active' => $row[8]);
	
	$www->ObjectAdd($dbh, $modem, $modema);
	
	
?>

