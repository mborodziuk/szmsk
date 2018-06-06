 <?php
 
	$Q1="select s.id_skt, s.nazwa, s.typ, t.id_trt from socket s left join trakty t on t.id_ifc1=s.id_skt where s.id_skt='$_GET[skt]'";
	WyswietlSql($Q1);
	$Q2="select s.id_skt, s.nazwa, s.typ, t.id_trt from socket s left join trakty t on t.id_ifc2=s.id_skt where s.id_skt='$_GET[skt]'";
	WyswietlSql($Q2);

	$row=Query2($Q1, $dbh);
	$ifc="id_ifc1";
	if ( empty($row[3]) )
	{
		$row=Query2($Q2, $dbh);
		$ifc="id_ifc2";
	}
	
	$_SESSION[$session[skt][update]]=$skta=array(
	'id_skt' 	=> $row[0], 	  'nazwa'		  => $row[1],    'typ'							=> $row[2], 
	'id_trt'	=> $row[3],			'id_ifc'		=> $ifc);


	$www->ObjectAdd($dbh, $skt, $skta);
	
?>

