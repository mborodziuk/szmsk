<?php

class IPTV
{

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from settopboxy where id_stb='$k'; 
						delete from pakiety where id_urz='$k';
						delete from belong where id_urz='$k'; 
						delete from uslugi_dodatkowe where id_urz='$k'; ";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.<br>";
}

	function ListaSTB($dbh)
	{
		include "func/config.php";
		
				$q1="select s.id_stb, s.typ, s.mac, s.sn, n.nazwa, n.symbol, t.symbol, n.id_abon
				from 
				(
				(settopboxy s left join  belong b on b.id_urz=s.id_stb and b.nalezy_od <= '$conf[data]' and b.nalezy_do >= '$conf[data]')
				left join nazwy n on n.id_abon=b.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
				left join
				(pakiety  p join towary_sprzedaz t on p.id_usl=t.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]') 
				 
				on s.id_stb=p.id_urz 				
				order by id_stb;";

				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				unset($q1);
				while ( $row =$sth1->fetchRow() )
					{
						DrawTable( $lp++, $conf[table_color] );
							{	
								echo "<td> <a href=\"index.php?panel=inst&menu=updatestb&stb=$row[0]\"> $row[0] </a></td>";
								echo "<td>  $row[1] </td>";
								echo "<td> $row[2] </td>";
								echo "<td> $row[3] </td>";
								$s=Choose($row[5], $row[4]);
								echo "<td> <b> $s </b> <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[7]\"> $row[7] </a> </td>";
								echo "<td> $row[6] </td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}

	}
	
	function AddSTB($dbh)
	{
		include "func/config.php";
		$Q="select id_stb from settopboxy order by id_stb desc limit 1";
	
		$id_pkt1=FindId2($_POST[pakiet1]);
		$id_pkt2=FindId2($_POST[pakiet2]);
		$id_pkt3=FindId2($_POST[pakiet3]);
		$id_pkt4=FindId2($_POST[pakiet4]);
		$id_pkt5=FindId2($_POST[pakiet5]);
				
		$stb=array(
		'id_stb'	  			=> IncValue($dbh,$Q),  						
		'typ'							=> $_POST[typ],
		'sn'							=> $_POST[sn], 
		'mac'		  				=> $_POST[mac],										 
		'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'fv' 			  			=> CheckboxToTable($_POST[fv]),   
		'aktywny'				  => CheckboxToTable($_POST[aktywny]),
		'pin'							=> $_POST[pin],
		'id_msi' 					=> FindId2($_POST[mi]) 
		);
		
		Insert($dbh, "settopboxy", $stb);

		if ( !empty($_POST[abonent]) && $_POST[abonent]!=$conf[select] )
		{
			$blg=array(
			'id_urz'=>$stb[id_stb], 'id_abon'=>FindId2($_POST[abonent]), 'nalezy_od' => $stb[data_aktywacji], 'nalezy_do' => $conf[wazne_do]);
			Insert($dbh, "belong", $blg);
		}

		
		if ( !empty($_POST[taryfa]) && !empty($_POST[data_aktywacji]) )
		{
			$pkt=array(
			'id_urz'=>$stb[id_stb], 'id_usl'=>FindId2($_POST[taryfa]), 'aktywny_od' => $stb[data_aktywacji], 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $pkt);
		}
		if ( !empty($_POST[dzierzawa]) && !empty($_POST[data_aktywacji]) )
		{
			$pkt=array(
			'id_urz'=>$stb[id_stb], 'id_usl'=>FindId2($_POST[dzierzawa]), 'FV'=>'T', 'aktywna_od' => $stb[data_aktywacji], 'aktywna_do' => $conf[wazne_do]);
			Insert($dbh, "uslugi_dodatkowe", $pkt);
		}
		
		if ( $stb[id_taryfy] != 'USL0437')
		{
			if ( IsNull($id_pkt1)!='NULL' && CheckboxToTable($_POST[pakiet1_fv]) == 'T' )
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt1', 'T', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
			else if (  IsNull($id_pkt1)!='NULL' && CheckboxToTable($_POST[pakiet1_fv]) == 'N' )
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt1', 'N', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
				
			if (  IsNull($id_pkt2)!='NULL' && CheckboxToTable($_POST[pakiet2_fv]) == 'T' )
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt2', 'T', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
			else if (  IsNull($id_pkt2)!='NULL' && CheckboxToTable($_POST[pakiet2_fv]) == 'N' )
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt2', 'N', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
				
			if (  IsNull($id_pkt3)!='NULL' && CheckboxToTable($_POST[pakiet3_fv]) == 'T')
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt3', 'T', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
			else if (  IsNull($id_pkt3)!='NULL' && CheckboxToTable($_POST[pakiet3_fv]) == 'N' )
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt3', 'N', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
				
				
			if (  IsNull($id_pkt4)!='NULL' && CheckboxToTable($_POST[pakiet4_fv]) == 'T' )
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt4', 'T', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
			else if (  IsNull($id_pkt4)!='NULL' && CheckboxToTable($_POST[pakiet4_fv]) == 'N')
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt4', 'N', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
				
			if (  IsNull($id_pkt5)!='NULL' && CheckboxToTable($_POST[pakiet5_fv]) == 'T' )
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt5', 'T', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
			else if (  IsNull($id_pkt5)!='NULL' && CheckboxToTable($_POST[pakiet5_fv]) == 'N')
				{
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt5', 'N', '$stb[data_aktywacji]', '$conf[wazne_do]')";
					WyswietlSql($q);
					Query($dbh,$q);
				}
				
		}
			
	}

	
	function ValidateStb($dbh, $ipc)
	{
		$flag=1;
		
		if ( empty ($_POST[mi]) || $_POST[mi]== $conf[select])
        {
          echo "Błąd pola 'Miejsce instalacji' : pole jest puste <br>";
           $flag=0;
        }
		if ( empty ($_POST[typ]) )
		{
			echo "Nie wprowadzono typu <br>";
			$flag=0;
		}
		if ( empty ($_POST[sn]) )
		{
			echo "Nie wprowadzono numeru seryjnego <br>";
			$flag=0;
		}
		if (  !$ipc->ValidateMac($dbh, $_POST[mac]) )
		{
			$flag=0;
		}
		if ( $_POST[data_aktywacji] != "" )
			if ( !ValidateDate($_POST[data_aktywacji]) )
				{ 	 
					$flag=0;
				}
		return ($flag);	
	}	

	function TaryfaAdd($dbh,$id_stb, $aktywny_od=Null)
{
		include "func/config.php";
		
		
		$stb0=$_SESSION[$id_stb.$_SESSION[login]];
			
		$ID_TARYFY= FindId2($_POST[taryfa]);
		$ID_DZR= FindId2($_POST[dzierzawa]);

		if ( $stb0['id_taryfy'] != $ID_TARYFY)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];
			}
			
				$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
				
				$q="update pakiety set aktywny_do='$aktywny_do2' where id_urz='$id_stb' and aktywny_do='$conf[wazne_do]'";
				WyswietlSql($q);
				$row=Query($dbh, $q);
			

			$trf=array(
			'id_urz' 		=> $id_stb, 'id_usl' 		=> $ID_TARYFY, 	 'aktywny_od' => $aktywny_od, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $trf);
		}
		
		if ( $stb0['id_dzr'] != $ID_DZR)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];
			}
			
				$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
				
			if (IsNull($stb0['id_dzr'])!='NULL' )
			{
				$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$id_stb' and aktywna_do='$conf[wazne_do]' and id_usl in (select id_tows from towary_sprzedaz where nazwa ilike '%dzierżawa%')";
				WyswietlSql($q);
				$row=Query($dbh, $q);
			}
			
			if ( IsNull($ID_DZR)!='NULL')
			{
				$dzr=array(
				'id_urz' 		=> $id_stb, 'id_usl' 		=> $ID_DZR, 	 'fv'	=> 'T', 'aktywna_od' => $aktywny_od, 'aktywna_do' => $conf[wazne_do]);
				Insert($dbh, "uslugi_dodatkowe", $dzr);
			}
		}
	
	$this->AditionalServices($dbh, $id_stb, $stb0, $aktywny_od);
}

	function AditionalServicesNew($dbh, $id_stb, $stb, $aktywna_od=Null)
	{
		include "func/config.php";
		$stb0=$_SESSION[$id_stb.$_SESSION[login]];
//		$ud=$_SESSION[ud.$_GET[stb].$_SESSION[login]];
//		print_r($stb0);
		
		$id_pkt1=FindId2($_POST[pakiet1]);
		$id_pkt2=FindId2($_POST[pakiet2]);
		$id_pkt3=FindId2($_POST[pakiet3]);
		$id_pkt4=FindId2($_POST[pakiet4]);
		$id_pkt5=FindId2($_POST[pakiet5]);
		$id_pkt6=FindId2($_POST[pakiet6]);
		$id_pkt7=FindId2($_POST[pakiet7]);

		if ($aktywna_od == Null)
		{
			$aktywna_od=$conf[data];
			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywna_od))); 
		}
				
		if ( IsNull($id_pkt1)!='NULL' && $ud[0][pakiet1] =='N' && 	$stb[id_taryfy] != $conf[dzierzawa_stb] )
			{
				if ( CheckboxToTable($_POST[pakiet1_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt1', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[pakiet1_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt1', 'N', '$aktywna_od', '$conf[wazne_do]')";

			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( IsNull($id_pkt1)!='NULL' && $ud[0][pakiet1]  =='T' && 	$stb[id_taryfy] != $conf[dzierzawa_stb])
			{
				if ( CheckboxToTable($_POST[pakiet1_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$stb[id_stb]' and id_usl='$id_pkt1'";
				
				else if ( CheckboxToTable($_POST[pakiet1_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$stb[id_stb]' and id_usl='$id_pkt1'";
			
			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($id_pkt1) == 'N' && $ud[0][pakiet1] =='T' || 	$stb[id_taryfy] == $conf[dzierzawa_stb] )
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$stb[id_stb]' and id_usl='$id_pkt1' and aktywna_do='$conf[wazne_do]'";
			
			WyswietlSql($q);
			Query($dbh,$q);
		}
		
		if ( IsNull($id_pkt2)!='NULL' && $stb0[addsrv2] =='N' && 	$stb[id_taryfy] != $conf[dzierzawa_stb] )
			{
				if ( CheckboxToTable($_POST[pakiet2_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt2', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[pakiet2_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt2', 'N', '$aktywna_od', '$conf[wazne_do]')";
					
			WyswietlSql($q);
			Query($dbh,$q);
			}
			
		else if ( IsNull($id_pkt2)!='NULL' && $stb0[addsrv2] =='T' && 	$stb[id_taryfy] != $conf[dzierzawa_stb] )
			{
				if ( CheckboxToTable($_POST[pakiet2_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$stb[id_stb]' and id_usl='$id_pkt2'";
				
				else if ( CheckboxToTable($_POST[pakiet2_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$stb[id_stb]' and id_usl='$id_pkt2'";
			}
			
		else if ( CheckboxToTable($id_pkt2) == 'N' && $stb0[addsrv2] =='T'  || 	$stb[id_taryfy] == $conf[dzierzawa_stb])
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$stb[id_stb]' and id_usl='$id_pkt2' and aktywna_do='$conf[wazne_do]'";
			
			WyswietlSql($q);
		  Query($dbh,$q);
		}
		
		if ( IsNull($id_pkt3)!='NULL' && $stb0[addsrv3] =='N' && 	$stb[id_taryfy] != $conf[dzierzawa_stb] )
			{
				if ( CheckboxToTable($_POST[pakiet3_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt3', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[pakiet3_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt3', 'N', '$aktywna_od', '$conf[wazne_do]')";
					
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( IsNull($id_pkt3)!='NULL' && $stb0[addsrv3] =='T' && 	$stb[id_taryfy] != $conf[dzierzawa_stb] )
			{
				if ( CheckboxToTable($_POST[pakiet3_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$stb[id_stb]' and id_usl='$id_pkt3'";
				
				else if ( CheckboxToTable($_POST[pakiet3_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$stb[id_stb]' and id_usl='$id_pkt3'";
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($id_pkt3) == 'N' && $stb0[addsrv3] =='T'  || 	$stb[id_taryfy] == $conf[dzierzawa_stb])
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$stb[id_stb]' and id_usl='$id_pkt3' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			Query($dbh,$q);
		}
		
		
		if ( IsNull($id_pkt4)!='NULL' && $stb0[addsrv5] =='N' )
			{
				if ( CheckboxToTable($_POST[pakiet4_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt4', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[pakiet4_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt4', 'N', '$aktywna_od', '$conf[wazne_do]')";
					
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( IsNull($id_pkt4)!='NULL' && $stb0[addsrv5] =='T' )
			{
				if ( CheckboxToTable($_POST[pakiet4_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$stb[id_stb]' and id_usl='$id_pkt4'";
				
				else if ( CheckboxToTable($_POST[pakiet4_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$stb[id_stb]' and id_usl='$id_pkt4'";
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($id_pkt4) == 'N' && $stb0[addsrv5] =='T' )
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$stb[id_stb]' and id_usl='$id_pkt4' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			Query($dbh,$q);
		}
		
		
		if ( IsNull($id_pkt5)!='NULL' && $stb0[addsrv6] =='N' )
			{
				if ( CheckboxToTable($_POST[pakiet5_fv]) == 'T' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt5', 'T', '$aktywna_od', '$conf[wazne_do]')";
				
				else if ( CheckboxToTable($_POST[pakiet5_fv]) == 'N' )
					$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$id_pkt5', 'N', '$aktywna_od', '$conf[wazne_do]')";
					
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( IsNull($id_pkt5)!='NULL' && $stb0[addsrv6] =='T' )
			{
				if ( CheckboxToTable($_POST[pakiet5_fv]) == 'T' )
					$q="update uslugi_dodatkowe set fv='T' where id_urz='$stb[id_stb]' and id_usl='$id_pkt5'";
				
				else if ( CheckboxToTable($_POST[pakiet5_fv]) == 'N' )
					$q="update uslugi_dodatkowe set fv='N' where id_urz='$stb[id_stb]' and id_usl='$id_pkt5'";
				WyswietlSql($q);
				Query($dbh,$q);
			}
			
		else if ( CheckboxToTable($id_pkt5) == 'N' && $stb0[addsrv6] =='T' )
		{
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$stb[id_stb]' and id_usl='$id_pkt5' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			Query($dbh,$q);
		}

	}
	

	function AditionalServices($dbh, $id_stb, $stb, $aktywna_od=Null)
	{
		include "func/config.php";
		$stb0=$_SESSION[$id_stb.$_SESSION[login]];

		if ($aktywna_od == Null)
		{
			$aktywna_od=$conf[data];
			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywna_od))); 
		}
				
		function UpdSrv($dbh, $j, $stb, $stb0, $aktywna_od, $aktywny_do2)
		{
			include "func/config.php";
			$addsrv=$conf[addsrv.$j];
			if ( CheckboxToTable($_POST[addsrv.$j]) == 'T' && $stb0[addsrv.$j] =='N' && 	$stb[id_taryfy] != $conf[dzierzawa_stb] )
				{
					if ( CheckboxToTable($_POST[addsrv.$j._fv]) == 'T' )
						$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$addsrv', 'T', '$aktywna_od', '$conf[wazne_do]')";
					
					else if ( CheckboxToTable($_POST[addsrv1_fv]) == 'N' )
						$q="insert into uslugi_dodatkowe values('$stb[id_stb]', '$addsrv', 'N', '$aktywna_od', '$conf[wazne_do]')";

				WyswietlSql($q);
				Query($dbh,$q);
				}
				
			else if ( CheckboxToTable($_POST[addsrv.$j]) == 'T' && $stb0[addsrv.$j] =='T' && 	$stb[id_taryfy] != $conf[dzierzawa_stb])
				{
					if ( CheckboxToTable($_POST[addsrv.$j._fv]) == 'T' )
						$q="update uslugi_dodatkowe set fv='T' where id_urz='$stb[id_stb]' and id_usl='$addsrv'";
					
					else if ( CheckboxToTable($_POST[addsrv.$j._fv]) == 'N' )
						$q="update uslugi_dodatkowe set fv='N' where id_urz='$stb[id_stb]' and id_usl='$addsrv'";
				
				WyswietlSql($q);
				Query($dbh,$q);
				}
				
			else if ( CheckboxToTable($_POST[addsrv.$j]) == 'N' && $stb0[addsrv.$j] =='T' || 	$stb[id_taryfy] == $conf[dzierzawa_stb] )
			{
				$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$stb[id_stb]' and id_usl='$addsrv' and aktywna_do='$conf[wazne_do]'";
				
				WyswietlSql($q);
				Query($dbh,$q);
			}		
		}
		
		for ( $j=1; $j<=17; ++$j )
		{
			UpdSrv($dbh, $j, $stb, $stb0, $aktywna_od, $aktywny_do2);
		}
		
}


		
	function ChangeAbon($dbh, $id_stb0, $id_abon)
	{
		include "func/config.php";
		
		$id_stb=FindId2($_POST[stb]);

		$q="update settopboxy set
						aktywny='T',
						data_aktywacji=(select data_aktywacji from settopboxy where id_stb='$id_stb0'),
						fv=(select fv from settopboxy where id_stb='$id_stb0'),
						id_msi=(select id_msi from settopboxy where id_stb='$id_stb0') where id_stb='$id_stb';
				update settopboxy set aktywny='N', fv='N', data_aktywacji=NULL, id_msi=NULL where id_stb='$id_stb0';
				update belong 					set nalezy_do='$conf[poprzednidzien]' where id_urz='$id_stb0' and nalezy_do='$conf[wazne_do]';
				insert into belong values ('$id_stb','$id_abon', '$_POST[nalezy_od]','$conf[wazne_do]');
				update pakiety set id_urz='$id_stb' where id_urz='$id_stb0';
				update uslugi_dodatkowe set id_urz='$id_stb' where id_urz='$id_stb0'";
		WyswietlSql($q);
		$row=Query($dbh, $q);
	}

	

	function UpdateSTB($dbh, $id_stb)
	{
		include "func/config.php";
		$stb0=$_SESSION[$id_stb.$_SESSION[login]];
		
		$id_taryfy=FindId2($_POST[taryfa]);
		$id_abon=FindId2($_POST[abonent]);
		$id_dzr=FindId2($_POST[dzierzawa]);
		
		


		if (  !empty ($stb0[id_abon]) && IsNull($id_abon)=='NULL'  )
				{
					$stb=array(
						'id_stb'	  			=> $id_stb,  		
						'data_aktywacji'	=> 'NULL', 
						'fv' 			  			=> 'N',   
						'aktywny'				  => 'N',
						'id_msi' 					=> 'NULL' 
					);
					Update($dbh, "settopboxy", $stb);
					$q="update belong 					set nalezy_do='$conf[poprzednidzien]' where id_urz='$id_stb' and nalezy_do='$conf[wazne_do]';
							update pakiety 					set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_stb' and aktywny_do='$conf[wazne_do]';
							update uslugi_dodatkowe set aktywna_do='$conf[poprzednidzien]' where id_urz='$id_stb' and aktywna_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
		
		else 
		{
		
				$stb=array(
				'id_stb'	  			=> $id_stb,  											
				'typ'							=> $_POST[typ],
				'sn'							=> $_POST[sn], 
				'mac'		  				=> $_POST[mac],										
				 'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
				'fv' 			  			=> CheckboxToTable($_POST[fv]),   
				'aktywny'				  => CheckboxToTable($_POST[aktywny]),
				'pin'							=> $_POST[pin],
				'id_msi' 					=> FindId2($_POST[mi]) 
				);				
				Update($dbh, "settopboxy", $stb);


				if ( !empty ($stb0[id_abon])  && IsNull($id_abon)!='NULL'  )
				{
					$q="update belong set id_abon='$id_abon' where id_urz='$id_stb' and nalezy_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				else if (  empty ($stb0[id_abon]) && IsNull($id_abon)!='NULL' )
				{
					$q="insert into belong values ('$id_stb','$id_abon', '$stb[data_aktywacji]','$conf[wazne_do]')";		
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}

					
				if ( !empty ($stb0[id_taryfy])  && IsNull($id_taryfy)!='NULL'  )
				{
					$q="update pakiety set id_usl='$id_taryfy' where id_urz='$id_stb' and aktywny_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				else if (  empty ($stb0[id_taryfy]) && IsNull($id_taryfy)!='NULL' )
				{
					$q="insert into pakiety values ('$id_stb','$id_taryfy', '$stb[data_aktywacji]','$conf[wazne_do]')";		
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
						else if (  !empty ($stb0[id_taryfy]) && IsNull($id_taryfy)=='NULL'  )
				{
					$q="update pakiety set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_stb' and aktywny_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				

				
				if ( !empty ($stb0[id_dzr])  && IsNull($id_dzr)!='NULL'  && $id_dzr!=$stb0[id_dzr] )
				{
					$q="update uslugi_dodatkowe set id_usl='$id_dzr' where id_usl='$stb0[id_dzr]' and id_urz='$id_stb' and aktywna_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				else if (  empty ($stb0[id_dzr]) && IsNull($id_dzr)!='NULL' )
				{
					$q="insert into uslugi_dodatkowe values ('$id_stb','$id_dzr', 'T', '$stb[data_aktywacji]','$conf[wazne_do]')";		
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				else if (  !empty ($stb0[id_dzr]) && IsNull($id_dzr)=='NULL'  )
				{
					$q="update uslugi_dodatkowe set aktywna_do='$conf[poprzednidzien]' where id_urz='$id_stb' and aktywna_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				
				
		foreach ($_POST as $k => $v)
		{
			$id=explode("_", $k);
			if ( $k!="przycisk" && $id[3] == "trf" && isset($_POST[$k]))
			{
				$q3="delete from pakiety where id_urz='$id_stb' and aktywny_do='$conf[wazne_do]'";
				WyswietlSql($q3);
				Query($dbh, $q3);
		
				$q2="select id_usl, aktywny_od, aktywny_do from pakiety p where id_urz='$id_stb' order by aktywny_do desc limit 1";
	      WyswietlSql($q2);
			  $r=Query2($q2, $dbh);

				$q1="update pakiety set aktywny_do='$conf[wazne_do]' where id_usl='$r[0]' and aktywny_od='$r[1]' and aktywny_do='$r[2]'";
	      WyswietlSql($q1);
			  Query($dbh, $q1);
			}

			if ( $k!="przycisk" && $id[3] == "dzr" && isset($_POST[$k]))
			{
				$q3="delete from uslugi_dodatkowe where id_urz='$id_stb' and aktywna_do='$conf[wazne_do]' and id_usl in (select id_tows from towary_sprzedaz where nazwa ilike '%dzierżawa%')";
				WyswietlSql($q3);
				Query($dbh, $q3);
		
				$q2="select id_usl, aktywna_od, aktywna_do from uslugi_dodatkowe p where id_urz='$id_stb'  and id_usl in (select id_tows from towary_sprzedaz where nazwa ilike '%dzierżawa%') order by aktywna_do desc limit 1";
	      WyswietlSql($q2);
			  $r=Query2($q2, $dbh);

				$q1="update uslugi_dodatkowe set aktywna_do='$conf[wazne_do]' where id_usl='$r[0]' and aktywna_od='$r[1]' and aktywna_do='$r[2]'";
	      WyswietlSql($q1);
			  Query($dbh, $q1);
			}
		}
				
				$this->AditionalServices($dbh, $id_stb, $stb, $aktywna_od=Null);
			}
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

		
		return ($flag);	
	}
	

	
}	


?>
