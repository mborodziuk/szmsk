<?php

function strtr_utf8($string, $from, $to) 
{ 
    $string = utf8_decode($string);     
    $string = strtr($string, utf8_decode($from), $to); 
 
    return utf8_encode($string); 
} 


function DBConnect($baza)
{
        include "config.php";
        require_once 'DB.php';
        $dsn = array
                (
                'phptype'  => $DBTYPE,
                'username' => $USER,
                'password' => $PASS,
                'host' 		=> $HOST,
                'database' => $baza,
                );
        $options = array(
                'debug'       => 2,
                'portability' => DB_PORTABILITY_ALL,
                );
        $dbh = DB::connect($dsn,$options);
        if (DB::isError($dbh)) 
	{
         die($dbh->getMessage());
                }
        return $dbh;
}

function MDB2Connect()
{
        include "config.php";
        require_once 'MDB2.php';
        $dsn = array
                (
                'phptype'  => "mysql",
                'username' => "vpopmail",
                'password' => "vpoppw",
                'host' => "localhost",
                'database' => "vpopmail",
                );
        $options = array(
                'debug'       => 5,
                'portability' => MDB2_PORTABILITY_ALL,
                );
        $dbh = MDB2::connect($dsn,$options);
        if (MDB2::isError($dbh)) 
	{
         die($dbh->getMessage());
                }
        return $dbh;
}

function Query($dbh, $query)
{
	include_once "config.php";
	$sth = $dbh->query($query);
	//WyswietlSql($query);
	if (DB::isError($sth))
		{
			die($sth->getMessage());
		}
	return $sth;
}

function Query2($query, $dbh=Null)
{
	include "config.php";
//	WyswietlSql($query);
	if ( $dbh==Null )
		$dbh=DBConnect($DBNAME1);

	$sth = $dbh->query($query);
	if (DB::isError($sth))
		{
			die($sth->getMessage());
		}
	$row=$sth->fetchRow();
	return $row;
}

function MDB2Query2($query, $dbh=Null)
{
	include "config.php";

	if ( $dbh==Null )
		$dbh=MDB2Connect();

	$sth = $dbh->query($query);
	if (MDB2::isError($sth))
		{
			die($sth->getMessage());
		}
	$row=$sth->fetchRow();
	return $row;
}

function WyswietlSql($q)
{
    include "config.php";
    if ($conf[wyswietl_sql]=='true' || $conf==1)
	echo " $q <br><br> ";
}
	

function Choose( $short, $long)
{
	return ( strlen($long) > 35 ? $short :  $long );
}


function Select($query, $name='', $active='', $oth='')
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$sth=Query($dbh,$query);
//	echo "$query";
	if ( !empty($name) )
		echo "<select name=\"$name\">";

	if ( !empty($active) )
	{
		if (preg_match("/ /", $active))
			{
				$id=explode(" ", $active);
				$ida=array_pop($id);
			}
		else
			$ida="$active";
	}

	$flag1=0;
 	$flag2=0;
	while ($row =$sth->fetchRow())
		{
			if ( !empty($ida) && $flag2==0)
				foreach ($row as $i) 
					if ($i == "$ida")
					{
							$flag1=1;
					}
			if ($flag1==1)
				{
					echo "<option selected>";
					$flag1=0;
					$flag2=1;
				}
			else
				echo "<option>";

			foreach ($row as $i) 
				{
					echo " $i  ";
				}
			echo "</option>";
		}

	if ( $flag2==0 && !empty($name) )
		echo "<option selected> $conf[select] </option> ";
	else
	    echo "<option> $conf[select] </option> ";
	
	if ( !empty($oth) )
		echo "<option> $oth </option> ";
	if ( !empty($name) )
		echo "</select>";
}



function SelectAbon($dbh)
{
	include "config.php";

	if ( empty($dbh) )
		$dbh=DBConnect($DBNAME1);

	$query="select id_abon, nazwa, symbol from abonenci order by nazwa";
	$sth=Query($dbh,$query);
	while ($row =$sth->fetchRow())
		{
			$abons[]=$row;
		}
	return $abons;
}

