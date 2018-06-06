<?php

class ZLECENIA
{

	function ZLECENIA()
	{
//		include "func/config.php";
	}

	function ValidateZlecenie()
	{
		include "func/config.php";
		$flag=1;

		if (  empty ($_POST[zlecajacy]) || $_POST[zlecajacy]==$conf[select] ) 
		{
			echo "Błąd pola 'zlecajacy' : pole jest puste <br>";
			$flag=0;
		}
		
		if (  empty ($_POST[rodzaj]) || $_POST[rodzaj]==$conf[select] ) 
		{
			echo "Błąd pola 'rodzaj' : pole jest puste <br>";
			$flag=0;
		}

		if ( empty ($_POST[opis]))
		{
			echo "Nie wprowadzono opisu zlecenia";
			$flag=0;
		}

		if ( strlen($_POST[opis])>130 )
		{ 	 
			echo "Opis może mieć maksymalnie 130 znaków !";
			$flag=0;
		}
		
		return ($flag);	
	}

	
	function Demontaz($dbh, $id_abon, &$szmsk)
	{
		include "func/config.php";
		
		$q="select n.nazwa, u.miasto from nazwy n, miejsca_instalacji m, budynki b, ulice u, komputery k
		where m.id_bud=b.id_bud and b.id_ul=u.id_ul and n.id_abon=k.id_abon and k.id_msi=m.id_msi and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]' and n.id_abon='$id_abon'";
		WyswietlSql($q);
		$r=Query2($q,$dbh);
		$nazwa=$r[0];
		$miejsc=$r[1];
		
		$_POST[rodzaj]='demontaż';
		
		$q="select id_cpe,  typ, mac from cpe  where id_abon='$id_abon' order by id_cpe";
					
		WyswietlSql($q);
		$opis="Demontaż:";
		$flag=0;
		$s=Query($dbh,$q);
		while ($r=$s->fetchRow())
			{
				$flag=1;
				//switch ($r[0])
			  $opis.=" $r[0] - $r[1] - $r[2];";
				$_POST[zlecajacy]="$nazwa $id_abon";
				
				if ( $miejsc=="Mysłowice" || $miejsc=="Katowice" || $miejsc=="Bieruń" || $miejsc=="Sosnowiec" )
					$_POST[wykonawca]="Torz_Przemyslaw PRC024";
				else
					$_POST[wykonawca]="Wojcik_Krzysztof PRC009";
				$_POST[opis]=$opis;
				$_POST[wartosc]="0";
				$_POST[data_zak]=date("Y-m-d",time()+7*86400);
			}
			if ( $flag==1)
				$this->DodajZlecenie($dbh, $szmsk);
				
				
		$q="select id_onu, typ, mac from 
					(
					select id_onu,  typ, mac from onu  where id_abon='$id_abon'
					union all
					select r.id_rtr,  r.typ, r.mac from router r,     belong b where b.id_urz=r.id_rtr and b.id_abon='$id_abon'
					union all
					select s.id_stb, 	s.typ, s.mac from settopboxy s, belong b where b.id_urz=s.id_stb and b.id_abon='$id_abon'
					union all
					select s.id_sim, 	s.sn, s.number from sim s, 			belong b where b.id_urz=s.id_sim and b.id_abon='$id_abon'
					union all
					select m.id_mdm, 	m.vendor, m.sn from modem m, 		belong b where b.id_urz=m.id_mdm and b.id_abon='$id_abon'
					union all
					select b.id_bmk, b.model, b.mac from bramki_voip b, telefony_voip t where t.id_bmk=b.id_bmk and t.id_abon='$id_abon'
					) as query
					order by 1,2,3";
					
