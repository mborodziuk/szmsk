<?php


class PLC
{

public $delete1 = array('polaczenia'=>'id_plc');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=plcadd", 'name' => 'Nowe polaczenie' ),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=plc'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array ('Id' 		=>'100', 'Nazwa' =>'200', 'Medium' =>'120', 'Technologia' =>'200', 'Przepustowość' =>'30', 'SSID' =>'50', 'Warstwa' =>'100', 'Vlan' =>'50', 'Węzeł' =>'100', '::' =>'20')
	);
	
function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
			$q.= "delete from patchcord 						where id_plc='$k'";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}

						
function Form($plca)
{
	include "func/config.php";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane połączenia'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
													
			'selectarray'		=> array (
													array('wyswietl' => 'Przepustowość szkielet razem', 'name'=>'przep_szkielet_razem', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_szkielet_razem]),
													array('wyswietl' => 'Przepustowość szkielet publ', 'name'=>'przep_szkielet_publ', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_szkielet_publ]),
													array('wyswietl' => 'Przepustowość dystrybucja razem', 'name'=>'przep_dystr_razem', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_dystr_razem]),
													array('wyswietl' => 'Przepustowość dystrybucja publ', 'name'=>'przep_dystr_publ', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_dystr_publ]),
													array('wyswietl' => 'Przepustowość dostęp razem', 'name'=>'przep_dost_razem', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_dostep_razem]),
													array('wyswietl' => 'Przepustowość dostęp publ', 'name'=>'przep_dost_publ', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_dostep_publ]),
													array('wyswietl' => 'Przepustowość niewykorzystana razem', 'name'=>'przep_niewyk_razem', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_niewyk_razem]),
													array('wyswietl' => 'Przepustowość niewykorzystana publ', 'name'=>'przep_niewyk_publ', 'size'=>'30', 
													'tablica' => array('0', '1000', '100', '20'), 'value'=>$plca[przep_niewyk_publ])
													),
			
			'select'		=> array (
													array('wyswietl' => 'Koniec', 	'name'=>'ifc2', 'size'=>'30', 'query'=>"$QA22", 'value'=>$plca[id_ifc2])
													)
	);
	
	if (empty ($plca[id_plc])) 
		{
			$form[form][action]="index.php?panel=admin&menu=plcaddsnd&id_ifc=$_GET[id_ifc]";
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=plcupdsnd&plc=$plca[id_plc]";		
		}
		return ($form);
													
}

function PrintList($dbh, $www=NULL)
{
	  $query="select i.id_plc, i.nazwa, i.typ, o.odf
					from socket i, odf o where
					o.id_plc=i.id_plc order by i.id_plc";
		
		WyswietlSql($query);
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=plcupd&plc=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";
				    echo "<td> $row1[4] </td>";
				    echo "<td> $row1[5] </td>";
				    echo "<td> $row1[6] </td>";
				    echo "<td> $row1[7] </td>";
				    echo "<td> $row1[8] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
	
function PlcValidate()
	{
		$flag=1;

	/*	if ( empty ($_POST[ifc1]) || $_POST[ifc1] == $conf[select] )
		{
			echo "Nie wprowadzono początku włókna <br>";
			$flag=0;
		}*/		
		if ( empty ($_POST[ifc2]) || $_POST[ifc2] == $conf[select] )
		{
			echo "Nie wprowadzono końca włókna <br>";
			$flag=0;
		}		

		return ($flag);	
	}	

function PlcAdd($dbh, $id_ifc)
{
		$Q="select id_plc from polaczenia order by id_plc desc limit 1";
		
		$plc=array(
			'id_plc' 							=> IncValue($dbh, $Q,  "PLC00000"), 
			'przep_szkielet_razem'=> $_POST[przep_szkielet_razem],
			'przep_szkielet_publ' => $_POST[przep_szkielet_publ],
			'przep_dystr_razem' 	=> $_POST[przep_dystr_razem],
			'przep_dystr_publ'		=> $_POST[przep_dystr_publ],
			'przep_dost_razem'		=>	$_POST[przep_dost_razem],
			'przep_dost_publ' 		=>	$_POST[przep_dost_publ],
			'przep_niewyk_razem'  =>	$_POST[przep_niewyk_razem],
			'przep_niewyk_publ' 	=>	$_POST[przep_niewyk_publ],
			'id_ifc1'							=>  FindId2($_POST[ifc2]), 
			'id_ifc2'							=>  $id_ifc  
		);
		Insert($dbh, "polaczenia", $plc);
}
	

function PlcUpd($dbh, $id_plc)
{
		include "func/config.php";
	
		$plca=$_SESSION[$session[plc][update]];
		$ifc=FindId2($_POST[ifc2]);
		
		//$q1="update patchcordy set id_ifc2=NULL where id_ifc2='$ifc'";
		//$r=Query2($q1, $dbh);
			
		$plc=array(
		'id_plc'	 					=> $id_plc,  			
	//	'id_ifc1' 					=> FindId2($_POST[ifc1]),   
		'id_ifc2' 					=> FindId2($_POST[ifc2])   
		);
		
		Update($dbh, "polaczenia", $plc);
}
	

	
}	


?>
