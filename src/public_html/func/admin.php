<?php


function ValidateDomena()
{
	$flag=1;

	if ( empty ($_POST["nazwa"]))
		{ 
			echo "Błąd pola 'Nazwa' : pole jest puste <br>";
			$flag=0;
		}	

	if ( !empty ($_POST["nazwa"]) && !ValidateDate($_POST["data_rej"]) )
		{ 
			$flag=0;
		}	

	if ( empty ($_POST["ip"]))
		{ 
			echo "Błąd pola 'IP' : pole jest puste <br>";
			$flag=0;
		}	

	return ($flag);
}

function AddNewAccount()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$Q1="select id_konta from konta order by id_konta desc limit 1";
	$ID_KONTA=IncValue($dbh,$Q1);
	$DATA_UTW=date('Y-m-d');

	$as=CheckboxToTable($_POST[antyspam]);
	$av=CheckboxToTable($_POST[antywir]);
	$aktywne=CheckboxToTable($_POST[aktywne]);

	$Q2="select id_gr from grupy where antyspam='$as' and antywir='$av' and pojemnosc=$_POST[pojemnosc] and uprawnienia='$_POST[uprawnienia]'";	
	$sth=Query($dbh,$Q2);	
	$row =$sth->fetchRow();
	$ID_GR=$row[0];

	$wlasc=explode(" ", $_POST[wlasciciel]);
	$ID_ABON=$wlasc[count($wlasc)-1];

	$konta=array('id_konta'=>$ID_KONTA, 'login'=>$_POST[login], 'haslo'=> $_POST[haslo1], 'data_utw'=> $DATA_UTW, 
			'id_gr'=>$ID_GR, 'id_abon' => $ID_ABON, 'aktywne'=>$aktywne);

	Insert($dbh, "KONTA", $konta);
}

function AddNewVHWWW()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$Q1="select id_vhw from vhost_www order by id_vhw desc limit 1";
	$IDV=IncValue($dbh,$Q1);
	$DATA_UTW=date('Y-m-d');

	$wlasc=explode(" ", $_POST[konto]);
	$IDK=$wlasc[count($wlasc)-1];

	$vhw=array(	'id_vhw'		=> $IDV, 					'nazwa'		=> $_POST[nazwa],		'domena'		=> $_POST[domena],		'katalog'=> $_POST[katalog],
					'data_utw'	=> $_POST[data_utw],		'id_konta'	=> $IDK,					'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );

	Insert($dbh, "vhost_www", $vhw);

}

function UpdateVHWWW($vhwww)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$wlasc=explode(" ", $_POST[konto]);
	$IDK=$wlasc[count($wlasc)-1];

	$vhw=array(	'id_vhw'		=> $vhwww,		'nazwa'		=> $_POST[nazwa],			'domena'		=> $_POST[domena],	'katalog'	=> $_POST[katalog],
					'data_utw'	=> $_POST[data_utw],		'id_konta'	=> $IDK,			'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );

	Update($dbh, "vhost_www", $vhw);
}

function AddNewVHFTP()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$Q1="select id_vhf from vhost_ftp order by id_vhf desc limit 1";
	$IDV=IncValue($dbh,$Q1);
	$DATA_UTW=date('Y-m-d');
	$wlasc=explode(" ", $_POST[konto]);
	$IDK=$wlasc[count($wlasc)-1];

	$vhf=array(	'id_vhf'		=> $IDV, 			'nazwa'		=> $_POST[nazwa],			'domena'		=> $_POST[domena],	'katalog'=> $_POST[katalog],
					'port'		=> $_POST[port],	'data_utw'	=> $_POST[data_utw],		'id_konta'	=> $IDK,					'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );
	Insert($dbh, "vhost_ftp", $vhf);
}

function UpdateVHFTP($vhftp)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	


	$wlasc=explode(" ", $_POST[konto]);
	$IDK=$wlasc[count($wlasc)-1];
	$vhf=array(	'id_vhf'		=> $vhftp,			'nazwa'		=> $_POST[nazwa],		'domena'		=> $_POST[domena],		'katalog'	=> $_POST[katalog],
					'port'		=> $_POST[port],	 'data_utw'	=> $_POST[data_utw],	'id_konta'	=> $IDK,						'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );

	Update($dbh, "vhost_ftp", $vhf);

}

