<?php

class MODEM
{

public $table=array( 
		'link' 	=> array('href' => "index.php?panel=inst&menu=modemadd", 'name' => 'Nowy modem'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=deletemodem&typ=modem'),
		'table' => array('witdh' => '1000', 'height'=>'50'),
		'row'		=> array ('Id' =>'100', 'Producent' =>'200', 'Model' =>'120',  'Abonent' =>'370', 'Imei' =>'100', 'Numer seryjny' =>'300', 'Dzierżawa' =>'100', '::' =>'20')
	);
	
	
function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from modem 			where id_mdm='$k';
								 delete from belong where id_urz='$k';
								delete from pakiety where id_urz='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.";
}




function Form($modema)
{
	include "func/config.php";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane modemu'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Aktywny', 			'name'=>'active', 				'value'=>$modema[active])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Producent', 		'name'=>'vendor', 'size'=>'40', 'tablica' => array('Huawei', 'ZTE', 'Inny'), 'value'=>$modema[vendor]),
													array('wyswietl' => 'Model', 				'name'=>'model', 'size'=>'40', 'tablica' => array('E173u-2', 'E3372', 'E3272', 'E3131', 'Inny'), 'value'=>$modema[model])
													),
			'input'		=> array (
													array('wyswietl' => 'Imei', 'name'=>'imei', 'size'=>'30', 'value'=>$modema[imei]),
													array('wyswietl' => 'Numer seryjny', 'name'=>'sn', 'size'=>'30', 'value'=>$modema[sn]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'date_active', 'size'=>'30', 'value'=>$modema[date_active])
													),
			'select'		=> array (
													array('wyswietl' => 'Dzierżawa', 'name'=>'dzierzawa', 'size'=>'30', 'query'=>"$QA17", 'value'=>$modema[id_usl])
													),
			'abonent'	=> array( 'value'=>$modema[id_abon]),

			'link' 	=> array (array('href' => "index.php?panel=inst&menu=trfmdmadd&modem=$modema[id_mdm]", 'name' => '>>> Nowa dzierzawa'),
												array('href' => "index.php?panel=inst&menu=cngmdmabn&modem=$modema[id_mdm]&abon=$modema[id_abon]", 'name' => '>>> Zmiana modemu')
			)
	);
	
		if (empty ($modema)) 
		{
			$form[form][action]='index.php?panel=inst&menu=modemaddsnd';
			if ( empty($modema[date_active]) )
				$form[input][2][value] = $conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=inst&menu=modemupdsnd&modem=$modema[id_mdm]";		
		}
		return ($form);
													 
}

function PrintList($dbh)
{
		include "func/config.php";
		
	  $query="select distinct c.id_mdm, c.vendor, c.model, c.imei, c.sn,  n.nazwa, n.symbol, t.symbol
					from 
					(
					(modem c left join belong b on b.id_urz=c.id_mdm and b.nalezy_od <= '$conf[data]' and b.nalezy_do >= '$conf[data]')
					left join 
					nazwy n on b.id_abon=n.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]'
					)
					left join 
					(towary_sprzedaz t join pakiety p on t.id_tows=p.id_usl and p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]') 
					on p.id_urz=c.id_mdm order by c.id_mdm ";
					
		WyswietlSql($query);				  
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
							$Q2="select n.nazwa, i1.nazwa from interfejsy_wezla i1, interfejsy_wezla i2, trakty t, nadajniki n 
				where t.id_ifc2=i2.id_ifc and t.id_ifc1=i1.id_ifc and i1.id_wzl=n.id_nad and  i2.id_wzl='$row1[0]'";
				//WyswietlSql($Q2);
				$r2=Query2($Q2, $dbh);
				
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=inst&menu=modemupd&modem=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
	
				    $s=Choose($row1[6], $row1[5]);
				    echo "<td> <b>$s </b></td>";

				echo "<td> $row1[3] </td>";
				echo "<td> $row1[4] </td>";
				echo "<td> $row1[7] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
function ValidateImei($imei)
{
	$wynik=preg_match("/^[0-9]{15}/", $imei);
	if($wynik==0)
		 echo "Nieprawidłowy numer IMEI !!! <br> Numer IMEI to 15 cyfr.<br>";
	return ($wynik);
}

function ValidateSn($sn)
{
	$wynik=preg_match("/^[0-9A-Z]{5,30}/", $sn);
	if($wynik==0)
		 echo "Nieprawidłowy numer seryjny karty SIM !!! <br> Numer seryjny SIM to 20 cyfr lub dużych liter.<br>";
	return ($wynik);
}

function modemValidate($dbh)
	{
	$flag=1;

		if (  !$this->ValidateSn($_POST[sn]))
		{
			$flag=0;
		}
		if (  !$this->ValidateImei($_POST[imei]))
		{
			$flag=0;
		}
		if ( $_POST[data_aktywacji] != "" )
			if ( !ValidateDate($_POST[data_aktywacji]) )
				{ 	 
					$flag=0;
				}

		return ($flag);	
}	

