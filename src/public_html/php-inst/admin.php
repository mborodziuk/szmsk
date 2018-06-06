<?php


function ValidateAuth()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$Q="select k.login, k.haslo, k.id_abon , a.symbol, a.nazwa from konta k, abonenci a, grupy g
		where k.id_abon=a.id_abon and k.id_gr=g.id_gr and g.uprawnienia in ('admin') and login='$_POST[login]' and haslo='$_POST[haslo]'";
	$sth=Query($dbh, $Q);
	$row=$sth->fetchRow();
//	echo "$row[0] $row[1]";
	if ( !empty($row[0]) && !empty($row[1]) )
		{	
			$sw="blabla";
			$_SESSION['id_abon']=$row[2]; //.','.md5($row[2].$sw);
			$_SESSION['login']=$row[0];
			$_SESSION['nazwa']=Choose($row[3], $row[4]);
			return 1;
		}
	else return 0;

}


function ValidateKomp($typ='')
{
	$flag=1;

	if ( empty ($_POST["wlasciciel"]))
		{ 
			echo "Błąd pola 'Właściciel' : pole jest puste <br>";
			$flag=0;
		}	
	if ( empty ($_POST["nazwa"]))
		{ 
			echo "Błąd pola 'Nazwa komputera' : pole jest puste <br>";
			$flag=0;
		}	

	$flag=0;
	for ($i=0; $i<3; ++$i)
		{
			if ( !empty ($_POST["mac$i"]) && ValidateMac( $_POST["mac$i"] ))
				{ 
					$flag=1;
				}
		}
	if ( $flag==0 )
		echo " Trzeba wpisać chciaż jeden adres fizyczny";

	$flag=0;
	for ($i=0; $i<3; ++$i)
		{
			if ( !empty ($_POST["ip$i"]) && ValidateIP( $_POST["ip$i"] ))
				{ 
					$flag=1;
				}
		}
	if ( $flag==0 )
		echo " Trzeba wpisać chciaż jeden adres IP";

	return ($flag);
}

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

function AddNewKomp()
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

	$Q8="insert into adresy_ip values('$_POST[adresip]', '$ID_KOMP')";
// 	echo $Q8;
	Query($dbh,$Q8);

	if ( !empty($_POST[mac]) )
		{
		$mac=strtolower($_POST[mac]);
		$Q9="insert into adresy_fizyczne values('$mac', '$_POST[adresip]')";
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

function UpdateKomp($ID_KOMP)
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

function ListaAbonentow()
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	$query="select a.id_abon, a.symbol, a.nazwa, u.kod, u.miasto, u.nazwa, b.numer, a.nr_mieszk, a.saldo
	 from abonenci a,ulice u, budynki b where  u.id_ul=b.id_ul and a.id_bud=b.id_bud order by a.id_abon";

	$sth1=Query($dbh,$query);
   while ($row =$sth1->fetchRow())
		{
			$q2="select telefon, tel_kom from telefony where id_podm='$row[0]'";
  			$sth2=Query($dbh,$q2);
  			$row2=$sth2->fetchRow();
  			$q3="select email from maile where id_podm='$row[0]'";
  			$sth3=Query($dbh,$q3);
  			$row3=$sth3->fetchRow();
			$q4="select count(id_komp) from komputery k, abonenci a where k.id_abon=a.id_abon and a.id_abon='$row[0]'"; 
   		$sth4=Query($dbh,$q4);
   		$row4=$sth4->fetchRow();
			$q5="select nazwa from kontakty where id_podm='$row[0]'";
   		$sth5=Query($dbh,$q5);
	   	$row5=$sth5->fetchRow();
			$q6="select t.telefon, t.tel_kom from telefony t, kontakty k where k.id_kontakt=t.id_podm and k.id_podm='$row[0]'";
   		$sth6=Query($dbh,$q6);
   		$row6=$sth6->fetchRow();
			$q7="select email from maile m, kontakty k where k.id_kontakt=m.id_podm and k.id_podm='$row[0]'";
   		$sth7=Query($dbh,$q7);
   		$row7=$sth7->fetchRow();

			echo "<tr>";
  			echo "<td> <a href=\"index.php?menu=updateabon&abon=$row[0]\"> $row[0] </a> </td>";
			$s=Choose($row[1], $row[2]);
	  		echo "<td> $s </td>";
  			echo "<td> $row[3] $row[4],<br/> ul. $row[5] $row[6]/$row[7] </td>";
  			echo "<td>";
			if ( !empty($row2[0]) )
					echo "tel.:  $row2[0] <br>";
			if ( !empty($row2[1]) )
					echo "tel.kom.:  $row2[1] <br>";
			if ( !empty($row3[0]) )
					echo "e-mail:  $row3[0]";
			echo "</td>";	
  			echo "<td>";
			if ( !empty($row5[0]) )
				echo "$row5[0] <br/>";
			if ( !empty($row6[0]) )
				echo "tel.: $row6[0] <br/>";
			if ( !empty($row6[1]) )
				echo "tel.kom.: $row6[1] <br/>";
			if ( !empty($row7[0]) )
				echo "e-mail: $row7[0] <br/>";
			echo "</td>";
   		echo "<td>";
			echo "$row4[0]";
			echo "</td>";
  			echo "<td> $row[8] </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
         echo "</tr>";
       }
}