function SelectFromAbon($abon, $id='', $name='', $oth='')
{
	if ( !empty($name) )
		echo "<select name=\"$name\">";

	$flag1=0;
 	$flag2=0;
	foreach ($abon as $k => $v)
		{
			if ( !empty($id) && $flag2==0)
				foreach ($v as $i) 
					if ($i == $id)
							$flag1=1;
			if ($flag1==1)
				{
					echo "<option selected>";
					$flag1=0;
					$flag2=1;
				}
			else
				echo "<option>";

			$nazwa = Choose($v[2], $v[1]);
			echo "$nazwa $v[0] </option>";
		}

	if ($flag2==0 )
		echo "<option selected> $conf[select] </option> ";

	if ( !empty($oth) )
		echo "<option> $oth </option> ";
	if ( !empty($name) )
		echo "</select>";
}



function DrawTable($lp,$color, $tr1='tr3', $tr2='tr4')
{
     if ($lp % 2 == 1 )
       echo "<tr class=\"$tr1\" onmouseover=\"this.style.backgroundColor='$color'\" onmouseout=\"this.style.backgroundColor=''\" >";
   else
       echo "<tr class=\"$tr2\" onmouseover=\"this.style.backgroundColor='$color'\" onmouseout=\"this.style.backgroundColor=''\" >";
}														   
									   

function KontoSpace($numer)
{
	$kn1=mb_substr($numer,0,2);
	$kn2=mb_substr($numer,2,4);
	$kn3=mb_substr($numer,6,4);
	$kn4=mb_substr($numer,10,4);
	$kn5=mb_substr($numer,14,4);
	$kn6=mb_substr($numer,18,4);
	$kn7=mb_substr($numer,22,4);
	$konto="$kn1 $kn2 $kn3 $kn4 $kn5 $kn6 $kn7";
	return $konto;
}															 

function IncValue($dbh, $Q, $id='')
{
	$sth=Query($dbh, $Q);
	while ($row =$sth->fetchRow())
		{
			$str=$row[0];
		}
	if (empty($str) && !empty($id)) $str=$id;

	for ( $i=0,$len=strlen($str);  $i<$len;  ++$i )
	{
		if ( is_numeric($str[$i]) ) 
		{
			$newstr=mb_substr($str,0,$i);
			$int=mb_substr( $str, $i, $len );
			break;
		}
	}
	$n=strlen($int);
	++$int;
	$n-=strlen($int);
	while($n>0)
	{
		$int="0".$int;
		--$n;
	}
	$newstr.="$int";
	return "$newstr";
}

function IncValue2($str)
{
	for ( $i=0,$len=strlen($str);  $i<$len;  ++$i )
	{
		if ( is_numeric($str[$i]) ) 
		{
			$newstr=mb_substr($str,0,$i);
			$int=mb_substr( $str, $i, $len );
			break;
		}
	}
	$n=strlen($int);
	++$int;
	$n-=strlen($int);
	while($n>0)
	{
		$int="0".$int;
		--$n;
	}
	$newstr.="$int";
	return "$newstr";
}

