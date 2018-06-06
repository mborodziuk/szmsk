 <?php
		
 	$q="select n.nazwa, a.ip, n.id_olt, n.typ	from olt n, inst_vlanu iv, adresy_ip a where iv.id_wzl=n.id_olt and a.id_urz=iv.id_ivn";
	
	WyswietlSql($q);				  
  $s1=Query($dbh,$q);
  while ($r1=$s1->fetchRow())
	{
		echo "<br> <b> $r1[0] $r1[1] $r1[2] </b> <br>";
		$host=$r1[1];
		if ( $r1[3]=="GEPON-OLT" )
			{
				$cmd="show epon onu-information";
				$result=$ctelnet->Connect($host, $conf[tuser], $conf[tpwd]);
				switch ($result) 
					{
						case 0:
							$ctelnet->enable();
							$ctelnet->DoCommand($cmd);
							$ctelnet->display();
							$ctelnet->Disconnect();
							break;
						case 1:
							echo 'Connect failed: Unable to open network connection';
							break;
						
						case 2:
							echo 'Connect failed: Unknown host';
							break;
						
						case 3:
							echo 'Connect failed: Login failed';
							break;
						
						case 4:
							echo 'Connect failed: Your PHP version does not support PHP Telnet';
							break; 
					}
			}
		else
			{
				$cmd="show onu unauthentication";
			}
	}

	
?>

