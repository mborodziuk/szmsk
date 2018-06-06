<?php

class SIM
{

public $table=array( 
		'link' 	=> array('href' => "index.php?panel=inst&menu=simadd", 'name' => 'Nowa karta sim'),
		'form' 	=> array('action' => 'index.php?panel=inst&menu=deletesim&typ=sim'),
		'table' => array('witdh' => '1000', 'height'=>'50'),
		'row'		=> array ('Id' =>'100', 'Numer' =>'120', 'Abonent' =>'370', 'Numer seryjny' =>'80', 'Stan' =>'370', 'Prędkość' =>'100', 'Doładowanie podstawowe' =>'300', 
		'::' =>'20')
	);
	
	
function Delete ($dbh)
{
	include "func/config.php";
	
	$q="";
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
						$q.="delete from pakiety 			where id_urz='$k';
						delete from taryfy 						where id_urz='$k';
						delete from uslugi_dodatkowe 	where id_urz='$k';
						delete from sim 							where id_sim='$k';
						delete from belong where id_urz='$k';";
			}
		}
	WyswietlSql($q);	
	Query($dbh, $q);

	echo "Usunięto dane z systemu.  <br>";
}




function Form($sima)
{
	include "func/config.php";
	
	$form=array( 
			'form' 		=> array('action' => Null, 'name'=> 'Dane karty Sim'),
			'table' 	=> array('witdh' => '500', 'height'=>'50'),
			'checkbox'=> array (
													array('wyswietl' => 'Aktywna', 			'name'=>'active', 				'value'=>$sima[active]),
													array('wyswietl' => 'Taryfa nocna', 'name'=>'night_rate', 		'value'=>$sima[night_rate]),
													array('wyswietl' => 'Automatyczne doładowanie', 			'name'=>'automatic_load', 'value'=>$sima[automatic_load])
													),
			'input'		=> array (
													array('wyswietl' => 'Numer telefonu', 'name'=>'number', 'size'=>'30', 'value'=>$sima[number]),
													array('wyswietl' => 'Numer seryjny', 'name'=>'sn', 'size'=>'30', 'value'=>$sima[sn]),
													array('wyswietl' => 'PIN', 'name'=>'pin', 'size'=>'30', 'value'=>$sima[pin]),
													array('wyswietl' => 'PUK', 'name'=>'puk', 'size'=>'30', 'value'=>$sima[puk]),
													array('wyswietl' => 'Data aktywacji', 'name'=>'date_active', 'size'=>'30', 'value'=>$sima[date_active])
													),
			'abonent'	=> array( 'value'=>$sima[id_abon]),
			'select'		=> array (
													array('wyswietl' => 'Prędkość w Mbit/s', 'name'=>'speed', 'size'=>'30', 'query'=>"$QA29", 'value'=>$sima[speed]),
													array('wyswietl' => 'Doładowanie podstawowe w GB', 'name'=>'basic_load', 'size'=>'30', 'query'=>"$QA30", 'value'=>$sima[basic_load])
													),
			'selectarray'		=> array (
													array('wyswietl' => 'Stan', 		'name'=>'state', 'size'=>'40', 'tablica' => array('S1', 'S2', 'S3'), 'value'=>$sima[state])
													),
			'link' 	=> array (array('href' => "index.php?panel=inst&menu=trfsimadd&sim=$sima[id_sim]", 'name' => '>>> Nowa prędkość'),
												array('href' => "index.php?panel=inst&menu=cngsimabn&sim=$sima[id_sim]&abon=$sima[id_abon]", 'name' => '>>> Zmiana karty SIM'))
	);
	
		if (empty ($sima)) 
		{
			$form[form][action]='index.php?panel=inst&menu=simaddsnd';
			if ( empty($sima[date_active]) )
				$form[input][4][value] = $conf[data];
		}
	else
		{
			$form[form][action]="index.php?panel=inst&menu=simupdsnd&sim=$sima[id_sim]";		
		}
		return ($form);
													 
}