function IncItNum($dbh, $date, $przedr)
{

	$d=explode("-", $date);
	switch ($przedr)
		{
			case "WPL":
				$Q="select id_wpl from wplaty where data_ksiegowania between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		order by id_wpl desc limit 1";
				break;
			case "WYP":
				$Q="select id_wyp from wyplaty where data_ksiegowania between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		order by id_wyp desc limit 1";
				break;
			case "AWR":
				$Q="select id_awr from awarie where czas_zgl  between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_awr desc limit 1";
				break;
			case "RKL":
				$Q="select id_cpl from complaint where not_time  between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_cpl desc limit 1";
				break;
			case "UAW":
				$Q="select id_usaw from usuwanie_awarii where czas_us  between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_usaw desc limit 1";
				break;
			case "SPW":
				$Q="select id_spw from sprawy_windykacyjne where data_zgl  between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_spw desc limit 1";
				break;
			case "ITL":
				$Q="select id_itl from instalacje where id_itl  like 'ITL/%/$d[1]/$d[0]' order by id_itl desc limit 1";
				break;
			case "PDL":
				$Q="select id_pdl from podlaczenia where data_rozp  between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_pdl desc limit 1";
				break;
			case "WND":
				$Q="select id_wnd from windykowanie where data_rozp  between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_wnd desc limit 1";
				break;			
			case "CSJ":
				$Q="select id_csj from cesje where data  between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_csj desc limit 1";
				break;
			case "ZLC":
				$Q="select id_zlc from zlecenia where data_zgl between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_zlc desc limit 1";
				break;
			case "WZC":
				$Q="select id_wzc from wykonywanie_zlecenia where data_wyk between 
		'$d[0]-$d[1]-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval::interval
		 order by id_wzc desc limit 1";
				break;					
			case "NEG":
				$Q="select id_neg from ustalenia where id_neg  like 'NEG/%/$d[1]/$d[0]' order by id_neg desc limit 1";
				break;
			case "PRL":
				$Q="select id_prl from przedluzenia where id_prl  like 'PRL/%/$d[1]/$d[0]' order by id_prl desc limit 1";
				break;

		}
	WyswietlSql($Q);
	$row=Query2($Q, $dbh);
	if (empty($row[0]))
		$wyj="$przedr/0001/$d[1]/$d[0]";
	else
		{
    		$id=explode("/", $row[0]);
    		$nr=$id[1];
		    ++$nr;
    		if ($nr < 10)
				{
					$id[1]="000$nr";
				}
    		else if ( $nr<100 && $nr>9)
				{
					$id[1]="00$nr";
				}
		
			else if ( $nr < 999 && $nr > 99)
				{
					$id[1]="0$nr";
				}
			else if ( $nr > 999)
					$id[1]="$nr";
			
			$wyj="$id[0]/$id[1]/$id[2]/$id[3]";
		} 
   return $wyj;
}

function IncItNum2($dbh, $date, $przedr)
{

	$d=explode("-", $date);
	switch ($przedr)
		{
			case "WPA":
				$Q="select id_wyp from wypowiedzenia_umow_abonenckich where data_wpl  between 
		'$d[0]-01-01 00:00:00' and date_trunc('month',timestamp '$d[0]-12-31 23:59:59')+'1month'::interval-'1day'::interval
		 order by id_wyp desc limit 1";
				break;
			case "PSP":
				$Q="select id_psp from pisma_przychodzace where data_wpl between 
		'$d[0]-01-01 00:00:00' and date_trunc('month',timestamp '$d[0]-$d[1]-01 00:00:00')+'1month'::interval-'1day'::interval
		 order by id_psp desc limit 1";
				break;
		}
	WyswietlSql($Q);
	$row=Query2($Q, $dbh);
	if (empty($row[0]))
		$wyj="$przedr/0001/$d[0]";
	else
		{
    		$id=explode("/", $row[0]);
    		$nr=$id[1];
		    ++$nr;
    		if ($nr < 10)
				{
					$id[1]="000$nr";
				}
    		else if ( $nr<100 && $nr>9)
				{
					$id[1]="00$nr";
				}
		
			else if ( $nr < 999 && $nr > 99)
				{
					$id[1]="0$nr";
				}
			else if ( $nr > 999)
					$id[1]="$nr";
			
			$wyj="$przedr/$id[1]/$d[0]";
		} 
   return $wyj;
}




function IsNull($str)
{
	if ( !empty($str) && !$str=="$conf[select]")
	    return ("$str"); 
	else 
	    return ("NULL");
}

function Insert($dbh, $table, $array)
{
	$q1="insert into $table ( ";
	$q2=" values (";
	foreach ( $array as $k => $w)
		{
			$q1.=" $k,";
			if ($w!="NULL")
			    $q2.=" '$w',";
			else
			    $q2.=" $w,";
		}
	$q1=mb_substr($q1, 0, -1);
	$q2=mb_substr($q2, 0, -1);

	$q1.=")";
	$q2.=")";

	$q="$q1"."$q2";	
  WyswietlSql($q);
	Query($dbh, $q);
//	echo "Wprowadzono nowe dane do systemu.";

}

