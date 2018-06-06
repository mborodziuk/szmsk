 <?php
 
	$Q="select id_sek, azymut, szer_katowa, zasieg, id_ifc 
					from sektory where id_sek='$_GET[sector]'";

	$row=Query2($Q, $dbh);

	$_SESSION['sector']=$sectora=array(
	'id_sek' 	=> $row[0], 	  'azymut'		  => $row[1],    'szer_katowa'							=> $row[2], 
	'zasieg'			=> $row[3],			'id_ifc' => $row[4]);


	$www->ObjectAdd($dbh, $sector, $sectora);
	
?>

