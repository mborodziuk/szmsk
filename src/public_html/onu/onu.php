<?php

class ONU
{


public $table=array( 
		'link' 	=> array('href' => "index.php?panel=inst&menu=onuadd", 'name' => 'Nowe onu'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=deleteonu&typ=onu'),
		'table' => array('witdh' => '1000', 'height'=>'50'),
		'row'		=> array ('Id' =>'100', 'Typ' =>'200', 'Adresy fizyczne' =>'120', 'Adresy IP' =>'80', 'Abonent' =>'370', 'Węzeł' =>'100', 'Interfejs' =>'300', 'Dzierżawa' =>'100', 'Conf' =>'30', '::' =>'20')
	);

function Delete ($dbh, $telnet)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
				$q1="select a.ip, i1.nazwa, o.mac from olt n, inst_vlanu iv, adresy_ip a, onu o, polaczenia p, interfejsy_wezla i1, interfejsy_wezla i2 
				where iv.id_wzl=n.id_olt and a.id_urz=iv.id_ivn and n.id_olt=i1.id_wzl and o.id_onu=i2.id_wzl
				and p.id_ifc2=i2.id_ifc and p.id_ifc1=i1.id_ifc and o.id_onu='$k'";
				WyswietlSql($q1);	
				$r1=Query2($q1, $dbh);
				//print_r($r1);
				
				/*
				// To odkomentować jeżeli onu ma byc usuwane z olta
				$mac=PonMac($r1[2]);
				$c1="interface $r1[1]";
				$c2="no epon bind-onu mac $mac";
				
				$result = $telnet->Connect($r1[0],$conf[tuser],$conf[tpwd]);

				switch ($result) 
				{
					case 0:
						$telnet->enable();
						$telnet->config();
						$telnet->DoCommand($c1);
						$telnet->display();
						$telnet->DoCommand($c2);
						$telnet->display();
						$telnet->Disconnect();
						break;
					
					case 1:
						echo '[PHP Telnet] Connect failed: Unable to open network connection';
						break;
					case 2:
						echo '[PHP Telnet] Connect failed: Unknown host';
						break;
					case 3:
						echo '[PHP Telnet] Connect failed: Login failed';
						break;
					case 4:
						echo '[PHP Telnet] Connect failed: Your PHP version does not support PHP Telnet';
						break; 
				}
				*/
				$q.="delete from pakiety 			where id_urz='$k';
						delete from polaczenia where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$k');
						delete from trakty where id_ifc2 in (select id_ifc from interfejsy_wezla where id_wzl='$k');
						delete from adresy_ip 				where id_urz in (select id_ivn from inst_vlanu where id_wzl='$k'); 
						update podsieci set wykorzystana='N' where id_pds in 
						(select id_pds from adresy_ip where id_urz in (select id_ivn from inst_vlanu where id_urz='$k'));
						delete from przyp_vlanu where id_ivn in (select id_ivn from inst_vlanu where id_wzl='$k');
						delete from inst_vlanu 	where id_wzl='$k';
						delete from interfejsy_wezla 	where id_wzl='$k';
						delete from onu							where id_onu='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}

function Form($onua)
{
	include "func/config.php";
	$q1="select i.id_ifc, i.nazwa, i.medium, i.technologia, i.przepustowosc, i.ssid from interfejsy_wezla i where i.id_wzl='$onua[id_onu]' order by i.id_ifc";
	$q2="select iv.id_ivn, a.ip, v.tag, v.nazwa, v.opis  from (inst_vlanu iv join vlany v on iv.id_vln=v.id_vln and iv.id_wzl='$onua[id_onu]') left join adresy_ip a on iv.id_ivn=a.id_urz  order by iv.id_ivn";

	$q3="select s.nazwa, k.nazwa, k.id_skt from spliter s, socket k where s.id_spt=k.id_odf  and k.nazwa not in ('Socket0') order by s.nazwa, k.nazwa";
	$q4="select o.nazwa, i.nazwa, i.id_ifc from olt o, interfejsy_wezla i where o.id_olt=i.id_wzl and i.dostep='T' order by o.nazwa, i.nazwa";
			
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane onu'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Aktywne', 'name'=>'aktywne', 'value'=>$onua[aktywne]),
													array('wyswietl' => 'Telewizja', 'name'=>'tv', 'value'=>$onua[tv])
													),
			'input'		=> array (
													array('wyswietl' => 'Mac', 'name'=>'mac', 'size'=>'30', 'value'=>$onua[mac]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'data_aktywacji', 'size'=>'30', 'value'=>$onua[data_aktywacji]),
													array('wyswietl' => 'Vlan', 'name'=>'vlan', 'size'=>'2', 'value'=>$onua[vlan])
													),
			'abonent'	=> array( 'value'=>$onua[id_abon]),
			'select'		=> array (
													array('wyswietl' => 'Miejsce instalacji', 'name'=>'mi', 'size'=>'30', 'query'=>"$QUERY14", 
													'value'=>$onua[id_msi], 'format'=>array(0=>'', 1=>'', 2=>'lok. ', 3=>'', 4=>'')),
												//array('wyswietl' => 'Złącze splitera', 			'name'=>'skt', 'size'=>'30', 'query'=>"$q3", 'value'=>$onua[id_skt]),														
													array('wyswietl' => 'Interfejs OLTa', 'name'=>'ifc', 'size'=>'30', 'query'=>"$q4", 'value'=>$onua[id_ifc]),																											
													array('wyswietl' => 'Dzierżawa', 'name'=>'dzierzawa', 'size'=>'30', 'query'=>"$QA17", 'value'=>$onua[id_tows])
													),			
			'selectarray'	 => array (
												array('wyswietl' => 'Producent', 'name'=>'producent', 'size'=>'40', 'tablica' => array('Extra Link', 'ZTE', 'Inny'), 'value'=>$onua[producent]),		
												array('wyswietl' => 'Typ', 'name'=>'typ', 'size'=>'40', 			'tablica' => array('F401', 'F411', 'F420'), 'value'=>$onua[typ])
													),

