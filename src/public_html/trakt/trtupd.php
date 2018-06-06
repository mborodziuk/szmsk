 <?php
 
	$Q1="select id_trt, ruch_szkielet, ruch_dystrybucja, ruch_dostep, udost, kolor_kanal, id_lin, id_plc, id_ifc1, id_ifc2 
	from trakty t  where id_trt='$_GET[trt]'";
	WyswietlSql($Q1);

	$row=Query2($Q1, $dbh);

	
	$_SESSION[$session[trt][update]]=$trta=array(
	'id_trt' 						=> $row[0], 	  
	'ruch_szkielet'		  => $row[1],    
	'ruch_dystrybucja'	=> $row[2], 
	'ruch_dostep'				=> $row[3],
	'udost'							=> $row[4],
	'kolor_kanal'				=> $row[5],
	'id_lin'						=> $row[6],
	'id_plc'						=> $row[7],
	'id_ifc1'						=> $row[8],
	'id_ifc2'						=> $row[9]
	);


	$www->ObjectAdd($dbh, $trt, $trta);
	
?>

