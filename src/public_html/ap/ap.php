<?php

class AP
{

public $table=array( 
		'link' 	=> array('href' => "index.php?panel=admin&menu=apadd", 'name' => 'Nowy węzeł'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=deleteap&typ=ap'),
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
			$q.= "delete from trakty 						where id_ifc2 in (select id_ifc from interfejsy_wezla 	where id_wzl='$k');
						delete from interfejsy_wezla 	where id_wzl='$k';
						delete from inst_vlanu 				where id_wzl='$k';
						delete from przyp_vlanu 			where id_ifc in (select id_ifc from interfejsy_wezla where id_wzl='$k');
						delete from adresy_ip 				where id_urz in (select id_ivn from inst_vlanu 	where id_wzl='$k');
						delete from olt 							where id_olt='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	
function Form($apa)
{
	include "func/config.php";
	
	$q1="select id_ifc, nazwa, medium, technologia, przepustowosc, ssid, warstwa from interfejsy_wezla where id_wzl='$apa[id_nad]'  order by id_ifc";
	$q2="select iv.id_ivn, a.ip, v.tag, v.nazwa, v.opis, p.id_ifc, p.tagowany  from ((inst_vlanu iv join vlany v on iv.id_vln=v.id_vln and iv.id_wzl='$apa[id_nad]') left join przyp_vlanu p on p.id_ivn=iv.id_ivn ) left join adresy_ip a on iv.id_ivn=a.id_urz  order by iv.id_ivn";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane nadajnika'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Szkieletowy', 'name'=>'szkieletowy', 'value'=>$apa[szkieletowy]),
													array('wyswietl' => 'Dystrybucyjny', 'name'=>'dystrybucyjny', 'value'=>$apa[dystrybucyjny]),
													array('wyswietl' => 'Dostępowy', 'name'=>'dostepowy', 'value'=>$apa[dostepowy])
													),		
			'input'		=> array (
													array('wyswietl' => 'Mac', 						'name'=>'mac', 'size'=>'30', 'value'=>$apa[mac]),
													array('wyswietl' => 'Adres IP', 			'name'=>'ip', 'size'=>'30', 'value'=>$apa[ip]),
													array('wyswietl' => 'Nazwa', 					'name'=>'nazwa', 'size'=>'30', 'value'=>$apa[nazwa]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'data_aktywacji', 'size'=>'30', 'value'=>$apa[data_aktywacji])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Rodzaj', 'name'=>'rodzaj', 'size'=>'30', 'tablica' => array('Access Point', 'Bridge'), 'value'=>$apa[rodzaj]),
						
					
											array('wyswietl' => 'Producent', 'name'=>'producent', 'size'=>'30', 'tablica' => array('Mikrotik', 'Ubiquiti','Inny'), 'value'=>$apa[producent]),	
					
													array('wyswietl' => 'Typ', 'name'=>'typ', 'size'=>'30', 'tablica' => array('RB333', 'RB433','RB600', 'RB800', 'x86'), 'value'=>$apa[typ]),		
																		
													
													array('wyswietl' => 'Interfejsy dosyłowe', 'name'=>'il1', 'size'=>'30', 'tablica' => array('0','1', '2'), 'value'=>$apa[il1]),
													array('wyswietl' => 'Interfejsy dostępowe', 'name'=>'il2', 'size'=>'30', 'tablica' => array('0','1', '2', '3', '4','8', '16', '24', '48'), 'value'=>$apa[il2]),
													array('wyswietl' => 'Interfejsy z sektorami', 'name'=>'il3', 'size'=>'30', 'tablica' => array('0','1', '2', '3', '4','5', '6'), 'value'=>$apa[il3])
													),													
			'select'		=> array (
													array('wyswietl' => 'Lokalizacja', 'name'=>'budynek', 'size'=>'30', 'query'=>"$QUERY1", 'value'=>$apa[budynek])
													),
			'list'		=>array ( 
													array(
													'add'		=> array ('query'=> $q1, 'type'=> 'ifc'),
													'row'		=> array ('Id' => '10',  'Nazwa' => '30', 'Medium' => '50', 'Technologia' => '100', 'Przepustowość' => '100',  'SSID' => '100', 'Warstwa' => '100' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=ifcadd&id_wzl=$apa[id_nad]", 'name' => '>>> Nowy interfejs')
													),
													
													array(	
													'add'		=> array ('query'=> $q2, 'type'=> 'ivn'),
													'row'		=> array ('Id' => '10',  'Adres IP' => '100', 'Tag id' => '50', 'Nazwa' => '100', 'Opis' => '100',  'Interfejs' => '100', 'Tagowany' => '10' , '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=ivnadd&id_wzl=$apa[id_nad]", 'name' => '>>> Nowy vlan')),
													
													array(	
													'link' 	=> array('href' => "index.php?panel=admin&menu=mng&id_nad=$apa[id_nad]", 'name' => '>>> Zarządzaj'))
												)											
	);
	
	if (empty ($apa)) 
		{
			$form[form][action]='index.php?panel=admin&menu=apaddsnd';
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=apupdsnd&ap=$apa[id_nad]";		
		}

		return ($form);
}

function PrintList($dbh, $www=NULL)
{
	  $q1="select distinct n.id_nad, n.nazwa, n.mac, n.typ, u.miasto, u.cecha, u.nazwa, b.numer  
					from ( nadajniki n left join inst_vlanu iv on n.id_nad=iv.id_wzl)  
					left join (ulice u join budynki b on u.id_ul=b.id_ul) on n.id_bud=b.id_bud order by n.id_nad, n.nazwa";

		
		WyswietlSql($q1);
	  $sth1=Query($dbh,$q1);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
				$addr=array('kod'=> NULL, 'miasto' => $row1[4], 'cecha'=>$row1[5], 'ulica' => $row1[6], 'budynek' => $row1[7]);
				
				$adres=$www->Adres($addr);
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=apupd&ap=$row1[0]\"> $row1[0] </a> </td>";
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
	
	

function ApValidate()
{
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

function ApAdd($dbh)
{
		include "func/config.php";

		$Q= "select id_nad from nadajniki					order by id_nad desc limit 1";
		$Q2="select id_ifc from interfejsy_wezla 	order by id_ifc desc limit 1";
		$Q3="select id_ivn from inst_vlanu 				order by id_ivn desc limit 1";
		$Q4="select id_trt from trakty 						order by id_trt desc limit 1";
		$Q5="select id_plc from polaczenia 				order by id_plc desc limit 1";
		$Q6="select id_lin from linie 						order by id_lin desc limit 1";
		$Q7="select id_pvn from przyp_vlanu 			order by id_pvn desc limit 1";
		
		$ap=array(
		'id_nad'	  	=> IncValue($dbh,$Q,  "NAD00000"),  			
		'rodzaj'			=> $_POST[rodzaj], 
		'producent'		=> $_POST[producent], 
		'typ'					=> $_POST[typ], 
		'nazwa'		  	=> $_POST[nazwa],
		'mac'		  		=> $_POST[mac],
		'id_bud' 			=> FindId2($_POST[budynek]),   
	  'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'szkieletowy'				  => CheckboxToTable($_POST[szkieletowy]), 
		'dystrybucyjny'				  => CheckboxToTable($_POST[dystrybucyjny]),
		'dostepowy'				  => CheckboxToTable($_POST[dostepowy])
		);		
		Insert($dbh, "nadajniki", $ap);
	
		
					$ivn4=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00004',
					'id_wzl' 			=> $ap[id_nad]
					);
					Insert($dbh, "inst_vlanu", $ivn4);
										
					$ip=array(
					'id_urz'	 => $ivn4[id_ivn],  			
					'ip'			=> $_POST[ip]
					);
					Insert($dbh, "adresy_ip", $ip);
					
					$ivn1=array(
					'id_ivn'	  => IncValue($dbh,$Q3,  "IVN00000"), 
					'id_vln' 			=> 'VLN00001',
					'id_wzl' 			=> $ap[id_nad]
					);
					Insert($dbh, "inst_vlanu", $ivn1);
		
					for ( $i=1; $i<=$_POST[il1]; $i++ )
					{
							$ifc=array(
							'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
							'medium'				=> 'radiowe',
							'technologia'		=> 'WiFi',
							'przepustowosc'	=> '54',
							'id_wzl'				=> $ap[id_nad],
							'ssid'					=> 'netico.pl - ulica',
							'warstwa'				=> 'sieć dostępowa',
							'nazwa'					=> "wlan$i"
							);
							Insert($dbh, "interfejsy_wezla", $ifc);
							
							$pvn=array(
							'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
							'id_ivn' 		=> $ivn4[id_ivn],
							'id_ifc'		=>	$ifc[id_ifc],
							'tagowany'	=> 'N'
							);
							Insert($dbh, "przyp_vlanu", $pvn);	
					}

					for ( $i=1; $i<=$_POST[il2]; $i++ )
					{
							$ifc=array(
							'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
							'medium'				=> 'kablowe',
							'technologia'		=> 'Ethernet',
							'przepustowosc'	=> '100',
							'id_wzl'				=> $ap[id_nad],
							'ssid'					=> '',
							'warstwa'				=> 'sieć dostępowa',
							'nazwa'					=> "ether$i"
							);
							Insert($dbh, "interfejsy_wezla", $ifc);
							
							$pvn=array(
							'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
							'id_ivn' 			=> $ivn1[id_ivn],
							'id_ifc'		=>	$ifc[id_ifc],
							'tagowany'	=> 'N'
							);
							Insert($dbh, "przyp_vlanu", $pvn);	
					}
					
					for ( $i=1; $i<=$_POST[il3]; $i++ )
					{
							$ifc=array(
							'id_ifc'	  		=> IncValue($dbh,$Q2,  "IFC00000"),  
							'medium'				=> 'radiowe',
							'technologia'		=> 'WiFi',
							'przepustowosc'	=> '54',
							'id_wzl'				=> $ap[id_nad],
							'ssid'					=> 'netico.pl - ulica',
							'warstwa'				=> 'sieć dostępowa',
							'nazwa'					=> "5GHz-$i"
							);
							Insert($dbh, "interfejsy_wezla", $ifc);
		
							$pvn=array(
							'id_pvn'	  => IncValue($dbh,$Q7,  "PVN00000"), 
							'id_ivn'		=> $ivn4[id_ivn],
							'id_ifc'		=>	$ifc[id_ifc],
							'tagowany'	=> 'N'
							);
							Insert($dbh, "przyp_vlanu", $pvn);	
					}
		
	
		$trt=array(
		'id_trt'	  				=> IncValue($dbh,$Q4,  "TRT00000"), 
		'ruch_szkielet' 		=> 'N',
		'ruch_dystrybucja' 	=> 'N',
		'ruch_dostep' 			=> 'T',
		'udost'							=> 'N',
		'kolor_kanal'				=> '5700',
		'id_ifc1'						=> FindId2($_POST[interfejs]),       
		'id_ifc2'						=> $ifc[id_ifc]
		);
		Insert($dbh, "trakty", $trt);	
	

		/*
		$lin=array(
		'id_lin'	  		=> IncValue($dbh,$Q3,  "TRT00000"), 
		'ruch_szkielet' 		=>
		'ruch_dystrybucja' 	=>
		'ruch_dostep' 			=>
		'udost'							=>
		'kolor_kanal'				=>
		'id_lin'						=>
		'id_plc'						=>
		'id_ifc1'						=>
		'id_ifc2'						=>
		);
		Insert($dbh, "interfejsy_wezla", $ifc);
	}
	
		$plc=array(
		'id_trt'	  		=> IncValue($dbh,$Q3,  "TRT00000"), 
		'ruch_szkielet' 		=>
		'ruch_dystrybucja' 	=>
		'ruch_dostep' 			=>
		'udost'							=>
		'kolor_kanal'				=>
		'id_lin'						=>
		'id_plc'						=>
		'id_ifc1'						=>
		'id_ifc2'						=>
		);
		Insert($dbh, "interfejsy_wezla", $ifc);
	}*/
}
	

function ApUpd($dbh, $id_nad)
{
	$n=$_SESSION[$session[ap][update]];
	
		$ap=array(
		'id_nad'	  			=> $id_nad,  			
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
		Update($dbh, "nadajniki", $ap);
		
	
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
