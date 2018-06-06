<?php

class CPE
{

public $table=array( 
		'link' 	=> array('href' => "index.php?panel=inst&menu=cpeadd", 'name' => 'Nowy zestaw'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=deletecpe&typ=cpe'),
		'table' => array('witdh' => '1000', 'height'=>'50'),
		'row'		=> array ('Id' =>'100', 'Typ' =>'200', 'Adresy fizyczne' =>'120', 'Adresy IP winbox' =>'80', 'Abonent' =>'370', 'Węzeł' =>'100', 'Interfejs' =>'300', 'Dzierżawa' =>'100', 'Ping [ms]' => '50',  'Uptime' => '50', 'RX [MBps]' => '50', 'TX [MBps]' => '50', 'Sygnał [dBm]' => '50', 'Conf' =>'30' , '::' =>'20')
	);
	
	
function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from pakiety 			where id_urz='$k';
						
						delete from trakty where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$k');
						update komputery set id_ivn='NULL' where id_ivn in (select id_ivn from inst_vlanu 	where id_wzl='$k');
						update podsieci set wykorzystana='N' where id_pds in 
						(select id_pds from adresy_ip where id_urz in (select id_ivn from inst_vlanu where id_wzl='$k') );
						delete from adresy_ip 				where id_urz in (select id_ivn from inst_vlanu where id_wzl='$k') ;
						update podsieci set wykorzystana='N' where id_pds in (select id_pds from adresy_ip where ip in (select ip from adresy_ip where id_urz in 
						(select id_ivn from inst_vlanu where id_urz='$k')));
						delete from przyp_vlanu where id_ivn in (select id_ivn from inst_vlanu where id_wzl='$k');
						delete from inst_vlanu 	where id_wzl='$k';
						delete from interfejsy_wezla 	where id_wzl='$k';
						delete from cpe 							where id_cpe='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	

function Form($cpea)
{
	include "func/config.php";
	$q1="select i.id_ifc, i.nazwa, i.medium, i.technologia, i.przepustowosc, i.ssid, i.warstwa from interfejsy_wezla i where i.id_wzl='$cpea[id_cpe]' order by i.id_ifc";
	$q2="select iv.id_ivn, a.ip, v.tag, v.nazwa, v.opis  from (inst_vlanu iv join vlany v on iv.id_vln=v.id_vln and iv.id_wzl='$cpea[id_cpe]') left join adresy_ip a on iv.id_ivn=a.id_urz  order by iv.id_ivn";

	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane Zestawu'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Aktywny', 'name'=>'aktywne', 'value'=>$cpea[aktywne])
													),
			'input'		=> array (
													array('wyswietl' => 'Mac', 'name'=>'mac', 'size'=>'30', 'value'=>$cpea[mac]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'data_aktywacji', 'size'=>'30', 'value'=>$cpea[data_aktywacji])
													),
			'abonent'	=> array( 'value'=>$cpea[id_abon]),
			'select'		=> array (
													array('wyswietl' => 'Miejsce instalacji', 'name'=>'mi', 'size'=>'30', 'query'=>"$QUERY14", 
													'value'=>$cpea[id_msi], 'format'=>array(0=>'', 1=>'', 2=>'lok. ', 3=>'', 4=>'')),
													array('wyswietl' => 'Interfejs nadrzędny', 'name'=>'interfejs', 'size'=>'30', 'query'=>"$QA14", 'value'=>$cpea[id_ifc]),														
													array('wyswietl' => 'Dzierżawa', 'name'=>'dzierzawa', 'size'=>'30', 'query'=>"$QA22", 'value'=>$cpea[id_tows])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Producent', 'name'=>'typ', 'size'=>'40', 'tablica' => array('Mikrotik', 'Ubiquiti'), 'value'=>$cpea[producent]),
													array('wyswietl' => 'Typ', 'name'=>'typ', 'size'=>'40', 'tablica' => array('RB711', 'RB411', 'RB433'), 'value'=>$cpea[typ]),
													array('wyswietl' => 'Sieć', 'name'=>'siec', 'size'=>'40', 'tablica' => array('Mysłowice', 'Oświęcim'), 'value'=>$cpea[siec]),
													array('wyswietl' => 'Podsieć IP', 'name'=>'pds', 'size'=>'40', 'tablica' => 
													array('30 bitowa prywatna','29 bitowa prywatna','30 bitowa publiczna', '29 bitowa publiczna','28 bitowa publiczna'), 
													'value'=>$cpea[pds]),
													),
			'link' 	=> array (array('href' => "index.php?panel=inst&menu=trfcpeadd&cpe=$cpea[id_cpe]", 'name' => '>>> Nowa taryfa')),
													