		WyswietlSql($q);
		$opis="Demontaż:";
		$flag=0;
		$s=Query($dbh,$q);
		while ($r=$s->fetchRow())
			{
				$flag=1;
				//switch ($r[0])
			  $opis.=" $r[0] - $r[1] - $r[2];";
				$_POST[zlecajacy]="$nazwa $id_abon";
				
				$_POST[wykonawca]="Ciepły_Oskar PRC030";
				$_POST[opis]=$opis;
				$_POST[wartosc]="0";
				$_POST[data_zak]=date("Y-m-d",time()+7*86400);
			}
			if ( $flag==1)
				$this->DodajZlecenie($dbh, $szmsk);

	}
	
	function ValidateWykZlc()
	{
			include "func/config.php";

		$flag=1;

		if ( empty ($_POST[opis]) )
		{
			echo "Nie wprowadzono opisu wykonania zlecenia";
			$flag=0;
		}

		if ( strlen($_POST[opis])>400 )
		{ 	 
			echo "Opis może mieć maksymalnie 400 znaków !";
			$flag=0;
		}
		
		return ($flag);	
	}

	function ValidateUpWykZlc()
	{
			include "func/config.php";

		$flag=1;

		if (  empty ($_POST[zlecajacy]) || $_POST[zlecajacy]==$conf[select] ) 
		{
			echo "Błąd pola 'Zgleceniobiorca' : pole jest puste <br>";
			$flag=0;
		}

		if ( empty ($_POST[opis_zlecenia]))
		{
			echo "Nie wprowadzono opisu zlecenia";
			$flag=0;
		}

		if ( strlen($_POST[opis_zlecenia])>400 )
		{ 	 
			echo "Opis może mieć maksymalnie 400 znaków !";
			$flag=0;
		}
		
		if (  empty ($_POST[wykonawca]) || $_POST[zlecajacy]==$conf[select] ) 
		{
			echo "Błąd pola 'Wykonawca' : pole jest puste <br>";
			$flag=0;
		}

		if ( empty ($_POST[opis_wykonania]) )
		{
			echo "Nie wprowadzono opisu wykonania zlecenia";
			$flag=0;
		}

		if ( strlen($_POST[opis_wykonania])>400 )
		{ 	 
			echo "Opis może mieć maksymalnie 400 znaków !";
			$flag=0;
		}
		
		return ($flag);	
	}


	function ListaZlecen($dbh, $p)
	{
		include "func/config.php";

		$serwisant=!ValidateAuth("'fin','admin'",$_SESSION[login],$_SESSION[haslo]);
				
		if ($p[wykonane]=="Wykonane")
			{
				$q1="select z.id_zlc, z.data_zgl, z.id_zcy, z.opis, n.nazwa, n.symbol, w.data_wyk, w.opis, p.nazwa , z.rodzaj
					from zlecenia z, nazwy n, wykonywanie_zlecenia w, pracownicy p
					where n.id_abon=z.id_zcy and w.id_zlc=z.id_zlc and z.wykonane='T' and p.id_prac=z.id_wyk 
					and z.data_zgl>='$p[data_od]' and z.data_zgl<='$p[data_do]'
					and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'";
		
				if( !empty($p[wykonawca]) && $p[wykonawca]!=$conf[select])
					{
						$prac=explode(" ", $_POST[wykonawca]);
						$id_prac=array_pop($prac);
						$q1.=" and z.id_wyk='$id_prac'";			
					}
					
				if ( $serwisant )
					{
						$prac=explode(" ", $_POST[wykonawca]);
						$id_prac=array_pop($prac);
						$q1.=" and z.id_wyk='$_SESSION[id_prac]'";	
					}
					
				if( !empty($p[zlecajacy]) && $p[zlecajacy]!=$conf[select] )
					{
						$zcy=explode(" ", $_POST[zlecajacy]);
						$id_zcy=array_pop($zcy);
						$q1.=" and z.id_zcy='$id_zcy'";			
					}
				if( !empty($p[rodzaj]) && $p[rodzaj]!=$conf[select] )
					{
						$q1.=" and z.rodzaj='$p[rodzaj]'";			
					}

				$q1.=" order by z.data_zgl, z.id_zlc";
		//echo "$q1 <br>";
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						DrawTable($lp++,$conf[table_color]);
							{	
								echo "<td> <a href=\"index.php?panel=inst&menu=updatewkzc&zlc=$row[0]\"> $row[0] </a></td>";
								echo "<td>  $row[1] / $row[6] </td>";
								echo "<td><b>";
								echo Choose($row[5], $row[4]);
				if ( $_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin')
					echo "<br><a href=\"index.php?panel=inst&menu=updateabon&abon=$row[2]\"> $row[2] </a> ";
				else
					echo "<br><a href=\"index.php?panel=sprzedaz&menu=updateabon&abon=$row[2]\"> $row[2] </a>";	

								if ( !$serwisant )
									echo "</b><br> $row[8]";
								echo "<td> $row[3] </td>";
								echo "<td> $row[7] </td>";
							echo "<td> <b>$row[8]</b> </td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}
			}
	else
			{
				$q1="select z.id_zlc, z.data_zgl, z.id_zcy, z.opis, z.wykonane, n.nazwa, n.symbol, z.wartosc, z.data_zak, p.nazwa, z.rodzaj, z.komentarz
					from zlecenia z, nazwy n, pracownicy p 
					where n.id_abon=z.id_zcy and z.wykonane='N' and p.id_prac=z.id_wyk
					and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]'
					and z.data_zgl>='$p[data_od]' and z.data_zgl<='$p[data_do]'";

				if( !empty($p[wykonawca]) && $p[wykonawca]!=$conf[select])
					{
						$prac=explode(" ", $_POST[wykonawca]);
						$id_prac=array_pop($prac);
						$q1.=" and z.id_wyk='$id_prac'";			
					}
					
				if ( $serwisant )
					{
						$prac=explode(" ", $_POST[wykonawca]);
						$id_prac=array_pop($prac);
						$q1.=" and z.id_wyk='$_SESSION[id_prac]'";			
					}

					
					if( !empty($p[zlecajacy]) && $p[zlecajacy]!=$conf[select] )
						{
							$zcy=explode(" ", $_POST[zlecajacy]);
							$id_zcy=array_pop($zcy);
							$q1.=" and z.id_zcy='$id_zcy'";			
						}
				if( !empty($p[rodzaj]) && $p[rodzaj]!=$conf[select] )
					{
						$q1.=" and z.rodzaj='$p[rodzaj]'";			
					}
					
					$q1.=" order by z.data_zgl, z.id_zlc";
			//		echo "$q1 <br>";
				WyswietlSql($q1);
				$lp=1;
				$sth1=Query($dbh,$q1);
				while ($row =$sth1->fetchRow())
					{
						
						DrawTable($lp++,$conf[table_color]);								
							{
								echo "<td> <a href=\"index.php?panel=inst&menu=updatezlc&zlc=$row[0]\"> $row[0] </a></td>";
								echo "<td> $row[1]</td>";
								echo "<td><b>";
								echo Choose($row[6], $row[5]);
				if ( $_SESSION[uprawnienia]=='fin' || $_SESSION[uprawnienia]=='admin')
					echo "<br> <a href=\"index.php?panel=inst&menu=updateabon&abon=$row[2]\"> $row[2] </a>";
				else
					echo "<br> <a href=\"index.php?panel=sprzedaz&menu=updateabon&abon=$row[2]\"> $row[2] </a>";	

								if ( !$serwisant )
									echo "</b><br> $row[9]";
								echo "</td>";
								echo "<td> $row[10] </td>";
								echo "<td> $row[3] </td>";
								echo "<td> $row[11] </td>";
								echo "<td> $row[7] </td>";
								echo "<td> <b>$row[8] </b></td>";
								echo "<td> <a href=\"index.php?panel=inst&menu=dodajwkzc&zlc=$row[0]\"> wykonano >> </a></td>";
								echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
							}
						echo "</tr>";
					}
			}
	}

	function DodajZlecenie($dbh, &$szmsk)
	{
		include "func/config.php";	

		$id=explode(" ", $_POST[zlecajacy]);
		$id_abon=array_pop($id);
		unset($id[-1]);
		$nazwa=strtoupper(join(" ", $id));

		$id=explode(" ", $_POST[wykonawca]);
		$id_prac=array_pop($id);
		
		if( empty($_POST[wartosc]) )
			$_POST[wartosc]=0;
		
		$id_zlc=IncItNum($dbh, $date=date("Y-m-d"), "ZLC");
		
		$zlecenie=array('id_zlc'=> $id_zlc, 'data_zgl'=>date( "Y-m-d"), 'id_zcy' =>$id_abon, 'id_wyk' =>$id_prac,
						 'opis'=> $_POST[opis], 'wartosc' => $_POST[wartosc], 'wykonane'=> 'N', 'data_zak' => $_POST[data_zak], 'rodzaj' => $_POST[rodzaj]);
		Insert($dbh, "Zlecenia", $zlecenie);

		$q="select u.miasto, u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom from miejsca_instalacji s, ulice u, budynki b, telefony t, komputery k
		where u.id_ul=b.id_ul and k.id_abon=t.id_podm and k.id_msi=s.id_msi and s.id_bud=b.id_bud 
		and k.id_abon='$id_abon'";
		WyswietlSql($q);
		
		$ktk=Query2($q,$dbh);
		$adres="$ktk[0], ul. $ktk[1] $ktk[2]/$ktk[3]";
		$tel="$ktk[5], $ktk[4]";
		
		$sk0=Skroc($ktk[0]);
//		$sk1=Skroc($ktk[1]);
		if ( !empty($ktk[3]) )
			$sadr=" $sk0, $ktk[1] $ktk[2]/$ktk[3]";
		else
				$sadr=" $sk0, $ktk[1] $ktk[2]";
				
		$mail=Query2("select email from maile where id_podm='$id_prac'",$dbh);
		$maile=explode(";", $mail[0]);

		$body="Zlecenie nr:			$id_zlc
		Wykonać do:			$zlecenie[data_zak]
		Przewidywana wartość zlecenia:			$zlecenie[wartosc] zł 
		Odbiorca zlecenia:			$nazwa - $adres - telefon: $tel
		
		Opis:			$zlecenie[opis]";

		if ( strlen($zlecenie[opis]) > 40)
			$adres=$sadr;

		if (preg_match("/^$firma[nazwa]/", $nazwa))	
			$subject="$zlecenie[data_zak] - $nazwa - $zlecenie[opis]";		
		else
			$subject="$zlecenie[data_zak] - $zlecenie[wartosc] zł - $nazwa - $adres - $tel - $zlecenie[opis]";		
		
		$subject=$szmsk->konwertuj($subject);
		foreach ($maile as $m)
		{
			$email=new EMAIL();
			$email->WyslijMaila("$conf[zlecenia_email]", $m, $subject, $body);
		}	
		
	}

	function DodajWykZlc($dbh, $id_zlc)
	{
		include "func/config.php";
		$date=date("Y-m-d");

		$wzc=array(	'id_wzc'	=>IncItNum($dbh, $date, "WZC"), 'data_wyk'=> $date, 'opis'=> $_POST[opis], 'id_zlc' => $id_zlc);

		$zlecenie=array('id_zlc' => $id_zlc, 'wykonane' => 'T');

		Insert($dbh, "Wykonywanie_zlecenia", $wzc);
		Update($dbh, "Zlecenia", $zlecenie);
	}

	function UpdateZlc($dbh, &$szmsk, $id_zlc)
	{
		include "func/config.php";

		$id=explode(" ", $_POST[zlecajacy]);
		$id_abon=array_pop($id);
		
		unset($id[-1]);
		$nazwa=strtoupper(join(" ", $id));
		
		$id=explode(" ", $_POST[wykonawca]);
		$id_prac=array_pop($id);
			
		if( empty($_POST[wartosc]) )
			$_POST[wartosc]=0;
		

		$zlecenie=array('id_zlc'=> $id_zlc, 'id_zcy' =>$id_abon, 'id_wyk' =>$id_prac,
							 'opis'=> $_POST[opis], 'wartosc' => $_POST[wartosc], 'data_zak' => $_POST[data_zak], 'rodzaj' => $_POST[rodzaj], 'komentarz' => $_POST[komentarz]);
		Update($dbh, "Zlecenia", $zlecenie);
		
		if ( isset($_POST[mail]) )
		{
			$q="select u.miasto, u.nazwa, b.numer, s.nr_lok, t.telefon, t.tel_kom from miejsca_instalacji s, ulice u, budynki b, telefony t , komputery k
			where u.id_ul=b.id_ul and k.id_abon=t.id_podm and k.id_msi=s.id_msi
			and k.id_abon='$id_abon'";
			WyswietlSql($q);
			$ktk=Query2($q,$dbh);
			$adres="$ktk[0], ul. $ktk[1] $ktk[2]/$ktk[3]";
			$tel="$ktk[5], $ktk[4]";
			
			$sk0=Skroc($ktk[0]);
			$sk1=Skroc($ktk[1]);
			if ( !empty($ktk[3]) )
				$sadr=" $sk0, $ktk[1] $ktk[2]/$ktk[3]";
			else
					$sadr=" $sk0, $ktk[1] $ktk[2]";
					
			$mail=Query2("select email from maile where id_podm='$id_prac'",$dbh);
			$maile=explode(";", $mail[0]);

			$body="Zlecenie nr:			$id_zlc
			Wykonać do:			$zlecenie[data_zak]
			Przewidywana wartość zlecenia:			$zlecenie[wartosc] zł 
			Odbiorca zlecenia:			$nazwa - $adres - telefon: $tel
			
			Opis:			$zlecenie[opis]";

			if ( strlen($zlecenie[opis]) > 40)
				$adres=$sadr;

			if (preg_match("/^$firma[nazwa]/", $nazwa))	
				$subject="$zlecenie[data_zak] - $nazwa - $zlecenie[opis]";		
			else
				$subject="$zlecenie[data_zak] - $zlecenie[wartosc] zł - $nazwa - $adres - $tel - $zlecenie[opis]";		
			$subject=$szmsk->konwertuj($subject);

			foreach ($maile as $m)
			{
				$email=new EMAIL();
				$email->WyslijMaila("$conf[zlecenia_email]", $m, $subject, $body);
			}
		}
	}

	function UpdateWykZlc($dbh, $id_awr, $id_uaw)
	{

		include "func/config.php";
		$dbh=DBConnect($DBNAME1);	

		$id=explode(" ", $_POST[zglaszajacy]);
		$id_abon=array_pop($id);
		$id=explode(" ", $_POST[usuwajacy]);
		$id_us=array_pop($id);

		$awarie=array('id_awr'=>$id_awr, 'id_zgl' =>$id_abon,
						 'opis'=> $_POST[opis_awarii]);

		$usawr=array(	'id_usaw'	=>$id_uaw,	'usuwajacy' =>$id_us,	'opis'=> $_POST[opis_usuwania], 
							'licznik_przed'=> Is_Null($_POST[licznik_przed]), 'licznik_po'=> Is_Null($_POST[licznik_po])  );

		Update($dbh, "Awarie", $awarie);
		Update($dbh, "Usuwanie_awarii", $usawr);
	}

}	


?>
