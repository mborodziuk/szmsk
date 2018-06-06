<?php


function CheckHowMany($Q)
{
 	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$sth=Query($dbh,$Q);
	$row =$sth->fetchRow();
	return ($row[0]);
}

function ValidateAbon2()
{
	$flag=1;

	if ( empty ($_POST["a_teldom"]) && empty ($_POST["a_telkom"])&& empty ($_POST["k_telkom"])&& empty ($_POST["k_telkom"]) )
	{ 	 
		echo "Nie podano żadnego numeru telefonu Abonenta";
		$flag=0;
	}
	
	return ($flag);	
}

/*function ValidateKomp()
{
	$flag=1;

	if ( empty ($_POST["mac0"]) && empty ($_POST["mac1"]))
		{ 
		echo "Błąd pola 'Adres fizyczny' : pole jest puste <br>";
		$flag=0;
		}	

	if ( !empty ($_POST["mac0"]) && !ValidateMac($_POST["mac0"]))
		{ 
			$flag=0;
		}	
	if ( !empty ($_POST["mac1"]) && !ValidateMac($_POST["mac1"]))
		{ 
			$flag=0;
		}	

	return ($flag);
}
*/

function UpdateAbon2 ($ID_ABON)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	
	$nr_uma=$_POST["nr_uma1"]."/UMA/".$_POST["nr_uma2"];

	$data_zawarcia="$_POST[rok]"."-"."$_POST[miesiac]"."-"."$_POST[dzien]";
	if ($data_zawarcia[0] !="2" && $data_zawarcia[1] !="0")
		$data_zawarcia="20"."$data_zawarcia";
	
	$id_bud=FindId($dbh, $_POST[a_budynek] );
	$obowiazujaca=CheckboxToTable($_POST[obowiazujaca]);

	$um1			=$_SESSION['umowy'];
	$ab1			=$_SESSION['abonenci'];
	$mi1			=$_SESSION['miejsca_instalacji'];
	$wl1			=$_SESSION['wlasciciele'];
	$tela1		=$_SESSION['telefony_a'];
	$mailea1		=$_SESSION['maile_a'];
	$kontakt1	=$_SESSION['kontakty'];
	$telk1		=$_SESSION['telefony_k'];
	$mailek1		=$_SESSION['maile_k'];


	$tela2=array ('telefon'=> IsNull($_POST[a_teldom]), 'tel_kom'=> IsNull($_POST[a_telkom]), 'id_podm' => $abonenci1[id_abon] );
	if ( !empty($tela1[telefon]) || !empty($tela1[tel_kom]) )
		{
			if ( !empty($tela2[telefon]) || !empty($tela2[tel_kom]) )
				$Q="update TELEFONY set telefon=$tela2[telefon], tel_kom=$tela2[tel_kom] where id_podm='$ab1[id_abon]'";
			else
				$Q="insert into TELEFONY values ('0-32', $tela2[telefon], $tela2[tel_kom], '$ab1[id_abon]')"; 
		echo "$Q<br/>"; 
		Query($dbh, $Q);
		}

	if ( !empty($_POST[a_email]) )
		{
			if ( !empty($mailea1[email]) )
				$Q="update MAILE set email='$_POST[a_email]' where id_podm='$ab1[id_abon]'";
			else
				$Q="insert into MAILE values ('$_POST[a_email]', '$ab1[id_abon]' )";
			echo "$Q<br/>"; 
			Query($dbh, $Q);
		}

	$ID_K=$kontakt1[id_kontakt];
	if ( !empty($_POST[k_nazwa]) )
		{
			$k_kod=IsNull($_POST[k_kod]);
			$k_miasto=IsNull($_POST[k_miasto]);
			$k_ulica=IsNull($_POST[k_ulica]);
			$k_kod=IsNull($_POST[k_nrbud]);
			$k_nrbud=IsNull($_POST[k_nrbud]);
			$k_nrmieszk=IsNull($_POST[k_nrmieszk]);
			if ( !empty($kontakt1[nazwa]) )
				{
					$Q="update KONTAKTY set nazwa='$_POST[k_nazwa]' , kod=$k_kod, miasto=$k_miasto,
						ulica=$k_ulica , nr_bud=$k_nrbud, nr_mieszk=$k_nrmieszk where id_kontakt='$ID_K'";
				}
			else
				{
					$Q1="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
					$ID_K=IncValue($dbh,$Q1);
					$Q="insert into KONTAKTY values ('$ID_K', '$_POST[k_nazwa]', $k_kod, $k_miasto, $k_ulica, 
						$k_nrbud, $k_nrmieszk, '$ab1[id_abon]') ";
				}
			echo "$Q<br/>"; 
			Query($dbh, $Q);
			if ( !empty($_POST[k_teldom]) || !empty($_POST[k_telkom]) )
				{
					$teldom=IsNull($_POST[k_teldom]);
					$telkom=IsNull($_POST[k_telkom]);
					if ( !empty($telk1[telefon]) || !empty($telk2[tel_kom]) )
						$Q="update TELEFONY set telefon=$teldom, tel_kom=$telkom where id_podm='$ID_K'";
					else
						$Q="insert into TELEFONY values ('0-32', $teldom, $telkom, '$ID_K')";
					echo "$Q<br/>"; 
					Query($dbh, $Q);
				}
			if ( empty($_POST[k_teldom]) && empty($_POST[k_telkom]) && (!empty($telk1[telefon]) || !empty($telk1[tel_kom])) )
				{
					$Q="delete from TELEFONY where id_podm='$ID_K'";
					echo "$Q<br/>"; 
					Query($dbh, $Q);
				}
			if ( !empty($_POST[k_email]) )
				{
					if ( !empty($mailek1[email]) )
						$Q="update MAILE  set email='$_POST[k_email]' where id_podm='$ID_K'";
					else
						$Q="insert into MAILE values ('$_POST[k_email]','$ID_K' )";
					echo "$Q<br/>"; 
					Query($dbh, $Q);
				}
			if ( empty($_POST[k_email]) && !empty($mailek1[email]) )
				{
					$Q="delete from MAILE where email='$mailek1[email]'";
					echo "$Q<br/>";
					Query($dbh, $Q);
				}
		}
	else 	if ( empty($_POST[k_nazwa]) && !empty($kontakt1[nazwa]) )
		{
			if ( !empty($telk1[telefon]) || !empty($telk1[tel_kom]) )
				{
					$Q="delete from TELEFONY where id_podm='$ID_K'";
					echo "$Q<br/>"; 
					Query($dbh, $Q);
				}

			if ( !empty($mailek1[email]) )
				{
					$Q="delete from MAILE where email='$mailek1[email]'";
					echo "$Q<br/>";
					Query($dbh, $Q);
				}

			$Q="delete from kontakty where id_kontakt='$ID_K'";
			echo "$Q<br/>";
			Query($dbh, $Q);

		}


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

	$Q2="	select distinct g.id_gr from grupy g, konta k
			where g.antyspam='$as' and g.antywir='$av' and g.pojemnosc='1024' and  g.uprawnienia in
			(select g.uprawnienia from grupy g, konta k where k.id_gr=g.id_gr and k.id_abon='$_SESSION[id_abon]')";

	$sth=Query($dbh,$Q2);	
	$row =$sth->fetchRow();
	$ID_GR=$row[0];


	$ID_ABON=$_SESSION[id_abon];

	$konta=array('id_konta'=>$ID_KONTA, 'login'=>$_POST[login], 'haslo'=> $_POST[haslo1], 'data_utw'=> $DATA_UTW, 
						'id_gr'=>$ID_GR, 'id_abon' => $ID_ABON, 'aktywne'=>$aktywne );

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

	$vhw=array(	'id_vhw'		=> $IDV, 				'nazwa'		=> $_POST[nazwa],		'domena'		=> $_POST[domena],		'katalog'=> $_POST[katalog],
					'data_utw'	=> date('Y-m-d'),		'id_konta'	=> $IDK,					'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );

	Insert($dbh, "vhost_www", $vhw);

}

