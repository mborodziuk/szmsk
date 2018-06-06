<?php


class PTC
{

public $delete1 = array('socket'=>'id_ptc');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=ptcadd", 'name' => 'Nowy interfejs' ),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=ptc'),
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
			$q.= "delete from patchcord 						where id_ptc='$k'";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	
function Form($ptca)
{
	include "func/config.php";
	
	/*$Q1="select l.nazwa, t.kolor_kanal, t.id_ptc from patchcordy t, line l, mufy m where t.id_lin=l.id_lin and l.pkt_b=m.id_muf and m.id_muf in 
	(select pkt_a from line where id_lin in (select id_lin from patchcordy where id_ptc='$_GET[ptc]') ) order  by l.nazwa, t.kolor_kanal";
	*/
	$Q2="(select o.nazwa, s.nazwa, s.id_skt from odf o, socket s 
	where s.id_odf=o.id_odf  order  by o.nazwa, s.nazwa) 
	union
	(select l.nazwa, t.kolor_kanal, t.id_trt from line l, trakty t
	where l.id_lin=t.id_lin order by l.nazwa, t.kolor_kanal)";			
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane patchcordu'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'select'		=> array (
											//		array('wyswietl' => 'Początek', 'name'=>'ifc1', 'size'=>'30', 'query'=>"$Q1", 'value'=>$ptca[id_ifc1]),
													array('wyswietl' => 'Koniec', 	'name'=>'ifc2', 'size'=>'30', 'query'=>"$Q2", 'value'=>$ptca[id_ifc2])
													)
	);
	
	if (empty ($ptca[id_ptc])) 
		{
			$form[form][action]="index.php?panel=admin&menu=ptcaddsnd&&id_ifc=$_GET[id_ifc]";
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=ptcupdsnd&ptc=$ptca[id_ptc]";		
		}
		return ($form);
													
}

function PrintList($dbh, $www=NULL)
{
	  $query="select i.id_ptc, i.nazwa, i.typ, o.odf
					from socket i, odf o where
					o.id_ptc=i.id_ptc order by i.id_ptc";
		
		WyswietlSql($query);
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=ptcupd&ptc=$row1[0]\"> $row1[0] </a> </td>";
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
	
	
function PtcValidate()
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

function PtcAdd($dbh, $id_ifc)
{
		$Q="select id_ptc from patchcord order by id_ptc desc limit 1";
		
		$ptc=array(
		'id_ptc'	 					=> IncValue($dbh,$Q,  "PTC00000"),    			  			
		'id_ifc1' 					=> $id_ifc,   
		'id_ifc2' 					=> FindId2($_POST[ifc2])   
		);
		Insert($dbh, "patchcord", $ptc);
}
	

function PtcUpd($dbh, $id_ptc)
{
		include "func/config.php";
	
		$ptca=$_SESSION[$session[ptc][update]];
		$ifc=FindId2($_POST[ifc2]);
		
		//$q1="update patchcordy set id_ifc2=NULL where id_ifc2='$ifc'";
		//$r=Query2($q1, $dbh);
			
		$ptc=array(
		'id_ptc'	 					=> $id_ptc,  			
	//	'id_ifc1' 					=> FindId2($_POST[ifc1]),   
		'id_ifc2' 					=> FindId2($_POST[ifc2])   
		);
		
		Update($dbh, "patchcord", $ptc);
	
}
	

	
}	


?>
