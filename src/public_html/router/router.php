<?php


class ROUTER
{


public $table=array( 
		'link' 	=> array('href' 	=> "index.php?panel=inst&menu=routeradd", 'name' => 'Nowy router'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=deleterouter&typ=router'),
		'table' => array('witdh' 	=> '1000', 'height'=>'50'),
		'row'		=> array('Id' 		=>'100', 'Producent'=>'200', 'Typ' =>'200', 'mac'=>'200', 'Abonent' =>'370',  'Dzierżawa' =>'100',  '::' =>'20')
	);
	

function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from router where id_rtr='$k'; delete from pakiety where id_urz='$k'; delete from belong where id_urz='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.<br>";
}

function Form($routera)
{
	include "func/config.php";


			
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane routera'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Aktywny', 'name'=>'aktywny', 'value'=>$routera[aktywny])
													),
			'input'		=> array (
													array('wyswietl' => 'Mac', 'name'=>'mac', 'size'=>'30', 'value'=>$routera[mac]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'data_aktywacji', 'size'=>'30', 'value'=>$routera[data_aktywacji])
													),
			'abonent'	=> array( 'value'=>$routera[id_abon]),
			
			'selectarray'		=> array (
													array('wyswietl' => 'Producent', 'name'=>'producent', 'size'=>'40', 'tablica' => array('Totolink', 'Netis', 'Tp-Link', 'Tenda', 'Inny'), 'value'=>$routera[producent]),
													array('wyswietl' => 'Typ', 'name'=>'typ', 'size'=>'40', 'tablica' => array('A3002RU', 'WF2780','WF2419D','740N','TL-WR841N', 'TL-WR842ND', 'TL-WR1043N', 'N300RT', 'Inny'), 'value'=>$routera[typ])
													),
			'select'		=> array (
													array('wyswietl' => 'Dzierżawa', 'name'=>'dzierzawa', 'size'=>'30', 'query'=>"$QA17", 'value'=>$routera[id_usl])
													),
			'link' 	=> array (array('href' => "index.php?panel=inst&menu=trfrouteradd&router=$routera[id_rtr]", 'name' => '>>> Nowa taryfa'),
			array('href' => "index.php?panel=inst&menu=cngrtrabn&router=$routera[id_rtr]&abon=$routera[id_abon]", 'name' => '>>> Zmiana routera'))
													
	);
	
		if (empty ($routera)) 
		{
			$form[form][action]='index.php?panel=inst&menu=routeraddsnd';
			if ( empty($routera[data_aktywacji]) )
				$form[input][1][value] = $conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=inst&menu=routerupdsnd&router=$routera[id_rtr]";		
		}
		
		return ($form);
													 
}

