<?php


class COMMITMENT
{


public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=fin&menu=cmtadd", 'name' => 'Nowe zobowiązanie'),
		'form' 	=> array('action' => 'index.php?panel=fin&menu=deletecmt&typ=cmt'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array('Id' 		=>'50',  'Abonent' =>'600',  'Usługa'=>'200', 'ilość' =>'20',  '::' =>'20')
	);
	

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from complaint where id_cpl='$k'";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.<br>";
}

function Form($cmta)
{
	include "func/config.php";


			
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane zobowiązania'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			
			'abonent'	=> array( 'value'=>$cmta[id_abon]),
			'select'		=> array (
													array('wyswietl' => 'Usługa', 'name'=>'usluga', 'size'=>'30', 'query'=>"$QA39", 'value'=>$cmta[id_usl])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Ilość', 'name'=>'ilosc', 'size'=>'40', 'tablica' => array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 
													'11', '12', '13', '14', '15', '16', '17', '18', '19', '20'), 'value'=>$cmta[ilosc])
													),
			'input'		=> array ( 										
			array('wyswietl' => 'Data aktywacji', 'name'=>'aktywne_od', 'size'=>'30', 'value'=>$cmta[aktywne_od]) ),
			
			'link' 	=> array (array('href' => "index.php?panel=inst&menu=cngcmtabn&cmt=$cmta[id_cmt]&abon=$cmta[id_abon]", 'name' => '>>> Zmiana zobowiązania')
			)
			
	);
	
		if (empty ($cmta)) 
		{
			$form[form][action]='index.php?panel=fin&menu=cmtaddsnd';
			if ( empty($cmta[data_aktywacji]) )
				$form[input][0][value] = $conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=fin&menu=cmtupdsnd&cmt=$cmta[id_cmt]";		
		}
		
		return ($form);
													 
}

function PrintList($dbh)
{
		include "func/config.php";
		
	  $query="select c.id_cmt, t.symbol, c.ilosc, n.nazwa, n.symbol, t.id_tows
				from 
				(zobowiazania c left join nazwy n on n.id_abon=c.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
				left join
				towary_sprzedaz t on c.id_usl=t.id_tows 
				where c.aktywne_od <= '$conf[data]' and c.aktywne_do >='$conf[data]'
				 
				order by id_cmt";
				
		WyswietlSql($query);				  
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
			
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=fin&menu=cmtupd&cmt=$row1[0]\"> $row1[0] </a> </td>";
						$s=Choose($row1[4], $row1[3]);
				    echo "<td> <b>$s </b></td>";
				    echo "<td> <a href=\"index.php?panel=fin&menu=updatetow&typ=sprzedaz&id=$row1[5]\"> $row1[1] </a> </td>";
				    echo "<td> $row1[2] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
function cmtValidate($dbh, $ipc)
	{
		$flag=1;

		if ( empty($_POST[abonent]) && $_POST[abonent]=$conf[select] )
		{
			echo "Nie wybrano abonenta <br>";
			$flag=0;
		}
		
		if ( empty($_POST[usluga]) && $_POST[usluga]=$conf[select] )
		{
			echo "Nie wybrano uslugi <br>";
			$flag=0;
		}
		
		if ( $_POST[data_aktywacji] != "" )
			if ( !ValidateDate($_POST[data_aktywacji]) )
				{ 	 
					$flag=0;
				}

		return ($flag);	
	}	

function cmtAdd($dbh)
{
		include "func/config.php";
		$Q1="select id_cmt from zobowiazania order by id_cmt desc limit 1";
		
		$cmt=array(
		'id_cmt'	  			=> IncValue($dbh,$Q1, "CMT00000"),
		'id_usl'					=> FindId2($_POST[usluga]),
		'ilosc'						=> $_POST[ilosc], 
		'id_abon'		  		=> FindId2($_POST[abonent]),	
		'aktywne_od'			=> IsNull($_POST[aktywne_od]), 
		'aktywne_do'			=> $conf[wazne_do]
		);

		Insert($dbh, "zobowiazania", $cmt);
		
}
	
function cmtUpd($dbh, $id_cmt)
{
		include "func/config.php";	
		$cmta=$_SESSION[$id_cmt.$_SESSION[login]];
	
		$cmt=array(
		'id_cmt'	  			=> $id_cmt,
		'id_usl'					=> FindId2($_POST[usluga]),
		'ilosc'						=> $_POST[ilosc], 
		'id_abon'		  		=> FindId2($_POST[abonent]),	
		'aktywne_od'			=> IsNull($_POST[aktywne_od])
		);

		if ( !empty($cmta[id_usl]) && IsNull($cmt[id_usl])=='NULL'  )
				{
					$cmt[aktywne_do]=$conf[poprzednidzien];
					$cmt[id_usl]=$cmta[id_usl];
				}
					
		Update($dbh, "zobowiazania", $cmt);

}

function TaryfaAdd($dbh, $id_urz, $aktywny_od=Null)
{
		include "func/config.php";
		$urza=$_SESSION[$id_urz.$_SESSION[login]];
		
		$ID_TARYFY= FindId2($_POST[dzierzawa]);
		if ( $urza['id_tows'] != $ID_TARYFY)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];

			}

			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
			$q="update pakiety set aktywny_do='$aktywny_do2' where id_urz='$id_urz' and aktywny_do='$conf[wazne_do]'";
					WyswietlSql($q);
			$row=Query($dbh, $q);
				
			$trf=array(
			'id_urz' 		=> $id_urz, 'id_usl' 		=> $ID_TARYFY, 	 'aktywny_od' => $aktywny_od, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $trf);
		}
}	

	

	
}	


?>