function Update($dbh, $table, $array, $array2=array())
{
	$q1="update $table set";
	if ( empty($array2) )
		{
			reset($array);
			$k=key($array);
			$q2=" where $k='$array[$k]'";
			next($array);
		}
	else
		{
			reset($array2);
			$k2=key($array2);
			$q2=" where $k2='$array2[$k2]'";
			next($array2);
			while ( list($k2, $w2) = each($array2) )
				$q2.="and where $k2='$array2[$k2]'";
		}
	while ( list($k, $w) = each($array) )
		{
			if ($w!="NULL")
				$q1.=" $k='$w',";
			else
				$q1.=" $k=$w,";
		}
	$q1=mb_substr($q1, 0, -1);

	$q="$q1"."$q2";	
	
	WyswietlSql($q);	
	Query($dbh, $q);
//	echo "Wprowadzono modyfikacje do systemu.";

} 

function Delete ($array1, $array2, $typ='', $array3='')
{
  include "config.php";
	$dbh=DBConnect($DBNAME1);
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
				foreach ($array2 as $k2 => $v2)
					if ( !empty($k2) )
						{ 
							$q2="delete from $k2 where $v2 in (select id_kontakt from kontakty where id_podm='$k')";
							WyswietlSql($q2);	
							Query($dbh, $q2);
								
						}
				foreach ($array1 as $k1 => $v1)
					if ( !empty($k1) )
					{ 
							if ($typ=="komp")
								{
									$q1="delete from adresy_fizyczne where ip in (select ip from adresy_ip where id_urz='$k')";
									$q2="delete from adresy_ip where id_urz='$k'";
									WyswietlSql($q1);
				    					WyswietlSql($q2);
									Query($dbh,$q1);
									Query($dbh,$q2);
								}
						$q3="delete from $k1 where $v1='$k'";
						WyswietlSql($q3);	
						Query($dbh, $q3);
					}

				if ( !empty($array3) )
				foreach ($array3 as $k3 => $v3)
					{ 
						$q4="delete from $k3 where $v3='$k'";
						WyswietlSql($q4);	
						Query($dbh, $q4);
					}
			}
		}
	echo "Usunięto dane z systemu.";
}



function FindId($dbh,$str)
{
	$budynek=explode(" ",$str);
	$nr_bud=array_pop($budynek);
	array_shift($budynek);
	$budynek=array_values($budynek);
	$ulica=join(' ',$budynek);
	$Q3="select b.id_bud from budynki b, ulice u where b.id_ul=u.id_ul and b.numer='$nr_bud' and u.nazwa='$ulica'";
	$sth=Query($dbh,$Q3);
	$row =$sth->fetchRow();
	$id_bud=$row[0];

	return ($id_bud);
}	

function FindId2($str)
{
	include "config.php";
	$adm=explode(" ", $str);
	$id=$adm[count($adm)-1];
	if ($id != $conf[select])
	    return ($id);
	else
	    return ("NULL");
}

function TableToCheckbox($str, $name)
{
	if ($str == "T")
		return "<input type=\"checkbox\" name=\"$name\" value=\"ON\" CHECKED>";
	else 
		return "<input type=\"checkbox\" name=\"$name\" value=\"off\">";

}

function CheckboxToTable($str)
{
	return ( isset ($str) ? "T" : "N");
}

function PrevMonth($date)
	{
		//echo "$date";
		$d=explode("-", $date);
		
		if ( $d[1] >= 2 && $d[1] <= 10 )
			{
				--$d[1];
				$month=$d[0]."-"."0".$d[1];
			}
		else if ( $d[1] >= 11 && $d[1] <= 12 )
			{
				--$d[1];
				$month=$d[0]."-".$d[1];

			}	
		else if ( $d[1] == 1 )	
			{
				--$d[0];
				$month=$d[0]."-12";
			}
			
		return $month;
	}


	
function add_date($givendate, $day=0, $mth=0, $yr=0) 
	{
    $cd = strtotime($givendate);
    $newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
    date('d',$cd)+$day, date('Y',$cd)+$yr));
    return $newdate;
  }
	
	function Skroc($str)
{
	$i=strlen($str);
	$j=$i-1;
	$k=$i-2;
	
	$nstr="$str[0]-$str[$k]$str[$j]";
	return ($nstr);
}



                                                                                                                                                                                            
                                