function PrintList($dbh)
{
		include "func/config.php";
		
	  $query="select distinct s.id_sim, s.number, n.nazwa, n.symbol, s.sn, s.state, t1.symbol, t2.symbol
					from 
					( sim s left join
					(belong b 	left join nazwy n on b.id_abon=n.id_abon and n.wazne_od <= '$conf[data]' and n.wazne_do >= '$conf[data]'
					and b.nalezy_od <= '$conf[data]' and b.nalezy_do >= '$conf[data]')
					 on s.id_sim=b.id_urz)
					left join 
					(
					(pakiety p left join towary_sprzedaz t1 on t1.id_tows=p.id_usl and p.aktywny_od <= '$conf[data]' and p.aktywny_do >= '$conf[data]' )
					join
					(uslugi_dodatkowe u left join towary_sprzedaz t2 on t2.id_tows=u.id_usl and u.aktywna_od <= '$conf[data]' and u.aktywna_do >= '$conf[data]') 
					on p.id_urz=u.id_urz 
					)
					on p.id_urz=s.id_sim order by s.id_sim ";
					
		WyswietlSql($query);				  
	  $sth1=Query($dbh,$query);
		$lp=1;
	  while ($row1=$sth1->fetchRow())
	    {
	      DrawTable($lp++,$conf[table_color]);  	
	        {
						echo "<td> <a href=\"index.php?panel=inst&menu=simupd&sim=$row1[0]\"> $row1[0] </a> </td>";
				    echo "<td> $row1[1] </td>";
				    $s=Choose($row1[3], $row1[2]);
				    echo "<td> <b>$s </b></td>";

				echo "<td> $row1[4] </td>";
				echo "<td> $row1[5] </td>";
				echo "<td> $row1[6] </td>";
				echo "<td> $row1[7] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
				}
			}
		echo "</tr>";
}
	
function ValidateSimSn($sn)
{
	$wynik1=preg_match("/^[0-9]{20}/", $sn);
	$wynik2=preg_match("/^[0-9]{19}/", $sn);
	if( $wynik1==0 && $wynik2==0 )
	{
		 echo "Nieprawidłowy numer seryjny karty SIM !!! Numer seryjny SIM to 19 lub 20 cyfr.<br>";
		 $wynik=0;
	}
	else
	{
		 $wynik=1;
	}
	return ($wynik);
}

function ValidatePin($pin)
{
	$wynik=preg_match("/^[0-9]{4}/", $pin);
	if($wynik==0)
		 echo "Nieprawidłowy PIN !!! PIN to 4 cyfry.<br>";
	return ($wynik);
}

function ValidatePuk($puk)
{
	$wynik=preg_match("/^[0-9]{8}/", $puk);
	if($wynik==0)
		 echo "Nieprawidłowy PUK !!! PUK to 8 cyfr.<br>";
	return ($wynik);
}
	
function simAddValidate($dbh)
	{
	$flag=1;
		if (  !ValidateTel($_POST[number]))
		{
			$flag=0;
			echo "1 <br>";
		}
		if (  !$this->ValidateSimSn($_POST[sn]))
		{
			$flag=0;
		echo "2 <br>";
		}
		if (  !$this->ValidatePin($_POST[pin]))
		{
			$flag=0;
			echo "3 <br>";
		}
		if (  !$this->ValidatePuk($_POST[puk]))
		{
			$flag=0;
			echo "4 <br>";			
		}
		if ( $_POST[data_aktywacji] != "" )
			if ( !ValidateDate($_POST[data_aktywacji]) )
				{ 	 
					$flag=0;
								echo "5 <br>";

				}

		return ($flag);
	
	}	


