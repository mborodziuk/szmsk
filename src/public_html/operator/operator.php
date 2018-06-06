<?php


class OPERATOR
{


public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=operatoradd", 'name' => 'Nowy operator'),
		'form' 	=> array('action' => 'index.php?panel=admin&menu=deleteoperator&typ=operator'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array('Id' 		=>'100', 'Nazwa'=>'200', 'Nr RPT' =>'200', 'Nr routingowy'=>'200',  '::' =>'20')
	);
	

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from operator where id_opr='$k';";
						Logging($dbh, 'delete', 'operator', $k);
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.<br>";
}

function Form($operatora)
{
	include "func/config.php";


			
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane Operatora Telekomunikacyjnego'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Aktywny', 'name'=>'aktywny', 'value'=>$operatora[aktywny])
													),
			'input'		=> array (
													array('wyswietl' => 'Nazwa', 'name'=>'nazwa', 'size'=>'30', 'value'=>$operatora[nazwa]),
													array('wyswietl' => 'Numer w rejestrze UKE',   'name'=>'rpt', 'size'=>'30', 'value'=>$operatora[rpt]),
													array('wyswietl' => 'Numer rouringowy', 'name'=>'nr_np', 'size'=>'30', 'value'=>$operatora[nr_np])
													)
													
	);
	
		if (empty ($operatora)) 
		{
			$form[form][action]='index.php?panel=admin&menu=operatoraddsnd';
	
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=operatorupdsnd&opr=$operatora[id_opr]";		
		}
		
		return ($form);
													 
}

function PrintList($dbh)
{
		include "func/config.php";
		
	  $query="select o.id_opr, o.nazwa, o.rpt, o.nr_np 
				from operator o
				order by o.id_opr";
				
		WyswietlSql($query);				  
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
			
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=operatorupd&opr=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";
	
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
function OperatorValidate($dbh, $ipc)
	{
		$flag=1;

		if ( empty ($_POST[nazwa]) )
		{
			echo "Nie wprowadzono typu <br>";
			$flag=0;
		}
		if ( strlen($_POST[nazwa]) > 50 )
		{
			echo "Zbyt długa nazwa, maksymana dozwolona ilość znaków to 50. <br>";
			$flag=0;
		}
		if ($_POST[rpt] > 99999 )
		{
			echo "Numer w Rejestrze Przedsiębiorców Telekomunikacyjnych to liczba maksymalnie 99999 <br>";
			$flag=0;
		}
		if (!preg_match("/^[C]{1}[0-9]{4}/", $_POST[nr_np]))
		{
			echo "Numer rutingowy to liczba postaci np. C3149  <br>";
			$flag=0;
		}

		return ($flag);	
	}	

function OperatorAdd($dbh)
{
		include "func/config.php";
		$Q1="select id_opr from operator order by id_opr desc limit 1";
		
		$_SESSION[$_GET[operatora].$_SESSION[login]]=$operator=array(
		'id_opr'	  			=> IncValue($dbh,$Q1, "OPR00000"),
		'nazwa'						=> $_POST[nazwa],
		'rpt'							=> $_POST[rpt], 
		'nr_np'		  				=> $_POST[nr_np],	
		'aktywny'				  => CheckboxToTable($_POST[aktywny])
		);

		Insert($dbh, "operator", $operator);
		Logging($dbh, 'input', 'operator', $operator[id_opr]);		
}
	
function OperatorUpd($dbh, $id_opr)
{
		include "func/config.php";	
		
		$operator=array(
		'id_opr'	  			=> $id_opr,
		'nazwa'						=> $_POST[nazwa],
		'rpt'							=> $_POST[rpt], 
		'nr_np'		  				=> $_POST[nr_np],	
		'aktywny'				  => CheckboxToTable($_POST[aktywny])
		);

		Update($dbh, "operator", $operator);
		Logging($dbh, 'update', 'operator', $id_opr);
}


	

	
}	


?>
