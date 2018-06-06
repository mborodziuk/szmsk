 <?php
 
 
	$Q="select distinct s.id_sim, s.pin, s.puk, s.sn, s.active, s.date_active, s. state, s.automatic_load, s.night_rate, p.id_usl, u.id_usl, b.id_abon, s.number
					from 
					(sim s left join belong b on b.id_urz=s.id_sim and b.nalezy_od <= '$conf[data]' and b.nalezy_do >= '$conf[data]') 	
					left join 
					(pakiety p left join uslugi_dodatkowe u on p.id_urz=u.id_urz and 
					p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]' and 
					u.aktywna_od <= '$conf[data]' and u.aktywna_do >= '$conf[data]') 

					on p.id_urz=s.id_sim 
					where s.id_sim='$_GET[sim]' ";
					
	WyswietlSql($Q);
	
				
	$row=Query2($Q, $dbh);

	$_SESSION[$_GET[sim].$_SESSION[login]]=$sima=array(
	'id_sim' 			=> $row[0], 	  'pin'		  => $row[1],    'puk'	=> $row[2], 'sn'			=> 	$row[3],			
	'active' => $row[4],	'date_active'	=> $row[5],		 'state'=> $row[6], 'automatic_load'			=>	$row[7], 
	'night_rate'				=>$row[8], 		'speed'=> $row[9], 'basic_load'	=> $row[10], 'id_abon' 	=> $row[11], 'number' => $row[12]
	);

	$www->ObjectAdd($dbh, $sim, $sima);
	
?>

