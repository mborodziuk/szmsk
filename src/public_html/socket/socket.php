<?php


class SKT
{

public $delete1 = array('socket'=>'id_skt');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=sktadd", 'name' => 'Nowy interfejs' ),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=skt'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array ('Id' 		=>'100', 'Nazwa' =>'200', 'Medium' =>'120', 'Technologia' =>'200', 'Przepustowość' =>'30', 'SSID' =>'50', 'Warstwa' =>'100', 'Vlan' =>'50', 'Węzeł' =>'100', '::' =>'20')
	);
	

	
function Form($skta)
{
	include "func/config.php";
	
	$Q=" select l.nazwa, t.kolor_kanal, t.id_trt from trakty t, line l, socket s, odf o where t.id_lin=l.id_lin and (l.pkt_a=o.id_odf or l.pkt_b=o.id_odf)and s.id_odf=o.id_odf and s.id_skt='$_GET[skt]'order by t.kolor_kanal";
			
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane złącza'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
	
			'input'		=> array (
													array('wyswietl' => 'Nazwa', 	'name'=>'nazwa', 	'size'=>'40', 'value'=>$skta[nazwa]),
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Typ', 'name'=>'typ', 'size'=>'60', 'tablica' => array('SC/PC', 'SC/APC', 'FC/PC', 'FC/APC', 'ST/PC', 'LC/PC', 'E2000/PC', 'E2000/APC'), 'value'=>$skta[typ]),
													),
			'select'		=> array (
													array('wyswietl' => 'Włókno', 'name'=>'trt', 'size'=>'30', 'query'=>"$Q", 'value'=>$skta[id_trt])
													)
	);
	
	if (empty ($skta[id_skt])) 
		{
			$form[form][action]="index.php?panel=admin&menu=sktaddsnd&id_skt=$_GET[id_skt]";
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=sktupdsnd&skt=$skta[id_skt]";		
		}
		return ($form);
													
}

function PrintList($dbh, $www=NULL)
{
	  $query="select i.id_skt, i.nazwa, i.typ, o.odf
					from socket i, odf o where
					o.id_skt=i.id_skt order by i.id_skt";
		
		WyswietlSql($query);
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=sktupd&skt=$row1[0]\"> $row1[0] </a> </td>";
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
	
	

function SktValidate()
	{
		$flag=1;

		if ( empty ($_POST[nazwa]) )
		{
			echo "Nie wprowadzono nazwy <br>";
			$flag=0;
		}
		if ( empty ($_POST[typ]) )
		{
			echo "Nie wprowadzono typu złącza <br>";
			$flag=0;
		}
	
		if ( empty ($_POST[trt]) || $_POST[trt] == $conf[select] )
		{
			echo "Nie wprowadzono włókna <br>";
			$flag=0;
		}		

		return ($flag);	
	}	

function SktAdd($dbh)
{
		$Q="select id_skt from socket order by id_skt desc limit 1";

			
		$skt=array(
		'id_skt'	  => IncValue($dbh,$Q),  			
		'nazwa'			=> $_POST[nazwa], 
		'typ'		  	=> $_POST[typ],
		'id_odf'		=> FindId2($_POST[odf])
		);
		
		Insert($dbh, "socket", $skt);
	}
	

function SktUpd($dbh, $id_skt)
{
		include "func/config.php";
	
		$skta=$_SESSION[$session[skt][update]];
	
		print_r($skta);
	
	$skt=array(
		'id_skt'	  => $id_skt,  			
		'nazwa'			=> $_POST[nazwa], 
		'typ'		  	=> $_POST[typ],
		);
		
		Update($dbh, "socket", $skt);

		
		$trt=array(
		'id_trt'	  				=> $skta[id_trt], 
		$skta[id_ifc]				=> 'NULL',       
		);
		Update($dbh, "trakty", $trt);			
		
		$trt=array(
		'id_trt'	  				=> FindId2($_POST[trt]), 
		$skta[id_ifc]				=> $id_skt,       
		);
		Update($dbh, "trakty", $trt);	
	
}
	

	
}	


?>
