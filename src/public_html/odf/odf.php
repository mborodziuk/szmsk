<?php

//Optical Distribution Frame
class ODF
{


public $table=array( 
		'link' 	=> array('href' => "index.php?panel=admin&menu=odfadd", 'name' => 'Nowa przełącznica'),
		'form' 	=> array('action' => 'index.php?panel=admin&menu=deleteodf&typ=odf'),
		'table' => array('witdh' => '1000', 'height'=>'50'),
		'row'		=> array ('Id złącza' =>'10', 'Nazwa złącza' =>'120',  'Id traktu' =>'200', 'Kolor / kanał traktu' =>'400', '::' =>'20')
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
						delete from odf 						  where id_odf='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}
	
function Form($odfa)
{
	include "func/config.php";
	
	$q1="
	select id_skt, nazwa1, nazwa2, nazwa3, nazwa4,  kolor_kanal, id_odf from
	(
	select s.id_skt, s.nazwa as nazwa1, o.nazwa as nazwa2, i.nazwa as nazwa3, l.nazwa as nazwa4,  t.kolor_kanal, s.id_odf as id_odf from 
	(socket s left join  (trakty t join line l on l.id_lin=t.id_lin ) on 
  t.id_ifc1=s.id_skt or t.id_ifc2=s.id_skt) left join
	((interfejsy_wezla i join olt o on i.id_wzl=o.id_olt) join patchcord p on p.id_ifc1=i.id_ifc) 
	on  p.id_ifc1=s.id_skt or p.id_ifc2=s.id_skt
	union	
	select s.id_skt, s.nazwa as nazwa1, w.nazwa as nazwa2, i.nazwa as nazwa3, l.nazwa as nazwa4,  t.kolor_kanal, s.id_odf as id_odf from 
	(socket s left join  (trakty t join line l on l.id_lin=t.id_lin ) on 
  t.id_ifc1=s.id_skt or t.id_ifc2=s.id_skt) left join
	((interfejsy_wezla i join wezly w on i.id_wzl=w.id_wzl) join patchcord p on p.id_ifc1=i.id_ifc) 
	on  p.id_ifc1=s.id_skt or p.id_ifc2=s.id_skt
	) q
	where id_odf='$odfa[id_odf]'
	order by 1";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane przełącznicy'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Szkieletowy', 'name'=>'szkieletowy', 'value'=>$odfa[szkieletowy]),
													array('wyswietl' => 'Dystrybucyjny', 'name'=>'dystrybucyjny', 'value'=>$odfa[dystrybucyjny]),
													array('wyswietl' => 'Dostępowy', 'name'=>'dostepowy', 'value'=>$odfa[dostepowy])
													),		
			'input'		=> array (
													array('wyswietl' => 'Nazwa', 					'name'=>'nazwa', 'size'=>'30', 'value'=>$odfa[nazwa]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'data_aktywacji', 'size'=>'30', 'value'=>$odfa[data_aktywacji])
													),
			'selectarray'		=> array (					
													array('wyswietl' => 'Typ złącza / adaptera', 'name'=>'typ', 'size'=>'30', 'tablica' => array('SC/PC', 'SC/APC', 'FC/PC', 'FC/APC', 'ST/PC', 'LC/PC', 'E2000/PC', 'E2000/APC'), 'value'=>$odfa[typ]),		
																		
													array('wyswietl' => 'Ilość złączy', 'name'=>'ilosc', 'size'=>'30', 'tablica' => array('96', '192', '48'), 'value'=>$odfa[ilosc])
													),
					'select'		=> array (
													array('wyswietl' => 'Lokalizacja', 'name'=>'budynek', 'size'=>'30', 'query'=>"$QUERY1", 'value'=>$odfa[budynek])
													),													
			'list'		=>array ( 
													array(
													'add'		=> array ('query'=> $q1, 'type'=> 'skt'),
													'row'		=> array ('Lp.'=>'10', 'Id złącza' => '10',  'Nazwa złącza' => '30', 'Węzeł' => '50', 'Interfejs' => '50', 'Nazwa linii' => '50',  'Kolor włókna' => '50', '::' =>'20'),
													'link' 	=> array('href' => "index.php?panel=admin&menu=sktadd&id_odf=$odfa[id_odf]", 'name' => '>>> Nowe złącze')
													),
													
												)											
	);
	
