<?php

class SUBNET
{

public $delete1 = array('podsieci'=>'id_pds');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=subnetadd", 'name' => 'Nowa podsieć'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=subnet'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array ('Id' 		=>'10','Adres' 		=>'100', 'Maska' =>'200', 'Brama' =>'120', 'Broadcast' =>'200', 'Warstwa' =>'30', 'Dostępna przez'=>'100', 'Wykorzystana' =>'50', '::' =>'20')
	);
	

	
function Form($subneta)
{
	include "func/config.php";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane podsieci'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Wykorzystana', 'name'=>'wykorzystana', 'value'=>$subneta[wykorzystana])
													),	
			'input'		=> array (
													array('wyswietl' => 'Adres', 	'name'=>'adres', 	'size'=>'30', 'value'=>$subneta[adres]),
													array('wyswietl' => 'Maska', 	'name'=>'maska', 	'size'=>'30', 'value'=>$subneta[maska]),
													array('wyswietl' => 'Brama', 	'name'=>'brama', 	'size'=>'30', 'value'=>$subneta[brama]),
													array('wyswietl' => 'Broadcast', 	'name'=>'broadcast', 	'size'=>'30', 'value'=>$subneta[broadcast]),
													array('wyswietl' => 'Dostępna przez', 	'name'=>'via', 	'size'=>'30', 'value'=>$subneta[via])													),
			'selectarray'		=> array (
													array('wyswietl' => 'Warstwa', 'name'=>'warstwa', 'size'=>'30', 'tablica' => array('rdzen', 'dystrybucja', 'dostep_pryw', 'dostep_zewn', 'dostep_publ', 'zarzadzanie_pon', 'zarzadzanie_dostep'), 'value'=>$subneta[warstwa])
													),
	);
	
	if (empty ($subneta)) 
		{
			$form[form][action]='index.php?panel=admin&menu=subnetaddsnd';
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=subnetupdsnd&subnet=$subneta[id_pds]";		
		}
		return ($form);
													
}

function PrintList($dbh, $www=NULL)
{
	  $query="select id_pds, adres, maska, brama, broadcast, warstwa, via, wykorzystana
					from podsieci order by id_pds";
		
		WyswietlSql($query);
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=admin&menu=subnetupd&subnet=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";
				    echo "<td> $row1[4] </td>";
				    echo "<td> $row1[5] </td>";
				    echo "<td> $row1[6] </td>";
				    echo "<td> $row1[7] </td>";	
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
				++$n;
			}
		echo "</tr>";
}
	
	

function SubnetValidate()
	{
		$flag=1;

		if ( empty ($_POST[adres]) )
		{
			echo "Nie wprowadzono nazwy <br>";
			$flag=0;
		}
		if ( empty ($_POST[maska]) )
		{
			echo "Nie wprowadzono medium <br>";
			$flag=0;
		}
		if ( empty ($_POST[brama]) )
		{
			echo "Nie wprowadzono technologia <br>";
			$flag=0;
		}
		if ( empty ($_POST[broadcast]) )
		{
			echo "Nie wprowadzono przepustowosc <br>";
			$flag=0;
		}
		if ( empty ($_POST[warstwa]) )
		{
			echo "Nie wprowadzono Warstwa <br>";
			$flag=0;
		}

		return ($flag);	
	}	

function SubnetAdd($dbh)
{
		$Q="select id_pds from podsieci order by id_pds desc limit 1";
								
		$subnet=array(
		'id_pds'	  	=> IncValue($dbh, $Q),
 		'adres'	  	=> $_POST[adres],  			
		'maska'			=> $_POST[maska], 
		'brama'		  => $_POST[brama],
		'broadcast'	=> $_POST[broadcast],
		'via' 			=> $_POST[via], 
		'warstwa' 	=> $_POST[warstwa],   
	  'wykorzystana'		=> CheckboxToTable($_POST[wykorzystana]), 
		);
		
		Insert($dbh, "podsieci", $subnet);
	}
	

function SubnetUpd($dbh, $id_pds)
{
		$subnet=array(
		'id_pds'		=> $id_pds,
		'adres'	  	=> $_POST[adres],  			
		'maska'			=> $_POST[maska], 
		'brama'		  => $_POST[brama],
		'broadcast'	=> $_POST[broadcast],
			'via' 			=> $_POST[via], 
		'warstwa' 	=> $_POST[warstwa],   
	  'wykorzystana'		=> CheckboxToTable($_POST[wykorzystana]), 
		);
		
		Update($dbh, "podsieci", $subnet);
	}
	
}	


?>