			'list'		=>array (	
													array(	
													'add'		=> array ('query'=> $q1, 'type'=> 'ifc'),
													'row'		=> array ('Id' => '10',  'Nazwa' => '30', 'Medium' => '50', 'Technologia' => '100', 'Przepustowość' => '100',  'SSID' => '100', 'Warstwa' => '100' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=ifcadd", 'name' => '>>> Nowy interfejs')),
																	
													array(	
													'add'		=> array ('query'=> $q2, 'type'=> 'ivn'),
													'row'		=> array ('Id' => '10',  'Adres IP' => '100', 'Tag id' => '50', 'Nazwa' => '100', 'Opis' => '100',  'Interfejs' => '100', 'Tagowany' => '10' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=vlnadd", 'name' => '>>> Nowy vlan'))
												)	
	);
	
		if (empty ($cpea)) 
		{
			$form[form][action]='index.php?panel=inst&menu=cpeaddsnd';
			if ( empty($cpea[data_aktywacji]) )
				$form[input][1][value] = $conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=inst&menu=cpeupdsnd&cpe=$cpea[id_cpe]";		
		}
		
		return ($form);
													 
}

function PrintList($dbh)
{
		include "func/config.php";
		
	  $query="select distinct c.id_cpe, c.typ, c.mac, n.symbol, n.nazwa, n.id_abon, t.symbol, c.uptime, c.rx_rate, c.tx_rate, c.signal_strength
					from 
	
					(cpe c 	left join nazwy n on c.id_abon=n.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
					left join 
					(towary_sprzedaz t join pakiety p on t.id_tows=p.id_usl and p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]') 
					on p.id_urz=c.id_cpe order by c.signal_strength, c.id_cpe";
					
		WyswietlSql($query);				  
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
							$Q2="select n.nazwa, i1.nazwa from interfejsy_wezla i1, interfejsy_wezla i2, trakty t, nadajniki n 
				where t.id_ifc2=i2.id_ifc and t.id_ifc1=i1.id_ifc and i1.id_wzl=n.id_nad and  i2.id_wzl='$row1[0]'";
				//WyswietlSql($Q2);
				$r2=Query2($Q2, $dbh);
				
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=inst&menu=cpeupd&cpe=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
	 			    echo "<td>";
						$q2="select a.ip, a.ping from adresy_ip a, inst_vlanu iv where iv.id_ivn=a.id_urz and iv.id_wzl='$row1[0]'";
					  $sth2=Query($dbh,$q2);
						while ($row2=$sth2->fetchRow())
						{
						$ping = $row2[1];
						echo " <a href=\"winbox://$row2[0] \"> $row2[0] </a> <br>";
						}
				    echo "</td>";
	
				    $s=Choose($row1[3], $row1[4]);
				    echo "<td> <b>$s </b> <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row1[5]\"> $row1[5] </a> </td>";

				echo "<td> $r2[0] </td>";
				echo "<td> $r2[1] </td>";
				echo "<td> $row1[6] </td>";
				echo "<td> $ping </td>";
				echo "<td> $row1[7] </td>";
				echo "<td> $row1[8] </td>";
				echo "<td> $row1[9] </td>";
				echo "<td><b> $row1[10] </b></td>";

				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=dw&id_wpl=$row[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
function CpeAddValidate($dbh, $ipc)
	{
			switch ($_POST[pds])
		{
			case "30 bitowa prywatna":	
																$mask='255.255.255.252';
																$warstwa='dostep_pryw';
																break;
			case "29 bitowa prywatna":	
																$mask='255.255.255.248';
																$warstwa='dostep_pryw';
																break;
			case "30 bitowa publiczna":	
																$mask='255.255.255.252';
																$warstwa='dostep_pub';
																break;
			case "29 bitowa publiczna":	
																$mask='255.255.255.248';
																$warstwa='dostep_pub';
																break;
			case "28 bitowa publiczna":	
																$mask='255.255.255.240';
																$warstwa='dostep_pub';
																break;	
			default:
																$mask='255.255.255.252';
																$warstwa='dostep_pryw';
																break;
		};
		
		$Q="select id_pds, via from podsieci where maska='$mask' and warstwa='$warstwa' and wykorzystana='N' order by id_pds limit 1";
		$pds=Query2($Q, $dbh);
		$flag=1;
		
		if ( empty ($pds) )
		{
			echo "Brak wolnych podsieci IP typu: $_POST[pds]. <br>";
			$flag=0;
		}
		if ( empty ($_POST[interfejs]) || $_POST[interfejs]==$conf[select] )
		{
			echo "Nie wprowadzono interfejsu węzła<br>";
			$flag=0;
		}
		if ( empty ($_POST[typ]) )
		{
			echo "Nie wprowadzono typu <br>";
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


function CpeUpdValidate($dbh, $ipc)
	{

		if ( empty ($_POST[typ]) )
		{
			echo "Nie wprowadzono typu <br>";
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
	
function CpeAdd($dbh, $ipc)
{
		include "func/config.php";
		
		switch ($_POST[pds])
		{
			case "30 bitowa prywatna":	
																$mask='255.255.255.252';
																$warstwa='dostep_pryw';
																break;
			case "29 bitowa prywatna":	
																$mask='255.255.255.248';
																$warstwa='dostep_pryw';
																break;
			case "30 bitowa publiczna":	
																$mask='255.255.255.252';
																$warstwa='dostep_pub';
																break;
			case "29 bitowa publiczna":	
																$mask='255.255.255.248';
																$warstwa='dostep_pub';
																break;
			case "28 bitowa publiczna":	
																$mask='255.255.255.240';
																$warstwa='dostep_pub';
																break;	
			default:
																$mask='255.255.255.252';
																$warstwa='dostep_pryw';
																break;
		};
		
		switch ($_POST[siec])
		{
			case "Mysłowice":	
																$address='10.8.%';
																break;
			case "Oświęcim":	
																$address='10.9.%';
																break;
			default:
																$address='10.8.%';
																break;
		};		
		
		$Q1="select id_cpe from cpe order by id_cpe desc limit 1";
		$Q2="select id_ifc from interfejsy_wezla order by id_ifc desc limit 1";
		$Q3="select id_ivn from inst_vlanu order by id_ivn desc limit 1";
		$Q4="select id_trt from trakty order by id_trt desc limit 1";
		$Q5="select id_plc from polaczenia order by id_plc desc limit 1";
		$Q6="select id_lin from linie order by id_lin desc limit 1";
		$Q7="select id_pvn from przyp_vlanu 			order by id_pvn desc limit 1";
		$Q8="select id_pds, via from podsieci where maska='$mask' and warstwa='$warstwa' and adres like '$address' and wykorzystana='N' order by id_pds limit 1";

		
		$cpe=array(
		'id_cpe'	  			=> IncValue($dbh,$Q1, "CPE00000"),  			
		'typ'							=> $_POST[typ], 
		'mac'		  				=> $_POST[mac],										 
		'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'aktywne'				  => CheckboxToTable($_POST[aktywne]),		
		'id_abon' 				=> FindId2($_POST[abonent]),
		'id_msi' 					=> FindId2($_POST[mi])
		);
		Insert($dbh, "cpe", $cpe);
		
		$pkt=array(
		'id_urz'=>$cpe[id_cpe], 'id_usl'=>FindId2($_POST[dzierzawa]), 'aktywny_od' => $conf[wazne_od], 'aktywny_do' => $conf[wazne_do]);
		
		if (  !empty($_POST[dzierzawa]) && $_POST[dzierzawa]!=$conf[select] )
		{
			Insert($dbh, "pakiety", $pkt);
		}
		
			$r=Query2($Q8, $dbh);
			$id_pds=$r[0];
			$via=$r[1];
		
			$ivn4=array(
			'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
			'id_vln' 			=> 'VLN00004',
			'id_wzl' 			=> $cpe[id_cpe]
			);
			Insert($dbh, "inst_vlanu", $ivn4);
			
			
			$ip1=array(
			'id_urz'	 => $ivn4[id_ivn],  			
			'ip'			=> $via
			);
			//if ( $ipc->ValidateIP2($dbh, $ip[ip]) )
			Insert($dbh, "adresy_ip", $ip1);
			
			/*
			$kmp=array(
			'id_komp' 	=> FindId2($_POST[komputer]),
			'id_ivn'		=> $ivn4[id_ivn]
			);
			Update($dbh, "komputery", $kmp);
*/
						
			$ivn1=array(
			'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
			'id_vln' 			=> 'VLN00001',
			'id_wzl' 			=> $cpe[id_cpe]
			);
			Insert($dbh, "inst_vlanu", $ivn1);

			$ip=array(
			'id_urz'	 => $ivn1[id_ivn],  			
			'ip'			=> $ipc->IpGate($dbh, $id_pds),
			'id_pds'			=> $id_pds
			);
	//		if ( $ipc->ValidateIP2($dbh, $ip[ip]) )
			{
				Insert($dbh, "adresy_ip", $ip);		
			
			$pds=array(
				'id_pds'	 => $id_pds,  			
				'wykorzystana'			=> 'T'
				);
				Update($dbh, "podsieci", $pds);
			}
			
		
		$ifc=array(
		'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
		'medium'				=> 'radiowe',
		'technologia'		=> 'WiFi',
		'przepustowosc'	=> '20',
		'id_wzl'				=> $cpe[id_cpe],
		'ssid'					=> 'ssid',
		'warstwa'				=> 'sieć szkieletowa lub dystrybucyjna',
		'nazwa'					=> 'wlan1'
		);
		Insert($dbh, "interfejsy_wezla", $ifc);
	
		$pvn=array(
			'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
			'id_ivn' 		=> $ivn4[id_ivn],
			'id_ifc'		=>	$ifc[id_ifc],
			'tagowany'	=> 'T'
		);
		Insert($dbh, "przyp_vlanu", $pvn);	
							
		
		
		$ifc=array(
		'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
		'medium'				=> 'kablowe',
		'technologia'		=> 'Ethernet',
		'przepustowosc'	=> '100',
		'id_wzl'				=> $cpe[id_cpe],
		'ssid'					=> '',
		'warstwa'				=> 'sieć dostępowa',
		'nazwa'					=> 'ether1'
		);
		Insert($dbh, "interfejsy_wezla", $ifc);
		
		$pvn=array(
			'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
			'id_ivn' 		=> $ivn1[id_ivn],
			'id_ifc'		=>	$ifc[id_ifc],
			'tagowany'	=> 'N'
		);
				Insert($dbh, "przyp_vlanu", $pvn);
}
	


	

	
function TaryfaAdd($dbh, $id_cpe, $aktywny_od=Null)
{
		include "func/config.php";
		$cp="cpe"."$id_cpe";
		$c=$_SESSION['$cp'];
		
		$ID_TARYFY= FindId2($_POST[dzierzawa]);
		if ( $c['id_tows'] != $ID_TARYFY)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];

			}

			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
			$q="update pakiety set aktywny_do='$aktywny_do2' where id_urz='$id_cpe' and aktywny_do='$conf[wazne_do]'";
					WyswietlSql($q);
			$row=Query($dbh, $q);
				
			$trf=array(
			'id_urz' 		=> $id_cpe, 'id_usl' 		=> $ID_TARYFY, 	 'aktywny_od' => $aktywny_od, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $trf);
		}
}	

	
function CpeUpd($dbh, $id_cpe)
{
		include "func/config.php";	

		$c=	$_SESSION[$session[cpe][update]];		
			
			
		$cpe=array(
		'id_cpe'	  			=> $id_cpe,  			
		'typ'							=> $_POST[typ], 
		'mac'		  				=> $_POST[mac],										   
		'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'aktywne'				  => CheckboxToTable($_POST[aktywne]),		
		'id_abon' 				=> FindId2($_POST[abonent]),
		'id_msi' 					=> FindId2($_POST[mi])
		);
		Update($dbh, "cpe", $cpe);
		 

		/*
			$kmp0=array(
			'id_komp' 	=> $c[id_komp],
			'id_ivn'		=> 'NULL'
			);
		
			$kmp=array(
			'id_komp' 	=> FindId2($_POST[komputer]),
			'id_ivn'		=> $c[id_ivn]
			);
			
			if ( $kmp[id_komp]!=$kmp0[id_komp] )
			{	
				if (!empty($c[id_komp]))
					Update($dbh, "komputery", $kmp0);
				Update($dbh, "komputery", $kmp);
			}
*/
		$id_tows=FindId2($_POST[dzierzawa]);
		
		if ( !empty($c[id_tows]) && IsNull($id_tows)!='NULL'  )
		{
			$q="update pakiety set id_usl='$id_tows' where id_urz='$id_cpe' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( empty($c[id_tows]) && IsNull($id_tows)!='NULL')
		{
			$q="insert into pakiety values ('$id_cpe','$id_tows', '$conf[data]','$conf[wazne_do]')";		
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( !empty($c[id_tows]) && IsNull($id_tows)=='NULL'  )
		{
			$q="update pakiety set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_cpe' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		
/*
			$ip=array(
			'id_urz'	 => $ivn1[id_ivn],  			
			'ip'			=> $ipc->IpGate($dbh, $id_pds)
			);

			if ( $ipc->ValidateIP($dbh, $ip[ip]) )
			{
				Insert($dbh, "adresy_ip", $ip);		
				$pds=array(
				'id_pds'	 => $id_pds,  			
				'wykorzystana'			=> 'T'
				);
				Update($dbh, "podsieci", $pds);
			}*/


}
	
}	


?>
