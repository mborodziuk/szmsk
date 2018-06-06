<?php

class OLT
{


public $table=array( 
		'link' 	=> array('href' => "index.php?panel=admin&menu=oltadd", 'name' => 'Nowy OLT'),
		'form' 	=> array('action' => 'index.php?panel=admin&menu=deleteolt&typ=olt'),
		'table' => array('witdh' => '1000', 'height'=>'50'),
		'row'		=> array ('Id' =>'10', 'Nazwa' =>'120', 'Adres IP' => '100', 'Mac' =>'120', 'Typ' =>'200', 'Adres' =>'400', '::' =>'20')
	);
	
function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
			$q.= "delete from polaczenia				where id_ifc2 in (select id_ifc from interfejsy_wezla 	where id_wzl='$k');
						delete from trakty 						where id_ifc2 in (select id_ifc from interfejsy_wezla 	where id_wzl='$k');
						delete from przyp_vlanu 			where id_ifc in (select id_ifc from interfejsy_wezla where id_wzl='$k');
						delete from adresy_ip 				where id_urz in (select id_ivn from inst_vlanu 	where id_wzl='$k');
						delete from interfejsy_wezla 	where id_wzl='$k';
						delete from inst_vlanu 				where id_wzl='$k';
						delete from olt 							where id_olt='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}

	
function Form($olta)
{
	include "func/config.php";
	
	$q1="select id_ifc, nazwa, medium, technologia, przepustowosc, ssid, rdzen, dystrybucja, dostep from interfejsy_wezla where id_wzl='$olta[id_olt]'  order by id_ifc";
	$q2="select iv.id_ivn, a.ip, v.tag, v.nazwa, v.opis, p.id_ifc, p.tagowany  from ((inst_vlanu iv join vlany v on iv.id_vln=v.id_vln and iv.id_wzl='$olta[id_olt]') left join przyp_vlanu p on p.id_ivn=iv.id_ivn ) left join adresy_ip a on iv.id_ivn=a.id_urz  order by iv.id_ivn";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane olt'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Szkieletowy', 		'name'=>'szkieletowy', 		'value'=>$olta[szkieletowy]),
													array('wyswietl' => 'Dystrybucyjny', 	'name'=>'dystrybucyjny', 'value'=>$olta[dystrybucyjny]),
													array('wyswietl' => 'Dostępowy', 			'name'=>'dostepowy', 				'value'=>$olta[dostepowy])
													),		
			'input'		=> array (
													array('wyswietl' => 'Mac', 						'name'=>'mac', 'size'=>'30', 'value'=>$olta[mac]),
													array('wyswietl' => 'Adres IP', 			'name'=>'ip', 'size'=>'30', 'value'=>$olta[ip]),
													array('wyswietl' => 'Nazwa', 					'name'=>'nazwa', 'size'=>'30', 'value'=>$olta[nazwa]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'data_aktywacji', 'size'=>'30', 'value'=>$olta[data_aktywacji])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Rodzaj', 'name'=>'rodzaj', 'size'=>'30', 'tablica' => array('Inny', 'Rodzaj'), 'value'=>$olta[rodzaj]),
						
					
											array('wyswietl' => 'Producent', 'name'=>'producent', 'size'=>'30', 'tablica' => array('ZTE','ExtraLink', 'Dasan', 'Huawei', 'Inny'), 'value'=>$olta[producent]),	
					
													array('wyswietl' => 'Typ', 'name'=>'typ', 'size'=>'30', 'tablica' => array('C300', 'GEPON-OLT', 'Inny'), 'value'=>$olta[typ]),		
																		
													
													array('wyswietl' => 'Interfejsy dosyłowe', 'name'=>'il1', 'size'=>'30', 'tablica' => array('0','1', '2', '4', '5', '6'), 'value'=>$olta[il1]),
													array('wyswietl' => 'Interfejsy dostępowe', 'name'=>'il2', 'size'=>'30', 'tablica' => array('0','1', '2', '3', '4','8', '16', '24', '32', '40'), 'value'=>$olta[il2])
													),													
			'select'		=> array (
													//array('wyswietl' => 'Interfejs nadrzędny', 'name'=>'interfejs', 'size'=>'30', 'query'=>"$QA22", 'value'=>$olta[id_ifc]),
													array('wyswietl' => 'Lokalizacja', 'name'=>'budynek', 'size'=>'30', 'query'=>"$QUERY1", 'value'=>$olta[budynek])
													),
			'list'		=>array ( 
													array(
													'add'		=> array ('query'=> $q1, 'type'=> 'ifc'),
													'row'		=> array ('Lp' => '10', 'Id' => '10',  'Nazwa' => '30', 'Medium' => '50', 'Technologia' => '100', 'Przepustowość' => '100',  'SSID' => '100', 'Rdzeń' => '100' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=ifcadd&id_wzl=$olta[id_olt]", 'name' => '>>> Nowy interfejs')
													),
													
													array(	
													'add'		=> array ('query'=> $q2, 'type'=> 'ivn'),
													'row'		=> array ('Id' => '10',  'Adres IP' => '100', 'Tag id' => '50', 'Nazwa' => '100', 'Opis' => '100',  'Interfejs' => '100', 'Tagowany' => '10' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=ivnadd&id_wzl=$olta[id_olt]", 'name' => '>>> Nowy vlan')
													),
													
													array(	
													'link' 	=> array('href' => "index.php?panel=admin&menu=oltmng&id=$olta[id_olt]", 'name' => '>>> Zarządzaj')
													),
													
													array(	
													'link' 	=> array('href' => "index.php?panel=admin&menu=oltinf&id=$olta[id_olt]", 'name' => '>>> Informacje')
													)
												)											
	);
	
	if (empty ($olta)) 
		{
			$form[form][action]='index.php?panel=admin&menu=oltaddsnd';
			$form[input][2][value]="OLT-";
			$form[input][3][value]=$conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=oltupdsnd&olt=$olta[id_olt]";		
		}

		return ($form);
}