			'link' 	=> array (array('href' => "index.php?panel=inst&menu=trfonuadd&onu=$onua[id_onu]", 'name' => '>>> Nowa taryfa')),
													
			'list'		=>array (	
													array(	
													'add'		=> array ('query'=> $q1, 'type'=> 'ifc'),
													'row'		=> array ('Id' => '10',  'Nazwa' => '30', 'Medium' => '50', 'Technologia' => '100', 'Przepustowość' => '100',  'SSID' => '100', 'Warstwa' => '100' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=ifcadd", 'name' => '>>> Nowy interfejs')),
																	
													array(	
													'add'		=> array ('query'=> $q2, 'type'=> 'ivn'),
													'row'		=> array ('Id' => '10',  'Adres IP' => '100', 'Tag id' => '50', 'Nazwa' => '100', 'Opis' => '100',  'Interfejs' => '100', 'Tagowany' => '10' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=vlnadd", 'name' => '>>> Nowy vlan')
													),
													
													array(	
													'link' 	=> array('href' => "index.php?panel=inst&menu=onumng&id=$onua[id_onu]", 'name' => '>>> Zarządzaj')
													),
													
													array(	
													'link' 	=> array('href' => "index.php?panel=inst&menu=onuinf&id=$onua[id_onu]", 'name' => '>>> Informacje')
													)

												)
	);
	
		if (empty ($onua)) 
		{
			$form[form][action]='index.php?panel=inst&menu=onuaddsnd';
			if ( empty($onua[data_aktywacji]) )
				$form[input][1][value] = $conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=inst&menu=onuupdsnd&onu=$onua[id_onu]";		
		}
		
		return ($form);
													 
}


function Mng($dev, $telnet)
{
	include "func/config.php";
	
	$cmd="help";
	
	$q="select a.ip	from olt n, inst_vlanu iv, adresy_ip a where iv.id_wzl=n.id_olt and a.id_urz=iv.id_ivn and n.id_olt='$dev'";
	WyswietlSql($q);	
	$r=Query2($q, $dbh);
	
	$result = $telnet->Connect($r[0],$conf[tuser],$conf[tpwd]);

	switch ($result) 
	{
		case 0:
			 echo "<br>------------------------------------------------------------------------------------------------------------------------------------------------ <br>";
			$telnet->enable();
			$telnet->DoCommand("show vlan");
			echo "<b>show vlan: </b><br>";
			$telnet->display();
			 echo "<br>------------------------------------------------------------------------------------------------------------------------------------------------ <br>";
			$telnet->enable();
			$telnet->DoCommand("show epon inactive-onu");
			echo "<b>show epon inactive-onu: </b><br>";
			$telnet->display();
			echo "------------------------------------------------------------------------------------------------------------------------------------------------ <br>";
			$telnet->DoCommand("show epon active-onu");
			echo "<b>show epon active-onu: </b><br>";
			$telnet->display();
			$telnet->Disconnect();
			break;
		
		case 1:
			echo '[PHP Telnet] Connect failed: Unable to open network connection';
			break;
		case 2:
			echo '[PHP Telnet] Connect failed: Unknown host';
			break;
		case 3:
			echo '[PHP Telnet] Connect failed: Login failed';
			break;
		case 4:
			echo '[PHP Telnet] Connect failed: Your PHP version does not support PHP Telnet';
			break; 
	}
}

function Info($dev, $ctelnet)
{
	include "func/config.php";
	
	$cmd="help";
	
	$q="select a.ip, i1.nazwa, o.llid from olt n, inst_vlanu iv, adresy_ip a, onu o, polaczenia p, interfejsy_wezla i1, interfejsy_wezla i2 
				where iv.id_wzl=n.id_olt and a.id_urz=iv.id_ivn and n.id_olt=i1.id_wzl and o.id_onu=i2.id_wzl
				and p.id_ifc2=i2.id_ifc and p.id_ifc1=i1.id_ifc and o.id_onu='$dev'";
	WyswietlSql($q);	
	$r=Query2($q, $dbh);
	
	$onu="$r[1]:$r[2]";
	
	$cmd=array(
	"show epon interface $onu onu ctc optical-transceiver-diagnosis",
	"show epon interface $onu onu port 1 state",
	"show epon interface $onu onu ctc basic-info",
	"show epon interface $onu onu mac address-table"
	);
	$result = $ctelnet->Connect($r[0],$conf[tuser],$conf[tpwd]);

	switch ($result) 
	{
		case 0:
		
			$ctelnet->enable();
			foreach ($cmd as $c)
			{
				echo "<br>------------------------------------------------------------------------------------------------------------------------------------------------ <br>";
				$ctelnet->DoCommand($c);
				echo "<b>$c </b><br>";
				$ctelnet->display();
			}
			$ctelnet->Disconnect();
			break;
		case 1:
			echo '[PHP Telnet] Connect failed: Unable to open network connection';
			break;
		case 2:
			echo '[PHP Telnet] Connect failed: Unknown host';
			break;
		case 3:
			echo '[PHP Telnet] Connect failed: Login failed';
			break;
		case 4:
			echo '[PHP Telnet] Connect failed: Your PHP version does not support PHP Telnet';
			break; 
	}
}

function PrintList($dbh)
{
		include "func/config.php";

	  $query="select distinct c.id_onu, c.typ, c.mac, n.symbol, n.nazwa, t.symbol, c.llid
					from 
	
					(onu c 	left join nazwy n on c.id_abon=n.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
					left join 
					(towary_sprzedaz t join pakiety p on t.id_tows=p.id_usl and p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]') 
					on p.id_urz=c.id_onu order by c.id_onu ";
					
		WyswietlSql($query);				  
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
				$Q2="select o.nazwa, i1.nazwa from interfejsy_wezla i1, interfejsy_wezla i2, polaczenia t, olt o 
				where t.id_ifc2=i2.id_ifc and t.id_ifc1=i1.id_ifc and i1.id_wzl=o.id_olt and  i2.id_wzl='$row1[0]'";
				WyswietlSql($Q2);
				$r2=Query2($Q2, $dbh);
	
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=inst&menu=onuupd&onu=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
	 			    echo "<td>";
						$q2="select a.ip from adresy_ip a, inst_vlanu iv where iv.id_ivn=a.id_urz and iv.id_wzl='$row1[0]'";
					  $sth2=Query($dbh,$q2);
						while ($row2=$sth2->fetchRow())
						echo "$row2[0] <br>";
				    echo "</td>";
	
				    $s=Choose($row1[3], $row1[4]);
				    echo "<td> <b>$s </b></td>";

				echo "<td> $r2[0] </td>";
				echo "<td> $r2[1]:$row1[6] </td>";
				echo "<td> $row1[5] </td>";
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=dw&id_wpl=$row[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
function OnuValidate($dbh, $ipc)
	{
		include "func/config.php";
		
		$id_ifc1=FindId2($_POST[ifc]);
				
		$Q9="select count (id_ifc1) from polaczenia where id_ifc1='$id_ifc1'";
		WyswietlSql($Q9);	
		$r9=Query2($Q9, $dbh);
		$llid=$r9[0];
		if ( $llid>=64 )
		{
			echo "Do interfejsu EPON można podłączyć maksymalnie 64 końcówki <br>";
			$flag=0;
		}
		
		
		$flag=1;
		if ( empty ($_POST[ifc]) || $_POST[ifc]==$conf[select] )
		{
			echo "Nie wprowadzono interfejsu OLTa <br>";
			$flag=0;
		}
		
		if ( empty ($_POST[typ]) )
		{
			echo "Nie wprowadzono typu <br>";
			$flag=0;
		}
		if (  !isMac($_POST[mac]) )
		{
			echo "Nieprawidłowy format MAC <br>";
			$flag=0;
		}

		if (  !empty($_POST[vlan]) && !isVlan($_POST[vlan]) )
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

function OnuAdd($dbh, $ipc, $ctelnet)
{
		include "func/config.php";
		$Q1="select id_onu from onu order by id_onu desc limit 1";
		$Q2="select id_ifc from interfejsy_wezla order by id_ifc desc limit 1";
		$Q3="select id_ivn from inst_vlanu order by id_ivn desc limit 1";
		$Q4="select id_trt from trakty order by id_trt desc limit 1";
		$Q5="select id_plc from polaczenia order by id_plc desc limit 1";
		$Q6="select id_lin from linie order by id_lin desc limit 1";
		$Q7="select id_pvn from przyp_vlanu 			order by id_pvn desc limit 1";
		$Q8="select id_pds, adres, maska, brama, broadcast  from podsieci where warstwa='zarzadzanie_pon' and wykorzystana='N' order by id_pds desc limit 1";
		
		$id_ifc1=FindId2($_POST[ifc]);
				
		$Q9="select count (id_ifc1) from polaczenia where id_ifc1='$id_ifc1'";
		WyswietlSql($Q9);	
		$r9=Query2($Q9, $dbh);
		$llid=$r9[0];
		
		$onu=array(
		'id_onu'	  			=> IncValue($dbh,$Q1, "ONU00000"),  			
		'typ'							=> $_POST[typ], 
		'producent'				=> $_POST[producent], 
		'mac'		  				=> $_POST[mac],										  
		'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'aktywne'				  => CheckboxToTable($_POST[aktywne]),		
		'id_abon' 				=> FindId2($_POST[abonent]),
		'id_msi' 					=> FindId2($_POST[mi]),
		'llid'						=> ++$llid
		);
		$onu[mac]=NormalizeMac($onu[mac]);
		Insert($dbh, "onu", $onu);
				
		$Q10="select distinct n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok
					from ulice u, budynki b, nazwy n, adresy_siedzib s
					where  u.id_ul=b.id_ul and s.id_bud=b.id_bud and n.id_abon=s.id_abon 
					and  n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]'
					and  s.wazne_od <= '$conf[data]' and s.wazne_do >= '$conf[data]'
					and  n.id_abon='$onu[id_abon]'";
		WyswietlSql($Q10);	
		$r10=Query2($Q10, $dbh);
		
		$pkt=array(
		'id_urz'=>$onu[id_onu], 'id_usl'=>FindId2($_POST[dzierzawa]), 'aktywny_od' => $conf[wazne_od], 'aktywny_do' => $conf[wazne_do]);
		
		if (  !empty($_POST[dzierzawa]) && $_POST[dzierzawa]!=$conf[select] )
		{
			Insert($dbh, "pakiety", $pkt);
		}
		
		$oif=explode(" ", $_POST[ifc]);
		//print_r($oif);
		$ifc=$oif[1];
		
		$q="select a.ip	from olt n, inst_vlanu iv, adresy_ip a where iv.id_wzl=n.id_olt and a.id_urz=iv.id_ivn and n.nazwa='$oif[0]'";
		WyswietlSql($q);	
		$r=Query2($q, $dbh);
		$host=$r[0];
		
		$tv=CheckboxToTable($_POST[tv]);		
		
		/* Odkomenttować gdy nma być dodawane onuu do olta
		Na rrazie tylko ExtraLink
		
		if ( $tv=='T')
			$tagged_vlan="9";
		else
			$tagged_vlan="1";
			
		if (  !empty($_POST[vlan]) )
		{
				$native_vlan="$_POST[vlan]";		
		}
		else
		{
			switch ($ifc)
			{
				case "epon0/1":
					$native_vlan="601";
					break;
				case "epon0/2":
					$native_vlan="602";
					break;
				case "epon0/3":
					$native_vlan="603";
					break;
				case "epon0/4":
					$native_vlan="604";
					break;
			}		
		}
		
		$ponmac=PonMac($onu[mac]);
		
		$desc =  $onu[id_abon];
		
		$cmd1=array(
		"interface $ifc", 
		"epon bind-onu mac $ponmac $llid", 
		);
		
		$cmd2=array(
		"exit",
		"interface $ifc:$llid", 
		"epon onu description $desc", 
		"epon onu port 1 ctc vlan mode trunk $native_vlan $tagged_vlan", 
		"exit", 
		"write"
		);
		
		print_r($cmd1);
		print_r($cmd2);
		
		
	$result = $ctelnet->Connect($host, $conf[tuser], $conf[tpwd]);


	switch ($result) 
	{
		case 0:
			$ctelnet->enable();
			$ctelnet->config();
			foreach ($cmd1 as $c)
			{
				$ctelnet->DoCommand($c);
				$ctelnet->display();
			}
			sleep(1);
			foreach ($cmd2 as $c)
			{
				$ctelnet->DoCommand($c);
				sleep(0.5);
				$ctelnet->display();
			}
			$ctelnet->Disconnect();
			break;
		
		case 1:
			echo '[PHP Telnet] Connect failed: Unable to open network connection';
			break;
		case 2:
			echo '[PHP Telnet] Connect failed: Unknown host';
			break;
		case 3:
			echo '[PHP Telnet] Connect failed: Login failed';
			break;
		case 4:
			echo '[PHP Telnet] Connect failed: Your PHP version does not support PHP Telnet';
			break; 
	}
		
    */
		
		
		/*	$b=explode(".", $r[2]);
			$i=explode(".", $r[3]);
			--$b[3];
			$last="$b[0].$b[1].$b[2].$b[3]";
			$ip="$i[0].$i[1].$i[2].$i[3]";
			
			if ( $last == $ip )
			{
				$q="update podsieci set wykorzystana='T' where id_pds='$r[4]'";
				Query($dbh, $q);
				$r=Query2($Q8, $dbh);
			}
			*/
			
			$ivn1=array(
			'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
			'id_vln' 			=> 'VLN00001',
			'id_wzl' 			=> $onu[id_onu]
			);
			Insert($dbh, "inst_vlanu", $ivn1);

			$ip=array(
			'id_urz'	 => $ivn1[id_ivn],  			
			'ip'			=> $ipc->AddIp($dbh, $r),
			'id_pds'			=> $r[0]
			);
			//	Insert($dbh, "adresy_ip", $ip);	
				
				
			$id_skt1=FindId2($_POST[skt]);
			/*
			$q9="select id_ivn from przyp_vlanu where tagowany='N' and id_ifc='$id_ifc1'";
			$ivn=Query2($q9, $dbh);
							
			$kmp=array(
			'id_komp' 	=> FindId2($_POST[komputer]),
			'id_ivn'		=> $ivn[0]
			);
			Update($dbh, "komputery", $kmp);
		*/
		
		$ifc=array(
		'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
		'medium'				=> 'światłowodowe',
		'technologia'		=> 'Gepon',
		'przepustowosc'	=> '1000',
		'id_wzl'				=> $onu[id_onu],
		'ssid'					=> 'ssid',
		'rdzen'					=> 'N',
		'dystrybucja'		=> 'N',
		'dostep'				=> 'T',
		'nazwa'					=> 'epon'
		);
		Insert($dbh, "interfejsy_wezla", $ifc);
	
	
		if (!empty($_POST[skt]) && $_POST[skt]!=$conf[select])
		{		
			$trt=array(
			'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"), 
			'ruch_szkielet' 		=> 'N',
			'ruch_dystrybucja' 	=> 'N',
			'ruch_dostep' 			=> 'T',
			'udost'							=> 'N',
			'kolor_kanal'				=> 'T1-czerwony',
			'id_ifc1'						=> $id_skt1,       
			'id_ifc2'						=> $ifc[id_ifc] );
		
			Insert($dbh, "trakty", $trt);	
		}
		
		$plc=array(
			'id_plc' 							=> IncValue($dbh,$Q5,  "PLC00000"), 
			'przep_szkielet_razem'=> 	'0',
			'przep_szkielet_publ' => 	'0',
			'przep_dystr_razem' 	=>	'0',
			'przep_dystr_publ'		=>	'0',
			'przep_dost_razem'		=>	'1000',
			'przep_dost_publ' 		=>	'0',
			'przep_niewyk_razem'  =>	'0',
			'przep_niewyk_publ' 	=>	'0',
			'id_ifc1'							=> $id_ifc1,       
			'id_ifc2'							=> $ifc[id_ifc]
		);
		Insert($dbh, "polaczenia", $plc);
							
		
		if ( $onu[typ] == "F401" )
		{
			$ifc=array(
			'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
			'medium'				=> 'kablowe',
			'technologia'		=> 'Ethernet',
			'przepustowosc'	=> '1000',
			'id_wzl'				=> 	$onu[id_onu],
			'ssid'					=> '',		
			'rdzen'					=> 'N',
			'dystrybucja'		=> 'N',
			'dostep'				=> 'T',
			'nazwa'					=> 'eth_0/1'
			);
			Insert($dbh, "interfejsy_wezla", $ifc);
		}

		else if ( $onu[typ] == "F411" )
		{
			$ifc=array(
			'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
			'medium'				=> 'kablowe',
			'technologia'		=> 'Ethernet',
			'przepustowosc'	=> '100',
			'id_wzl'				=> 	$onu[id_onu],
			'ssid'					=> '',
			'rdzen'					=> 'N',
			'dystrybucja'		=> 'N',
			'dostep'				=> 'T',
			'nazwa'					=> 'eth_0/1'
			);
			Insert($dbh, "interfejsy_wezla", $ifc);		
			
			$ifc=array(
			'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
			'medium'				=> 'kablowe',
			'technologia'		=> 'Ethernet',
			'przepustowosc'	=> '100',
			'id_wzl'				=> 	$onu[id_onu],
			'ssid'					=> '',
			'rdzen'					=> 'N',
			'dystrybucja'		=> 'N',
			'dostep'				=> 'T',
			'nazwa'					=> 'eth_0/2'
			);
			Insert($dbh, "interfejsy_wezla", $ifc);		

			$ifc=array(
			'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
			'medium'				=> 'kablowe',
			'technologia'		=> 'Ethernet',
			'przepustowosc'	=> '100',
			'id_wzl'				=> 	$onu[id_onu],
			'ssid'					=> '',
			'rdzen'					=> 'N',
			'dystrybucja'		=> 'N',
			'dostep'				=> 'T',
			'nazwa'					=> 'eth_0/3'
			);
			Insert($dbh, "interfejsy_wezla", $ifc);		

			$ifc=array(
			'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
			'medium'				=> 'kablowe',
			'technologia'		=> 'Ethernet',
			'przepustowosc'	=> '100',
			'id_wzl'				=> 	$onu[id_onu],
			'ssid'					=> '',
			'rdzen'					=> 'N',
			'dystrybucja'		=> 'N',
			'dostep'				=> 'T',
			'nazwa'					=> 'eth_0/4'
			);
			Insert($dbh, "interfejsy_wezla", $ifc);		
		}
}
	

	
function TaryfaAdd($dbh,$id_onu, $aktywny_od=Null)
{
		include "func/config.php";
		$cp="onu"."$id_onu";
		$c=$_SESSION['$cp'];
		
		$ID_TARYFY= FindId2($_POST[dzierzawa]);
		if ( $c['id_tows'] != $ID_TARYFY)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];
			}

			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
			$q="update pakiety set aktywny_do='$aktywny_do2' where id_urz='$id_onu' and aktywny_do='$conf[wazne_do]'";
					WyswietlSql($q);
			$row=Query($dbh, $q);
				
			$trf=array(
			'id_urz' 		=> $id_onu, 'id_usl' 		=> $ID_TARYFY, 	 'aktywny_od' => $aktywny_od, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $trf);
		}
}	

	
function OnuUpd($dbh, $id_onu)
{
		include "func/config.php";	
		$Q4="select id_trt from trakty order by id_trt desc limit 1";
		
		$c=	$_SESSION[$session[onu][update]];
	
		$onu=array(
		'id_onu'	  			=> $id_onu,  			
		'typ'							=> $_POST[typ], 
		'mac'		  				=> $_POST[mac],										   
		'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'aktywne'				  => CheckboxToTable($_POST[aktywne]),		
		'id_abon' 				=> FindId2($_POST[abonent]),
		'id_msi' 					=> FindId2($_POST[mi])
		);
		Update($dbh, "onu", $onu);
		
		$plc=array(
		'id_plc'	  				=> $c[id_plc], 
		'id_ifc1'						=> FindId2($_POST[ifc]),       
		);		
		Update($dbh, "polaczenia", $plc);	

		
		
		if ( !empty($c[id_trt]) && IsNull($_POST[skt])!='NULL' )
		{
			$trt=array(
			'id_trt'	  				=> $c[id_trt], 
			'id_ifc1'						=> FindId2($_POST[skt]),       
			);		
			Update($dbh, "trakty", $trt);	
		}
		else if ( empty($c[id_trt]) && IsNull($_POST[skt])!='NULL')
		{
			$q="select id_ifc from interfejsy_wezla where id_wzl='$id_onu' and nazwa='epon'";		
			WyswietlSql($q);
			$r=Query2($q, $dbh);

			$trt=array(
			'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"), 
			'ruch_szkielet' 		=> 'N',
			'ruch_dystrybucja' 	=> 'N',
			'ruch_dostep' 			=> 'T',
			'udost'							=> 'N',
			'kolor_kanal'				=> 'T1-czerwony',
			'id_ifc1'						=> FindId2($_POST[skt]),       
			'id_ifc2'						=> $r[0] 
			);
			Insert($dbh, "trakty", $trt);
			
		}
		
		
		
		$id_tows=FindId2($_POST[dzierzawa]);
		
		if ( !empty($c[id_tows]) && IsNull($id_tows)!='NULL' )
		{
			$q="update pakiety set id_usl='$id_tows' where id_urz='$id_onu' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( empty($c[id_tows]) && IsNull($id_tows)!='NULL')
		{
			$q="insert into pakiety values ('$id_onu','$id_tows', '$conf[data]','$conf[wazne_do]')";		
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( !empty($c[id_tows]) && IsNull($id_tows)=='NULL' )
		{
			$q="update pakiety set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_onu' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
	
}
	
}	


?>
