 <?php
	
		$Q="select id_spt, typ, nazwa, wsp, data_aktywacji, asymetryczny, tlumienie
					from spliter where id_spt='$_GET[spt]'";
	WyswietlSql($Q);					
	$row=Query2($Q, $dbh);
	
	$Q2="select t.id_trt from spliter s, trakty t, socket k where t.id_ifc2=k.id_skt and k.id_odf=s.id_spt and s.id_spt='$_GET[spt]'";
	WyswietlSql($Q2);	
	
	$row=Query2($Q, $dbh);
	$row2=Query2($Q2, $dbh);
	
	$wsp=explode(",", $row[3]);
	$szer=substr($wsp[0],1,strlen($wsp[0]));
	$dl=substr($wsp[1],0,strlen($wsp[0])-1);
	
	$_SESSION[$session[spliter][update]]=$spta=array(
	'id_spt' 					=> $row[0], 	  	'typ'		  		=> $row[1],   'nazwa'							=> $row[2], 
	'data_aktywacji' 	=> $row[4],				'asymetryczny'=> $row[5],		'tlumienie' 				=> $row[6],		
	'szerokosc' 	=> $szer, 						'dlugosc' 		=> $dl,					'id_trt' 						=> $row2[0]);
	
	if ( empty($spta[data_aktywacji]))
		$spta[data_aktywacji]=$conf[data];

	$www->ObjectAdd($dbh, $spt, $spta);
?>

