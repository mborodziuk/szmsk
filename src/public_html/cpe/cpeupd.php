 <?php
 
 
	$Q="select c.id_cpe, c.typ, c.mac, c.aktywne, c.data_aktywacji, p.id_usl, m.id_msi, c.id_abon
					from 
					(cpe c left join pakiety p on p.id_urz=c.id_cpe and  p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]')
					left join 
					miejsca_instalacji m on c.id_msi=m.id_msi
					where c.id_cpe='$_GET[cpe]' ";
					
	WyswietlSql($Q);
	
	$Q2="select t.id_trt, t.id_ifc1 from cpe c, trakty t, interfejsy_wezla i where c.id_cpe=i.id_wzl and t.id_ifc2=i.id_ifc and c.id_cpe='$_GET[cpe]'";
	WyswietlSql($Q2);					
					
	$row=Query2($Q, $dbh);
	$row2=Query2($Q2, $dbh);

	$_SESSION[$session[cpe][update]]=$cpea=array(
	'id_cpe' 			=> $row[0], 	  'typ'		  => $row[1],    'mac'	=> $row[2], 'aktywne'			=> 	$row[3],			
	'data_aktywacji' => $row[4],	'id_tows'	=> $row[5],		 'id_msi'=> $row[6], 'id_abon'			=>	$row[7], 
	'id_ifc'				=>$row2[1], 		'id_trt'=> $row2[0]
	);

	$www->ObjectAdd($dbh, $cpe, $cpea);
	
?>