function PrintList($dbh)
{
		include "func/config.php";
		
	  $query="select s.id_rtr,s.producent, s.typ, s.mac, n.id_abon, n.nazwa, n.symbol, t.symbol 
				from 
				((router s left join belong b on b.id_urz=s.id_rtr and b.nalezy_od <= '$conf[data]' and b.nalezy_do >= '$conf[data]' )
				left join nazwy n on n.id_abon=b.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]')
				
				left join
				(pakiety  p join towary_sprzedaz t on p.id_usl=t.id_tows and p.aktywny_od <= '$conf[data]' and p.aktywny_do >='$conf[data]') 
				 
				on s.id_rtr=p.id_urz 				
				order by id_rtr";
				
		WyswietlSql($query);				  
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
			
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=inst&menu=routerupd&rtr=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    echo "<td> $row1[2] </td>";
				    echo "<td> $row1[3] </td>";

	
				    $s=Choose($row1[6], $row1[5]);
				    echo "<td> <b>$s </b> <br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row1[4]\"> $row1[4] </a></td>";

				echo "<td> $row1[7] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
function RouterValidate($dbh, $ipc)
	{
		$flag=1;

		if ( empty ($_POST[typ]) )
		{
			echo "Nie wprowadzono typu <br>";
			$flag=0;
		}
		if (  !$ipc->ValidateMac($dbh, $_POST[mac]) )
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

function RouterAdd($dbh)
{
		include "func/config.php";
		$Q1="select id_rtr from router order by id_rtr desc limit 1";
		
		$router=array(
		'id_rtr'	  			=> IncValue($dbh,$Q1, "RTR00000"),
		'producent'				=> $_POST[producent],
		'typ'							=> $_POST[typ], 
		'mac'		  				=> $_POST[mac],	
		'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
		'aktywny'				  => CheckboxToTable($_POST[aktywny])
		);

		Insert($dbh, "router", $router);

		if ( !empty($_POST[abonent]) && $_POST[abonent]!=$conf[select] )
		{
			$blg=array(
			'id_urz'=>$router[id_rtr], 'id_abon'=>FindId2($_POST[abonent]), 'nalezy_od' => $router[data_aktywacji], 'nalezy_do' => $conf[wazne_do]);
			Insert($dbh, "belong", $blg);
		}

		$pkt=array(
		'id_urz'=>$router[id_rtr], 'id_usl'=>FindId2($_POST[dzierzawa]), 'aktywny_od' => $conf[wazne_od], 'aktywny_do' => $conf[wazne_do]);
		
		if ( !empty($_POST[dzierzawa]) && $_POST[dzierzawa]!=$conf[select] )
		{
			Insert($dbh, "pakiety", $pkt);
		}
		
	}
	
function RouterUpd($dbh, $id_urz)
{
		include "func/config.php";	
		$urza=$_SESSION[$id_urz.$_SESSION[login]];
		$id_tows=FindId2($_POST[dzierzawa]);
		$id_abon=FindId2($_POST[abonent]);
				
		if (  !empty ($urza[id_abon]) && IsNull($id_abon)=='NULL'  )
			{
					$urz=array(
						'id_rtr'	  			=> $id_urz,  		
						'data_aktywacji'	=> 'NULL', 
						'aktywny'				  => 'N'
					);
					Update($dbh, "router", $urz);
					$q="update belong 					set nalezy_do='$conf[poprzednidzien]' where id_urz='$id_urz' and nalezy_do='$conf[wazne_do]';
							update pakiety 					set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_urz' and aktywny_do='$conf[wazne_do]';";
					WyswietlSql($q);
					$row=Query($dbh, $q);
			}
				
		else 
			{
				$urz=array(
				'id_rtr'	  			=> $id_urz,  			
				'producent'				=> $_POST[producent],
				'typ'							=> $_POST[typ],  
				'mac'		  				=> $_POST[mac],	
				'data_aktywacji'	=> IsNull($_POST[data_aktywacji]), 
				'aktywny'				  => CheckboxToTable($_POST[aktywny])
				);
				Update($dbh, "router", $urz);

				if ( !empty ($urza[id_abon])  && IsNull($id_abon)!='NULL'  )
				{
					$q="update belong set id_abon='$id_abon', nalezy_od='$urz[data_aktywacji]' where id_urz='$id_urz' and nalezy_do='$conf[wazne_do]'";
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
					$q="update pakiety set id_usl='$id_tows', aktywny_od='$urz[data_aktywacji]'  where id_urz='$id_urz' and aktywny_do='$conf[wazne_do]'";
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

	function ChangeAbon($dbh, $id_rtr0, $id_abon)
	{
		include "func/config.php";
		
		$id_rtr=FindId2($_POST[rtr]);

		$q="update router set
						aktywny='T',
						data_aktywacji=(select data_aktywacji from router where id_rtr='$id_rtr0')
						where id_rtr='$id_rtr';
				update router		 set aktywny='N',  data_aktywacji=NULL where id_rtr='$id_rtr0';
				update belong 					set nalezy_do='$conf[poprzednidzien]' where id_urz='$id_rtr0' and nalezy_do='$conf[wazne_do]';
				insert into belong values ('$id_rtr','$id_abon', '$_POST[nalezy_od]','$conf[wazne_do]');
				update pakiety set id_urz='$id_rtr' where id_urz='$id_rtr0';";
		WyswietlSql($q);
		$row=Query($dbh, $q);
	}

	

	
}	


?>
