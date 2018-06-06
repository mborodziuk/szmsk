<?php


class IFC
{

public $delete1 = array('interfejsy_wezla'=>'id_ifc');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=ifcadd", 'name' => 'Nowy interfejs' ),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=ifc'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array ('Id' 		=>'100', 'Nazwa' =>'200', 'Medium' =>'120', 'Technologia' =>'200', 'Przepustowość' =>'30', 'SSID' =>'50', 'Rdzeń' =>'10', 'Dystrybucja' =>'10', 'Dostęp' =>'10', 'Vlan' =>'50', 'Węzeł' =>'100', '::' =>'20')
	);
	

	
function Form($ifca)
{
	include "func/config.php";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane interfejsu'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
	
			'input'		=> array (
													array('wyswietl' => 'Nazwa', 	'name'=>'nazwa', 	'size'=>'40', 'value'=>$ifca[nazwa]),
													array('wyswietl' => 'SSID', 	'name'=>'ssid', 	'size'=>'40', 'value'=>$ifca[ssid])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Medium', 'name'=>'medium', 'size'=>'60', 'tablica' => array('radiowe','kablowe','światłowodowe'), 'value'=>$ifca[medium]),
													array('wyswietl' => 'Technologia', 'name'=>'technologia', 'size'=>'60', 'tablica' => array('Ethernet','WiFi'), 'value'=>$ifca[technologia]),
													array('wyswietl' => 'Przepustowość', 'name'=>'przepustowosc', 'size'=>'60', 'tablica' => array('20','50','100'), 'value'=>$ifca[przepustowosc])
													),
			'select'		=> array (
													array('wyswietl' => 'Połączenie', 'name'=>'interfejs', 'size'=>'30', 'query'=>"$QA22", 'value'=>$ifca[id_ifc1])
											//		array('wyswietl' => 'Patchcord', 	'name'=>'patchcord', 'size'=>'30', 'query'=>"$QA25", 'value'=>$ifca[id_ptc])
													),
			'checkbox'=> array (
													array('wyswietl' => 'Szkieletowy', 	 'name'=>'rdzen', 'value'=>$ifca[rdzen]),
													array('wyswietl' => 'Dystrybucyjny', 'name'=>'dystrybucja', 'value'=>$ifca[dystrybucja]),
													array('wyswietl' => 'Dostępowy', 			'name'=>'dostep', 'value'=>$ifca[dostep])
													),		
			'link' 			=> array(array('href' => "index.php?panel=admin&menu=ptcadd&id_ifc=$ifca[id_ifc]", 'name' => '>>> Dodaj patchcord'),
													array('href' => "index.php?panel=admin&menu=plcadd&id_ifc=$ifca[id_ifc]", 'name' => '>>> Dodaj połączenie')
			)
	);
	
	if (empty ($ifca[id_ifc])) 
		{
			$form[form][action]="index.php?panel=admin&menu=ifcaddsnd&id_wzl=$_GET[id_wzl]";
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=ifcupdsnd&ifc=$ifca[id_ifc]";		
		}
		return ($form);
													
}

function PrintList($dbh, $www=NULL)
{
	  $query="select i.id_ifc, i.nazwa, i.medium, i.technologia, i.przepustowosc, i.ssid,  i.rdzen,  i.dystrybucja,  i.dostep, w.nazwa
					from interfejsy_wezla i, wezly w where
					w.id_wzl=i.id_wzl order by i.id_ifc";
		
		WyswietlSql($query);
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=ifcupd&ifc=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";
				    echo "<td> $row1[4] </td>";
				    echo "<td> $row1[5] </td>";
				    echo "<td> $row1[6] </td>";
				    echo "<td> $row1[7] </td>";
				    echo "<td> $row1[8] </td>";
				    echo "<td> $row1[9] </td>";
				    echo "<td> $row1[10] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
	

function IfcValidate()
	{
		$flag=1;

		if ( empty ($_POST[nazwa]) )
		{
			echo "Nie wprowadzono nazwy <br>";
			$flag=0;
		}
		if ( empty ($_POST[medium]) )
		{
			echo "Nie wprowadzono medium <br>";
			$flag=0;
		}
		if ( empty ($_POST[technologia]) )
		{
			echo "Nie wprowadzono technologia <br>";
			$flag=0;
		}
		if ( empty ($_POST[przepustowosc]) )
		{
			echo "Nie wprowadzono przepustowosc <br>";
			$flag=0;
		}
		if ( empty ($_POST[warstwa]) )
		{
			echo "Nie wprowadzono Warstwa <br>";
			$flag=0;
		}
/*		if ( empty ($_POST[wezel]) || $_POST[wezel] == $conf[select] )
		{
			echo "Nie wprowadzono Węzła <br>";
			$flag=0;
		}		*/

		return ($flag);	
	}	

function IfcAdd($dbh)
{
		$Q="select id_ifc from interfejsy_wezla order by id_ifc desc limit 1";
		if ( empty ($_POST[vlan]) )
			$_POST[vlan]='NULL';
			
		$ifc=array(
		'id_ifc'	  			=> IncValue($dbh,$Q),  			
		'nazwa'						=> $_POST[nazwa], 
		'medium'		  		=> $_POST[medium],
		'technologia'		  => $_POST[technologia],
		'przepustowosc' 	=> $_POST[przepustowosc],   
	  'ssid'						=> $_POST[ssid], 
		'rdzen'				  	=> $_POST[rdzen], 
		'dystrybucja'			=> $_POST[dystrybucja], 
		'dostep'				  => $_POST[dostep], 
		'id_wzl'				  => FindId2($_POST[wezel])
		);
		
		Insert($dbh, "interfejsy_wezla", $ifc);
	}
	

function IfcUpd($dbh, $id_ifc)
{
	include "func/config.php";
	
	$ifca=$_SESSION[$session[ifc][update]];
				
		if ( empty ($_POST[vlan]) )
			$_POST[vlan]='NULL';
			
		$ifc=array(
		'id_ifc'	  			=> $id_ifc,  			
		'nazwa'						=> $_POST[nazwa], 
		'medium'		  		=> $_POST[medium],
		'technologia'		  => $_POST[technologia],
		'przepustowosc' 	=> $_POST[przepustowosc],   
	  'ssid'						=> $_POST[ssid], 
		'warstwa'				  => $_POST[warstwa],
 		'rdzen'				  	=> $_POST[rdzen], 
		'dystrybucja'			=> $_POST[dystrybucja], 
		'dostep'				  => $_POST[dostep], 		
		'id_wzl'				  => $ifca[id_wzl]
		);
		Update($dbh, "interfejsy_wezla", $ifc);
		
		$id_ifc1=FindId2($_POST[interfejs]);
		
		if ( $id_ifc1 != $ifca[id_ifc1] && IsNull($id_ifc1)!='NULL'  )
		{
			$plc=array(
			'id_plc'	  				=> $ifca[id_plc], 
			'id_ifc1'						=> $id_ifc1       
			);
			Update($dbh, "polaczenia", $plc);	
		}
		
	}
	
}	


?>