function CountDate($date, $days)
{
		if ($days!=0)
			--$days;
    $d=explode("-",$date);
    $stamp1=mktime(0,0,0,$d[1],$d[2],$d[0]);
    $stamp2=$stamp1 + ($days * 86400);
    return (date("Y-m-d",$stamp2));
}
                                                                                                                                    


																																																																		
function CreateSymbol($name)
{
    $in=explode(" ", $name);
    $symbol="";
    foreach ( $in as $k => $v)
    {
			if ( $k==0 )
				$symbol.=$v;
			else if ( $k==1 )
				$symbol.="_"."$v";
			else
	    {
				$symbol.="_";
				$symbol.=mb_substr($in[$k],0,1);
			}
    }
    return (strtolower($symbol));
}


function DataSlownie($data)
{
		$d=explode("-", $data);
		$m=(int)$d[1];
		$miesiac=array(1=>"stycznia","lutego","marca","kwietnia","maja","czerwca","lipca","sierpnia","września","października","listopada","grudnia");
		
		$slownie="$d[2] $miesiac[$m] $d[0] r.";
		return $slownie;
}

function OstatniDzienMiesiaca($data)
{
		$d=explode("-", $data);
		$m=$d[1];
		$ostatni = date("Y-m-d", mktime (0,0,0,$d[1]+1,0,$d[0]));
		return "$ostatni";
}




function Generate($typ)
{
	switch ($typ)
		{
			case "netgen":
				system("sudo /home/szmsk/perl/netgen.pl 1>/dev/null 2>&1", $retval);
				echo $retval;
				break;
			case "konta":
				system("sudo /home/szmsk/perl/konta.pl 1>/dev/null 2>&1", $retval);
			//	echo $retval;
				break;
			case "vhost":
				system("sudo /home/szmsk/perl/vhost.pl 1>/dev/null 2>&1", $retval);
			//	echo $retval;
				break;
		}
}


///////////////////////////////////////////////////////////////////////////
/////////////////////////// V A L I D A T E ///////////////////////////////
///////////////////////////////////////////////////////////////////////////

function ValidateAuth($str,$login,$haslo)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$Q="select k.login, k.haslo, k.id_abon , p.nazwa, p.id_prac from konta k, pracownicy p, grupy g
		where k.id_abon=p.id_prac and k.id_gr=g.id_gr and g.uprawnienia in ($str) and login='$login' and haslo='$haslo' and k.aktywne='T'";
	$sth=Query($dbh, $Q);
	$row=$sth->fetchRow();
//	echo "$row[0] $row[1]";
	if ( !empty($row[0]) && !empty($row[1]) )
		{	
			$sw="blabla";
			$_SESSION['id_abon']=$row[2]; //.','.md5($row[2].$sw);
			$_SESSION['login']=$row[0];
			$_SESSION['nazwa']=$row[3];
			$_SESSION['id_prac']=$row[4];
			return 1;
		}
	else return 0;

}

function Uprawnienia($login, $haslo)
{
	include "config.php";
	$upr=array
	(
	
	);
	
	$dbh=DBConnect($DBNAME1);
	$Q="select k.login, k.haslo, k.id_abon , p.nazwa, p.id_prac, g.uprawnienia from konta k, pracownicy p, grupy g
		where k.id_abon=p.id_prac and k.id_gr=g.id_gr and g.uprawnienia in ($str) and login='$login' and haslo='$haslo'";
	$sth=Query($dbh, $Q);
	$row=$sth->fetchRow();
//	echo "$row[0] $row[1]";
	if ( !empty($row[0]) && !empty($row[1]) )
		{	
			$sw="blabla";
			$_SESSION['id_abon']=$row[2]; //.','.md5($row[2].$sw);
			$_SESSION['login']=$row[0];
			$_SESSION['nazwa']=$row[3];
			$_SESSION['id_prac']=$row[4];
			return 1;
		}
	else return 0;

}

function ValidateNip($nip)
{
	$flag=0;
	$wynik1=preg_match("/^[0-9]{3}-[0-9]{3}(-[0-9]{2}){2}/", $nip);
  $wynik2=preg_match("/^[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3}/", $nip);
  $wynik3=preg_match("/^[0-9]{10}$/", $nip);
  
	if ( $wynik1==1 || $wynik2==1 || $wynik3==1 )
		$flag=1;

	#		echo "Nieprawidłowy NIP !!! <br> NIP powinnien zostac wpisany w formacie, np: 222-073-85-59 lub 2220738559";
	return ($flag);
}