function ChangeAbon($dbh, $id_mdm0, $id_abon)
	{
		include "func/config.php";
		
		$id_mdm=FindId2($_POST[mdm]);

		$q="update modem set
						active='T',
						date_active=(select date_active from modem where id_mdm='$id_mdm0') where id_mdm='$id_mdm';
				update modem set active='N' , date_active=NULL where id_mdm='$id_mdm0';
				update belong 					set nalezy_do='$conf[poprzednidzien]' where id_urz='$id_mdm0' and nalezy_do='$conf[wazne_do]';
				insert into belong values ('$id_mdm','$id_abon', '$_POST[nalezy_od]','$conf[wazne_do]');
				update pakiety set id_urz='$id_mdm' where id_urz='$id_mdm0';";
		WyswietlSql($q);
		$row=Query($dbh, $q);
	}
	
	
function modemAdd($dbh)
{
		include "func/config.php";
		
		$Q1="select id_mdm from modem order by id_mdm desc limit 1";
		
		$mdm=array(
		'id_mdm'	  				=> IncValue($dbh,$Q1, "MDM0000"),  			
		'vendor'						=> $_POST[vendor], 
		'model'		  				=> $_POST[model],										 
		'imei'		  				=> $_POST[imei],	
		'sn'		 						=> $_POST[sn],	
		'date_active'				=> IsNull($_POST[date_active]), 
		'active'				  	=> CheckboxToTable($_POST[active]),		
		);
		Insert($dbh, "modem", $mdm);
		
		if ( !empty($_POST[abonent]) && $_POST[abonent]!=$conf[select]  )
		{
			$blg=array(
			'id_urz'=>$mdm[id_mdm], 'id_abon'=>FindId2($_POST[abonent]), 'nalezy_od' => $mdm[date_active], 'nalezy_do' => $conf[wazne_do]);
			Insert($dbh, "belong", $blg);
		}
		
		$pkt=array(
		'id_urz'=>$mdm[id_mdm], 'id_usl'=>FindId2($_POST[dzierzawa]), 'aktywny_od' => $conf[wazne_od], 'aktywny_do' => $conf[wazne_do]);
		
		if ( !empty($_POST[dzierzawa]) && $_POST[dzierzawa]!=$conf[select] )
		{
			Insert($dbh, "pakiety", $pkt);
		}
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

	
function modemUpd($dbh, $id_urz)
{
		include "func/config.php";	
		$urza=$_SESSION[$id_urz.$_SESSION[login]];
		$id_tows=FindId2($_POST[dzierzawa]);
		$id_abon=FindId2($_POST[abonent]);
						
		if (  !empty ($urza[id_abon]) && IsNull($id_abon)=='NULL'  )
			{
					$urz=array(
						'id_mdm'	  			=> $id_urz,  		
						'date_active'	=> 'NULL', 
						'active'				  => 'N'
					);
					Update($dbh, "modem", $urz);
					$q="update belong 					set nalezy_do='$conf[poprzednidzien]' where id_urz='$id_urz' and nalezy_do='$conf[wazne_do]';
							update pakiety 					set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_urz' and aktywny_do='$conf[wazne_do]';";
					WyswietlSql($q);
					$row=Query($dbh, $q);
			}
				
		else 
			{
				$urz=array(
					'id_mdm'	  				=> $id_urz,   			
					'vendor'						=> $_POST[vendor], 
					'model'		  				=> $_POST[model],										 
					'imei'		  				=> $_POST[imei],	
					'sn'		 						=> $_POST[sn],	
					'date_active'				=> IsNull($_POST[date_active]), 
					'active'				  	=> CheckboxToTable($_POST[active]),	
				);
				Update($dbh, "modem", $urz);
				
				if ( !empty ($urza[id_abon])  && IsNull($id_abon)!='NULL'  )
				{
					$q="update belong set id_abon='$id_abon' where id_urz='$id_urz' and nalezy_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				else if (  empty ($urza[id_abon]) && IsNull($id_abon)!='NULL' )
				{
					$q="insert into belong values ('$id_urz','$id_abon', '$conf[data]','$conf[wazne_do]')";		
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				
				if ( !empty($urza[id_usl]) && IsNull($id_tows)!='NULL'  )
				{
					$q="update pakiety set id_usl='$id_tows' where id_urz='$id_urz' and aktywny_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				else if ( empty($urza[id_usl]) && IsNull($id_tows)!='NULL' )
				{
					$q="insert into pakiety values ('$id_urz','$id_tows', '$conf[data]','$conf[wazne_do]')";		
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
						else if ( !empty($urza[id_usl]) && IsNull($id_tows)=='NULL'  )
				{
					$q="update pakiety set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_urz' and aktywny_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
		}



}
	
}	


?>