function AddNewKomp_deprecated()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$Q1="select id_komp from komputery order by id_komp desc limit 1";
	$ID_KOMP=IncValue($dbh,$Q1);
	$DATA_PODL=date('Y-m-d');

	$dhcp=CheckboxToTable($_POST[dhcp]);
	$powiaz_ipmac=CheckboxToTable($_POST[ipmac]);
	$inet=CheckboxToTable($_POST[inet]);
	$proxy=CheckboxToTable($_POST[proxy]);
	$antyporn=CheckboxToTable($_POST[antyporn]);
	$pgg=CheckboxToTable($_POST[przekiergg]);
	$pftp=CheckboxToTable($_POST[przekierftp]);
	$pemule=CheckboxToTable($_POST[przekieremule]);
	$pinne=CheckboxToTable($_POST[przekierinne]);
	$podlaczony=CheckboxToTable($_POST[podlaczony]);

	$Q2="select id_konf from konfiguracje 
		where dhcp='$dhcp' and powiaz_ipmac='$powiaz_ipmac' and inet='$inet' and proxy='$proxy' and antyporn='$antyporn' 
		and przekier_gg='$pgg' and przekier_ftp='$pftp' and przekier_emule='$pemule' and przekier_inne='$pinne'";	

	$sth=Query($dbh,$Q2);	
	$row =$sth->fetchRow();
	$ID_KONF=$row[0];

	$Q3="select id_tows from towary_sprzedaz where symbol='$_POST[taryfa]'";	

	$sth=Query($dbh,$Q3);	
	$row =$sth->fetchRow();
	$ID_TARYFY=$row[0];

	$wlasc=explode(" ", $_POST[wlasciciel]);
	$ID_ABON=$wlasc[count($wlasc)-1];

	$Q7="insert into KOMPUTERY values ('$ID_KOMP', '$_POST[nazwa]', '$_POST[system]', '$ID_KONF', '$ID_TARYFY', '$ID_ABON', '$DATA_PODL', '$podlaczony' )";	
	Query($dbh,$Q7);
//	echo $Q7;

	$Q8="insert into adresy_ip values('$_POST[ip0]', '$ID_KOMP')";
// 	echo $Q8;
	Query($dbh,$Q8);

	if ( !empty($_POST[mac]) )
		{
		$mac=strtolower($_POST[mac0]);
		$Q9="insert into adresy_fizyczne values('$mac', '$_POST[ip0]')";
			Query($dbh,$Q9);	
// 	echo $Q9;
		}



}

function UpdateKonto ($ID_KONTA)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$as=CheckboxToTable($_POST[antyspam]);
	$av=CheckboxToTable($_POST[antywir]);
	$aktywne=CheckboxToTable($_POST[aktywne]);
	$Q2="select id_gr from grupy where antyspam='$as' and antywir='$av' and pojemnosc=$_POST[pojemnosc] and uprawnienia='$_POST[uprawnienia]'";	
	echo $Q2;
	$sth=Query($dbh,$Q2);	
	$row =$sth->fetchRow();
	$ID_GR=$row[0];

	$wlasc=explode(" ", $_POST[wlasciciel]);
	$ID_ABON=$wlasc[count($wlasc)-1];

	$konta_old=$_SESSION['konta'];

	$konta=array(	'id_konta'	=>$ID_KONTA, 	'login'		=>$_POST[login],	 'haslo'		=>$_POST[haslo1], 'data_utw'=>$_POST[data_utw], 
			'id_gr'		=>$ID_GR, 		'id_abon'	=>$ID_ABON, 		'aktywne'	=>$aktywne);

	if ($konta[login]!=$konta_old[login])
	    $konta[login_old]=$konta_old[login];
	
	Update($dbh, "KONTA", $konta);

	$aliasy=$_SESSION['aliasy'];

	for ($i=0; $i<3 ; ++$i)
		{
			$alias="alias"."$i";
			if ( !empty($_POST[$alias]) && empty( $aliasy[$i]) )
				{	
					$DATA_UTW=date('Y-m-d');
					$Q="insert into ALIASY_EMAIL  values ('$_POST[$alias]', '$DATA_UTW', '$ID_KONTA')";
					Query($dbh, $Q);
				}
			if ( !empty($_POST[$alias]) && !empty( $aliasy[$i]) )
				{	
					$Q="update ALIASY_EMAIL set alias='$_POST[$alias]' where alias='$aliasy[$i]'";
					Query($dbh, $Q);
				}
			if ( empty($_POST[$alias]) && !empty( $aliasy[$i]) )
				{	
					$Q="delete from ALIASY_EMAIL where alias='$aliasy[$i]'";
					Query($dbh, $Q);
				}
		}
}

function UpdateKomp_deprecated($ID_KOMP)
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

	$Q3="select id_tows from towary_sprzedaz where symbol='$_POST[taryfa]'";	

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

function AddNewDomena()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$domeny=array( 'nazwa'		=> $_POST[nazwa], 		'ip'			=> $_POST[ip],		'data_rej'	=> $_POST[data_rej] );
	Insert($dbh, "domeny", $domeny);
}

function UpdateDomena($DOMENA)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$domeny=array('nazwa'		=> $_POST[nazwa], 		'ip'			=> $_POST[ip],		'data_rej'	=> $_POST[data_rej] );
	$domeny2=array( 'nazwa'		=> $DOMENA );
	Update($dbh, "domeny", $domeny, $domeny2);
}


