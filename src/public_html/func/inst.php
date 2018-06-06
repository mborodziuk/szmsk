<?php


function UpdateKomp2($ID_KOMP)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$dhcp=CheckboxToTable($_POST[dhcp]);
	$powiaz_ipmac=CheckboxToTable($_POST[ipmac]);
	$inet=CheckboxToTable($_POST[inet]);
	$proxy=CheckboxToTable($_POST[proxy]);
	$antyporn=CheckboxToTable($_POST[antyporn]);
	$pgg=CheckboxToTable($_POST[przekier_gg]);
	$pftp=CheckboxToTable($_POST[przekier_ftp]);
	$pemule=CheckboxToTable($_POST[przekier_emule]);
	$pinne=CheckboxToTable($_POST[przekier_inne]);
	$podlaczony=CheckboxToTable($_POST[podlaczony]);

	$Q2="select id_konf from konfiguracje 
		where dhcp='$dhcp' and powiaz_ipmac='$powiaz_ipmac' and inet='$inet' and proxy='$proxy' and antyporn='$antyporn' 
		and przekier_gg='$pgg' and przekier_ftp='$pftp' and przekier_emule='$pemule' and przekier_inne='$pinne'";	

	$sth=Query($dbh,$Q2);	
	$row =$sth->fetchRow();
	$ID_KONF=$row[0];

	$wlasc=explode(" ", $_POST[wlasciciel]);
	$ID_ABON=$wlasc[count($wlasc)-1];

	$Q3="select id_tows from towary_sprzedaz where symbol='$_POST[taryfa]' and vat='23'";	

	$sth=Query($dbh,$Q3);	
	$row =$sth->fetchRow();
	$ID_TARYFY=$row[0];

	$mac=$_SESSION['mac'];
	$ip=$_SESSION['ip'];

	for ($i=0; $i<count($mac); $i++)
	{
		$name="mac"."$i";
		if ( !empty($_POST[$name]) )
			{
				$Q7="update adresy_fizyczne set mac='$_POST[$name]' where mac='$mac[$i]'";
// 				echo "<br/> $Q7" ;
				Query($dbh,$Q7);	
			}
		else
			{
				$Q7="delete from adresy_fizyczne where mac='$mac[$i]'";
// 				echo "<br/> $Q7" ;
				Query($dbh,$Q7);	
			}
	}

	$name="mac"."$i";
	if ( !empty($_POST[$name]) )
		for ($j=0; $j<count($ip); $j++)
			{
				$name2="ip"."$j";
				$Q7="insert into adresy_fizyczne values ('$_POST[$name]','$_POST[$name2]')";
// 				echo "<br/> $Q7" ;
				Query($dbh,$Q7);	
			}
	
	for ($i=0; $i<count($ip); $i++)
	{
		$name="ip"."$i";
		if ( !empty($_POST[$name]) )
			{	
			$Q8="update adresy_ip set ip='$_POST[$name]' where ip='$ip[$i]' and id_urz='$ID_KOMP'";
// 			echo "<br/> $Q8" ;
			Query($dbh,$Q8);	
			}
		else
			{
				$Q7="delete from adresy_ip where ip='$ip[$i]'";
// 				echo "<br/> $Q7" ;
				Query($dbh,$Q7);	
			}
	}

	$name="ip"."$i";
	if ( !empty($_POST[$name]) )
			{
				$Q7="insert into adresy_ip values ('$_POST[$name]','$_GET[komp]')";
// 				echo "<br/> $Q7" ;
				Query($dbh,$Q7);	
			}


	$Q9="	update KOMPUTERY set nazwa_smb='$_POST[nazwa]', system='$_POST[system]', id_konf='$ID_KONF', 
			id_taryfy='$ID_TARYFY', id_abon='$ID_ABON', podlaczony='$podlaczony'
			where id_komp='$ID_KOMP'";
// 	echo $Q9;
	Query($dbh,$Q9);	

}

function ListaKomputerow2()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);

	$query=
	"select k.id_komp, k.nazwa_smb, k.system, ts.symbol, a.symbol, a.nazwa
	 from komputery k, abonenci a , towary_sprzedaz ts
	 where a.id_abon=k.id_abon and ts.id_tows=k.id_taryfy order by k.id_komp";

	$sth1=Query($dbh,$query);
	while ($row1=$sth1->fetchRow())
		{
		$ip=array();
		echo "<tr>";
			{
      	echo "<td> <a href=\"index.php?panel=inst&menu=updatekomp&komp=$row1[0]\"> $row1[0] </a> </td>";
      	echo "<td> $row1[1] </td>";
			$s=Choose($row1[4], $row1[5]);
     		echo "<td> $s </td>";
      	$q2="select ip from adresy_ip, komputery where id_urz=id_komp and id_urz='$row1[0]'";
      	$sth2=Query($dbh,$q2);
      	echo "<td>";
      	while ($row2=$sth2->fetchRow() )
				{
					array_push( $ip, $row2[0] );
      			echo " $row2[0] <br>"; 
				}
      	echo "</td>";
			echo "<td>";		
      	foreach ($ip as $i)
				{
				$q3="select af.mac from adresy_fizyczne af, adresy_ip  ai where af.ip=ai.ip and af.ip='$i'";
      			$sth3=Query($dbh,$q3);
      			while ($row3=$sth3->fetchRow() )
      					echo " $row3[0] <br>"; 
      			}
			echo "</td>";
      	echo "<td> $row1[2] </td>";
      	echo "<td> $row1[3] </td>";
			echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
      }
      echo "</tr>";
		}
	
}

?>
 