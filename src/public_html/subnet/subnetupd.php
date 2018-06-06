 <?php
 
	$Q="select id_pds, adres, maska, brama, broadcast, warstwa, wykorzystana , via
					from podsieci where id_pds='$_GET[subnet]'";

	$row=Query2($Q, $dbh);

	$_SESSION['subnet']=$subneta=array(
	'id_pds' 				=> $row[0], 'adres' 	=> $row[1], 	  'maska'		  		=> $row[2],    'brama'	=> $row[3], 
	'broadcast'			=> $row[4],	'warstwa' => $row[5],			'wykorzystana' 	=> $row[6], 		'via' 	=> $row[7]);


	$www->ObjectAdd($dbh, $subnet, $subneta);
	
?>

