<?php

class VOIP
{

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
			$q.="	delete from pakiety where id_urz='$k'; 
						delete from uslugi_dodatkowe where id_urz='$k'; 
						delete from telefony_voip where id_tlv='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	function Minutes($s)
	{
		// przeliczac sek na min jest sens tylko powyzej 1 min
		if ($s>60)
		{
			// w php nie ma wbudowanego dzielenia calkowitego tylko reszta z dzielenia
			$r=$s%60;
			$m=($s-$r)/60;
			$minutes="$m"."m"." $r"."s";
		}
		else
		{
			$minutes="$s";
		}
		return($minutes);
	}
	
	function ListaBramek($dbh)
	{
		include "func/config.php";
				$q1="select distinct b.id_bmk, b.producent, b.model, b.nr_seryjny, b.mac, n.nazwa, n.symbol 
				from (bramki_voip b left join telefony_voip t on t.id_bmk=b.id_bmk) left join nazwy n on n.id_abon=t.id_abon
								and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]'
				order by id_bmk";

		//echo "$q1 <br>";
				$lp=1;
				$sth1=Query($dbh,$q1);
				unset($q1);
				while ( $row =$sth1->fetchRow() )
					{
						DrawTable( $lp++, $conf[table_color] );
							{	
								echo "<td> <a href=\"index.php?panel=inst&menu=updategate&bmk=$row[0]\"> $row[0] </a></td>";
								echo "<td>  $row[1] </td>";
								echo "<td> $row[2] </td>";
								echo "<td> $row[3] </td>";
								echo "<td> $row[4] </td>";
								$s=Choose($row[6], $row[5]);
								echo "<td> <b> $s </b> </td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}

	}
	
	function AddGate($dbh)
	{

		$Q="select id_bmk from bramki_voip order by id_bmk desc limit 1";
	
		$bmk=array(
		'id_bmk'					=> IncValue($dbh,$Q),  						
		'producent'				=> $_POST[producent],
		'model'						=> $_POST[model],							
		'nr_seryjny'			=> $_POST[nr_seryjny], 
		'mac'							=> $_POST[mac],
		'id_msi' 					=> FindId2($_POST[mi])  								   	 
		);
		
		Insert($dbh, "bramki_voip", $bmk);
	}

	function UpdateGate($dbh, $id_bmk)
	{
		$bmk=array(
		'id_bmk'				=> $id_bmk,  									
		'producent'			=> $_POST[producent],
		'model'					=> $_POST[model],							
		'nr_seryjny'		=> $_POST[nr_seryjny], 
		'mac'						=> $_POST[mac] ,
		'id_msi' 				=> FindId2($_POST[mi])  								   	 
		);
		
		Update($dbh, "bramki_voip", $bmk);
	}	
	
	
	function ValidateGate($dbh, $ipc)
	{
		$flag=1;
		
		if ( empty ($_POST[mi]) || $_POST[mi]== $conf[select])
        {
          echo "Błąd pola 'Miejsce instalacji' : pole jest puste <br>";
           $flag=0;
        }
		if ( empty ($_POST[producent]) )
		{
			echo "Nie wprowadzono producenta <br>";
			$flag=0;
		}
		if ( empty ($_POST[model]) )
		{
			echo "Nie wprowadzono modelu <br>";
			$flag=0;
		}
		if ( empty ($_POST[nr_seryjny]) )
		{
			echo "Nie wprowadzono numeru seryjnego <br>";
			$flag=0;
		}
		if (  !$ipc->ValidateMac($dbh, $_POST[mac]) )
		{
			$flag=0;
		}

	
		return ($flag);	
	}	

	function ListaTlv($dbh)
	{
		include "func/config.php";
		
				$q1="select t.id_tlv, t.numer, n.symbol, n.nazwa, p.id_usl, ts.symbol, n.id_abon
				from  
				(telefony_voip t left join nazwy n on n.id_abon=t.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]') 
				left join  
				(towary_sprzedaz ts join pakiety p on p.id_usl=ts.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]')
				on t.id_tlv=p.id_urz
				order by id_tlv";
				
				WyswietlSql($q1);
				
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ( $row =$sth1->fetchRow() )
					{
						DrawTable( $lp++, $conf[table_color] );
							{	
								echo "<td> <a href=\"index.php?panel=inst&menu=updatetlv&tlv=$row[0]\"> $row[0] </a></td>";
								echo "<td>  $row[1] </td>";
								$s=Choose($row[2], $row[3]);
								echo "<td> <b> $s <b> <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[6]\"> $row[6] </a> </td>";
								echo "<td> $row[5] </td>";

								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}
	}
	
	
	function AddTlv($dbh, $dbh2)
	{
		include "func/config.php";
		$Q="select id_tlv from telefony_voip order by id_tlv desc limit 1";
	
		$tlv=array(
		'id_tlv'	=> IncValue($dbh,$Q),  					'numer'			=> $_POST[numer], 								   	 'id_abon' 				=> FindId2($_POST[abonent]), 
		'id_bmk' 	=> FindId2($_POST[bramka]),			 'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'fv' 			=> CheckboxToTable($_POST[fv]), 'aktywny'		=> CheckboxToTable($_POST[aktywny])
		);	
		Insert($dbh, "telefony_voip", $tlv);
	
		$id=explode("V", $tlv['id_tlv']);
		$id_abon=explode("N", $tlv['id_abon']);
		$nr=explode(" ", $tlv['numer']);
		$numer="$nr[0]$nr[1]$nr[2]$nr[3]";	
		$login="48$numer";
		
		$tlv_lms=array(
		'id'	=> $id[1],  					'ownerid'			=> $id_abon[1],   	 'login' 				=> $login, 
		'passwd' 	=> 'klon2010',			 'phone'	=>  $numer, 
		'access' 			=> '1'
		);	
		Insert($dbh2, "voipaccounts", $tlv_lms);

		
		if ( !empty($_POST[taryfa]) && !empty($_POST[data_aktywacji]) )
		{	
			$pkt=array('id_urz'=>$tlv[id_tlv], 'id_usl'=>FindId2($_POST[taryfa]), 'aktywny_od' => $tlv[data_aktywacji], 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $pkt);
		}
		
		if ( CheckboxToTable($_POST[addsrv7]) == 'T' && CheckboxToTable($_POST[addsrv7_fv]) == 'T' )
		{
			$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv7]', 'T', '$tlv[data_aktywacji]', '$conf[wazne_do]')";
			WyswietlSql($q);
			Query($dbh,$q);
		}
		else if ( CheckboxToTable($_POST[addsrv7]) == 'T' && CheckboxToTable($_POST[addsrv7_fv]) == 'N' )
		{
			$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv7]', 'N', '$tlv[data_aktywacji]', '$conf[wazne_do]')";
			WyswietlSql($q);
			Query($dbh,$q);
		}
	
	if ( CheckboxToTable($_POST[addsrv14]) == 'T' && CheckboxToTable($_POST[addsrv14_fv]) == 'T' )
		{
			$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv14]', 'T', '$tlv[data_aktywacji]', '$conf[wazne_do]')";
			WyswietlSql($q);
			Query($dbh,$q);
		}
		else if ( CheckboxToTable($_POST[addsrv14]) == 'T' && CheckboxToTable($_POST[addsrv14_fv]) == 'N' )
		{
			$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv14]', 'N', '$tlv[data_aktywacji]', '$conf[wazne_do]')";
			WyswietlSql($q);
			Query($dbh,$q);
		}
	
	}


	function TaryfaAdd($dbh,$id_tlv, $aktywny_od=Null)
	{
		include "func/config.php";

		$tlv0=$_SESSION[$id_tlv.$_SESSION[login]];
			
		$ID_TARYFY= FindId2($_POST[taryfa]);
		if ( $tlv0['id_taryfy'] != $ID_TARYFY)
		{
//				echo "$tlv[id_taryfy] / $ID_TARYFY";
		
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];
				$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
				
				$q="update pakiety set aktywny_do='$aktywny_do2' where id_urz='$id_tlv' and aktywny_do='$conf[wazne_do]'";
				$row=Query($dbh, $q);
			}

			$trf=array(
			'id_urz' 		=> $id_tlv, 'id_usl' 		=> $ID_TARYFY, 	 'aktywny_od' => $aktywny_od, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $trf);
		}
			$this->AditionalServices($dbh, $id_tlv, $tlv, $aktywny_od);
	}
	

	

	
	function AditionalServices($dbh, $id_tlv, $tlv, $aktywna_od=Null)
	{
		include "func/config.php";
		
		$tlv0=$_SESSION[$id_tlv.$_SESSION[login]];
		
		if ($aktywna_od == Null)
		{
			$aktywna_od=$conf[data];
			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywna_od))); 
		}
				
		
		if ( CheckboxToTable($_POST[addsrv7]) == 'T' && $tlv0[addsrv7] =='N' && 	$tlv[id_taryfy] != $conf[addsrv7] )
			{
				if ( CheckboxToTable($_POST[addsrv7_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv7]', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[addsrv7_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv7]', 'N', '$aktywna_od', '$conf[wazne_do]')";

			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($_POST[addsrv7]) == 'T' && $tlv0[addsrv7] =='T' && 	$tlv[id_taryfy] != $conf[addsrv7])
			{
				if ( CheckboxToTable($_POST[addsrv7_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$tlv[id_tlv]' and id_usl='$conf[addsrv7]'";
				
				else if ( CheckboxToTable($_POST[addsrv7_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$tlv[id_tlv]' and id_usl='$conf[addsrv7]'";
			
			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($_POST[addsrv7]) == 'N' && $tlv0[addsrv7] =='T' || 	$tlv[id_taryfy] == $conf[dzierzawa_stb] )
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$tlv[id_tlv]' and id_usl='$conf[addsrv7]' and aktywna_do='$conf[wazne_do]'";
			
			WyswietlSql($q);
			Query($dbh,$q);
		}

		if ( CheckboxToTable($_POST[addsrv14]) == 'T' && $tlv0[addsrv14] =='N' && 	$tlv[id_taryfy] != $conf[addsrv14] )
			{
				if ( CheckboxToTable($_POST[addsrv14_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv14]', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[addsrv14_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$tlv[id_tlv]', '$conf[addsrv14]', 'N', '$aktywna_od', '$conf[wazne_do]')";

			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($_POST[addsrv14]) == 'T' && $tlv0[addsrv14] =='T' && 	$tlv[id_taryfy] != $conf[addsrv14])
			{
				if ( CheckboxToTable($_POST[addsrv14_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$tlv[id_tlv]' and id_usl='$conf[addsrv14]'";
				
				else if ( CheckboxToTable($_POST[addsrv14_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$tlv[id_tlv]' and id_usl='$conf[addsrv14]'";
			
			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($_POST[addsrv14]) == 'N' && $tlv0[addsrv14] =='T' || 	$tlv[id_taryfy] == $conf[dzierzawa_stb] )
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$tlv[id_tlv]' and id_usl='$conf[addsrv14]' and aktywna_do='$conf[wazne_do]'";
			
			WyswietlSql($q);
			Query($dbh,$q);
		}
		
	}
	
	
	
	function UpdateTlv($dbh, $dbh2, $id_tlv)
	{
		include "func/config.php";
		$id_taryfy=FindId2($_POST[taryfa]);
			
		$tlv0=$_SESSION[$id_tlv.$_SESSION[login]];
				
		$tlv=array(
		'id_tlv'	=> $tlv0[id_tlv],  										'numer'						=> $_POST[numer], 								   	 'id_abon' 				=> FindId2($_POST[abonent]), 
		'id_bmk' 	=> FindId2($_POST[bramka]),			 'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'fv' 			=> CheckboxToTable($_POST[fv]), 'aktywny'					=> CheckboxToTable($_POST[aktywny])
		);
	
		//print_r($tlv);		
		Update($dbh, "telefony_voip", $tlv);

		
		$id=explode("V", $tlv['id_tlv']);
		$id_abon=explode("N", $tlv['id_abon']);
		$nr=explode(" ", $tlv['numer']);
		$numer="$nr[0]$nr[1]$nr[2]$nr[3]";	
		$login="48$numer";
		
		
		$tlv_lms=array(
		'id'	=> $id[1],  					'ownerid'			=> $id_abon[1],   	 'login' 				=> $login, 
		'passwd' 	=> 'klon2010',			 'phone'	=>  $numer, 
		'access' 			=> '1'
		);	
		Update($dbh2, "voipaccounts", $tlv_lms);
		
		
		if ( !empty ($tlv0[id_taryfy])  && IsNull($id_taryfy)!='NULL'  )
		{
			$q="update pakiety set id_usl='$id_taryfy' where id_urz='$id_tlv' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if (  empty ($tlv0[id_taryfy]) && IsNull($id_taryfy)!='NULL' )
		{
			$q="insert into pakiety values ('$id_tlv','$id_taryfy', '$conf[data]','$conf[wazne_do]')";		
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
				else if (  !empty ($tlv0[id_taryfy]) && IsNull($id_taryfy)=='NULL'  )
		{
			$q="update pakiety set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_tlv' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
	
		$this->AditionalServices($dbh, $id_tlv, $tlv, $aktywna_od=Null);
				
	}
	
	function ValidateTlv()
	{
		include "func/config.php";

		$flag=1;

		if ( empty ($_POST[numer]) )
		{
			echo "Nie wprowadzono numeru telefonu <br>";
			$flag=0;
		}

		if ( $_POST[data_aktywacji] != "" )
			if ( !ValidateDate($_POST[data_aktywacji]) )
				{ 	 
					$flag=0;
				}
		
		return ($flag);	
	}
	

	function ConnectionsList($dbh, $p)
	{
		include "func/config.php";
		$idk=explode(" ", $p[abon]);
		$ida=array_pop($idk);
		$ntl=FindId2($_POST[ntl]);
		

		$q="select p.data, n.nazwa, n.symbol, n.id_abon, p.nr_zrodlowy, p.nr_docelowy, p.oplata, p.czas_polaczenia, p.rodzaj_polaczenia
						from polaczenia_voip p, nazwy n, telefony_voip t
						where t.id_abon=n.id_abon and p.nr_zrodlowy=t.numer 
						and  p.data>='$p[data_od] 00:00:00' and p.data <= '$p[data_do] 24:00:00'
						and n.wazne_od<='$p[data_od] 00:00:00' and n.wazne_do >= '$p[data_do] 24:00:00'";
						
		if (empty($p[rodzpol]) || $p[rodzpol] == "Wszystkie")
			{
				$q=$q;
			}
		else 
				$q.=" and p.rodzaj_polaczenia like '$p[rodzpol]%'";
	
			if (!empty($p[abon]) && $p[abon] !=$conf[select] )
				{
					$q.=" and n.id_abon='$ida'";
				}

		if (!empty($p[ntl]) && $p[ntl] !=$conf[select] )
				{
					$q.=" and t.id_tlv='$ntl'";
				}

				
		if (empty($p[order]) || $p[order] == "Data")
				$p[order]="p.data, n.id_abon";
		else if ($p[order] == "Nazwa abonenta")
				$p[order]="n.nazwa, n.id_abon, p.data";
		else if ($p[order] == "Opłata")
				$p[order]="p.oplata, p.data";	
		else if ($p[order] == "Numer docelowy")
				$p[order]="p.nr_docelowy, p.data";	
				
			$q.=" order by $p[order]";

		WyswietlSql($q);
		
		$lp=1;
		$oplata=0;
		$czas=0;
		$sth=Query($dbh,$q);
		while ($row =$sth->fetchRow())
				{
					$oplata+=$row[6];
					$czas+=$row[7];
				DrawTable($lp,$conf[table_color]);  	
				echo "<td> $lp. </td>";
				echo "<td> $row[0] </td>";
				$name=Choose($row[2], $row[1]);
				echo "<td> <b> $name </b> <br> $row[3]</td>";
				echo "<td> $row[4] </td>";
				echo "<td> $row[5] </td>";
				$row[6]=round($row[6], 2);
				echo "<td> $row[6] </td>";
				echo "<td> $row[7] </td>";
				echo "<td> $row[8] </td>";
        ++$lp;
				}

					
	$oplata=round($oplata, 2);
	$minutes=$this->Minutes($czas);
	DrawTable($lp++,$conf[table_color]);
				echo "<td> </td>";
				echo "<td> </td>";
				echo "<td> <b> SUMA: </b></td>";
				echo "<td> </td>";
				echo "<td> </td>"; 				
				echo "<td> <b>$oplata </b> </td>";
				echo "<td> <b> $minutes </b></td>";
				echo "<td></td>";
				echo "</tr>";
			
	}
	
}	


?>
