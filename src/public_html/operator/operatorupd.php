 <?php
 
	$Q="select nazwa, rpt, nr_np, aktywny from operator where id_opr='$_GET[opr]' ";
	WyswietlSql($Q);
	
	$row=Query2($Q, $dbh);

	
	$_SESSION[$_GET[operatora].$_SESSION[login]]=$opra=array(
	'id_opr'		=> $_GET[opr],
	'nazwa' 			=> $row[0], 	  
	'rpt'		  => $row[1],    
	'nr_np'	=> $row[2],
	'aktywny' => $row[3]
	);
	$www->ObjectAdd($dbh, $operator, $opra);
	
?>

