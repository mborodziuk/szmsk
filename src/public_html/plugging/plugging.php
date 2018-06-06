<?php

class PLUGGING
{

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from instalacje where id_itl='$k'; 
						delete from podlaczenia where id_itl='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.<br>";
}

	function PlgList($dbh, $p, &$www)
	{
		include "func/config.php";
					
		$data_do=explode("-", $p[data_do]);
		$m=$data_do[1];

		$rb=$data_do[0];
		$rp=$rb-1;
		
		
		$dbh=DBConnect($DBNAME1);

		if ( $p[typ]=='niewykonane' || $p[typ]==$conf[select] )
			{
				$q="select distinct i.id_itl, p.id_pdl, a.id_abon, n.symbol, n.nazwa, a.saldo, p.etap, u.kod, u.miasto, 
					u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom, i.trudnosc, i.data_zgl, i.data_zak
					from abonenci a, instalacje i, podlaczenia p, nazwy n, ulice u, budynki b, adresy_siedzib s, telefony t
					where i.id_abon=a.id_abon and a.id_abon=n.id_abon and p.id_itl=i.id_itl 
					and u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=s.id_abon and t.id_podm=a.id_abon
					
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
					and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'
					and i.data_zgl between '$p[data_od]' and '$p[data_do]'
					and i.wykonana='N' and p.data_zak is null ";
			}
		else
			{
				$q="select distinct i.id_itl, i.id_itl, a.id_abon, n.symbol, n.nazwa, a.saldo, i.id_itl, u.kod, u.miasto, 
					u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom, i.trudnosc, i.data_zgl, i.data_zak
					from abonenci a, instalacje i, nazwy n, ulice u, budynki b, adresy_siedzib s, telefony t
					where i.id_abon=a.id_abon and a.id_abon=n.id_abon 
					and u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=s.id_abon and t.id_podm=a.id_abon
					
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
					and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'
					and i.data_zgl between '$p[data_od]' and '$p[data_do]'
					and i.wykonana='T'";
			};
			
			function transform1($p)
			{	
				include "func/config.php";
				
				if ($p[etap]!=$conf[select])
					$q.=" and p.etap='$p[etap]'";
						
				if ($p[nazwa]!=$conf[select])
					$q.=" and n.nazwa like '$p[nazwa]%'";

				if ($p[ulice]!=$conf[select])
					$q.=" and u.nazwa='$p[ulice]'";
					
							if ($p[miasto]!=$conf[select])
											$q.=" and u.miasto='$p[miasto]'";
															
				if ($p[budynki]!=$conf[select])
					$q.=" and b.numer='$p[budynki]'";
														
				if ($p[saldo]!=$conf[select])
					{
						switch ( $p[saldo] )
							{
								case "< -200" :
										$q.=" and a.saldo < -200";
										break;
								case "-150 do -100" :
										$q.=" and a.saldo between -200 and -101";
										break;
								case "-100 do 0" :
										$q.=" and a.saldo between -100 and -1";
										break;
								case "0" :
										$q.=" and a.saldo=0";
										break;
								case "0 do 100" :
										$q.=" and a.saldo between 1 and 100";
										break;
								case "100 do 200" :
										$q.=" and a.saldo between 101 and 200";
										break;
								case "> 200" :
										$q.=" and a.saldo > 200";
										break;
							}
					}
					return $q;
			}
				$q.=transform1($p);
								
		$q.=" order by i.data_zak, i.data_zgl, n.nazwa";
		
		WyswietlSql($q);	
		
		$sth=Query($dbh,$q);
		$lp=1;
		$razem=0;
		 while ($row =$sth->fetchRow())
			{
				$il_dni = round((strtotime($row[16]) - strtotime($row[15])) / 86400);
				$razem+=$il_dni;
				
				$key=array_search($row[6], $conf[etapy]);
				DrawTable($lp++,$conf[table_color], $key, $key);
				$liczbaporzad=$lp-1;
				echo "<td><i>$liczbaporzad.</i></td>";
				echo "<td class=\"klasa4\">
				<a href=\"index.php?panel=inst&menu=itlupd&itl=$row[0]\"> $row[0] </a>  <br> $row[15]
				 </td>";
				echo "<td class=\"klasa4\"> $row[16] </td>";
					
				$s=Choose($row[3], $row[4]);
					echo "<td class=\"klasa4b\"> $s <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[2]\"> $row[2] </a>  </td>";
					echo "<td class=\"klasa4\"> $row[8], ul. $row[9] $row[10]";
					
					echo "<td class=\"klasa4\">";
				if ( !empty($row[12]) )
					echo "$row[12] <br/>";
				if ( !empty($row[13]) )
					echo " $row[13] <br/>";
				echo "</td>";
				echo "<td class=\"klasa4\"> $row[14] </td>";

					echo "<td class=\"klasa4\">";
			/*	echo "$row4[0]";
				while ($row8 =$sth8->fetchRow())
				{
				echo "<br> $row8[0]";
				}*/
				echo "</td>";
				
			
				if ( $p[typ]=='niewykonane' || $p[typ]==$conf[select] )
				{
					echo "<td class=\"klasa4\">";
					$www->SelectFromArray($conf[etapy], "$row[6]-$row[0]-$row[1]", $row[6]);
					echo "</td>";
					if ( $_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin' )
					{
						echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"delete-$row[0]-$row[1]\"/></td>";
					}

				}
				else
				{
					echo "<td class=\"klasa4\"> $il_dni</td>";
					
				}
				echo "</tr>";
			}
							if ( $p[typ]=='wykonane' )
				{
					$wsk=round($razem/$lp);
					$wsk2=round($razem/$lp/2);
					echo "Czas oczekiwania na przyłączenie do sieci telekomunikacyjnej: <b>$wsk dni </b><br>";
					echo "Podzielony przez dwa: <b>$wsk2 dni </b><br><br>";
				}
	}

	

	
	
	function PlgEnd($dbh, $id_pdl, $data_zak, $id_itl)
	{
		include "func/config.php";

		$pdl=array('id_pdl'=>$id_pdl, 'data_zak'=>$data_zak);
		Update($dbh, "podlaczenia", $pdl);
		$itl=array('id_itl'=>$id_itl, 'wykonana'=> 'T');
		Update($dbh, "instalacje", $itl);
	}

	function PlgNotEnd($dbh, $id_pdl, $data_zak, $id_itl)
	{
		include "func/config.php";

		$itl=array('id_itl'=>$id_itl, 'data_zak'=>$data_zak);
		Update($dbh, "instalacje", $itl);
	}
	
	
	function PlgMaking($dbh, $id_pdl, $data_zak, $id_itl)
	{
		include "func/config.php";
		$q="select n.nazwa from nazwy n, instalacje i where 
		n.id_abon=i.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]'
		and	i.id_itl='$id_itl'";
		WyswietlSql($q);
		$r=Query2($q, $dbh);
		
		$subject="Abonent $r[0] jest aktualnie podłączany do sieci.";
		$body="Abonent $r[0] jest aktualnie podłączany do sieci.";

		
		$maile=explode(";", $conf[wypowiedzenia_email]);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[szmsk_email]", $m, $subject, $body);
		}
	}
	
	
	function PlgMake($dbh, $etap, &$zlc, &$szmsk)
	{
		include "func/config.php";
		$data=date("Y-m-d");
		
		foreach ($_POST as $k => $v)
			{
				if ($k!="przycisk" )
					{
						$t=explode("-", $k);
						if ($t[0]=="delete" )
						{
								$this->PlgEnd($dbh, $t[2], $data, $t[1]);
						}
						
					 else if ( $t[0] != $v && $t[1]!="przycisk" )
						{		
								$pdl=array('id_pdl'=>$t[2], 'data_zak'=>$data);
								Update($dbh, "podlaczenia", $pdl);
								
								$pdl=array('id_pdl'=>IncItNum($dbh, $data, "PDL"), 'data_rozp'=>$data, 'data_zak' =>'NULL', 'etap'=> $v, 'id_itl'=>$t[1]);
								Insert($dbh, "podlaczenia", $pdl);

								switch($v)
								{
									case "podłączony":
										$this->PlgNotEnd($dbh, $pdl[id_pdl], $data, $t[1]);
										break;
									case "realizacja":
										$this->PlgMaking($dbh, $pdl[id_pdl], $data, $t[1]);
										break;	
									case "pu":
											$this->PlgEnd($dbh, $pdl[id_pdl], $data, $t[1]);
											break;		
								}
						}
					}
			}
			
		echo "Wprowadzono zmiany do systemu.<br>";
	}


	
	function PierwszyEtap( $dbh, $id_abon )
	{
			include "func/config.php";
			$data=date("Y-m-d");
			$data_zak=date("Y-m-d",time()+14*86400);
				
		 $id_itl=IncItNum($dbh, $data, "ITL");
			$itl=array('id_itl'=>$id_itl, 'data_zgl'=>$data, 'id_abon'=> $id_abon,'id_prac' =>'NULL', 
			'wykonana'=> 'N', 'trudnosc'=>1, 'data_zak'=>$data_zak);
			Insert($dbh, "instalacje", $itl);
		
		$podlaczenia=array('id_pdl'=>IncItNum($dbh, $data, "PDL"), 'data_rozp'=>$data, 'data_zak' =>'NULL', 'etap'=> 'nieruszany', 'id_itl'=>$id_itl);
			Insert($dbh, "podlaczenia", $podlaczenia);
	}
	
	
	function WlaczInfo()
	{
		echo "Włączono informację o nieuregulowanych płatnościach <br>";
	}

	function WlaczBlokade()
	{
		echo "Włączono blokadę dostępu do Internetu <br>";
	}

	function Zlecenie($dbh, $id_itl, &$zlc, &$szmsk)
	{
		$q="select id_abon from instalacje where id_itl='$id_itl'";
		$r=Query2($q,$dbh);
		$id_abon=$r[0];
		
		//$zlc->Demontaz($dbh, $id_abon, $szmsk);
	}
	
	function Firma($dbh, $id_spw)
	{	
		$q="update umowy_abonenckie set status='windykowana' where id_abon in (select id_abon from sprawy_windykacyjne where id_spw='$id_spw')";
		echo "Dodano do kroku Firma <br>";
		Query($dbh,$q);
	}
	
	
	function ItlValidate($dbh)
	{
		$flag=1;
		if ( ValidateDate($_POST[data_zgl]) )
				{ 	 
					$flag=1;
				}
		else
				{
					$flag=0;
				}

		return ($flag);	
	}	

function ItlUpd($dbh, $id_itl)
{
		include "func/config.php";	
		$itla=$_SESSION[$id_itl.$_SESSION[login]];
				
		$itl=array(
						'id_itl'	  => $id_itl,  		
						'data_zgl'	=> $_POST[data_zgl], 
						'data_zak'	=> $_POST[data_zak], 
						'opis'			=> $_POST[opis],
						'trudnosc'	=> $_POST[trudnosc]
					);
		Update($dbh, "instalacje", $itl);
		
	}
}

?>