function ValidateDate($date)
{
	$wynik=preg_match("/^[0-9]{4}(-[0-9]{2}){2}/u", $date);
	if($wynik==0)
		 echo "Nieprawidłowy format daty !!! <br> Data wpisana powinna być w formacie Rok-Miesiąc-dzień, np: 2005-05-25<br>";
	return ($wynik);
}

function ValidateKontoBankowe($nr_konta)
{
	$wynik=preg_match("/^[0-9]{26}/", $nr_konta);
	if($wynik==0)
		 echo "Nieprawidłowy numer konta !!! <br> Numer konta powinno stanowić 26 cyfr wpisanych bez znaków spacji. <br>";
	return ($wynik);
}


function ValidateTel($nr_tel)
{
	$wynik=preg_match("/^[0-9]{11}/", $nr_tel);
	if($wynik==0)
		 echo "Nieprawidłowy numer telefonu !!! <br> Numer telefonu zapisujemy w postacji: 48XXXYYYZZZ gdzie 48 to kierunkowy do Polski. <br>";
	return ($wynik);
}



function ValidateKod($kod)
{
	$wynik=preg_match("/^[0-9]{2}-[0-9]{3}/", $kod);
	if($wynik==0)
		 echo "Nieprawidłowy kod pocztowy !!! <br> Kod powinnien być zapisany w postaci np: 41-406.  <br>";
	return ($wynik);
}



function ValidateKonto($typ='')
{
	$flag=1;
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ( $typ!="update" && empty ($_POST["login"]))
		{ 
		echo "Błąd pola 'Login' : pole jest puste <br>";
		$flag=0;
		}	
	else if($typ!="update")
		{
			$Q="select login from konta where login='$_POST[login]'";
			$sth=Query($dbh, $Q);
			$row=$sth->fetchRow();
			if ( !empty($row[0]) )
				{
					echo "Błąd pola 'Login' : istnieje konto o takiej nazwie <br>";
					$flag=0;
				}
		}
	if ( empty ($_POST["haslo1"]))
		{ 
		echo "Błąd pola 'Haslo' : pole jest puste <br>";
		$flag=0;
		}	
	if ( empty ($_POST["haslo2"]))
		{ 
		echo "Błąd pola 'Powtórz hasło' : pole jest puste <br>";
		$flag=0;
		}		
	if ( $_POST["haslo1"] != $_POST["haslo2"] )
		{ 
		echo " Hasła nie zgadzają się, wprowadź ponownie. <br>";
		$flag=0;
		}		
	return ($flag);
}

function ValidateVHF($typ='')
{
	$flag=1;

include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ( empty ($_POST["nazwa"]) || $_POST["nazwa"]=="ftp.")
		{ 
		echo "Błąd pola 'Nazwa' : pole jest puste <br>";
		$flag=0;
		}	
	else if($typ!="update")
		{
			$Q="select nazwa from vhost_ftp where nazwa='$_POST[nazwa]'";
			$sth=Query($dbh, $Q);
			$row=$sth->fetchRow();
			if ( !empty($row[0]) )
				{
					echo "Błąd pola 'Nazwa' : istnieje juz wirtualny host o takiej nazwie <br>";
					$flag=0;
				}
		}

	if ( empty ($_POST["port"]))
		{ 
		echo "Błąd pola 'Port' : pole jest puste <br>";
		$flag=0;
		}	
	else if($typ!="update")
		{
			$Q="select port from vhost_ftp where port='$_POST[port]'";
			$sth=Query($dbh, $Q);
			$row=$sth->fetchRow();
			if ( !empty($row[0]) )
				{
					echo "Błąd pola 'Port' : istnieje juz wirtualny host na takim porcie. <br>";
					$flag=0;
				}
		}
	return ($flag);
}