	if (empty ($odfa)) 
		{
			$form[form][action]='index.php?panel=admin&menu=odfaddsnd';
			$form[input][1][value]=$conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=odfupdsnd&odf=$odfa[id_odf]";		
		}

		return ($form);
}

function PrintList($dbh, $www=NULL)
{
	  $q1="select distinct o.id_odf, o.nazwa,  o.typ, u.miasto, u.cecha, u.nazwa, b.numer  
					from odf o  left join (ulice u join budynki b on u.id_ul=b.id_ul) on 
					o.id_bud=b.id_bud order by o.id_odf, o.nazwa";

		
		WyswietlSql($q1);
	  $sth1=Query($dbh,$q1);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
				$addr=array('kod'=> NULL, 'miasto' => $row1[3], 'cecha'=>$row1[4], 'ulica' => $row1[5], 'budynek' => $row1[6]);
				
				$adres=$www->Adres($addr);
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=odfupd&odf=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";;
						echo "<td> $adres </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
	

function OdfValidate()
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

function OdfAdd($dbh)
{
		include "func/config.php";

		$Q= "select id_odf from odf 						order by id_odf desc limit 1";
		$Q2="select id_skt from socket						order by id_skt desc limit 1";
		$Q3="select id_ivn from inst_vlanu 				order by id_ivn desc limit 1";
		$Q4="select id_trt from trakty 						order by id_trt desc limit 1";
		$Q5="select id_plc from polaczenia 				order by id_plc desc limit 1";
		$Q6="select id_lin from linie 						order by id_lin desc limit 1";

		
		$odf=array(
		'id_odf'	  			=> IncValue($dbh,$Q,  "ODF00000"),  			
 
		'nazwa'		  			=> $_POST[nazwa],
		'id_bud' 					=> FindId2($_POST[budynek]),   
	  'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'szkieletowy'			=> CheckboxToTable($_POST[szkieletowy]), 
		'dystrybucyjny'		=> CheckboxToTable($_POST[dystrybucyjny]),
		'dostepowy'				=> CheckboxToTable($_POST[dostepowy])
		);		
		Insert($dbh, "odf", $odf);
	


		for ( $i=1; $i<=$_POST[ilosc]/2; $i++ )
			{
				$skt=array(
					'id_skt'	  		=> IncValue($dbh,$Q2,  "SKT00000"),  
					'typ'						=> $_POST[typ],
					'id_odf'				=> $odf[id_odf],
					'nazwa'					=> "$i"."A"
					);
				Insert($dbh, "socket", $skt);
				$skt=array(
					'id_skt'	  		=> IncValue($dbh,$Q2,  "SKT00000"),  
					'typ'						=> $_POST[typ],
					'id_odf'				=> $odf[id_odf],
					'nazwa'					=> "$i"."B"
					);		
				Insert($dbh, "socket", $skt);
			}
					
}
	

function OdfUpd($dbh, $id_odf)
{
		include "func/config.php";
	
		$odf0=$_SESSION[$session[odf][update]];
			
		$odf=array(
		'id_odf'	  			=> $id_odf,  			
		'nazwa'		  			=> $_POST[nazwa],
		'id_bud' 					=> FindId2($_POST[budynek]),   
	  'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'szkieletowy'			=> CheckboxToTable($_POST[szkieletowy]), 
		'dystrybucyjny'		=> CheckboxToTable($_POST[dystrybucyjny]),
		'dostepowy'				=> CheckboxToTable($_POST[dostepowy])
		);
		Update($dbh, "odf", $odf);

	}
}	


?>