function UpdateVHWWW($vhwww)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$wlasc=explode(" ", $_POST[konto]);
	$IDK=$wlasc[count($wlasc)-1];

	$vhw=array(	'id_vhw'		=> $vhwww,	'nazwa'		=> $_POST[nazwa],			'domena'		=> $_POST[domena],	'katalog'	=> $_POST[katalog],
				'id_konta'	=> $IDK,			'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );

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

	$vhf=array(	'id_vhf'		=> $IDV, 			'nazwa'		=> $_POST[nazwa],			'domena'		=> $_POST[domena],'katalog'	=> $_POST[katalog],
					'port'		=> $_POST[port],	'data_utw'	=> date('Y-m-d'),		'id_konta'	=> $IDK,					'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );
	Insert($dbh, "vhost_ftp", $vhf);
}

function UpdateVHFTP($vhftp)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	


	$wlasc=explode(" ", $_POST[konto]);
	$IDK=$wlasc[count($wlasc)-1];
	$vhf=array(	'id_vhf'		=> $vhftp,			'nazwa'		=> $_POST[nazwa],		'domena'		=> $_POST[domena],		'katalog'	=> $_POST[katalog],
					'port'		=> $_POST[port],	 'id_konta'	=> $IDK,						'aktywny' 	=> CheckboxToTable($_POST[aktywny]) );

	Update($dbh, "vhost_ftp", $vhf);

}