function PrintList($dbh, $www=NULL)
{
	  $q1="select distinct n.id_olt, n.nazwa, n.mac, n.typ, u.miasto, u.cecha, u.nazwa, b.numer  
					from ( olt n left join inst_vlanu iv on n.id_olt=iv.id_wzl)  
					left join (ulice u join budynki b on u.id_ul=b.id_ul) on n.id_bud=b.id_bud order by n.nazwa";

		
		WyswietlSql($q1);
	  $sth1=Query($dbh,$q1);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
				$addr=array('kod'=> NULL, 'miasto' => $row1[4], 'cecha'=>$row1[5], 'ulica' => $row1[6], 'budynek' => $row1[7]);
				
				$adres=$www->Adres($addr);
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=oltupd&olt=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td>";
						$q2="select a.ip from adresy_ip a, inst_vlanu iv where iv.id_ivn=a.id_urz and iv.id_wzl='$row1[0]'";
					  $sth2=Query($dbh,$q2);
						while ($row2=$sth2->fetchRow())
						echo "$row2[0] <br>";
				    echo "</td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";
						echo "<td> $adres </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
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
			$telnet->DoCommand("show run");
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
	
	$q="select a.ip	from olt n, inst_vlanu iv, adresy_ip a where iv.id_wzl=n.id_olt and a.id_urz=iv.id_ivn and n.id_olt='$dev'";

	WyswietlSql($q);	
	$r=Query2($q, $dbh);
	
	$onu="$r[1]:$r[2]";
	
	$cmd=array(
	"show epon onu-information",
	"show epon inactive-onu",
	"show epon active-onu",
	"show epon optical-transceiver-diagnosis",
	"show vlan",
	"show run"
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
//				sleep(0.5);
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

function OltValidate()
	{
			include "func/config.php";
		$flag=1;

		if ( empty ($_POST[typ]) )
		{
			echo "Nie wprowadzono typu <br>";
			$flag=0;
		}
		if ( empty ($_POST[nazwa]) )
		{
			echo "Nie wprowadzono nazwy <br>";
			$flag=0;
		}
		if ( $_POST[data_aktywacji] != "" )
			if ( !ValidateDate($_POST[data_aktywacji]) )
				{ 	 
					$flag=0;
				}
		return ($flag);	
	}	

function OltAdd($dbh)
{
		include "func/config.php";

		$Q= "select id_olt from olt 							order by id_olt desc limit 1";
		$Q2="select id_ifc from interfejsy_wezla 	order by id_ifc desc limit 1";
		$Q3="select id_ivn from inst_vlanu 				order by id_ivn desc limit 1";
		$Q4="select id_trt from trakty 						order by id_trt desc limit 1";
		$Q5="select id_plc from polaczenia 				order by id_plc desc limit 1";
		$Q6="select id_lin from linie 						order by id_lin desc limit 1";
		$Q7="select id_pvn from przyp_vlanu 			order by id_pvn desc limit 1";
		
		$olt=array(
		'id_olt'	  			=> IncValue($dbh,$Q,  "OLT00000"),  			
		'rodzaj'					=> $_POST[rodzaj], 
		'producent'				=> $_POST[producent], 
		'typ'							=> $_POST[typ], 
		'nazwa'		  			=> $_POST[nazwa],
		'mac'		  				=> $_POST[mac],
		'id_bud' 					=> FindId2($_POST[budynek]),   
	  'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'szkieletowy'			=> CheckboxToTable($_POST[szkieletowy]), 
		'dystrybucyjny'		=> CheckboxToTable($_POST[dystrybucyjny]),
		'dostepowy'				=> CheckboxToTable($_POST[dostepowy])
		);		
		Insert($dbh, "olt", $olt);
	

				
					$ivn4=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00004',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn4);
										
					$ip=array(
					'id_urz'	 => $ivn4[id_ivn],  			
					'ip'			=> $_POST[ip]
					);
					Insert($dbh, "adresy_ip", $ip);
					
					$ivn3=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00003',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn3);
					
					$ivn2=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00002',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn2);

					$ivn1=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00001',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn1);
		//			
		
					$ivn104=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00104',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn104);

					$ivn105=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00105',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn105);
					
					
					$ivn106=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00106',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn106);

					$ivn107=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00107',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn107);
					
					$ivn108=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00108',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn108);

					$ivn109=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00109',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn109);
					
					$ivn110=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00110',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn110);

					$ivn111=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00111',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn111);
					
					$ivn112=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00112',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn112);

					$ivn113=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00113',
					'id_wzl' 			=> $olt[id_olt]
					);
					Insert($dbh, "inst_vlanu", $ivn113);
					

					for ( $i=1; $i<=$_POST[il1]; $i++ )
					{
							
							$ifc=array(
							'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
							'medium'				=> 'światłowodowe',
							'technologia'		=> '1 Gigabit Ethernet',
							'przepustowosc'	=> '1000',
							'id_wzl'				=> $olt[id_olt],
							'ssid'					=> '',
							'rdzen'					=> 'N',
							'dystrybucja'		=> 'T',
							'dostep'				=> 'N'
							);
							
							if ($olt[typ] == 'GEPON-OLT')
							{
								$ifc[nazwa] = "g0/$i";
							}
							else
							{
								$ifc[nazwa] = "gei_0/14/$i";
							}
							
							Insert($dbh, "interfejsy_wezla", $ifc);

							
							$pvn=array(
							'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
							'id_ivn' 		=> $ivn4[id_ivn],
							'id_ifc'		=>	$ifc[id_ifc],
							'tagowany'	=> 'T'
							);
							Insert($dbh, "przyp_vlanu", $pvn);	
							
							$pvn=array(
							'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
							'id_ivn' 			=> $ivn2[id_ivn],
							'id_ifc'		=>	$ifc[id_ifc],
							'tagowany'	=> 'T'
							);
							Insert($dbh, "przyp_vlanu", $pvn);
							
							$pvn=array(
							'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
							'id_ivn' 		=> $ivn3[id_ivn],
							'id_ifc'		=>	$ifc[id_ifc],
							'tagowany'	=> 'T'
							);
							Insert($dbh, "przyp_vlanu", $pvn);
					}
					
					
					for ( $i=1; $i<=$_POST[il2]; $i++ )
					{
														
							$ifc=array(
							'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
							'medium'				=> 'światłowodowe',
							'technologia'		=> 'EPON',
							'przepustowosc'	=> '1000',
							'id_wzl'				=> $olt[id_olt],
							'ssid'					=> '',
							'rdzen'					=> 'N',
							'dystrybucja'		=> 'N',
							'dostep'				=> 'T'
							);

							if ($olt[typ] == 'GEPON-OLT')
							{
								$ifc[nazwa] = "epon0/$i";
							}
							else
							{
								$ifc[nazwa] = "epon-onu_0/1/$i";
							}

							Insert($dbh, "interfejsy_wezla", $ifc);
							
							$pvn=array(
							'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
							'id_ivn' 			=> $ivn1[id_ivn],
							'id_ifc'		=>	$ifc[id_ifc],
							'tagowany'	=> 'N'
							);
							Insert($dbh, "przyp_vlanu", $pvn);	
					}
}
	

function OltUpd($dbh, $id_wzl)
{
		include "func/config.php";
		
		$n=$_SESSION[$session[olt][update]];
	
		$olt=array(
		'id_wzl'	  			=> $id_wzl,  			
		'rodzaj'					=> $_POST[rodzaj], 
		'producent'				=> $_POST[producent], 
		'typ'							=> $_POST[typ], 
		'nazwa'		  			=> $_POST[nazwa],
		'id_bud' 					=> FindId2($_POST[budynek]),   
 		'mac'		  				=> $_POST[mac],
		'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'szkieletowy'		  => CheckboxToTable($_POST[szkieletowy]), 
		'dystrybucyjny'	  => CheckboxToTable($_POST[dystrybucyjny]),
		'dostepowy'			  => CheckboxToTable($_POST[dostepowy])
		);
		Update($dbh, "wezly", $olt);
		
	
		$ip=array( 			
		'ip'			=> $_POST[ip],
		'id_urz'	  => $n[id_ivn]
		);
		
		
		if ( empty($n[ip]) && ! empty($_POST[ip]))
				Insert($dbh, "adresy_ip", $ip);
		else if ( ! empty($n[ip]) && ! empty($_POST[ip]) )
			{
				$Q="update adresy_ip set ip='$_POST[ip]' where ip='$n[ip]'";
				WyswietlSql($Q);
				Query($dbh, $Q);
			}
		else if ( ! empty($n[ip]) && empty($_POST[ip]) )
			{
				$Q="delete from adresy_ip where ip='$n[ip]'";
				WyswietlSql($Q);
				Query($dbh, $Q);
			}
	}
}	


?>
