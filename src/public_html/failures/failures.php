<?php

//  AWARIE
class FAILURES
{

	function ListaAwarii($dbh, $p)
	{
		include "func/config.php";
		$Q="select count(distinct nr_um) from umowy_abonenckie where status='Obowiązująca'";
		$s=Query($dbh,$Q);
		$r=$s->fetchRow();
		$ilum=$r[0];
		
		if ($p[usunieta]=="Usunięte" && $_SESSION['uprawnienia']!='callcenter')
			{
				$q1="select  distinct  aw.id_awr, aw.czas_zgl, aw.id_zgl, aw.opis, n.nazwa, n.symbol, au.czas_us, au.opis, p.nazwa, n.id_abon, aw.komentarz
					from awarie aw, nazwy n, usuwanie_awarii au, pracownicy p
					where 
					n.id_abon=aw.id_zgl and au.id_awr=aw.id_awr and aw.usunieta='T' and p.id_prac=au.usuwajacy 
					and aw.czas_zgl>='$p[data_od]' and aw.czas_zgl<='$p[data_do]] 24:00'
					and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'";
				if( !empty($p[usuwajacy]) && $p[usuwajacy]!=$conf[select])
					{
						$prac=explode(" ", $_POST[usuwajacy]);
						$id_prac=array_pop($prac);
						$q1.=" and p.id_prac='$id_prac'";			
					}
				if( !empty($p[zglaszajacy]) && $p[zglaszajacy]!=$conf[select] )
					{
						$zgl=explode(" ", $_POST[zglaszajacy]);
						$id_zgl=array_pop($zgl);
						$q1.=" and aw.id_zgl='$id_zgl'";			
					}
				$q1.=" order by aw.id_awr";
				WyswietlSql($q1);

				$lp=1;
				$razem=0;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						$czas = round((strtotime($row[6]) - strtotime($row[1])) / 3600);
						$razem+=$czas;

						DrawTable($lp++,$conf[table_color]);
							{	
								$czas1=mb_substr($row[1],0,-3);
								$czas2=mb_substr($row[6],0,-3);
								
								echo "<td> <a href=\"index.php?panel=inst&menu=updateusawarie&awr=$row[0]\"> $row[0] </a></td>";
								echo "<td>  $czas1 / $czas2 </td>";
								echo "<td><b>";
								echo Choose($row[5], $row[4]);
								echo "</b> <br> $row[10] <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[9]\"> $row[9] </a></td>";
								echo "<td> $row[3] </td>";
								echo "<td> $row[7] </td>";
								echo "<td> <b>$row[8]</b> </td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}
					$wsk=round($razem/$lp);
					$wsk2=round($razem/$lp/8);
					$wsk3=number_format(round($lp*100/$ilum, 2), 2, ',','');
					
					echo "Czas usunięcia uszkodzenia stałego łacza dostępowego: <b>$wsk h </b><br>";
					echo "Podzielone przez osiem (bo awarie są opisywane za późno): <b>$wsk2 h </b></br>";
					echo "Liczba uszkodzeń przypadająca na 100 linii stałego dostępu: <b>$wsk3 </b> <br><br>";
			}
	else
			{
				$q1=
					"select distinct aw.id_awr, aw.czas_zgl, aw.id_zgl, aw.opis, aw.usunieta, n.nazwa, n.symbol,  n.id_abon, u.miasto, u.cecha, u.nazwa, b.numer, s.nr_lok, aw.komentarz
					from awarie aw, nazwy n, adresy_siedzib s, ulice u, budynki b	where
					n.id_abon=s.id_abon and u.id_ul=b.id_ul and s.id_bud=b.id_bud and
					n.id_abon=aw.id_zgl and aw.usunieta='N' and aw.czas_zgl between '$p[data_od]' and '$p[data_do] 24:00'
					and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
					and s.wazne_od <= '$conf[data]' and s.wazne_do >='$conf[data]'";
					//echo "$q1";
				if( !empty($p[zglaszajacy]) && $p[zglaszajacy]!=$conf[select] )
						{
							$zgl=explode(" ", $_POST[zglaszajacy]);
							$id_zgl=array_pop($zgl);
							$q1.=" and aw.id_zgl='$id_zgl'";			
						}
					$q1.=" order by aw.id_awr";
					
				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
							DrawTable($lp++,$conf[table_color]);
							{
								$czas1=mb_substr($row[1],0,-3);
								echo "<td> <a href=\"index.php?panel=inst&menu=updateawarie&awr=$row[0]\"> $row[0] </a></td>";
								echo "<td> $czas1 </td>";
								if ( $_SESSION['uprawnienia']!='callcenter')
								{
									echo "<td><b>";
									echo Choose($row[6], $row[5]);
									echo "</b> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[7]\"> $row[7] </a> <br> $row[8], $row[9] $row[10] $row[11]";
									if (!empty($row[12]))
										echo "/$row[12]</td>";
									else
										echo " </td>";
								}
								else
								{
									echo "<td><b>";
									echo Choose($row[6], $row[5]);
									echo "</b>  $row[7] ";
										echo " </td>";								
								}
								
								echo "<td> $row[3] </td>";
								echo "<td> $row[13] </td>";
								echo "<td> <a href=\"index.php?panel=inst&menu=dodajusawr&awr=$row[0]\"> usunięto >> </a></td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}
			}
	}

	function AddNewAwarie($dbh, &$szmsk)
	{
		include "func/config.php";

		$id=explode(" ", $_POST[zglaszajacy]);
		$id_abon=array_pop($id);
		unset($id[-1]);
		$nazwa=strtoupper(join(" ", $id));

		$awarie=array(
		'id_awr'=>IncItNum($dbh, $date=date("Y-m-d"), "AWR"), 
		'czas_zgl'=>date( "Y-m-d H:I"), 
		'id_zgl' =>$id_abon,
		'opis'=> $_POST[opis], 'usunieta'=> 'N'
		);
		
		Insert($dbh, "Awarie", $awarie);
		
		$q="select u.miasto, u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom, u.kod from miejsca_instalacji s, komputery k, ulice u, budynki b, telefony t 
		where u.id_ul=b.id_ul and k.id_abon=t.id_podm and s.id_bud=b.id_bud and k.id_msi=s.id_msi
		and k.id_abon='$id_abon'";
		
		$ktk=Query2($q,$dbh);
		$adres="$ktk[0], ul. $ktk[1] $ktk[2]/$ktk[3]";
		$tel="$ktk[5], $ktk[4]";
		
		$sk0=Skroc($ktk[0]);
	//	$sk1=Skroc($ktk[1]);
		if ( !empty($ktk[3]) )
			$sadr=" $sk0, $ktk[1] $ktk[2]/$ktk[3]";
		else
				$sadr=" $sk0, $ktk[1] $ktk[2]";
				
		$body="Awaria nr:			$awarie[id_awr]
		Zgłaszający:			$nazwa - $adres - telefon: $tel
		
		Opis:			$awarie[opis]";

		if ( strlen($awarie[opis]) > 40)
			$adres=$sadr;

		if (preg_match("/^$firma[nazwa]/", $nazwa))	
			$subject="$nazwa - $awarie[opis]";		
		else
			$subject="$nazwa - $adres - $tel - $awarie[opis]";		
		
		$subject=$szmsk->konwertuj($subject);

		$maile=explode(";", $conf[awarie_sms]);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[awarie_email]", $m, $subject);
		}
		
		
		/*if (preg_match("/(41-400|41-406)/", $row[6]))	
		{
			$subject="$firma[nazwa]: instalacja/awaria przyłącza u klienta.";
			$body=str_replace("NAZWA_ULICY", "$ktk[1] $ktk[6]", $_POST[opisum]);
			
			$maile=explode(";", $conf[um_email]);
			foreach ($maile as $m)
			{
				$email=new EMAIL();
				$email->WyslijMaila("$conf[serwis_email]", $m, $subject, $body);
			}
		}*/
	}

	function AddNewUsAwr($dbh, $id_awr)
	{
		include "func/config.php";

		$id=explode(" ", $_POST[usuwajacy]);
		$id_us=array_pop($id);


		$usawr=array(	'id_usaw'	=>IncItNum($dbh, $date=date("Y-m-d"), "UAW"), 'czas_us'=>date( "Y-m-d H:I"), 
							'usuwajacy' =>$id_us,		'opis'=> $_POST[opis], 'id_awr' => $id_awr);

		$awaria=array('id_awr' => $id_awr, 'usunieta' => 'T');

		Insert($dbh, "Usuwanie_awarii", $usawr);
		Update($dbh, "Awarie", $awaria);
	}

	function UpdateAwarie($dbh, &$szmsk, $id_awr)
	{
		include "func/config.php";

		$id=explode(" ", $_POST[zglaszajacy]);
		$id_abon=array_pop($id);
		$nazwa=strtoupper(join(" ", $id));
		
		$awarie=array('id_awr'=>$id_awr, 'id_zgl' =>$id_abon,
						 'opis'=> $_POST[opis], 'komentarz'=> $_POST[komentarz]);
		Update($dbh, "Awarie", $awarie);
		
		if ( isset($_POST[mail]) )
		{
			$q="select u.miasto, u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom from miejsca_instalacji s, komputery k, ulice u, budynki b, telefony t 
			where u.id_ul=b.id_ul and k.id_abon=t.id_podm and s.id_bud=b.id_bud and k.id_msi=s.id_msi
			and k.id_abon='$id_abon'";
			
			$ktk=Query2($q,$dbh);
			$adres="$ktk[0], ul. $ktk[1] $ktk[2]/$ktk[3]";
			$tel="$ktk[5], $ktk[4]";
			
			$sk0=Skroc($ktk[0]);
	//		$sk1=Skroc($ktk[1]);
			if ( !empty($ktk[3]) )
				$sadr=" $sk0, $ktk[1] $ktk[2]/$ktk[3]";
			else
					$sadr=" $sk0, $ktk[1] $ktk[2]";
					
			$body="Awaria nr:			$awarie[id_awr]
			Zgłaszający:			$nazwa - $adres - telefon: $tel
			
			Opis:			$awarie[opis]		
			Komentarz:			$awarie[komentarz]";

			if ( strlen($awarie[opis]) > 40)
				$adres=$sadr;

			if (preg_match("/^$firma[nazwa]/", $nazwa))	
				$subject="$nazwa - $awarie[opis]";		
			else
				$subject="$nazwa - $adres - $tel - $awarie[opis]";		
			
			
			$subject=$szmsk->konwertuj($subject);
			
			$maile=explode(";", $conf[awarie_sms]);
			foreach ($maile as $m)
			{
				$email=new EMAIL();
				$email->WyslijMaila("$conf[awarie_email]", $m, $subject);
			}
		}
	}

	function UpdateUsAwr($dbh, $id_awr, $id_uaw)
	{
		include "func/config.php";

		$id=explode(" ", $_POST[zglaszajacy]);
		$id_abon=array_pop($id);
		$id=explode(" ", $_POST[usuwajacy]);
		$id_us=array_pop($id);

		$awarie=array('id_awr'=>$id_awr, 'id_zgl' =>$id_abon,
						 'opis'=> $_POST[opis_awarii]);

		$usawr=array(	'id_usaw'	=>$id_uaw,	'usuwajacy' =>$id_us,	'opis'=> $_POST[opis_usuwania] );

		Update($dbh, "Awarie", $awarie);
		Update($dbh, "Usuwanie_awarii", $usawr);
	}


	function ValidateAwarie()
	{
		$flag=1;
		include "func/config.php";

		if (  empty ($_POST[zglaszajacy]) || $_POST[zglaszajacy]==$conf[select] ) 
		{
			echo "Błąd pola 'Zgłaszający' : pole jest puste <br>";
			$flag=0;
		}

		if ( empty ($_POST[opis]))
		{
			echo "Nie wprowadzono opisu awarii";
			$flag=0;
		}

		if ( strlen($_POST[opis])>105 )
		{ 	 
			echo "Opis może mieć maksymalnie 105 znaków !";
			$flag=0;
		}
		
		return ($flag);	
	}
	
	function ValidateUsAwr()
	{
		$flag=1;
		include "func/config.php";

		if (  empty ($_POST[usuwajacy]) || $_POST[zglaszajacy]==$conf[select] ) 
		{
			echo "Błąd pola 'Usuwający' : pole jest puste <br>";
			$flag=0;
		}

		if ( empty ($_POST[opis]) )
		{
			echo "Nie wprowadzono opisu awarii";
			$flag=0;
		}

		if ( strlen($_POST[opis])>400 )
		{ 	 
			echo "Opis może mieć maksymalnie 400 znaków !";
			$flag=0;
		}
		
		return ($flag);	
	}

	function ValidateUpUsAwr()
	{
		$flag=1;
		include "func/config.php";

		if (  empty ($_POST[zglaszajacy]) || $_POST[zglaszajacy]==$conf[select] ) 
		{
			echo "Błąd pola 'Zgłaszający' : pole jest puste <br>";
			$flag=0;
		}

		if ( empty ($_POST[opis_awarii]))
		{
			echo "Nie wprowadzono opisu awarii";
			$flag=0;
		}

		if ( strlen($_POST[opis_awarii])>400 )
		{ 	 
			echo "Opis może mieć maksymalnie 400 znaków !";
			$flag=0;	
		}
		
		if (  empty ($_POST[usuwajacy]) || $_POST[zglaszajacy]==$conf[select] ) 
		{
			echo "Błąd pola 'Usuwający' : pole jest puste <br>";
			$flag=0;
		}

		if ( empty ($_POST[opis_usuwania]) )
		{
			echo "Nie wprowadzono opisu awarii";
			$flag=0;
		}

		if ( strlen($_POST[opis_usuwania])>400 )
		{ 	 
			echo "Opis może mieć maksymalnie 400 znaków !";
			$flag=0;
		}
		
		return ($flag);	
	}


}

?>