<?php


class TRT
{

public $delete1 = array('socket'=>'id_trt');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=trtadd", 'name' => 'Nowy interfejs' ),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=trt'),
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
			$q.= "delete from trakty 						where id_lin='$k'";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	
function Form($trta)
{
	include "func/config.php";
	
	$Q1="select l.nazwa, t.kolor_kanal, t.id_trt from trakty t, line l, mufy m where t.id_lin=l.id_lin and l.pkt_b=m.id_muf and m.id_muf in 
	(select pkt_a from line where id_lin in (select id_lin from trakty where id_trt='$_GET[trt]') ) order  by l.nazwa, t.kolor_kanal";
	
	$Q2="select l.nazwa, t.kolor_kanal, t.id_trt from trakty t, line l, mufy m where t.id_lin=l.id_lin and l.pkt_a=m.id_muf and m.id_muf in 
	(select pkt_b from line where id_lin in (select id_lin from trakty where id_trt='$_GET[trt]') ) order  by l.nazwa, t.kolor_kanal";			
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane traktu'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Ruch szkielet', 			'name'=>'ruch_szkielet', 		'value'	=>$trta[ruch_szkielet]),
													array('wyswietl' => 'Ruch dystrybucja', 	'name'=>'ruch_dystrybucja', 'value'	=>$trta[ruch_dystrybucja]),
													array('wyswietl' => 'Ruch dostęp', 				'name'=>'ruch_dostep', 			'value'	=>$trta[ruch_dostep]),
													array('wyswietl' => 'Udostepniony', 			'name'=>'udost', 						'value'	=>$trta[udost])
													),	
			'selectarray'		=> array (
													array('wyswietl' => 'Kolor/kanał', 'name'=>'kolor_kanal', 'size'=>'60', 'tablica' => 
													array(0	=> $conf[select], 1=>'czerwony', 2=>'zielony', 3=>'niebieski', 4=>'biały', 5=>'fioletowy', 6=>'pomarańczowy', 
		7=>'szary', 8=>'żółty', 9=>'brązowy', 10=>'różowy', 11=>'czarny', 12=>'turkusowy' ), 'value'=>$trta[typ]),
													),
			'select'		=> array (
											//		array('wyswietl' => 'Początek', 'name'=>'ifc1', 'size'=>'30', 'query'=>"$Q1", 'value'=>$trta[id_ifc1]),
													array('wyswietl' => 'Koniec', 	'name'=>'ifc2', 'size'=>'30', 'query'=>"$Q2", 'value'=>$trta[id_ifc2])
													)
	);
	
	if (empty ($trta[id_trt])) 
		{
			$form[form][action]="index.php?panel=admin&menu=trtaddsnd&id_trt=$_GET[id_trt]";
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=trtupdsnd&trt=$trta[id_trt]";		
		}
		return ($form);
													
}

function PrintList($dbh, $www=NULL)
{
	  $query="select i.id_trt, i.nazwa, i.typ, o.odf
					from socket i, odf o where
					o.id_trt=i.id_trt order by i.id_trt";
		
		WyswietlSql($query);
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=trtupd&trt=$row1[0]\"> $row1[0] </a> </td>";
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
	
	
function TrtValidate()
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

function TrtAdd($dbh)
{
		$Q="select id_trt from socket order by id_trt desc limit 1";

			
		$trt=array(
		'id_trt'	  => IncValue($dbh,$Q),  			
		'nazwa'			=> $_POST[nazwa], 
		'typ'		  	=> $_POST[typ],
		'id_odf'		=> FindId2($_POST[odf])
		);
		
		Insert($dbh, "socket", $trt);
	}
	

function TrtUpd($dbh, $id_trt)
{
		include "func/config.php";
	
		$trta=$_SESSION[$session[trt][update]];
		$ifc=FindId2($_POST[ifc2]);
		
		//$q1="update trakty set id_ifc2=NULL where id_ifc2='$ifc'";
		//$r=Query2($q1, $dbh);
			
		$trt=array(
		'id_trt'	 					=> $id_trt,  			
		'ruch_szkielet'			=> CheckboxToTable($_POST[ruch_szkielet]), 
		'ruch_dystrybucja'	=> CheckboxToTable($_POST[ruch_dystrybucja]),
		'ruch_dostep'				=> CheckboxToTable($_POST[ruch_dostep]),
		'udost'							=> CheckboxToTable($_POST[udost]),
	//	'id_ifc1' 					=> FindId2($_POST[ifc1]),   
		'id_ifc2' 					=> FindId2($_POST[ifc2])   
		);
		
		Update($dbh, "trakty", $trt);
	
}
	

	
}	


?>
