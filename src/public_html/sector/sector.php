<?php

class SECTOR
{

public $delete1 = array('sektory'=>'id_sek');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=sectoradd", 'name' => 'Nowy sektor'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=id_sek'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array ('Lp.' 		=>'10','Id' 		=>'10','Azymut' 		=>'100', 'Szerokość kątowa' =>'200', 'Zasięg' =>'120', 'Interfejs' =>'200', 'Węzeł' =>'100', '::' =>'20')
	);
	

	
function Form($sectora)
{
	include "func/config.php";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane podsieci'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),

			'input'		=> array (
													array('wyswietl' => 'Azymut', 	'name'=>'azymut', 	'size'=>'30', 'value'=>$sectora[azymut]),
													array('wyswietl' => 'Szerokość kątowa', 	'name'=>'szer_katowa', 	'size'=>'30', 'value'=>$sectora[szer_katowa]),
													array('wyswietl' => 'Zasięg', 	'name'=>'zasieg', 	'size'=>'30', 'value'=>$sectora[zasieg])
													),
			'select'		=> array (
													array('wyswietl' => 'Interfejs', 'name'=>'ifc', 'size'=>'30', 'query'=>"$QA14", 'value'=>$sectora[id_ifc])
													)
													
	);
	
	if (empty ($sectora)) 
		{
			$form[form][action]='index.php?panel=admin&menu=sectoraddsnd';
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=sectorupdsnd&sector=$sectora[id_sek]";		
		}
		return ($form);
													
}

function PrintList($dbh, $www=NULL)
{
	  $query="select s.id_sek, s.azymut, s.szer_katowa, s.zasieg, i.nazwa, w.nazwa 
					from sektory s, interfejsy_wezla i, wezly w 
					where i.id_ifc=s.id_ifc and w.id_wzl=i.id_wzl order by s.id_sek";
		
		WyswietlSql($query);
	  $sth1=Query($dbh,$query);
		$lp=1;
		$n=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td><i>$n.</i></td>";
						echo "<td> <a href=\"index.php?panel=admin&menu=sectorupd&sector=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";
				    echo "<td> $row1[4] </td>";
				    echo "<td> $row1[5] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
				++$n;
			}
		echo "</tr>";
}
	
	

function SectorValidate()
	{
		$flag=1;

		if ( empty ($_POST[azymut]) && $_POST[azymut] != '0' )
		{
			echo "Nie wprowadzono Azymut <br>";
			$flag=0;
		}
		if ( empty ($_POST[szer_katowa]) )
		{
			echo "Nie wprowadzono Szerokość kątowa <br>";
			$flag=0;
		}
		if ( empty ($_POST[zasieg]) )
		{
			echo "Nie wprowadzono Zasięg <br>";
			$flag=0;
		}
		if ( empty ($_POST[ifc]) )
		{
			echo "Nie wprowadzono Interfejsu <br>";
			$flag=0;
		}

		return ($flag);	
	}	

function SectorAdd($dbh)
{
		$Q="select id_sek from sektory order by id_sek desc limit 1";
								
		$sector=array(
		'id_sek'	  => IncValue($dbh, $Q),  			
		'azymut'			=> $_POST[azymut], 
		'szer_katowa'		  	=> $_POST[szer_katowa],
		'zasieg'		  	=> $_POST[zasieg],
		'id_ifc' 				=> FindId2($_POST[ifc])    
		);
		
		Insert($dbh, "sektory", $sector);
	}
	

function SectorUpd($dbh, $id_sek)
{
		$sector=array(
		'id_sek'	  => $id_sek,  			
		'azymut'			=> $_POST[azymut], 
		'szer_katowa'		  	=> $_POST[szer_katowa],
		'zasieg'		  	=> $_POST[zasieg],
		'id_ifc' 				=> FindId2($_POST[ifc])    
		);
		
		Update($dbh, "sektory", $sector);
	}
	
}	


?>