function simUpdValidate($dbh)
	{
	$flag=1;
		if (  !ValidateTel($_POST[number]))
		{
			$flag=0;
		}
		if (  !$this->ValidateSimSn($_POST[sn]))
		{
			$flag=0;
		}
		if (  !$this->ValidatePin($_POST[pin]))
		{
			$flag=0;
		}
		if (  !$this->ValidatePuk($_POST[puk]))
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
	

function ChangeAbon($dbh, $id_sim0, $id_abon)
	{
		include "func/config.php";
		
		$id_sim=FindId2($_POST[sim]);

		$q="update sim set
						active='T',
						date_active=(select date_active from sim where id_sim='$id_sim0'),
						night_rate=(select night_rate from sim where id_sim='$id_sim0'),
						automatic_load=(select automatic_load from sim where id_sim='$id_sim0') where id_sim='$id_sim';
				update sim set active='N', date_active=NULL where id_sim='$id_sim0';
				update belong 					set nalezy_do='$conf[poprzednidzien]' where id_urz='$id_sim0' and nalezy_do='$conf[wazne_do]';
				insert into belong values ('$id_sim','$id_abon', '$_POST[nalezy_od]','$conf[wazne_do]');
				update pakiety set id_urz='$id_sim' where id_urz='$id_sim0';
				update uslugi_dodatkowe set id_urz='$id_sim' where id_urz='$id_sim0'";
		WyswietlSql($q);
		$row=Query($dbh, $q);
	}
	
	
function simAdd($dbh)
{
		include "func/config.php";
		
		$Q1="select id_sim from sim order by id_sim desc limit 1";
		
		$sim=array(
		'id_sim'	  			=> IncValue($dbh,$Q1, "SIM0000"),  			
		'pin'							=> $_POST[pin], 
		'puk'		  				=> $_POST[puk],										 
		'sn'		  				=> $_POST[sn],	
		'number'		 			=> $_POST[number],	
		'date_active'			=> IsNull($_POST[date_active]), 
		'active'				  => CheckboxToTable($_POST[active]),		
		'state'						=> $_POST[state],
		'automatic_load'  => CheckboxToTable($_POST[automatic_load]),		
		'night_rate'			=> CheckboxToTable($_POST[night_rate])
		);
		Insert($dbh, "sim", $sim);
		
		if ( !empty($_POST[abonent]) && $_POST[abonent]!=$conf[select]  )
		{
			$blg=array(
			'id_urz'=>$sim[id_sim], 'id_abon'=>FindId2($_POST[abonent]), 'nalezy_od' => $sim[date_active], 'nalezy_do' => $conf[wazne_do]);
			Insert($dbh, "belong", $blg);
		}
		
		$pkt=array(
		'id_urz'=>$sim[id_sim], 'id_usl'=>FindId2($_POST[speed]), 'aktywny_od' => $conf[wazne_od], 'aktywny_do' => $conf[wazne_do]);
		
		if (  !empty($_POST[speed]) && $_POST[speed]!=$conf[select] )
		{
			Insert($dbh, "pakiety", $pkt);
		}
		
		$ud=array(
		'id_urz'=>$sim[id_sim], 'id_usl'=>FindId2($_POST[basic_load]), 'aktywna_od' => $conf[wazne_od], 'aktywna_do' => $conf[wazne_do]);
		
		if (  !empty($_POST[basic_load]) && $_POST[basic_load]!=$conf[select] )
		{
			Insert($dbh, "uslugi_dodatkowe", $ud);
		}	
}
	


	

	
function TaryfaAdd($dbh, $id_sim, $aktywny_od=Null)
{
		include "func/config.php";
		$s=	$_SESSION[$id_sim.$_SESSION[login]];	
		
		$ID_TARYFY= FindId2($_POST[speed]);
		$id_bl=FindId2($_POST[basic_load]);
		
		if ( $s['speed'] != $ID_TARYFY)
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];

			}

			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
			$q="update pakiety set aktywny_do='$aktywny_do2' where id_urz='$id_sim' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
				
			$trf=array(
			'id_urz' 		=> $id_sim, 'id_usl' 		=> $ID_TARYFY, 	 'aktywny_od' => $aktywny_od, 'aktywny_do' => $conf[wazne_do]);
			Insert($dbh, "pakiety", $trf);
		}
		
		if ( $s['basic_load'] != $id_bl )
		{
			if ($aktywny_od == Null)
			{
				$aktywny_od=$_POST[aktywny_od];

			}

			$aktywny_do2=date('Y-m-d', strtotime('-1 day', strtotime($aktywny_od))); 
			$q="update uslugi_dodatkowe set aktywna_do='$aktywny_do2' where id_urz='$id_sim' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
				
			$ud=array(
			'id_urz' 		=> $id_sim, 'id_usl' 		=> $id_bl, 	 'aktywna_od' => $aktywny_od, 'aktywna_do' => $conf[wazne_do]);
			Insert($dbh, "uslugi_dodatkowe", $ud);
		}
}	

	
function simUpd($dbh, $id_sim)
{
		include "func/config.php";	

		$s=	$_SESSION[$id_sim.$_SESSION[login]];		
		$id_abon=FindId2($_POST[abonent]);
				
		if (  !empty ($s[id_abon]) && IsNull($id_abon)=='NULL'  )
				{
					$sim=array(
						'id_sim'	  			=> $id_sim,  		
						'date_active'			=> 'NULL', 
						'active'				  => 'N',
						'automatic_load'  => 'N',
						'night_rate'			=> 'N' 
					);
					Update($dbh, "sim", $sim);
					$q="update belong 					set nalezy_do='$conf[poprzednidzien]' 	where id_urz='$id_stb' and nalezy_do='$conf[wazne_do]';
							update pakiety 					set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_stb' and aktywny_do='$conf[wazne_do]';
							update uslugi_dodatkowe set aktywna_do='$conf[poprzednidzien]' where id_urz='$id_stb' and aktywna_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
		
		else 
		{
		$sim=array(
		'id_sim'	  			=> $id_sim,  					
		'pin'							=> $_POST[pin], 
		'puk'		  				=> $_POST[puk],										 
		'sn'		  				=> $_POST[sn],	
		'number'		 			=> $_POST[number],	
		'date_active'			=> IsNull($_POST[date_active]), 
		'active'				  => CheckboxToTable($_POST[active]),		
		'state'						=> $_POST[state],
		'automatic_load'  => CheckboxToTable($_POST[automatic_load]),		
		'night_rate'			=> CheckboxToTable($_POST[night_rate]),
		);
		Update($dbh, "sim", $sim);
		 

		 if ( !empty ($s[id_abon])  && IsNull($id_abon)!='NULL'  )
				{
					$q="update belong set id_abon='$id_abon' where id_urz='$id_sim' and nalezy_do='$conf[wazne_do]'";
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				else if (  empty ($s[id_abon]) && IsNull($id_abon)!='NULL' )
				{
					$q="insert into belong values ('$id_sim','$id_abon', '$conf[data]','$conf[wazne_do]')";		
					WyswietlSql($q);
					$row=Query($dbh, $q);
				}
				
		$id_tows=FindId2($_POST[speed]);
		
		if ( !empty($s[speed]) && IsNull($id_tows)!='NULL'  )
		{
			$q="update pakiety set id_usl='$id_tows' where id_urz='$id_sim' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( empty($s[speed]) && IsNull($id_tows)!='NULL')
		{
			$q="insert into pakiety values ('$id_sim','$id_tows', '$conf[data]','$conf[wazne_do]')";		
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( !empty($s[speed]) && IsNull($id_tows)=='NULL'  )
		{
			$q="update pakiety set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_sim' and aktywny_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}

		
		$id_ud=FindId2($_POST[basic_load]);
		
		if ( !empty($s[basic_load]) && IsNull($id_ud)!='NULL'  )
		{
			$q="update uslugi_dodatkowe set id_usl='$id_ud' where id_urz='$id_sim' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( empty($s[basic_load]) && IsNull($id_ud)!='NULL')
		{
			$q="insert into uslugi_dodatkowe values ('$id_sim','$id_ud','T', '$conf[data]','$conf[wazne_do]')";		
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
		else if ( !empty($s[basic_load]) && IsNull($id_ud)=='NULL'  )
		{
			$q="update uslugi_dodatkowe set aktywny_do='$conf[poprzednidzien]' where id_urz='$id_sim' and aktywna_do='$conf[wazne_do]'";
			WyswietlSql($q);
			$row=Query($dbh, $q);
		}
	}
}


	
}	


?>