function UpdateKonto ($ID_KONTA)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$konta1=$_SESSION['konta'];

	$as=CheckboxToTable($_POST[antyspam]);
	$av=CheckboxToTable($_POST[antywir]);
	$aktywne=CheckboxToTable($_POST[aktywne]);

	$Q2="	select distinct g.id_gr from grupy g, konta k
			where g.antyspam='T' and g.antywir='N' and g.pojemnosc='1024' and  g.uprawnienia in
			(select g.uprawnienia from grupy g, konta k where k.id_gr=g.id_gr and k.id_konta='$ID_KONTA')";
	$sth=Query($dbh,$Q2);	
	$row =$sth->fetchRow();
	$ID_GR=$row[0];

	$wlasc=explode(" ", $_POST[wlasciciel]);
	$ID_ABON=$wlasc[count($wlasc)-1];

	$konta=array(	'id_konta'	=>$ID_KONTA, 	'haslo'		=>$_POST[haslo1], 
						'id_gr'		=>$ID_GR, 		'aktywne'	=>$aktywne);
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

function UpdateKompdeprecated($ID_KOMP)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	$antyporn=CheckboxToTable($_POST[antyporn]);
	$pgg=CheckboxToTable($_POST[przekiergg]);
	$pftp=CheckboxToTable($_POST[przekierftp]);
	$pemule=CheckboxToTable($_POST[przekieremule]);
	$pinne=CheckboxToTable($_POST[przekierinne]);

	$Q2="select id_konf from konfiguracje 
		where dhcp='T' and powiaz_ipmac='T' and inet='T' and proxy='T' and antyporn='$antyporn' 
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

	for ($i=0; $i<2; $i++)
	{
		$name="mac"."$i";
		if ( !empty($_POST[$name]) && !empty($mac[$i]) )
			{
				$Q7="update adresy_fizyczne set mac='$_POST[$name]' where mac='$mac[$i]'";
	//			echo "<br/> $Q7" ;
				Query($dbh,$Q7);	
			}
		else if ( empty($_POST[$name]) && !empty($mac[$i]) )
			{
				$Q7="delete from adresy_fizyczne where mac='$mac[$i]'";
//				echo "<br/> $Q7" ;
				Query($dbh,$Q7);	
			}
		else if ( !empty($_POST[$name]) && empty($mac[$i]) )
			for ($j=0; $j<count($ip); $j++)
				{
					$Q7="insert into adresy_fizyczne values ('$_POST[$name]','$ip[$j]')";
					//echo "<br/> $Q7" ;
					Query($dbh,$Q7);	
				}
	}

	
	$Q9="update KOMPUTERY set id_konf='$ID_KONF'	where id_komp='$ID_KOMP'";
//	echo $Q9;
	Query($dbh,$Q9);	

}


function ListaKont()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$q1=
		"select id_konta, symbol, a.nazwa, login, haslo, data_utw, antyspam, antywir, pojemnosc
		from konta k, abonenci a, grupy g 
		where k.id_abon=a.id_abon and a.id_abon='$_SESSION[id_abon]' and g.id_gr=k.id_gr order by id_konta";

	$sth1=Query($dbh,$q1);
   while ($row =$sth1->fetchRow())
		{
			echo "<tr>";
				{
					echo "<td> <a href=\"index.php?panel=abon&menu=updatekonto&konto=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[3] </td>";
					echo "<td> $row[4] </td>";
					$Q2="select alias from aliasy_email where id_konta='$row[0]'";
					$sth2=Query($dbh,$Q2);
					echo "<td>";
				   while ($row2 = $sth2->fetchRow())
						echo "$row2[0] <br/>";
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
			where v.id_konta=k.id_konta and k.id_abon=a.id_abon and k.id_abon='$_SESSION[id_abon]' order by id_vhw";

	$sth1=Query($dbh,$q1);
   while ($row =$sth1->fetchRow())
		{
			echo "<tr>";
				{
					echo "<td> <a href=\"index.php?panel=abon&menu=updatevhwww&vhwww=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[1] </td>";
					echo "<td> $row[2] </td>";
					echo "<td> $row[3] </td>";
					echo "<td> $row[4] </td>";
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
			where v.id_konta=k.id_konta and k.id_abon=a.id_abon and a.id_abon='$_SESSION[id_abon]' order by id_vhf";

	$sth1=Query($dbh,$q1);
   while ($row =$sth1->fetchRow())
		{
			echo "<tr>";
				{
					echo "<td> <a href=\"index.php?panel=abon&menu=updatevhf&vhf=$row[0]\"> $row[0] </a></td>";
					echo "<td> $row[1] </td>";
					echo "<td> $row[2] </td>";
					echo "<td> $row[3] </td>";
					echo "<td> $row[4] </td>";
					echo "<td> $row[5] </td>";
					echo "<td> $row[8] </td>";
					echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
				}
			echo "</tr>";
      }
}
?>