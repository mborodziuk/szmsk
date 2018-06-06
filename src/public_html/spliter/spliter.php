<?php


class SPLITER
{


public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=sptadd", 'name' => 'Nowy spt'),
		'form' 	=> array('action' => 'index.php?panel=admin&menu=deletespt&typ=spt'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array ('Id' 		=>'10', 'Nazwa' =>'120',  'Typ' =>'200', 'Adres' =>'400', '::' =>'20')
	);
	
function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
			$q.= "delete from socket 	where id_odf='$k';
						delete from spliter where id_spt='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	
function Form($spta)
{
	include "func/config.php";
	

		
/*	if (empty ($spta)) 
		{
			$spta[data_aktywacji]=$conf[data];
		}
	*/	
	$q1="select id_skt, nazwa, typ from socket where id_odf='$spta[id_spt]'  order by id_skt";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane spta'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),	
			'checkbox'=> array (
													array('wyswietl' => 'Asymetryczny', 'name'=>'asymetryczny', 'value'=>$spta[asymetryczny])
													),	
			'input'		=> array (
													array('wyswietl' => 'Nazwa', 									'name'=>'nazwa', 					'size'=>'30', 'value'=>$spta[nazwa]),
													array('wyswietl' => 'Data aktywacji', 				'name'=>'data_aktywacji', 'size'=>'30', 'value'=>$spta[data_aktywacji]),
													array('wyswietl' => 'Szerokość geograficzna', 'name'=>'szerokosc', 			'size'=>'30', 'value'=>$spta[szerokosc]),
													array('wyswietl' => 'Długość geograficzna', 	'name'=>'dlugosc', 				'size'=>'30', 'value'=>$spta[dlugosc]),
													array('wyswietl' => 'Tłumienie', 							'name'=>'tlumienie', 			'size'=>'30', 'value'=>$spta[tlumienie])
													),
			'selectarray'		=> array (					
													array('wyswietl' => 'Typ złącza / adaptera', 'name'=>'typ', 'size'=>'30', 'tablica' => 
																array('SC/APC', 'SC/PC', 'FC/PC', 'FC/APC', 'ST/PC', 'LC/PC', 'E2000/PC', 'E2000/APC'), 'value'=>$spta[typ]),		
																		
													array('wyswietl' => 'Ilość złączy', 'name'=>'ilosc', 'size'=>'30', 'tablica' => array('8', '2','4', '16'), 'value'=>$spta[ilosc])
													),
			'select'		=> array (
													array('wyswietl' => 'Włókno', 'name'=>'trt', 'size'=>'30', 'query'=>"$QA25", 'value'=>$spta[id_trt])
													),
			'list'		=>array ( 
													array(
													'add'		=> array ('query'=> $q1, 'type'=> 'skt'),
													'row'		=> array ('Id' => '10',  'Nazwa' => '30', 'Typ' => '50', '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=sktadd&id_spt=$spta[id_spt]", 'name' => '>>> Nowe złącze')
													),
													
												)											
	);
			if (empty ($spta)) 
		{
			$form[form][action]='index.php?panel=admin&menu=sptaddsnd';
			$form[input][1][value]=$conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=sptupdsnd&spt=$spta[id_spt]";		
		}
			return ($form);

}

function PrintList($dbh, $www=NULL)
{
	  $q1="select id_spt, nazwa,  typ, wsp 
					from spliter  order by id_spt, nazwa";

		
		WyswietlSql($q1);
	  $sth1=Query($dbh,$q1);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
				DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=sptupd&spt=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";;
						echo "<td> <a href=\"javascript&#058;displayWindow('https://maps.google.com/maps?z=18&q=$row1[3]',1280,1000, '38')\"> Pokaż </a></td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}


function SptValidate()
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


function SptAdd($dbh)
{
		include "func/config.php";

		$Q= "select id_spt from spliter 					order by id_spt desc limit 1";
		$Q2="select id_skt from socket						order by id_skt desc limit 1";
		$Q3="select id_ivn from inst_vlanu 				order by id_ivn desc limit 1";
		$Q4="select id_trt from trakty 						order by id_trt desc limit 1";
		$Q5="select id_plc from polaczenia 				order by id_plc desc limit 1";
		$Q6="select id_lin from linie 						order by id_lin desc limit 1";

		
		$spt=array(
		'id_spt'	  			=> IncValue($dbh,$Q,  "SPT00000"),  			
 		'asymetryczny'		=> CheckboxToTable($_POST[asymetryczny]),
		'nazwa'		  			=> $_POST[nazwa],
		'tlumienie'		  	=> $_POST[tlumienie],
		'typ' 						=> $_POST[typ],   
	  'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'wsp'							=> "$_POST[szerokosc],$_POST[dlugosc]", 
		);		
		Insert($dbh, "spliter", $spt);
	
		$skt=array(
			'id_skt'	  		=> IncValue($dbh,$Q2,  "SKT00000"),  
			'typ'						=> $_POST[typ],
			'id_odf'				=> $spt[id_spt],
			'nazwa'					=> "Socket0"
		);
		Insert($dbh, "socket", $skt);
				
		$trt=array(
			'id_trt'	  				=> FindId2($_POST[trt]), 
			'id_ifc2'						=> $skt[id_skt]
		);
		Update($dbh, "trakty", $trt);	
			
		for ( $i=1; $i<=$_POST[ilosc]; $i++ )
			{
				$skt=array(
					'id_skt'	  		=> IncValue($dbh,$Q2,  "SKT00000"),  
					'typ'						=> $_POST[typ],
					'id_odf'				=> $spt[id_spt],
					'nazwa'					=> "Socket$i"
					);
				Insert($dbh, "socket", $skt);
			}					
}
	

function SptUpd($dbh, $id_spt)
{
		include "func/config.php";
	
		$spt=array(
		'id_spt'	  			=> $id_spt,  			
 		'asymetryczny'		=> CheckboxToTable($_POST[asymetryczny]),
		'nazwa'		  			=> $_POST[nazwa],
		'tlumienie'		  	=> $_POST[tlumienie],
		'typ' 						=> $_POST[typ],   
	  'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'wsp'							=> "$_POST[szerokosc],$_POST[dlugosc]",
		);
		Update($dbh, "spliter", $spt);
		
		$id_trt=FindId2($_POST[trt]);
		
		$q1="update trakty set id_ifc2=(select k.id_skt from socket k, spliter s where k.id_odf=s.id_spt and k.nazwa='Socket0' and s.id_spt='$id_spt')
		where id_trt='$id_trt'";
		WyswietlSql($q1);
		Query2($q1, $dbh);


	}
}	


?>
