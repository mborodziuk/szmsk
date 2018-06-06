<?php


class COMPLAINT
{

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

	function ComplaintList($dbh, $p)
	{
		include "func/config.php";
		$Q="select count(distinct nr_um) from umowy_abonenckie where status='Obowiązująca'";
		$s=Query($dbh,$Q);
		$r=$s->fetchRow();
		$ilum=$r[0];
		
		if ($p[rozpatrzona]=="Rozpatrzone")
			{

				$q1="select c.id_cpl, c.not_time, c.id_abon, c.brief, n.nazwa, n.symbol, au.czas_us, au.opis, p.nazwa, n.id_abon
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
					"select c.id_cpl, c.not_time, c.submit_time, c.brief, n.nazwa, n.symbol,  n.id_abon
					from complaint c, nazwy n
					where
					n.id_abon=c.id_abon and c.considered='N' and c.not_time between '$p[data_od]' and '$p[data_do]'
							and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'";
					//echo "$q1";
				if( !empty($p[abon]) && $p[abon]!=$conf[select] )
						{
							$zgl=explode(" ", $_POST[abon]);
							$id_abon=array_pop($abon);
							$q1.=" and c.id_abon='$id_abon'";			
						}
					$q1.=" order by c.not_time, c.id_cpl";
					
				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						
							DrawTable($lp++,$conf[table_color]);
								
							{
								echo "<td> <a href=\"index.php?panel=inst&menu=cplupd&cpl=$row[0]\"> $row[0] </a></td>";
								echo "<td> $row[1] </td>";
								echo "<td> $row[2] </td>";
								echo "<td><b>";
								echo Choose($row[5], $row[4]);
								echo "</b> <br> $row[8] <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[7]\"> $row[7] </a></td>";								echo "<td> $row[3] </td>";
																echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('image/mkimage.php?dok=complaint&id_dok=$row[0]',800,1100, '38')\"/> <img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/></a> </td>";
								echo "<td> <a href=\"index.php?panel=inst&menu=dodajusawr&awr=$row[0]\"> Rozpatrzono >> </a></td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}
			}
	}

	function ComplaintAdd($dbh)
	{
		include "func/config.php";

		$id=explode(" ", $_POST[abonent]);
		$id_abon=array_pop($id);
	
		$id_cpl=IncItNum($dbh, $date=$_POST[data_wpl], "RKL");
		
		$uploadfile = $conf[upload] .'/'. basename($_FILES['complaint_img']['name']);
		$name = $_POST['name'];
		
		if (move_uploaded_file($_FILES['complaint_img']['tmp_name'], $uploadfile))
		 {   
			echo "Plik został wczytany poprawnie.<br>";
		 }
		 else   {   echo "Błąd przy wczytywaniu pliku !<br>";   }

		 echo "$uploadfile\n";

		$conn = pg_pconnect("dbname=$DBNAME1 user=$USER password=$PASS");
		pg_query($conn, "begin");
		$oid=pg_lo_import($conn, $uploadfile); 
		pg_query($conn, "commit");
	
		$cpl=array('id_cpl'=> $id_cpl, 'id_abon' =>$id_abon, 'not_time'=>$_POST[data_wpl], 'submit_time'=>$_POST[data_pis],
								'brief'=> $_POST[tresc], 'image'=> $oid);
												
		Insert($dbh, "complaint", $cpl);
		
		
		
		$subject="$_POST[abonent] $_POST[instytucja] wysłał/a do nas reklamację.";
		$body="$_POST[abonent] $_POST[instytucja] wysłał/a do nas dnia $_POST[data_wpl] reklamację.";
		
		$maile=explode(";", $conf[pismaprzych_email]);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[szmsk_email]", $m, $subject, $body);
		}	}

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
						 'opis'=> $_POST[opis]);
		Update($dbh, "Awarie", $awarie);

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



	
	function ComplaintValidate()
	{
		include "func/config.php";
		$flag=1;

		if (  empty($_POST[abonent]) || $_POST[abonent]==$conf[select] )  
		{
			echo "Pole 'Abonent' musi być wypełnione : pole jest puste <br>";
			$flag=0;
		}

		
		 if ( empty($_FILES['complaint_img']['name'])  )
		 {
			echo "Brak obrazu (skanu) pisma ! <br>";
			$flag=0;		 
		 }

		if ( strlen($_POST[uwagi])>500 )
		{ 	 
			echo "Skrót reklamacji może mieć maksymalnie 500 znaków ! <br>";
			$flag=0;
		}
		
		if ( ValidateDate($_POST[data_wpl]) || ValidateDate($_POST[data_pis]) || ValidateDate($_POST[data_wej]) )
			$flag==0;
	
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