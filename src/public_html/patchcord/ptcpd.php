 <?php
 
	$Q1="select id_ptc id_ifc1, id_ifc2 
	from patchcord  where id_ptc='$_GET[ptc]'";
	WyswietlSql($Q1);

	$row=Query2($Q1, $dbh);

	
	$_SESSION[$session[ptc][update]]=$ptca=array(
	'id_ptc' 						=> $row[0], 	  
	'id_ifc1'						=> $row[1],
	'id_ifc2'						=> $row[2]
	);


	$www->ObjectAdd($dbh, $ptc, $ptca);
	
?>

