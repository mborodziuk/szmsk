 <?php
 
	$Q1="select id_plc, 	przep_szkielet_razem, przep_szkielet_publ, przep_dystr_razem, przep_dystr_publ, przep_dost_razem, 
	przep_dost_publ, przep_niewyk_razem, przep_niewyk_publ,  id_ifc1, id_ifc2 
	from polaczenia  where id_plc='$_GET[plc]'";
	WyswietlSql($Q1);

	$row=Query2($Q1, $dbh);

	
	$_SESSION[$session[ptc][update]]=$ptca=array(
	'id_plc' 							=> $row[0],
	'przep_szkielet_razem'=> $row[1],
	'przep_szkielet_publ' => $row[2],
	'przep_dystr_razem' 	=> $row[3],
	'przep_dystr_publ'		=> $row[4],
	'przep_dost_razem'		=>	$row[5],
	'przep_dost_publ' 		=>	$row[6],
	'przep_niewyk_razem'  =>	$row[7],
	'przep_niewyk_publ'	=>	$row[8],
	'id_ifc1'						=> $row[9],
	'id_ifc2'						=> $row[10]
	);


	$www->ObjectAdd($dbh, $plc, $plca);
	
?>

