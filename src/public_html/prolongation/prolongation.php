<?php

class PROLONGATION
{

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from ustalenia where id_neg='$k'; 
						delete from przedluzenia where id_prl='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.<br>";
}

	function PrlList($dbh, $p, &$www)
	{
		include "func/config.php";
					
		$data_do=explode("-", $p[data_do]);
		$m=$data_do[1];

		$rb=$data_do[0];
		$rp=$rb-1;
		
		
		$dbh=DBConnect($DBNAME1);

		if ( $p[typ]=='niezakończone')
			{
				$q="select distinct i.id_neg, p.id_prl, a.id_abon, n.symbol, n.nazwa, a.saldo, p.etap, u.kod, u.miasto, 
					u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom,  i.data_zgl, i.data_zak, i.nr_um1, i.nr_um2
					from abonenci a, ustalenia i, przedluzenia p, nazwy n, ulice u, budynki b, adresy_siedzib s, telefony t, umowy_abonenckie um, pracownicy pr
					where i.nr_um1=um.nr_um and um.id_abon=a.id_abon and a.id_abon=n.id_abon and p.id_neg=i.id_neg and pr.id_prac=i.id_prac
					and u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=s.id_abon and t.id_podm=a.id_abon
					
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
					and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'
					and i.data_zgl between '$p[data_od]' and '$p[data_do]'
					and i.zakonczone='N' and p.data_zak is null ";
			}
		else if ( $p[typ]=='zakończone')
			{
				$q="select distinct i.id_neg, a.id_abon, a.id_abon, n.symbol, n.nazwa, a.saldo, u.kod, u.miasto, 
					u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom,  i.data_zgl, i.data_zak, i.nr_um1, i.nr_um2
					from abonenci a, ustalenia i, przedluzenia p, nazwy n, ulice u, budynki b, adresy_siedzib s, telefony t, umowy_abonenckie um, pracownicy pr
					where i.nr_um1=um.nr_um and um.id_abon=a.id_abon and a.id_abon=n.id_abon and p.id_neg=i.id_neg  and pr.id_prac=i.id_prac
					and u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=s.id_abon and t.id_podm=a.id_abon
					
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
					and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'
					and i.data_zgl between '$p[data_od]' and '$p[data_do]'
					and i.zakonczone='T'";
			}
		else
			{
				$q="select distinct i.id_neg, a.id_abon, a.id_abon, n.symbol, n.nazwa, a.saldo, u.kod, u.miasto, 
					u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom,  i.data_zgl, i.data_zak, i.nr_um1, i.nr_um2
					from abonenci a, ustalenia i, przedluzenia p, nazwy n, ulice u, budynki b, adresy_siedzib s, telefony t, umowy_abonenckie um, pracownicy pr
					where i.nr_um1=um.nr_um and um.id_abon=a.id_abon and a.id_abon=n.id_abon and p.id_neg=i.id_neg  and pr.id_prac=i.id_prac
					and u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=s.id_abon and t.id_podm=a.id_abon
					
					and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'
					and s.wazne_od <= '$p[data_do]' and s.wazne_do >= '$p[data_do]'
					and i.data_zgl between '$p[data_od]' and '$p[data_do]'";
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
														
				if ($p[pracownik]!=$conf[select])
					{
						$id_prac=FindId2($p[pracownik]);
					$q.=" and pr.id_prac='$id_prac'";
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
				
				$key=array_search($row[6], $conf[negotiate]);
				DrawTable($lp++,$conf[table_color], $key, $key);
				$liczbaporzad=$lp-1;
				echo "<td><i>$liczbaporzad.</i></td>";
				echo "<td class=\"klasa4\">
				<a href=\"index.php?panel=inst&menu=negupd&neg=$row[0]\"> $row[0] </a>  <br> $row[14]
				 </td>";
				echo "<td class=\"klasa4\"> $row[15] </td>";
					
				$s=Choose($row[3], $row[4]);
					echo "<td class=\"klasa4b\"> $s <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[2]\"> $row[2] </a>  </td>";
					echo "<td class=\"klasa4\"> $row[8], ul. $row[9] $row[10]";
					
					echo "<td class=\"klasa4\">";
				if ( !empty($row[12]) )
					echo "$row[12] <br/>";
				if ( !empty($row[13]) )
					echo " $row[13] <br/>";
				echo "</td>";

				
			
				if ( $p[typ]=='niezakończone' || $p[typ]==$conf[negotiate] )
				{
					echo "<td class=\"klasa4\">";
					$www->SelectFromArray($conf[negotiate], "$row[6]-$row[0]-$row[1]-$row[16]-$row[17]", $row[6]);
					echo "</td>";
					if ( $_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin' )
					{
						echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"delete-$row[0]-$row[1]-$row[1]-$row[16]-$row[17]\"/></td>";
					}

				}
				else
				{
					echo "<td class=\"klasa4\"> $il_dni</td>";
					
				}
				echo "</tr>";
			}
							if ( $p[typ]=='zakonczone' )
				{
					$wsk=round($razem/$lp);
					$wsk2=round($razem/$lp/2);
					echo "Czas oczekiwania na przyłączenie do sieci telekomunikacyjnej: <b>$wsk dni </b><br>";
					echo "Podzielony przez dwa: <b>$wsk2 dni </b><br><br>";
				}
	}

	

	

	
	function CtrPrlAdd($dbh, &$customers, $nr_um1)
	{
			include "func/config.php";
			$q="select id_abon from umowy_abonenckie where nr_um='$nr_um1'";
			$r=Query2($q, $dbh);
			
			$data_zawarcia="$_POST[rok]"."-"."$_POST[miesiac]"."-"."$_POST[dzien]";
			if ($data_zawarcia[0] !="2" && $data_zawarcia[1] !="0")
						$data_zawarcia="20"."$data_zawarcia";

			$data_zycie="$_POST[rokz]"."-"."$_POST[miesiacz]"."-"."$_POST[dzienz]";
			if ($data_zycie[0] !="2" && $data_zycie[1] !="0")
						$data_zycie="20"."$data_zycie";
						
			if ( empty ($_POST["nr_uma1"]) )
				$nr_um2=$customers->FindLastUm($dbh, $data_zawarcia);
			else
			{
				$nr1=$this->UpdateNrUm($_POST["nr_um1"]);
				$nr_um2="$nr1"."/".$_POST["rodzaj"]."/".$_POST["nr_um2"];
			}

						
				$um=array(
				'nr_um' => $nr_um2, 'data_zaw' => $data_zawarcia, 'typ_um' => $_POST[typ_um], 'id_abon' => $r[0], 
				'status' => $_POST[status_uma], 'miejsce' => $_POST[miejsce], 'siedziba' => CheckboxToTable($_POST[siedziba]),
				'id_prac' => 	FindId2($_POST[id_prac]), 'data_zycie' => $data_zycie, 'szablon' => $_POST[szablon], 'ulga' => $_POST[ulga]
				 );

				Insert($dbh, "umowy_abonenckie", $um);
				$this->PierwszyEtap($dbh, $nr_um1, $nr_um2 );
	}
	
	function PrlEnd($dbh, $id_prl, $data_zak, $id_neg, $nr_um1, $nr_um2, $zawarta)
	{
		include "func/config.php";
		$prl=array('id_prl'=>$id_prl, 'data_zak'=>$data_zak);
		Update($dbh, "przedluzenia", $prl);
		$neg=array('id_neg'=>$id_neg, 'zakonczone'=> 'T');
		Update($dbh, "ustalenia", $neg);

		if ($zawarta)
		{
			$umowa=array('nr_um'=>$nr_um2, 'status'=> 'Obowiązująca');
			Update($dbh, "umowy_abonenckie", $umowa);
			$umowa=array('nr_um'=>$nr_um1, 'status'=> 'Rozwiązana');
			Update($dbh, "umowy_abonenckie", $umowa);
		}
		else
		{
			$umowa=array('nr_um'=>$nr_um2, 'status'=> 'Nie podpisana');
			Update($dbh, "umowy_abonenckie", $umowa);
		}


	}
	
	function PrlMake($etap, &$zlc, &$szmsk)
	{
		include "func/config.php";
		$dbh=DBConnect($DBNAME1);
		$data=date("Y-m-d");
		
		foreach ($_POST as $k => $v)
			{
				if ($k!="przycisk" )
					{
						$t=explode("-", $k);
						if ($t[0]=="delete" )
						{
								$this->PrlEnd($dbh, $t[2], $data, $t[1], $t[3], $t[4]);
						}
						
					 else if ( $t[0] != $_POST[$k] && $t[1]!="przycisk" )
						{		
								switch($v)
								{
									case "zawarta":
											$this->PrlEnd($dbh, $t[2], $data, $t[1], $t[3], $t[4], 1);
											break;
									case "rezygnacja":
											$this->PrlEnd($dbh, $t[2], $data, $t[1], $t[3], $t[4], 0);
											break;
									case "przeterminowany":
											$this->PrlEnd($dbh, $t[2], $data, $t[1], $t[3], $t[4], 0);
											break;
									default:
											$prl=array('id_prl'=>$t[2], 'data_zak'=>$data);
											Update($dbh, 'przedluzenia', $prl);
											$prl=array('id_prl'=>IncItNum($dbh, $data, "PRL"), 'data_rozp'=>$data, 'data_zak' =>'NULL', 'etap'=> $v, 'id_neg'=>$t[1]);
											Insert($dbh, "przedluzenia", $prl);
								}
						}
					}
			}
			
		echo "Wprowadzono zmiany do systemu.<br>";
	}


	
	function PierwszyEtap( $dbh, $nr_um1, $nr_um2  )
	{
			include "func/config.php";
			$data=date("Y-m-d");
			$data_zak=date("Y-m-d",time()+14*86400);
			
			$id_neg=IncItNum($dbh, $data, "NEG");
			$neg=array('id_neg'=>$id_neg, 'data_zgl'=>$data, 'nr_um1'=> $nr_um1, 'nr_um2'=> $nr_um2,'id_prac' =>$_SESSION[id_prac], 
			'zakonczone'=> 'N', 'data_zak'=>$data_zak);
			Insert($dbh, "ustalenia", $neg);
		
		$przedluzenia=array('id_prl'=>IncItNum($dbh, $data, "PRL"), 'data_rozp'=>$data, 'data_zak' =>'NULL', 'etap'=> 'telefon', 'id_neg'=>$id_neg);
		Insert($dbh, "przedluzenia", $przedluzenia);
	}
	
	


	function Zlecenie($dbh, $id_neg, &$zlc, &$szmsk)
	{
			include "func/config.php";
		$q="select id_abon from ustalenia where id_neg='$id_neg'";
		$r=Query2($q,$dbh);
		$id_abon=$r[0];
		
		//$zlc->Demontaz($dbh, $id_abon, $szmsk);
	}
	
	function Firma($dbh, $id_spw)
	{	
			include "func/config.php";
		$q="update umowy_abonenckie set status='windykowana' where id_abon in (select id_abon from sprawy_windykacyjne where id_spw='$id_spw')";
		echo "Dodano do kroku Firma <br>";
		Query($dbh,$q);
	}
	
	
	function NegValidate($dbh)
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

function NegUpd($dbh, $id_neg)
{
		include "func/config.php";	
		$nega=$_SESSION[$id_neg.$_SESSION[login]];
				
		$neg=array(
						'id_neg'	  => $id_neg,  		
						'data_zgl'	=> $_POST[data_zgl], 
						'data_zak'	=> $_POST[data_zak], 
						'opis'			=> $_POST[opis]
					);
		Update($dbh, "ustalenia", $neg);
		
	}
}

?>