<?php

class IP extends Net_IPv4
{

function InitIp($t)
{
		$a=explode(".", $t[0]);
		$g=explode(".", $t[1]);
		$b=explode(".", $t[2]);
		$i=explode(".", $t[3]);
		
		if ( $g[3]!= 1 )
			$i[3]=1;
		else 
		{
			$i[3]=2;
		}
	$ip="$a[0].$a[1].$a[2].$i[3]";
	return "$ip";
}


// do poprawy !
function IncIp($t)
{
		$a=explode(".", $t[0]);
		$g=explode(".", $t[1]);
		$b=explode(".", $t[2]);
		$i=explode(".", $t[3]);

		
		if ( ($i[3]<252 && $g[3] == 254) || ($i[3]<=253 && $g[3] != 254) )
			++$i[3];
		else if ( $i[3]==254 )
		{
			++$i[2];
			$i[3]=1;
		}
	$ip="$i[0].$i[1].$i[2].$i[3]";
	return "$ip";
}

function LastIp($b)
{
	$i=explode(".", $b);
	--$i[3];
	--$i[3];
	$l="$i[0].$i[1].$i[2].$i[3]";
	return $l;
}


function IpBroadcast($dbh, $id_pds)
{
	$q="select adres, maska, brama, broadcast, warstwa from podsieci where id_pds='$id_pds'";
	$r=Query2($q, $dbh);

	$this->ip = $r[0];
	$this->netmask = $r[1];
	
	// calculate
	$error = $this->calculate();
	if (!is_object($error))
	{
		$b=$this->broadcast;
	}
	else
	{
		// otherwise handle error
		echo "An error occured: ".$error->getMessage();
	}
	return $b;
}


function IpGate($dbh, $id_pds)
{
	$b=$this->IpBroadcast($dbh, $id_pds);	
	
	$i=explode(".", $b);
	--$i[3];
	$g="$i[0].$i[1].$i[2].$i[3]";
	return $g;
}




function Wykorzystana($dbh, $id_pds)
{
	$pds=array(
	'id_pds'				=> $id_pds,
	'wykorzystana'	=> 'N'
	);
	Update($dbh, "podsieci", $pds);
}

function AddIp($dbh, $pds)	
{
		$a=explode(".", $pds[1]);
		$g=explode(".", $pds[2]);
		$b=explode(".", $pds[3]);
		
		$li=$this->LastIp($b);
		
		$kap=explode(".", $a);
		$k1=$kap[3];
		
		$l=$a[3];
		$flag=0;
		++$l;
		
		$q="select ip from adresy_ip where id_pds='$pds[0]'";
		WyswietlSql($q);
		$s=Query($dbh,$q);
		$b4=array();
		while ($r=$s->fetchRow())
			{
			 $ip=explode(".", $r[0]);
			 array_push($b4, $ip[3]);
			}
		if ( empty($b4) )
		{
			$ip="$a[0].$a[1].$a[2].$l";
			$flag=1;
			if ( $ip==$li )
				$this->Wykorzystana($dbh, $pds[0]);
			return($ip);
		}
		sort($b4);	
		//print_r($b4);

		foreach ( $b4 as  $v)
		{
			echo " $v != $l ?? : ";
			if( $v!=$l )
				{
					echo "T <br>";
					$ip="$a[0].$a[1].$a[2].$l";
					$flag=1;
					if ( $ip==$li )
						$this->Wykorzystana($dbh, $pds[0]);
					return($ip);
				}
			else
			{
				echo "N <br>";
			}
				++$l;
		}
		if ( $flag == 0 )
		{
			$max=max($b4);
			++$max;
			$ip="$a[0].$a[1].$a[2].$max";
			if ( $ip==$li )
				$this->Wykorzystana($dbh, $pds[0]);
			return($ip);
		}
			

	
//	else 
	//	$ip=$this->InitIp($a);
	/*
	    $Q8="insert into adresy_ip values('$_POST[ip0]', '$id_komp', '$id_pds')";
		//      echo $Q8;
		Query($dbh,$Q8);
*/
	
}

function ValidateMac($dbh, $mac)
{
	$wynik=preg_match("/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}/", $mac);
	if($wynik==0)
		 echo "Nieprawidłowy adres fizyczny !!! <br>";
	return ($wynik);
}

function ValidateIP1($ip)
{
	$wynik=1;
	$wynik=preg_match('/(^[0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/', $ip);
	if($wynik==0)
		 echo "Nieprawidłowy adres IP !!! <br>";
		 
	return ($wynik);
}

function ValidateIP2($dbh, $ip)
{
	$wynik=1;
	$wynik=$this->ValidateIP1($ip);
		 
	$q="select ip from adresy_ip where ip='$ip'";	
	$r=Query2($q, $dbh);
	if (!empty($r))
	{
		echo "Adres IP $ip został już wprowadzony do systemu <br>";
		$wynik=0;
	}
	
	return ($wynik);
}


}	


?>
