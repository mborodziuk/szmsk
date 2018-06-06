 <?php
 
	$Q="select i.id_ivn, v.id_vln, p.id_pds, a.ip, i.id_wzl  from 
	((inst_vlanu i join vlany v on v.id_vln=i.id_vln) left join 
	(podsieci p right join adresy_ip a on a.id_pds=p.id_pds) on a.id_urz=i.id_ivn ) left join wezly w on i.id_wzl=w.id_wzl
	where i.id_ivn='$_GET[ivn]'";
	WyswietlSql($Q);
	$row=Query2($Q, $dbh);
	
	$_SESSION['ivn']=$ivna=array(
	'id_ivn' 	=> $row[0], 	  'id_vln'=>$row[1], 'id_pds'		  => $row[2],    
	'ip'				=> $row[3],   'id_wzl'	=> $row[4]);


	$www->ObjectAdd($dbh, $ivn, $ivna);
	
?>

