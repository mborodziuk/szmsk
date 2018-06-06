 <?php
 
	$Q="select id_trf, download, upload, download_noc, upload_noc, nazwa , aktywna, download_p2p, download_max
		
					from taryfy_internet where id_trf='$_GET[taryfa]'";
	
	$row=Query2($Q, $dbh);

	$_SESSION[$session[taryfa][update]]=$taryfaa=
	array(
	'id_trf' 				=> $row[0], 	   'download'					=> $row[1], 
	'upload'				=> $row[2],		'download_noc' 	=> $row[3],		'upload_noc' 			=> $row[4],
	'nazwa'	=> $row[5], 	'aktywna' => $row[6], 'download_p2p' 	=> $row[7],		'download_max' 			=> $row[8]);
	
	$www->ObjectAdd($dbh, $taryfa, $taryfaa);
	
?>