function ListaKomputerow()
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
      	echo "<td> <a href=\"index.php?menu=updatekomp&komp=$row1[0]\"> $row1[0] </a> </td>";
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

function ListaKont()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$q1=
		"select id_konta, symbol, a.nazwa, login, haslo, data_utw, antyspam, antywir, pojemnosc
		from konta k, abonenci a, grupy g 
		where k.id_abon=a.id_abon and g.id_gr=k.id_gr order by id_konta";

	$sth1=Query($dbh,$q1);
   while ($row =$sth1->fetchRow())
		{
			echo "<tr>";
				{
					echo "<td> <a href=\"index.php?menu=updatekonto&konto=$row[0]\"> $row[0] </a></td>";
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
		"select id_konta, symbol, a.nazwa, login, haslo, data_utw, antyspam, antywir, pojemnosc
		from konta k, abonenci a, grupy g 
		where k.id_abon=a.id_abon and g.id_gr=k.id_gr order by id_konta";

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
	$q1="select v.id_vhw, v.nazwa, v.domena, v.katalog, k.login, a.symbol, a.nazwa, v.data_utw from vhost_www v, konta k, abonenci a 
			where v.id_konta=k.id_konta and k.id_abon=a.id_abon order by id_vhw";

	$sth1=Query($dbh,$q1);
   while ($row =$sth1->fetchRow())
		{
			echo "<tr>";
				{
					echo "<td> <a href=\"index.php?menu=updatevhwww&vhwww=$row[0]\"> $row[0] </a></td>";
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
	$q1="select v.id_vhf, v.nazwa, v.domena, v.katalog, v.port, k.login, a.symbol, a.nazwa, v.data_utw from vhost_ftp v, konta k, abonenci a 
			where v.id_konta=k.id_konta and k.id_abon=a.id_abon order by id_vhf";

	$sth1=Query($dbh,$q1);
   while ($row =$sth1->fetchRow())
		{
			echo "<tr>";
				{
					echo "<td> <a href=\"index.php?menu=updatevhf&vhf=$row[0]\"> $row[0] </a></td>";
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
   while ($row =$sth1->fetchRow())
		{
			echo "<tr>";
				{
					echo "<td> <a href=\"index.php?menu=updatedomene&domena=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[1] </td>";
					echo "<td> $row[2] </td>";
					echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
				}
			echo "</tr>";
      }
}

function Generate($typ)
{
	switch ($typ)
		{
			case "netgen":
				system("sudo /home/szmsk/perl/netgen.pl 1>/dev/null 2>&1", $retval);
				//echo $retval;
				break;
			case "konta":
				system("sudo /home/szmsk/perl/konta.pl 1>/dev/null 2>&1", $retval);
			//	echo $retval;
				break;
			case "vhost":
				system("sudo /home/szmsk/perl/vhost.pl 1>/dev/null 2>&1", $retval);
			//	echo $retval;
				break;
		}
}

?>
 