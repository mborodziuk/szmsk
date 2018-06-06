<?php


class VLAN
{

public $delete1 = array('interfejsy_wezla'=>'id_ifc');
public $delete2 = array();

public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=admin&menu=ifcadd", 'name' => 'Nowy interfejs' ),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=delete&typ=ifc'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array ('Id' 		=>'100', 'Nazwa' =>'200', 'Medium' =>'120', 'Technologia' =>'200', 'Przepustowość' =>'30', 'SSID' =>'50', 'Warstwa' =>'100', 'Vlan' =>'50', 'Węzeł' =>'100', '::' =>'20')
	);
	

	
function Form($ivna)
{
	include "func/config.php";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Instancja Vlanu'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'select'		=> array (
													array('wyswietl' => 'Vlan', 		'name'=>'vln', 'size'=>'30', 				'query'=>"$Q13", 'value'=>$ivna[id_vln]),
													array('wyswietl' => 'Podsieć', 	'name'=>'pds', 'size'=>'30', 				'query'=>"$Q12", 'value'=>$ivna[id_pds]),
													array('wyswietl' => 'Interfejs', 'name'=>'interfejs', 'size'=>'30', 'query'=>"$Q12", 'value'=>$ivna[id_pds])
													),
			'input'		=> array (
													array('wyswietl' => 'Adres IP', 'name'=>'ip', 'size'=>'30', 'value'=>$ivna[ip])
													)
	);
	
	if (empty ($ivna[id_ivn])) 
		{
			$form[form][action]="index.php?panel=admin&menu=ivnaddsnd&id_wzl=$_GET[id_wzl]";
		}
	else
		{
			$form[form][action]="index.php?panel=admin&menu=ivnupdsnd&ivn=$ivna[id_ivn]";		
		}
		return ($form);
													
}
	

function IvnValidate($dbh, $ipc)
	{
		$flag=1;

		if ( empty ($_POST[vln]) || $_POST[vln] == $conf[select] )
		{
			echo "Nie wprowadzono Vlanu <br>";
			$flag=0;
		}		
		
	//	$id_pds=FindId2($_POST[pds]);

	//	$g=$ipc->IpGate($dbh, $id_pds);
		
		/*if ( !$ipc->ValidateIP2($dbh, $_POST[ip]) )
		{
			echo "Ta podsieć jest już wykorzystana <br>";
			$flag=0;
		}	*/	

		return ($flag);	
	}	

	
function IvnAdd($dbh, $id_wzl, $ipc)
{
		$Q="select id_ivn from inst_vlanu order by id_ivn desc limit 1";
		
			$ivn=array(
			'id_ivn'	  	=> IncValue($dbh,$Q),  			
			'id_vln'			=> FindId2($_POST[vln]),
			'id_wzl'			=> FindId2($id_wzl)
			);
			Insert($dbh, "inst_vlanu", $ivn);

	if ( !empty ($_POST[pds])  )
	{
			$id_pds=FindId2($_POST[pds]);
			$g=$ipc->IpGate($dbh, $id_pds);
			
			$ipa=array(
			'id_urz'	  	=> $ivn[id_ivn],  			
			'ip'					=> $g,
			'id_pds'			=> $id_pds
			);
			Insert($dbh, "adresy_ip", $ipa);
	}
}
	

function IvnUpd($dbh, $id_ivn, $ipc)
{
			$ivna=$_SESSION[ivn];
			
			$ivn=array(
			'id_ivn'	  	=> $id_ivn,  			
			'id_vln'			=> FindId2($_POST[vln]),
			'id_wzl'			=> $_SESSION[ivn][id_wzl]
			);
			Update($dbh, "inst_vlanu", $ivn);

			$id_pds=FindId2($_POST[pds]);					
			$g=$ipc->IpGate($dbh, $id_pds);

			$ip=array(
			'ip' 			=> $g,
			'id_urz'	=> $ivn[id_ivn],
			'id_pds'	=> $id_pds
			);			
			
			if ( empty($ivna[ip]) && ! empty($g))
			{
				Insert($dbh, "adresy_ip", $ip);
			}
			else if ( !empty($ivna[ip]) && ! empty($g) )
				{
					$Q="update adresy_ip set ip='$g', id_urz='$ivn[id_ivn]' where ip='$ivna[ip]'";
					WyswietlSql($Q);
					Query($dbh, $Q);
				}
		/*	else if ( ! empty($ivna[ip]) && empty($_POST[ip]) )
				{
					$Q="delete from adresy_ip where ip='$ivna[ip]'";
					WyswietlSql($Q);
					Query($dbh, $Q);
				}*/

}
	
}	


?>
