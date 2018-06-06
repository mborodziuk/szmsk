<?php
/////////////////////////////////////////////////////////////////
//////////////////    N o t y   O b c i a z e n i o w e    ///////////////////
///////////////////////////////////////////////////////////////

class DEBITNOTE
{

	function DeleteNo ($dbh)
	{
		 include "func/config.php";
		
		$_POST2=array_reverse($_POST);
		foreach ($_POST2 as $k => $v)

			{
				if ( $k!="przycisk" )
				{			
					$d=explode("/", $k);
		
					$q5="select d.nr_nob, d.id_odb, a.pesel_nip from noty_obciazeniowe d, abonenci a where d.nr_nob like '%/$d[2]/$d[3]' and d.id_odb=a.id_abon order by nr_nob desc limit 1";	
					$sth=Query($dbh, $q5);
					$row=$sth->fetchRow();
					$ds_ost=$row[0];
					if ( !ValidateNip($row[2]) )
					{
						$q2="select kwota from noty_obciazeniowe where nr_nob='$k'";
						$sth=Query($dbh, $q2);
						$row =$sth->fetchRow();						
						$kwota=$row[0];
				
							$q3="update abonenci set saldo=saldo+$kwota where id_abon=(select id_odb from noty_obciazeniowe where nr_nob='$k');
							delete from noty_obciazeniowe where nr_nob='$k';";
							WyswietlSql($q3);	
							Query($dbh, $q3);
							
							if ($ds_ost != $k)
							{
								$q4="update noty_obciazeniowe  set nr_nob='$k'  where nr_nob='$ds_ost';";
								WyswietlSql($q4);	
								Query($dbh, $q4);
							}
					}
				else 
					echo "Nie można usunąć Noty Obciążeniowej, ponieważ ostatnia wystawiona w bieżącym miesiącu to faktura dla firmy.";
				}
			}
		echo "Usunięto dane z systemu.";
	}

	function PierwszyRoboczy($data)
	{
		$d=explode("-",$data);
		
		$pierw_rob=date(w, mktime(0,0,0,$d[1],"01",$d[0]));
		if ( $pierw_rob != 0 ) 
			$dzien="01";
		else
			 $dzien="02";
		return "$d[0]-$d[1]-$dzien";
	}

	function InitNOB($dbh)
	{
		$data=date("Y-m");
		$nr=date("/m/Y");
		$q="select nr_nob from noty_obciazeniowe where data_wyst between 
		'$data-01 00:00:00' and date_trunc('month',timestamp '$data-01 00:00:00')+'1month'::interval-'1day'::interval order by nr_nob desc limit 1";
		$sth=Query($dbh, $q);
		$row=$sth->fetchRow();
		if ( empty($row) )
			$nr="NOB/0001"."$nr";
		else 
			{
				$numer=explode("/",$row[0]);
				if ($numer[0] < 50)
						$nr=$this->IncNOB($row[0]);
				else 
					$nr="XXX";
			}
		return($nr);
	}

	function IncNOB($nr)
{
    $nry=explode("/", $nr);
    ++$nry[1];
    if ($nry[1] < 10)
        $nry[1]="000"."$nry[1]";
    else if ($nry[1] < 100)
        $nry[1]="00"."$nry[1]";
    else if ( $nry[1] < 1000)
	$nry[1]="0"."$nry[1]";
	
    $new_nr="NOB/$nry[1]"."/"."$nry[2]"."/"."$nry[3]";
    return($new_nr);
}