function ValidateVHW($typ='')
{
	$flag=1;

include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ( empty ($_POST["nazwa"]) || $_POST["nazwa"]=="www.")
		{ 
		echo "Błąd pola 'Nazwa' : pole jest puste <br>";
		$flag=0;
		}	
	else if($typ!="update")
		{
			$Q="select nazwa from vhost_www where nazwa='$_POST[nazwa]'";
			$sth=Query($dbh, $Q);
			$row=$sth->fetchRow();
			if ( !empty($row[0]) )
				{
					echo "Błąd pola 'Nazwa' : istnieje juz wirtualny host o takiej nazwie <br>";
					$flag=0;
				}
		}

	return ($flag);
}



function ValidateCsj($nr_csj, $data)
{
	$wynik1=preg_match("/^[0-9]{4}(-[0-9]{2}){2}/", $data);	
	$wynik2=preg_match("/^[0-9]{2}\/CSJ\/[0-9]{2}/", $nr_csj);
	
	if( !$wynik1 || !$wynik2)
		 echo "Nieprawidłowy format daty !!! <br> Data wpisana powinna być w formacie Rok-Miesiąc-dzień, np: 2005-05-25";
	
	return ($wynik1*$wynik2);
}


function IsVlan($vlan)
{
	$wynik=preg_match('/^[\d]{1,4}$/', $vlan);	
		
	if( !$wynik || $vlan > 4094 )
	{
		 echo "Nieprawidłowy format vlan !!! <br> Vlan to liczba od 1 do 4094";
		 $wynik=0;
	}
	return ($wynik);
}


function isEmail ($email)
{
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
		echo "Błędny format e-maila. <br> Adres e-maiil wygląda np.: <i>nazwa@domena.pl </i> <br>";
		$wynik=0;
	}
else
	$wynik=1;
	
	return($wynik);
}

function isMac($mac)
{
  // 01:23:45:67:89:ab
  if (preg_match('/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/', $mac))
    return true;
  // 01-23-45-67-89-ab
  if (preg_match('/^([a-fA-F0-9]{2}\-){5}[a-fA-F0-9]{2}$/', $mac))
    return true;
  // 0123456789ab
  else if (preg_match('/^[a-fA-F0-9]{12}$/', $mac))
    return true;
  // 0123.4567.89ab
  else if (preg_match('/^([a-fA-F0-9]{4}\.){2}[a-fA-F0-9]{4}$/', $mac))
    return true;
  else
    return false;
}


function NormalizeMac($mac)
{
  // remove any dots
  $mac =  str_replace(".", "", $mac);

  // replace dashes with colons
  $mac =  str_replace("-", ":", $mac);

  // counting colons
  $colon_count = substr_count ($mac , ":");

  // insert enough colons if none exist
  if ($colon_count == 0)
  {
    $mac =  substr_replace($mac, ":", 2, 0);
    $mac =  substr_replace($mac, ":", 5, 0);
    $mac =  substr_replace($mac, ":", 8, 0);
    $mac =  substr_replace($mac, ":", 11, 0);
    $mac =  substr_replace($mac, ":", 14, 0);
  }

  // uppercase
  $mac = strtoupper($mac);

  // DE:AD:BE:EF:10:24
  return $mac;
}


function PonMac($mac)
{
  // remove any dots
  $mac =  str_replace(".", "", $mac);

  // remove any dashes
  $mac =  str_replace("-", "", $mac);
  
	// remove ":"
  $mac =  str_replace(":", "", $mac);

  // counting colons
  $colon_count = substr_count ($mac , ".");

  // insert enough colons if none exist
  if ($colon_count == 0)
  {
    $mac =  substr_replace($mac, ".", 4, 0);
    $mac =  substr_replace($mac, ".", 9, 0);
  }

  // uppercase
  $mac = strtolower($mac);

  // DE:AD:BE:EF:10:24
  return $mac;
}


function Logging($dbh, $log_table, $tab, $id_tbl)
{
		$q="select id from $log_table order by id desc limit 1";
		
		$log=array(
		'id'	  			=> IncValue($dbh,$q, "LOG000000000000000"),
		'tab'					=> $tab,
		'id_tbl'			=> $id_tbl, 
		'id_prc'		  => $_SESSION['id_prac'],	
		'time'				=> date( "Y-m-d H:I")
		);
		
		Insert($dbh, $log_table, $log);
}


?>