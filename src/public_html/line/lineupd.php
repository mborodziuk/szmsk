 <?php
	
		$Q="select distinct id_lin, typ_linii, rodz_traktu_kabel, tech_linii, pasmo_radio, przep_radio, jedn_linii, 
		pkt_a, pkt_b, ruch_szkielet, ruch_dystrybucja, ruch_dostep, nazwa					from line where id_lin='$_GET[line]'";
					
	WyswietlSql($Q);	
	
	$row=Query2($Q, $dbh);

	
	$_SESSION[$session[line][update]]=$linea=array(
	'id_lin' 							=> $row[0], 	  
	'typ_linii'		  			=> $row[1],    
	'rodzaj_traktu_kabel'	=> $row[2], 
	'tech_linii'					=> $row[3],			
	'pasmo_radio' 				=> $row[4],				
	'przep_radio' 				=> $row[5],
	'jedn_linii'					=> $row[6], 
	'pkt_a' 							=> $row[7], 
	'pkt_b' 							=> $row[8],
	'ruch_szkielet'				=> $row[9], 
	'ruch_dystrybucja'		=> $row[10],
	'ruch_dostep'					=> $row[11],
	'nazwa' 							=> $row[12]
	);
	

	$www->ObjectAdd($dbh, $line, $linea);
?>