	function DebitNoteList($p)
	{
		 include "func/config.php";
		$dbh=DBConnect($DBNAME1);
		$idk=explode(" ", $p[abon]);
		$ida=array_pop($idk);
		
		if (empty($p[stan]))
			{
				$p[stan]="'uregulowana','nieuregulowana'";
			}
		else if ($p[stan] == "Wszystkie")
				$p[stan]="'uregulowana','nieuregulowana'";
		else if ($p[stan] == "Uregulowane")
			$p[stan]="'uregulowana'";
		else if ($p[stan] == "Nieuregulowane")
			$p[stan]="'nieuregulowana'";

		if (empty($p[order]) || $p[order] == "Data wystawienia")
			{
				$p[order]="t.data_wyst, t.nr_nob";
			}
		else if ($p[order] == "Nazwa odbiorcy")
				$p[order]="n.nazwa, t.data_wyst";


			$q1="	select  t.nr_nob, n.nazwa, t.data_wyst, t.term_plat, t.kwota
						from noty_obciazeniowe t, nazwy n 
						where t.id_odb=n.id_abon and t.data_wyst >= '$p[data_od]' and t.data_wyst <= '$p[data_do]' 
						and n.wazne_od <= '$p[data_do]' and n.wazne_do >= '$p[data_do]'";
						if (!empty($p[abon]) && $p[abon] !=$conf[select])   
							$q1.=" and n.id_abon='$ida' 	order by $p[order]";
						else 
						$q1.=" 	order by $p[order]";
						//echo "$q1";
						
		$sth1=Query($dbh,$q1);
		$lp=1;
		$suma=0;
		while ($row1 =$sth1->fetchRow())
			{
				$suma+=$row1[4];
				DrawTable($lp++,$conf[table_color]);			
				$kwota=number_format($row1[4], 2,'.','');
				echo "<td class=\"klasa4\"> <a href=\"index.php?panel=fin&menu=debitnoteupd&&no=$row1[0]\"> $row1[0] </a> </td>";
				echo "<td class=\"klasa4b\"> $row1[1]</td>";
				echo "<td class=\"klasa4\"> $row1[2] <br> $row1[3]</td>";
				echo "<td class=\"klasa4\"> $kwota</td>";

				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=nob&nr=$row1[0]',800,800, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=nob&nr=$row1[0]',800,800, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('pdf/mkpdf.php?dok=nobfv&typ=DUPLIKAT&nr=$row1[0]',800,800, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
			 echo "</tr>";
			 }
				 DrawTable($lp++,$conf[table_color]);
				echo "<td> </td>";
				echo "<td> <b> SUMA: </b></td>";
				echo "<td></td>";
				echo "<td> <b>$suma </b> </td>"; 				
				echo "<td> </td>";
				echo "<td> </td>";
				echo "<td> </td>";
				echo "<td> </td>";
				echo "</tr>";
	}

	

	function DebitNoteAdd($dbh)
	{
	include "func/config.php";
	$id_odb=FindId2($_POST[odbiorca]);
	$kwota=$_POST[kwota];
	
	if ( empty($kwota) )
	{
		$q1="select sum(kwota) from wplaty where id_kontrah='$id_odb' 
		and data_ksiegowania>=(select data_zaw from umowy_abonenckie where status='windykowana' and id_abon='$id_odb')";
		$r1=Query2($q1, $dbh);
		$suma_wplat=$r1[0];
		
		$q2="select count(t.cena) from towary_sprzedaz t, pozycje_sprzedaz p, dokumenty_sprzedaz d where 
		t.id_tows=p.id_tows and p.nr_ds=d.nr_ds and d.id_odb='$id_odb'  
		and p.id_tows=(select id_taryfy from komputery where id_abon='$id_odb')";
		$r2=Query2($q2, $dbh);
		$ilosc_abonamentow=$r2[0];
		
		$q3="select sum(t.cena) from towary_sprzedaz t, pozycje_sprzedaz p, dokumenty_sprzedaz d where 
		t.id_tows=p.id_tows and p.nr_ds=d.nr_ds and d.id_odb='$id_odb'  
		and p.id_tows != (select id_taryfy from komputery where id_abon='$id_odb')";
		$r3=Query2($q3, $dbh);
		$suma_nie_abonamentow=$r3[0];
		
		$q4="select t.cena from towary_sprzedaz t, komputery k where 
		t.id_tows=k.id_taryfy and k.id_abon='$id_odb'";
		$r4=Query2($q4, $dbh);		
		$cena_pakietu=$r4[0];
		
		$n=($suma_wplat-$suma_nie_abonamentow) / $cena_pakietu;
		$n=floor($n);
		
		$r5=Query2($QA12,$dbh);
		$ulga_inst=$r5[0];
		$miesiace=24;
		$ulga_miesiac=$ulga_inst/$miesiace;
		$kwota=($miesiace-$n)*$ulga_miesiac;
		$kwota=round($kwota,2);
		
	};

	
	$dn=array
	(
	'nr_nob'			=> $this->FindLastNOB($dbh,$_POST[data_wyst]), 			'id_odb'		=> $id_odb,
	'data_wyst'		=> $_POST[data_wyst],	'term_plat'	=> CountDate($_POST[data_wyst], $_POST[term_plat]),
	'miejsce_wyst'	=> $_POST[miejsce_wyst], 'forma_plat'	=>$_POST[forma_plat], 	'stan'		=> $_POST[stan],
	'kwota' => $kwota, 'wystawil' => $_POST[wystawil], 'zaplacona' => 'N', 'opis' => $_POST[opis]
	);

		Insert($dbh, "NOTY_OBCIAZENIOWE", $dn);
		$q1="update abonenci set saldo=saldo-$dn[kwota] where id_abon='$dn[id_odb]'"; 
		WyswietlSql($q1);
		Query($dbh, $q1);
	}

	function FindLastNOB($dbh,$date)
{
    $d=explode("-", $date);
    $Q="select nr_nob from noty_obciazeniowe where data_wyst 
		between '$d[0]-$d[1]-01 00:00:00' 
		and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval-'1day'::interval
		order by nr_nob desc limit 1";

    $row=Query2($Q, $dbh);
    if (empty($row[0]))
        $nr="NOB/0001/$d[1]/$d[0]";
    else
    $nr=$this->IncNOB($row[0]);
    return ($nr);
}

	function DebitNoteUpd($dbh, $no)
	{
	include "func/config.php";
	$id_odb=FindId2($_POST[odbiorca]);
	$kwota=$_POST[kwota];
	
	$no0=$_SESSION[$_GET[no].$_SESSION[login]];

	$dn=array
	(
	'nr_nob'			=> $no, 'id_odb'			=> $id_odb,
	'data_wyst'		=> $_POST[data_wyst],	'term_plat'	=> $_POST[term_plat],
	'miejsce_wyst'	=> $_POST[miejsce_wyst], 'forma_plat'	=>$_POST[forma_plat], 	'stan'		=> $_POST[stan],
	'kwota' => $kwota, 'wystawil' => $_POST[wystawil],  'opis' => $_POST[opis]
	);

		Update($dbh, "NOTY_OBCIAZENIOWE", $dn);
		
	if ( $no0[id_odb] != $id_odb )
	{

		$q1="update abonenci set saldo=saldo+$kwota where id_abon='$no0[id_odb]'; 
		update abonenci set saldo=saldo-$kwota where id_abon='$id_odb'";
		
	}
	else
			$q1="update abonenci set saldo=saldo+$no0[kwota]-$dn[kwota] where id_abon='$dn[id_odb]'"; 
		
		echo "$q1";
		Query($dbh, $q1);

	
	}

	function ValidateDebitNote()
	{
		$flag=1;

		if ( !ValidateDate($_POST[data_wyst]) )
			{ 
				echo "Błąd pola 'Data wystawienia' <br>";
				$flag=0;
			}

		return ($flag);
	}
		
}

?>