function ListaKont($dbh)
{
	include "config.php";

	$q1=
		"select id_konta, symbol, n.nazwa, login, haslo, data_utw, antyspam, antywir, pojemnosc
		from konta k, nazwy n, grupy g 
		where k.id_abon=n.id_abon and g.id_gr=k.id_gr 
		and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
		order by id_konta";

	$sth1=Query($dbh,$q1);
	$lp=1;
   while ($row =$sth1->fetchRow())
		{
			DrawTable($lp++,$conf[table_color]);  	

				{
					echo "<td> <a href=\"index.php?panel=admin&menu=updatekonto&konto=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[3] </td>";
					echo "<td> $row[4] </td>";
					$Q2="select alias from aliasy_email where id_konta='$row[0]'";
					$sth2=Query($dbh,$Q2);
					echo "<td>";
				   while ($row2 = $sth2->fetchRow())
						echo "$row2[0] <br/>";
					echo "</td>";
					echo "<td>";
					echo Choose($row[1], $row[2]);
					echo "</td>";
					echo "<td>";
					echo TableToCheckbox($row[6],"antyspam");
					echo "</td>";
					echo "<td>"; 
					echo TableToCheckbox($row[7],"antyspam");
					echo "</td>";
					echo "<td> $row[8] </td>";
					echo "<td> $row[5] </td>";
					echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
				}
			echo "</tr>";
      }
}

function ListaAliasow()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$q1=
		"select id_konta, symbol, n.nazwa, login, haslo, data_utw, antyspam, antywir, pojemnosc
		from konta k, nazwy n, grupy g 
		where k.id_abon=n.id_abon and g.id_gr=k.id_gr order by id_konta";

	$sth1=Query($dbh,$q1);
   while ($row =$sth1->fetchRow())
		{
		echo "<tr>";
				{
				echo "<td> $row[0] </td>";
				$size=strlen( $row[2] );
     				if ( $size > 20)
     				echo "<td> $row[1] </td>";
     				else echo "<td> $row[2] </td>";
				echo "<td> $row[3] </td>";
				echo "<td> $row[4] </td>";
				echo "<td> $row[5] </td>";
				echo "<td>";
				echo TableToCheckbox($row[6],"antyspam");
				echo "</td>";
				echo "<td>"; 
				echo TableToCheckbox($row[7],"antyspam");
				echo "</td>";
				echo "<td> $row[8] </td>";
				}
            echo "</tr>";
      }
}

function ListaVHW()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$q1="select v.id_vhw, v.nazwa, v.domena, v.katalog, k.login, n.symbol, n.nazwa, v.data_utw 
			from vhost_www v, konta k, nazwy n 
			where v.id_konta=k.id_konta and k.id_abon=n.id_abon 
					and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
					order by id_vhw";

	$sth1=Query($dbh,$q1);
	$lp=1;
   while ($row =$sth1->fetchRow())
		{
			DrawTable($lp++,$conf[table_color]);  	

				{
					echo "<td> <a href=\"index.php?panel=admin&menu=updatevhwww&vhwww=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[1] </td>";
					echo "<td> $row[2] </td>";
					echo "<td> $row[3] </td>";
					echo "<td> $row[4] </td>";
					echo "<td>";
					echo Choose($row[5], $row[6]);
					echo "</td>";
					echo "<td> $row[7] </td>";
					echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
				}
			echo "</tr>";
      }
}

function ListaVHF()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$q1="select v.id_vhf, v.nazwa, v.domena, v.katalog, v.port, k.login, n.symbol, n.nazwa, v.data_utw 
			from vhost_ftp v, konta k, nazwy n 
			where v.id_konta=k.id_konta and k.id_abon=n.id_abon 
					and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
					order by id_vhf";

	$sth1=Query($dbh,$q1);
	$lp=1;
   while ($row =$sth1->fetchRow())
		{
			DrawTable($lp++,$conf[table_color]);  	

				{
					echo "<td> <a href=\"index.php?panel=admin&menu=updatevhf&vhf=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[1] </td>";
					echo "<td> $row[2] </td>";
					echo "<td> $row[3] </td>";
					echo "<td> $row[4] </td>";
					echo "<td> $row[5] </td>";
					echo "<td>";
					echo Choose($row[6], $row[7]);
					echo "</td>";
					echo "<td> $row[8] </td>";
					echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
				}
			echo "</tr>";
      }
}

function ListaDomen()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$q1="select nazwa, ip, data_rej from domeny order by nazwa";

	$sth1=Query($dbh,$q1);
	$lp=1;
   while ($row =$sth1->fetchRow())
		{
			DrawTable($lp++,$conf[table_color]);  	
				{
					echo "<td> <a href=\"index.php?panel=admin&menu=updatedomene&domena=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[1] </td>";
					echo "<td> $row[2] </td>";
					echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
				}
			echo "</tr>";
      }
}


?>
