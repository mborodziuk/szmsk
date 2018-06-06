 <?php
 
	$Q="select c.id_onu, c.typ, c.mac, c.aktywne, c.data_aktywacji, p.id_usl, m.id_msi, c.id_abon
					from 
					(onu c left join pakiety p on p.id_urz=c.id_onu and  p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]')
					left join 
					miejsca_instalacji m on c.id_msi=m.id_msi
					where c.id_onu='$_GET[onu]' ";
					
	WyswietlSql($Q);
	
	$Q2="select t.id_trt, t.id_ifc1 from onu c, trakty t, interfejsy_wezla i where c.id_onu=i.id_wzl and t.id_ifc2=i.id_ifc and c.id_onu='$_GET[onu]'";
	WyswietlSql($Q2);					
	
	$Q3="select p.id_plc, p.id_ifc1 from onu o, polaczenia p, interfejsy_wezla i where o.id_onu=i.id_wzl and p.id_ifc2=i.id_ifc and o.id_onu='$_GET[onu]'";
	WyswietlSql($Q3);	
	
	$row=Query2($Q, $dbh);
	$row2=Query2($Q2, $dbh);
	$row3=Query2($Q3, $dbh);
	
$_SESSION[$session[onu][update]]=$onua=array(
	'id_onu' 			=> $row[0], 	  'typ'		  => $row[1],   'mac'	=> $row[2], 'aktywne'			=> 	$row[3],			
	'data_aktywacji' => $row[4],	'id_tows'	=> $row[5],		'id_msi'	=> $row[6], 'id_abon'			=>	$row[7], 
	'id_skt'				=>$row2[1], 		'id_trt'=> $row2[0], 	'id_plc'	=> $row3[0], 'id_ifc'=> $row3[1]
	);

/*		
	$q1="select id_ifc1 from trakty where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$_GET[onu]')";
	WyswietlSql($q1);
	$q2="select t1.id_ifc1 from trakty t1, spliter s, socket k where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$_GET[onu]')";
	WyswietlSql($q2);
	$q3="select id_ifc1 from trakty where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$_GET[onu]')";
	WyswietlSql($q3);
	$q4="select id_ifc1 from trakty where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$_GET[onu]')";
	WyswietlSql($q4);
	*/
	$www->ObjectAdd($dbh, $onu, $onua);
	
?>

