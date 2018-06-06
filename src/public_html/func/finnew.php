<?php

function IncNr($dbh, $Q, $id='')
{
	$sth=Query($dbh, $Q);
	while ($row =$sth->fetchRow())
		{
			$str=$row[0];
		}
	if (empty($str) && !empty($id)) $str=$id;

	$nr=explode("/", $str);

	for ( $i=0,$len=strlen($str);  $i<$len;  ++$i )
	{
		if ( is_numeric($str[$i]) ) 
		{
			$newstr=substr($str,0,$i);
			$int=substr( $str, $i, $len );
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


	function ListaPrac()
	{
		$dbh=DBConnect($DBNAME1);
		$query="select  id_pracy, nazwa, data_rozp, data_zak, kwota
					from prace order by id_pracy";

		$sth=Query($dbh,$query);
		$lp=1;
		 while ($row =$sth->fetchRow())
			{
				DrawTable($lp++,$conf[table_color]);  	

					echo "<td> <a href=\"index.php?panel=fin&menu=updateprace&praca=$row[0]\"> $row[0] </a> </td>";
					echo "<td> $row[1]</td>";
					echo "<td> $row[2]</td>";
					echo "<td> $row[3]</td>";
					echo "<td> $row[4]</td>";
				echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
			 echo "</tr>";
				 }
	}

	function ListaUmp()
	{
		$dbh=DBConnect($DBNAME1);
		$query="	select  um.nr_ump, p.nazwa, pr.nazwa, um.data_zawarcia, um.typ
					from umowypracy um, pracownicy p, prace pr 
					where	 p.id_prac=um.id_prac and um.id_pracy=pr.id_pracy order by um.nr_ump";

		$sth=Query($dbh,$query);
		$l=1;
		 while ($row =$sth->fetchRow())
			{
				DrawTable($lp++,$conf[table_color]);  	

					echo "<td> <a href=\"index.php?panel=fin&menu=updateump&ump=$row[0]\"> $row[0] </a> </td>";
					echo "<td> $row[1]</td>";
					echo "<td> $row[2]</td>";
					echo "<td> $row[3]</td>";
					echo "<td> $row[4] </td>";
				echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
			 echo "</tr>";
				 }
	}

	function AddNewUmp()
	{
		$dbh=DBConnect($DBNAME1);	


		$ump=array (	
							'nr_ump'				=>	$_POST[nr_ump], 			'id_prac'	=>	FindId2($_POST[pracownik]),	'id_pracy'	=>	FindId2($_POST[praca]),
							'data_zawarcia'	=>	$_POST[data_zawarcia],	'typ'			=>	$_POST[typ]
						);
		Insert($dbh, "UMOWYPRACY", $ump);
	}

	function ValidatePrace()
	{
		$flag=1;
		if ( empty ($_POST[nazwa]))
			{ 
				echo "Błąd pola 'Nazwa' : pole jest puste <br>";
				$flag=0;
			}	

		if ( empty($_POST[kwota]) )
			{ 
				echo "Błąd pola 'Kwota' : pole jest puste <br>";
				$flag=0;
			}

		if ( empty($_POST[opis]) )
			{ 
				echo "Błąd pola 'Opis' : pole jest puste <br>";
				$flag=0;
			}

		if ( !ValidateDate($_POST[data_rozp]) )
			{ 
				echo "Błąd pola 'Data rozpoczęcia'<br>";
				$flag=0;
			}

		if ( !ValidateDate($_POST[data_zak]) )
			{ 
				echo "Błąd pola 'Data zańczenia'<br>";
				$flag=0;
			}

		return ($flag);
	}

	function ValidateUmp()
	{
		$flag=1;
		if ( empty ($_POST[nr_ump]))
			{ 
				echo "Błąd pola 'Numer' : pole jest puste <br>";
				$flag=0;
			}	

		if ( !ValidateDate($_POST[data_zawarcia]) )
			{ 
				echo "Błąd pola 'Data zawarcia'";
				$flag=0;
			}

		return ($flag);
	}
	
	function AddNewPrace()
	{
		$dbh=DBConnect($DBNAME1);	

		$Q1="select id_pracy from prace order by id_pracy desc limit 1";
		$id_pracy=IncValue($dbh, $Q1, "PR0000");
		
		$praca=array (	
							'id_pracy'	=>	$id_pracy, 					'nazwa'		=>	$_POST[nazwa],				'opis'	=>	$_POST[opis],
							'data_rozp'	=>	$_POST[data_rozp],		'data_zak'	=>	$_POST[data_zak],			'kwota'	=>	$_POST[kwota]
						);
		Insert($dbh, "PRACE", $praca);
	}

	function UpdatePrace($id_pracy)
	{
		$dbh=DBConnect($DBNAME1);	

		$praca=array (	
							'id_pracy'	=>	$id_pracy, 					'nazwa'		=>	$_POST[nazwa],				'opis'	=>	$_POST[opis],
							'data_rozp'	=>	$_POST[data_rozp],		'data_zak'	=>	$_POST[data_zak],			'kwota'	=>	$_POST[kwota]
						);
		Update($dbh, "PRACE", $praca);
	}


	function UpdateUmp($nr_ump)
	{
		$dbh=DBConnect($DBNAME1);	

		$SESSION[ump]=$ump;
		$ump=array (	
							'nr_ump'				=>	$ump[nr_ump],		'nr_ump'				=>	$_POST[nr_ump], 			'id_prac'	=>	FindId2($_POST[pracownik]),	
							'id_pracy'	=>	FindId2($_POST[praca]),	'data_zawarcia'	=>	$_POST[data_zawarcia],	'typ'			=>	$_POST[typ]
						);
		Update($dbh, "UMOWYPRACY", $ump);
	}
	
	

///////////////////////////////////////////////////
//////////////// B U D Y N K I ///////////////////
/////////////////////////////////////////////////

function ListaBudynkow()
{
   include "func/config.php";
	$dbh=DBConnect($DBNAME1);

	$query="select b.id_bud, u.nazwa, b.numer, u.miasto, a.symbol, b.il_mieszk, b.przylacze, b.adres_ip 
		from budynki b, ulice u, instytucje a
		where b.id_ul=u.id_ul and a.id_inst=b.id_adm 
		order by u.miasto, u.nazwa, b.numer, b.id_bud"; 
	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			$q1="	select count(id_abon) from abonenci where id_bud='$row[0]'"; 
			$sth1=Query($dbh,$q1);
			$row1 =$sth1->fetchRow();
			DrawTable($lp++,$conf[table_color]);  	
				echo "<td> <a href=\"index.php?panel=fin&menu=updatebud&bud=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> ul. $row[1] $row[2], $row[3]</td>";
  			echo "<td> $row[4]</td>";
  			echo "<td> $row1[0]</td>";
  			echo "<td> $row[5]</td>";
  			echo "<td> $row[6]</td>";
  			echo "<td> $row[7]</td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
     echo "</tr>";
       }
}

function AddNewBud()
{
	include "config.php";

	$dbh=DBConnect($DBNAME1);	
	$Q1="select id_bud from budynki order by id_bud desc limit 1";
	$id_bud=IncValue($dbh, $Q1, "bud00");

	if ( empty( $_POST[inna_ul] ) && $_POST[ulica]!="Inna")
		{
			$bud=array ('id_bud'	=>$id_bud, 	'id_ul'	=>	FindId2( $_POST[ulica] ), 'id_adm'	=>FindId2( $_POST[administracja] ),   
			'numer'=>$_POST[nr_bud], 'il_mieszk'	=>IsNull($_POST[il_mieszk]), 	'przylacze'		=>$_POST[przylacze], 'adres_ip'=>$_POST[adres_ip]);
		}
	else	if ( !empty( $_POST[inna_ul] ) && !empty( $_POST[miasto] ) && !empty( $_POST[kod] ) && $_POST[ulica]=="Inna")
		{
			$Q1="select id_ul from ulice order by id_ul desc limit 1";
			$id_ul=IncValue($dbh, $Q1, "ul000");
			$ul=array( 'id_ul'=> $id_ul ,		'nazwa'=>	$_POST[inna_ul], 'miasto'=> $_POST[miasto], 'kod'=> $_POST[kod]);
			if ( ValidateKod($_POST[kod]) )
				{
					Insert($dbh, "ulice", $ul);
					$bud=array ('id_bud'	=>$id_bud, 	'id_ul'	=>	$id_ul, 'id_adm'	=>FindId2( $_POST[administracja] ),   'numer'=>$_POST[nr_bud],
								'il_mieszk'	=>IsNull($_POST[il_mieszk]), 	'przylacze'		=>$_POST[przylacze], 'adres_ip'=>$_POST[adres_ip]);
				}
		}		
	Insert($dbh, "budynki", $bud);
			
}


function UpdateBud($id_bud)
{
	include "config.php";

	$dbh=DBConnect($DBNAME1);	

	if ( empty( $_POST[inna_ul] ) && $_POST[ulica]!="Inna")
		{
			$bud=array (	'id_bud'	=>$id_bud, 	'id_ul'	=>	FindId2( $_POST[ulica] ), 'id_adm'	=>FindId2( $_POST[administracja] ),   'numer'=>$_POST[nr_bud],
						'il_mieszk'	=>IsNull($_POST[il_mieszk]), 	'przylacze'		=>$_POST[przylacze], 'adres_ip'=>$_POST[adres_ip]);
		}
	else	if ( !empty( $_POST[inna_ul] ) && $_POST[ulica]=="Inna")
		{
			$Q1="select id_ul from ulice order by id_ul desc limit 1";
			$id_ul=IncValue($dbh, $Q1, "ul000");
			$ul=array( 'id_ul'=> $id_ul ,		'nazwa'=>	$_POST[ulica], 'miasto'=> "Mysłowice", 'kod'=> "41-406");
			Insert($dbh, "ulice", $ul);
			$bud=array ('id_bud'	=>$id_bud, 	'id_ul'	=>	$id_ul, 'id_adm'	=>FindId2( $_POST[administracja] ),   'numer'=>$_POST[nr_bud],
						'il_mieszk'	=>IsNull($_POST[il_mieszk]), 	'przylacze'		=>$_POST[przylacze], 'adres_ip'=>$_POST[adres_ip]);
		}
	Update($dbh, "budynki", $bud);

}

function ValidateBud($id_bud='')
{
	$flag=1;
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ( empty ($_POST[nr_bud]))
		{ 
			echo "Błąd pola 'Numer budynku' : pole jest puste <br>";
			$flag=0;
		}	

	if ( empty($_POST[inna_ul]) && $_POST[ulica]=="Inna")
		{ 
			echo "Błąd pola 'Ulica' : pole jest puste <br>";
			$flag=0;
		}
	if ( empty($_POST[adres_ip]) )
		{ 
			echo "Błąd pola 'Adres ip' : pole jest puste <br>";
			$flag=0;
		}	


	return ($flag);
}


///////////////////////////////////////////////////
//////////////// W P Ł A T Y //////////////////////
//////////////////////////////////////////////////

function ValidateDodajWpl()
{
	$flag=1;

	if (  !empty ($_POST["kwota2"]) && !preg_match("/\d+/", $_POST["kwota2"]) ) 
	{
		echo "Błąd pola 'Inna kwota' : wpisana pozycja nie jest liczbą <br>";
		$flag=0;
	}

	$rozm=strlen($_POST[opis]);
	if ($rozm > 400)
	{
		echo "Zbyt długi opis, pole opis może zawierać maksymalnie 400 znaków <br>";
		$flag=0;
	}
	
	return ($flag);	
}

function ValidateUpdateWpl()
{
	$flag=1;

	if (  !empty ($_POST["kwota"]) && !preg_match("/\d+/", $_POST["kwota"]) ) 
	{
		echo "Błąd pola 'kwota' : wpisana pozycja nie jest liczbą <br>";
		$flag=0;
	}
	else if (  empty ($_POST["kwota"]) ) 
	{
		echo "Pola 'kwota': niemoże być puste <br>";
		$flag=0;
	}

	$rozm=strlen($_POST[opis]);
	if ($rozm > 400)
	{
		echo "Zbyt długi opis, pole opis może zawierać maksymalnie 400 znaków <br>";
		$flag=0;
	}

	
	return ($flag);	
}

function ListaWplat($p)
{
   include "config.php";
   $dbh=DBConnect($DBNAME1);
//	$abons=SelectAbon($dbh);

	$idk=explode(" ", $p[abon]);
	$ida=array_pop($idk);

	if (empty($p[rozliczona]) || $p[rozliczona] == "Rozliczone")
		{
			$flag=1;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis, a.nazwa, a.id_abon
    	    from wplaty w, abonenci a
          where w.id_kontrah=a.id_abon and w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' and w.rozliczona='T'";
		}
	else 
		{
			$flag=0;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis
    	    from wplaty w 
          where w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' and w.rozliczona='N'";
		}

		if (!empty($p[abon]) && $p[abon] !=$conf[select] && $flag==1)
			{
				$q.=" and a.id_abon='$ida'";
			}

	if (empty($p[order]) || $p[order] == "Data wpłaty")
			$p[order]="w.data_ksiegowania, w.data_zlecona, w.id_wpl";
	else if ($p[order] == "Nazwa kontrahenta")
			$p[order]="a.nazwa, w.data_ksiegowania, w.data_zlecona, w.id_wpl";

	$q.=" order by $p[order]";

//	echo $q;
	$lp=1;
	$suma=0;
	$sth=Query($dbh,$q);
	while ($row =$sth->fetchRow())
	    {
			DrawTable($lp++,$conf[table_color]);  	
			echo "<td> <a href=\"index.php?panel=fin&menu=updatewplate&wpl=$row[0]\"> $row[0] </a> </td>";
			echo "<td> $row[1] <br> $row[2] <br> $row[3]</td>";
			echo "<td> $row[4] $row[5]</td>";
			$suma+=$row[4];
			if (!$flag)
				{
					echo "<td>";
					$name_select="$row[0]_select_$row[4]";
					SelectWlasc($name_select);
					echo "</td>";
				}
			else
 				echo "<td> <b> $row[7] </b> <br> $row[8]</td>"; 				
 			$row[6]=strip_tags($row[6]);
			echo "<td> $row[6] </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]_check\" value=\"off\"/></td>";
			echo "</tr>";
	    }

DrawTable($lp++,$conf[table_color]);
			echo "<td> </td>";
			echo "<td> <b> SUMA: </b></td>";
			echo "<td> <b>$suma </b></td>";
			echo "<td> </td>"; 				
			echo "<td> </td>";
			echo "<td></td>";
			echo "</tr>";
		
}


function ListaWplat2($p)
{
   include "config.php";
   $dbh=DBConnect($DBNAME1);
//	$abons=SelectAbon($dbh);

	$idk=explode(" ", $p[abon]);
	$ida=array_pop($idk);

	if (empty($p[rozliczona]) || $p[rozliczona] == "Rozliczone")
		{
			$flag=1;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis, a.nazwa, a.id_abon
    	    from wplaty w, abonenci a
          where w.id_kontrah=a.id_abon and w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' and w.rozliczona='T'";
		}
	else 
		{
			$flag=0;
			$q=" select w.id_wpl, w.data_ksiegowania, w.data_zlecona, w.forma, w.kwota, w.waluta, w.opis
    	    from wplaty w 
          where w.data_ksiegowania>='$p[data_od]' and w.data_ksiegowania <= '$p[data_do]' and w.rozliczona='N'";
		}

		if (!empty($p[abon]) && $p[abon] !=$conf[select] && $flag==1)
			{
				$q.=" and a.id_abon='$ida'";
			}

	if (empty($p[order]) || $p[order] == "Data wpłaty")
			$p[order]="w.data_ksiegowania, w.data_zlecona, w.id_wpl";
	else if ($p[order] == "Nazwa kontrahenta")
			$p[order]="a.nazwa, w.data_ksiegowania, w.data_zlecona, w.id_wpl";

	$q.=" order by $p[order]";

//	echo $q;
	$lp=1;
	$sth=Query($dbh,$q);
	while ($row =$sth->fetchRow())
	    {
			DrawTable($lp++,$conf[table_color]);  	
			echo "<td> <a href=\"index.php?panel=fin&menu=updatewplate&wpl=$row[0]\"> $row[0] </a> </td>";
			echo "<td> $row[1] $row[2] $row[3]</td>";
			echo "<td> $row[4] $row[5]</td>";
			if (!$flag)
				{
					echo "<td>";
					$name_select="$row[0]_select_$row[4]";
					SelectWlasc($name_select);
					echo "</td>";
				}
			else
 				echo "<td> <b> $row[7] </b> <br> $row[8]</td>"; 				
 			$row[6]=strip_tags($row[6]);
			echo "<td> $row[6] </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]_check\" value=\"off\"/></td>";
			echo "</tr>";
	    }
}


function UpdateWpl($array1)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);
	foreach ($_POST as $k => $v)
		{
			$idk=explode(" ", $v);
			$ida=array_pop($idk);
			$id=explode("_", $k);
			if ( $k!="przycisk" )
			{
				if ($id[1] == "select" && $v!=$conf[select] && !empty($v))
					{ 
						foreach ($array1 as $k1 => $v1)
						{
						$q3="update $k1 set id_kontrah='$ida', rozliczona='T' where $v1='$id[0]'; 
						update abonenci set saldo=saldo+$id[2] where id_abon='$ida'";
						WyswietlSql($q3);
						Query($dbh, $q3);
						}
					}
				else if( $id[1] == "check" && isset($_POST[$k])  )
					{
					foreach ($array1 as $k1 => $v1)
						{ 
							$q3="update abonenci set saldo=saldo-(select kwota from wplaty where id_wpl='$id[0]') where id_abon in (select id_kontrah from wplaty where id_wpl='$id[0]');
							delete from $k1 where $v1='$id[0]'";
							WyswietlSql($q3);
							Query($dbh, $q3);
						}
					}
			}
		}
	echo "Uaktualniono dane.";
}

function ListaPlikowWplat()
{
   include "config.php";
	 $m=date("m");
	 $y=date("Y");
	 echo "$m $Y";
	$d = opendir("$szmsk[feed]/$y") or die ($php_errormsg);
	$lp=1;
	while (false !== ($f = readdir($d)) )
		{
			if ( is_file("$szmsk[feed]/$y/$f") )
				{
				$rozm=Filesize("$szmsk[feed]/$y/$f");
				DrawTable($lp++,$conf[table_color]);  	
				echo "<td> <b>$f </b></td>";
				echo "<td> $rozm </td>";
				echo "<td>  </td>";
				echo "<td>  </td>";
				echo "<td>  </td>";
				echo "<td><input type=\"checkbox\" name=\"$szmsk[feed]/$y/$f\" value=\"off\"/></td>";
				echo "</tr>";
				}
		}
	closedir($d);
	$d = opendir("$szmsk[feed]/$y/$m") or die ($php_errormsg);
	$lp=1;
	while (false !== ($f = readdir($d)) )
		{
			if ( is_file("$szmsk[feed]/$y/$m/$f") )
				{
				$rozm=Filesize("$szmsk[feed]/$y/$m/$f");
				DrawTable($lp++,$conf[table_color]);  	
				echo "<td> <b>$f </b></td>";
				echo "<td> $rozm </td>";
				echo "<td>  </td>";
				echo "<td>  </td>";
				echo "<td>  </td>";
				echo "<td><input type=\"checkbox\" name=\"$szmsk[feed]/$y/$m/$f\" value=\"off\"/></td>";
				echo "</tr>";
				}
		}
	closedir($d);	
}


function FindLastWpl($date, $dbh)
{
	include "config.php";
	$d=explode("-", $date);
	$Q="select id_wpl from wplaty where data_ksiegowania like '$d[0]-$d[1]-%' order by id_wpl desc limit 1";
	$sth=Query($dbh,$Q);
	$row =$sth->fetchRow();
	if (empty($row[0]))
		$wpl="WPL/0001/$d[1]/$d[0]";
	else
		$wpl=IncWpl($row[0]);
	return $wpl;
}



function IncWpl($param)
{
    $id=explode("/", $param);
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
    else if ( $nr < 1000 && $nr > 99)
	{
	    $id[1]="0$nr";
	}
    else if ( $nr >= 1000 )
	{
	    $id[1]="$nr";
	}
    $wyj="$id[0]/$id[1]/$id[2]/$id[3]";
    return $wyj;
}

function AddNewWpl()
{
	include "config.php";

	$dbh=DBConnect($DBNAME1);	
	$wl=explode(" ", $_POST[abon]);
	$ID_ABON=$wl[count($wl)-1];

	$wpl=array 
	(	'id_wpl'		=> FindLastWpl($_POST[data],$dbh),		'data_ksiegowania'	=>	$_POST[data], 		'data_zlecona'	=>	$_POST[data],
		'forma'			=> $_POST[forma], 			'kwota'					=>$_POST[kwota1], 	'waluta'			=> "PLN",
		'id_kontrah'	=> $ID_ABON,					'rozliczona' => 'T', 							'opis' 			=> $_POST[opis]);

	if ( !empty( $_POST[kwota2] ))
		{
			$wpl[kwota] = $_POST[kwota2];
		}

	Insert($dbh, "wplaty", $wpl);
	$q="update abonenci set saldo=saldo+$wpl[kwota] where id_abon='$wpl[id_kontrah]'";
	Query($dbh, $q);

}



function UpdateWplata($id_wpl)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);

	$wl=explode(" ", $_POST[abon]);
	$ID_ABON=$wl[count($wl)-1];

	$wpl=array 
	(	'id_wpl'		=> $id_wpl,			'data_ksiegowania'	=>	$_POST[data], 		'data_zlecona'	=>	$_POST[data],
		'forma'			=> $_POST[forma], 'kwota'					=> $_POST[kwota], 	'waluta'			=> "PLN",
		'id_kontrah'	=> $ID_ABON,		'rozliczona'			=> 'T', 					'opis' 			=> $_POST[opis]);

	Update($dbh, "wplaty", $wpl);

	$kwota=$_SESSION[wpl][kwota]; 
	$id_abon=$_SESSION[wpl][id_kontrah];

	if ( $_SESSION[wpl][id_kontrah] != $wpl[id_kontrah] )
	{
		$q1="update abonenci set saldo=saldo-$kwota where id_abon='$id_abon'; 
		update abonenci set saldo=saldo+$wpl[kwota] where id_abon='$wpl[id_kontrah]'";
	//	echo "$q1 <br> $q2";
		Query($dbh, $q1);
	}

	else if ( $_SESSION[wpl][id_kontrah] == $wpl[id_kontrah]  &&  $_SESSION[wpl][kwota] != $_POST[kwota] )
	{
	  $kwota=$_SESSION[wpl][kwota];
		$q="update abonenci set saldo=saldo-$kwota+$_POST[kwota] where id_abon='$wpl[id_kontrah]'";
		//echo $q;
		Query($dbh, $q);
	}
}



function WczytajWyciag($dbh, $file, $forma, $id_wpl, $id_wyp)
{

    include "config.php";
    
    $fh = fopen ("$file" ,'r') or die ($php_errormsg);        

    if ( $forma == "$firma[wyciag]" )
			while ( $s = fgets($fh, 1024) )    
      {
			//	$s=iconv("ISO-8859-2","UTF-8", $s);							
        if ( preg_match("/^<tr><td nowrap>[0-9]{4}(-[0-9]{2}){2}/", $s) )
          {
            $wpl = preg_split("/<\/td><td nowrap>|<\/td><td>|<\/td><td >/", $s);
            //    $wpl = explode("<\td><td>", $s);
                      
            $s=strip_tags($s);
            //  print "      $s \n";
            $kwota=$wpl[4];
                        
            if ( preg_match("/<br>Prowizja: 5,00 PLN/", $wpl[3]) )
              {
                //echo "<br>sepy<br>";
           	    $kwota+=$firma[prowizja];
             	}
                        
            $opis=strip_tags($wpl[3]);
    	        //      $opis=$wpl[7];
            	    
            	//        foreach ( $wpl as $k => $w)
            	//        {
            	//        $w=strip_tags($w);
            	//        echo "<b>$k</b> ->  $w <br>";    	    
            	//        };
         		$id_wpl=IncWpl($id_wpl);
           	$wplata=array
              (
           	    'id_wpl' => $id_wpl,
           	    'data_ksiegowania' => strip_tags(strip_tags($wpl[0])),
     	    	    'data_zlecona' => strip_tags($wpl[1]),
           	    'forma' =>  $forma,
           	    'kwota' => $kwota,
           	    'waluta' => strip_tags($wpl[5]),
           	    'id_kontrah' => NULL,
           	    'opis' => $opis
                  //    'rozliczona'
              );
                        
           	$id_wyp=IncWpl($id_wyp);
            $wyplata=array
                        (
                            'id_wypl' => $id_wyp,
                            'data_ksiegowania' => strip_tags($wpl[0]),
                            'data_zlecona' => strip_tags($wpl[1]),
                            'forma' =>  $forma,
                            'kwota' => $wpl[4],
                            'waluta' => $wpl[5],
                            'id_kontrah' => NULL,
                            'opis' => $opis
                        );
					}
          if      ( $wplata[kwota] > 0 )  Insert($dbh, "wplaty", $wplata);
          else if ( $wplata[kwota] < 0 )  Insert($dbh, "wyplaty", $wyplata);                        
			}
    	    
    else if ( $forma == "$firma[wyciag2]" )
    while ( $s = fgets($fh, 1024) )
   	    {
					//	$s=iconv("ISO-8859-2","UTF-8", $s);
          if ( preg_match("/^<tr><td>\d+/", $s) )
       	    {
           		$wpl = explode("</td><td>", $s);
           		$s=strip_tags($s);
        		//  print "      $s \n";
           		$kwota=$wpl[4];
           		$opis=strip_tags($wpl[7]);
    		//      $opis=$wpl[7];

							$id_wpl=IncWpl($id_wpl);
	            $wplata=array
                (
                 'id_wpl' => $id_wpl,
                  'data_ksiegowania' => $wpl[1],
                  'data_zlecona' => $wpl[2],
                  'forma' =>  $forma,
                  'kwota' => $wpl[4],
                  'waluta' => $wpl[5],
									'id_kontrah' => NULL,
	                'opis' => $opis
    	            //    'rozliczona'
								);

							$id_wyp=IncWpl($id_wyp);
              $wyplata=array
                (
                 'id_wypl' => $id_wyp,
                 'data_ksiegowania' => $wpl[1],
                 'data_zlecona' => $wpl[2],
                 'forma' =>  $forma,
                 'kwota' => $wpl[4],
                 'waluta' => $wpl[5],
                 'id_kontrah' => NULL,
                 'opis' => $opis                        
                );
						}	
					if      ( $wplata[kwota] > 0 )  Insert($dbh, "wplaty", $wplata);	
					else if ( $wplata[kwota] < 0 )  Insert($dbh, "wyplaty", $wyplata);
				}
 
			else if ( $forma == "$firma[wyciag3]" )
    	while ( $s = fgets($fh, 1024) )
				{
					$s=iconv("ISO-8859-2","UTF-8", $s);
        	$wpl = explode(",", $s);
            //		$s=strip_tags($s);
        		//  print "      $s \n";
          $kwota=$wpl[2]/100;
					$kw=$wpl[6];
          $opis=$wpl[7];

					$id_wpl=IncWpl($id_wpl);
	        $wplata=array
          (
            'id_wpl' => $id_wpl,
            'data_ksiegowania' => $wpl[1],
            'data_zlecona' => $wpl[1],
						'forma' =>  $forma,
            'kwota' => $kwota,
            'waluta' => "PLN",
            'id_kontrah' => NULL,
	          'opis' => $opis,
						'rozliczona' => 'T'
    	    );

					if ( $wplata[kwota] > 0 ) 
					{	
						echo "$wplata <br>";
					//	Insert($dbh, "wplaty", $wplata);	
					}
	    }
    fclose($fh);
}
                                    
function WczytajWpl()
{
	include "config.php";

	set_time_limit ( 180 );

/////////////////////////////////
//echo "Trwa wczyywnia wpłat z pliku. To może potrwać około 2 minut.";
	$dbh=DBConnect($DBNAME1);
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" && isset($_POST[$k]))
			{
				$plik=explode("/", $k);

				$plik1=explode("-", $plik[5]);
			
//				$m=substr($plik[2], 0, -4);

				$forma=$plik1[0];
				$y=$plik1[1];
				$m=$plik1[2];
				$d=$plik1[3];
							    
			  if ( $forma == $firma[wyciag] )
					{
				    $forma="$firma[wyciag]";
				    $flag=1;
					}
			  else if ($forma == $firma[wyciag2] )
					{
				    $forma="$firma[wyciag2]";
				    $flag=2;
					}
				else if ($forma == $firma[wyciag3] )
					{
				    $forma="$firma[wyciag3]";
				    $flag=3;
					}
				else $flag=0;

				echo $forma;
			  if ( $flag != 0 )
			    {
						$Q="select * from wplaty where id_wpl like 'WPL/%/$m/$d' and forma='$forma' limit 1";
						$sth=Query($dbh,$Q);
						$roww =$sth->fetchRow();
						if ( $roww==null )
							{
								$Q2="select id_wpl from wplaty where id_wpl like 'WPL/%/$m/$d' order by id_wpl desc limit 1";
								$sth2=Query($dbh,$Q2);
								$row2 =$sth2->fetchRow();
								if ( $row2==null )
									{                                                                                            
										$id_wpl="WPL/0000/$m/$d";
										//echo "$id_wpl";
									}
										//echo "$k";
								else 
									{
										$id_wpl=$row2[0];
									}
																			
								$Q3="select id_wypl from wyplaty where id_wypl like 'WYP/%/$m/$d' order by id_wypl desc limit 1";
								$sth3=Query($dbh,$Q3);
								$row3 =$sth3->fetchRow();
								if ( $row3==null )
									{
										$id_wyp="WYP/0000/$m/$d";
												 //echo "$id_wpl";
									}
									 //echo "$k";
								else
									{
										 $id_wyp=$row3[0];
									}	
									
								if ( flag==1 || flag==2 )	
									{
									//	$plik[2][2]=".";
									//	$k="$plik[0]-$plik[1]-$plik[2]-$plik[3]-$plik[4]-$plik[5]"; 
											//echo "$k   $forma   $id_wpl, $id_wyp";                                                                 		
										WczytajWyciag($dbh, $k, $forma, $id_wpl, $id_wyp);	
				//					    Rozlicz($dbh,"20$str2-$str1");
										Rozlicz($dbh,"$str2-$str1");
									}
								else if ( flag==3 )
									{
									//	$plik[2][2]=".";
								//		$k="$plik[0]-$plik[1]-$plik[2]"; 
											echo "$k   $forma   $id_wpl, $id_wyp <br>";                                                                 		
							//			WczytajWyciag($dbh, $k, $forma, $id_wpl, $id_wyp);									
									}
							}
					else
						{
				      print "Plik $k juz zostal przetworzony <br> ";
						}
			    }
				else 
					{
						print "Niepoprawna nazwa pliku <br>";
					}	
		}
	}
}

function create_match($tab)
{
    $text='/';
    foreach ( $tab as $v )
    {	
			$v_Nr="$v"."Nr";
	  
          $match.="\b$v\b|\b$v_Nr|"; 
    }
    $match=substr($match,0,strlen($match)-1);
    return $match;
}



function Rozlicz($dbh, $data)
{
    function UpdateWpl1($p0, $p1, $p2, $p3)
    {
    $Q5="update wplaty set id_kontrah='$p1', rozliczona='T' where id_wpl='$p2'";
        Query($p0,$Q5);
    $Q6="update abonenci set saldo=saldo+$p3 where id_abon='$p1'";
        //    print "$Q6 \n";
      Query($p0,$Q6);	
    }

    set_time_limit(300);
    include "config.php";
    
    $lp=0;

    $Q2="select distinct a.id_abon, a.nazwa,  u.nazwa, b.numer, a.nr_mieszk from abonenci a, budynki b, ulice u , umowy_abonenckie um
         where a.id_bud=b.id_bud and u.id_ul=b.id_ul and um.id_abon=a.id_abon and um.status='Obowiązująca' order by a.nazwa";
    $Q3="select opis, kwota, rozliczona, id_wpl from wplaty where rozliczona='N' and data_ksiegowania like '$data%'";

    $sth2=Query($dbh,$Q2);
    while ( $row2 =$sth2->fetchRow() )
        {
            $id_abon=$row2[0];
						$id_abon2=substr($id_abon, -4,4);
						
            $nazwa=explode(" ", $row2[1] );
            $imie=$nazwa[1];
            $imiepl=konwertuj($nazwa[1]);
            if ( ! preg_match ("/ABONI/i", $id_abon ))
                {
                    $flag=0;
                    $nazwisko=$nazwiskom=$nazwiskok=$nazwa[0];
                    $nazwiskopl=konwertuj($nazwa[0]);
										$nazwiskoNr=$nazwisko;
                    $nazw_koncowka=substr($nazwisko, -2,2);
                    if ($nazw_koncowka == "ki")
                        {
                            $nazwiskok=substr_replace($nazwisko,'a', -1);
                        }
                    else if ($nazw_koncowka == "ka")
                        {
                            $nazwiskom=substr_replace($nazwisko,'i', -1);
                        }
                }
            else
                {
                    $flag=1;
                    $nazwa_firmy=$row2[1];
                }
								$ulica=$row2[2];
								$ulicapl=konwertuj($row2[2]);
								$bud=$row2[3];
								$mieszk=$row2[4];
				//	    if ( $flag==0 )
				//             echo " $row2[1] $nazwisko:: $nazwiskopl $nazwiskom $nazwiskok => <br>";
								$matches=array($nazwisko,$nazwiskom, $nazwiskok, $nazwiskopl);
								$match=create_match($matches);
				//echo "$match <br>";
							
								$sth3=Query($dbh,$Q3);
								$lpn=0;
						
				//	  if ($nazwisko!="Dorota")
						
								while ($row3 =$sth3->fetchRow())
									{
	//	$lp_all++;
										if ( preg_match("/$id_abon|ABON.$id_abon2|ABONI.$id_abon2/i",$row3[0]) )
											{
												++$lp;
												//print "Znaleziono : $id_abon - $nazwisko $imie ";
												UpdateWpl1($dbh, $row2[0], $row3[3], $row3[1]);						  
											}
										else if ( $flag==0 && preg_match ("/$match/i", $row3[0] ) ||  $flag==1 && preg_match("/\b$nazwa_firmy\b/i",$row3[0]) )
											{
										//		echo "Znaleziono | $nazwisko ";
												$Q4="select count(nazwa) from abonenci where nazwa like '%$nazwisko %' or nazwa like '%$nazwiskom %' or nazwa like 
											'%$nazwiskopl %' or nazwa like '%$nazwiskok %' and aktywny='T'";
								    //  echo "$Q4 <br>";
												$sth4=Query($dbh, $Q4);
												$row4= $sth4->fetchRow();
												if ( $row4[0] > 1)
													{
														if ( preg_match ("/(\b$imie\b|\b$imiepl\b)|((\b$ulica\b|\b$ulicapl\b)+$bud+$mieszk)/i", $row3[0]) )
		                        {
		                        ++$lp;
					
		      //                       print "Wlsciwe imie:  $nazwisko $imie <br>";
		                          // UpdateWpl1($dbh, $row2[0], $row3[3], $row3[1]);
		                        }
													}
												else if ( $row4[0] == 1)
														{
													++$lp;
										//         print "$lp. + $nazwisko |$nazwiskok $nazwiskom| $imie $row3[3]<br>";
															//	UpdateWpl1($dbh, $row2[0], $row3[3], $row3[1]);
														}
											}
										else 
										{
											$lpn++; 
											 //echo "Nie znaleziono - |$nazwisko| nazwisko <br> $row3[0] <br> <br>";
											 //echo "$nazwisko ";
										}
			
		}
	}
    $sprawnosc=round($lp*100/($lp+$lpn),2);
    $all=$lp+$lpn;
    echo "Rozliczono $lp wpłat z $all ogółem wszystkich wpłat. Pozostało $lpn wpłat nie rozliczonych. <br> Sprawność na poziomie: $sprawnosc % <br><br>";
}





///////////////////////////////////////////////////
//////////////// P I S M A ///////////////////////
//////////////////////////////////////////////////

function ListaPism($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	function Druk($dbh,$typ, $query )
	{
		$sth=Query($dbh,$query);
		$lp=1;
	   while ($row =$sth->fetchRow())
		{
					DrawTable($lp++,$conf[table_color]);  	
  				echo "<td> <a href=\"index.php?panel=fin&menu=updatepismo&typ=$typ&pismo=$row[0]\"> $row[0] </a> </td>";
	  			echo "<td> $row[1] </td>";
  				echo "<td> $row[2]</td>";
  				echo "<td> $row[3]</td>";
  				echo "<td> $row[4]</td>";
					echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('func/pdf.php?dok=psw&id_psw=$row[0]',800,1100, '38')\"> 
					<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";  				echo "<td> <input 				type=\"checkbox\" name=\"$row[0]\" /> </td>";
  	 			echo "</tr>";
     		}
	}
		
	if ($typ=="przych")
		{
			$query1="select pp.id_pp, pp.data, pp.data_przyj, pp.dotyczy, pp.lok_fiz, pp.lok_kopii, i.nazwa
						from pisma_przych pp, instytucje i where pp.id_nad=i.id_inst order by pp.data"; 
			$query2="select pp.id_pp, pp.data, pp.data_przyj, pp.dotyczy, pp.lok_fiz, pp.lok_kopii, a.nazwa
						from pisma_przych pp, abonenci a where pp.id_nad=a.id_abon order by pp.data"; 
			$query3="select pp.id_pp, pp.data, pp.data_przyj, pp.dotyczy, pp.lok_fiz, pp.lok_kopii, d.nazwa
						from pisma_przych pp, dostawcy d where pp.id_nad=d.id_dost order by pp.data"; 
		}
	else
		{
			$query1="select pw.id_psw, pw.data, pw.dotyczy, pw.tresc, pw.autor
						from pisma_wych pw, instytucje i where pw.id_odb=i.id_inst order by pw.data"; 
			$query2="select pw.id_psw, pw.data, pw.dotyczy, pw.tresc, pw.autor
						from pisma_wych pw full join abonenci a on pw.id_odb=a.id_abon order by pw.data"; 
			$query3="select pw.id_psw, pw.data, pw.dotyczy, pw.tresc, pw.autor
						from pisma_wych pw, dostawcy d where pw.id_odb=d.id_dost order by pw.data"; 
		}

	//	Druk($dbh, $typ, $query1);
		Druk($dbh, $typ, $query2);
	//	Druk($dbh, $typ, $query3);

}

function ValidatePismo()
{
	$flag=1;

	if ( empty ($_POST[numer]))
		{ 
			echo "Błąd pola 'Numer' : pole jest puste <br>";
			$flag=0;
		}	

	if ( empty($_POST[data]) || !ValidateDate($_POST[data]))
		{ 
			echo "Błąd pola 'Pismo z dnia'<br>";
			$flag=0;
		}

	if ( empty($_POST[data_poczta])  || !ValidateDate($_POST[data_poczta]))
		{ 
			echo "Błąd pola 'Data otrzymania/wysłania' <br>";
			$flag=0;
		}

	return ($flag);
}

function AddNewPismo($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ=="przych")
		{
			$TABLE="pisma_przych";
			$ID="id_pp";
			$FK_NAME="id_nad";
			$DATA2="data_przyj";
			$NP="PP0000";
		}
	else
		{
			$TABLE="pisma_wych";
			$ID="id_pw";
			$FK_NAME="id_odb";
			$DATA2="data_wyj";
			$NP="PW0000";
		}

	if ( empty($_POST[instytucja]) && empty($_POST[abonent]) )
			$ID2=$_POST[dostawca];
	else 	if ( empty($_POST[instytucja]) && empty($_POST[dostawca]) )
			$ID2=$_POST[abonent];
	else 	if ( empty($_POST[dostawca]) && empty($_POST[abonent]) )
			$ID2=$_POST[instytucja];

	$Q1="select $ID from $TABLE order by $ID desc limit 1";
	$id_pisma=IncValue($dbh, $Q1, $NP);
	
	$pismo=array (	
						$ID			=>	$id_pisma, 					'numer'		=>	$_POST[numer],					'data'		=>	$_POST[data],
						$DATA2		=>	$_POST[data_poczta],		'dotyczy'	=>	IsNull($_POST[dotyczy]),	'lok_fiz'	=>	$_POST[lok_fiz],
						'lok_kopii'	=>	$_POST[lok_kopii],		$FK_NAME		=>	FindId2($ID2)
					);
	Insert($dbh, $TABLE, $pismo);
}

function UpdatePismo($typ, $id_pisma)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ=="przych")
		{
			$TABLE="pisma_przych";
			$ID="id_psp";
			$FK_NAME="id_nad";
			$DATA2="data_przyj";
		}
	else
		{
			$TABLE="pisma_wych";
			$ID="id_psw";
			$FK_NAME="id_odb";
			$DATA2="data_wyj";
		}

	if ( empty($_POST[instytucja]) && empty($_POST[abonent]) )
			$ID2=$_POST[dostawca];
	else 	if ( empty($_POST[instytucja]) && empty($_POST[dostawca]) )
			$ID2=$_POST[abonent];
	else 	if ( empty($_POST[dostawca]) && empty($_POST[abonent]) )
			$ID2=$_POST[instytucja];

	
	$pismo=array (	
						$ID			=>	$id_pisma	, 									'numer'		=>	$_POST[numer], 				'data'		=>	$_POST[data],
						$DATA2		=>	$_POST[data_poczta],			'dotyczy'	=>	IsNull($_POST[dotyczy]),	'lok_fiz'	=>	$_POST[lok_fiz],
						'lok_kopii'	=>	$_POST[lok_kopii],			$FK_NAME		=>	FindId2($ID2)
					);
	Update($dbh, $TABLE, $pismo);
}


/////////////////////////////////////////////////
///////////// K s i a z e cz k i ////////////////
/////////////////////////////////////////////////
function ListaKa()
{
    include "config.php";
    $dbh=DBConnect($DBNAME1);
  
    $query="(select distinct a.id_abon, a.symbol, a.nazwa, u.kod, u.miasto, u.nazwa, b.numer, a.nr_mieszk
           from abonenci a,ulice u, budynki b
	   where u.id_ul=b.id_ul and a.id_bud=b.id_bud 
           )
	   union
	   (select distinct a.id_abon, a.symbol, a.nazwa, u.kod, u.miasto, u.nazwa, a.nr_bud, a.nr_mieszk
	    from abonenci a,ulice u, budynki b
	    where u.id_ul=a.id_ul)";
												   
    $sth=Query($dbh,$query);
    while ($row =$sth->fetchRow())
	{
	 echo "<tr>";
         echo "<td> <a href=\"index.php?panel=fin&menu=updateabon&abon=$row[0]\"> $row[0] </a> </td>";
         $s=Choose($row[1], $row[2]);
         echo "<td> $s </td>";
         echo "<td> $row[3] $row[4], ul. $row[5] $row[6]/$row[7] </td>";
	 echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
	 echo "</tr>";
        }
}

//////////////////////////////////////////////////
///////////// G W A R A N C J E //////////////////
//////////////////////////////////////////////////

function ListaTowGwar($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	if ($typ=="sprzedaz")
		$query="	select id_tows, nazwa, okres_gwar, cena from towary_sprzedaz where aktywny='T' order by id_tows";
	else 
		$query="	select id_towz, nazwa, okres_gwar, cena from towary_zakup order by id_towz";

	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			 
			$tow[$row[0]]=$row[1];
			DrawTable($lp++,$conf[table_color]);  	
  			echo "<td> <a href=\"index.php?panel=fin&menu=updatetow&typ=$typ&id=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> $row[1]</td>";
  			echo "<td> $row[2]</td>";
  			echo "<td> <b> $row[3] </b> </td>";
  			echo "<td>";
  			echo "<select name=\"$row[0]\" >";
			for ($i=0; $i<101; ++$i)
				echo "<option> $i </option>";
			echo "</select>";
  			echo "</td>";
			echo "</tr>";
       }
	$_SESSION[tow]=$tow;
}

function ListaTowGwar2($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);


	$tow=$_SESSION[tow];
	foreach ($_POST as  $k => $v )
		{
			while ($v>0)
				{
					--$v;
					echo "<tr>";
  					echo "<td> $k </td>";
	  				echo "<td> $tow[$k] </td>";
  					echo "<td> <input size=\"30\" name=\"$k-$v\" > </td>";
					echo "</tr>";
				}
		}

}

function ListaGwar($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	if ($typ=="sprzedaz")
			$q1="	select  g.nr_gwar, a.symbol, g.data_wyst  from gwarancje_sprzedaz g, abonenci a where g.id_odb=a.id_abon order by g.data_wyst desc ";
	else 
			$q1="	select  g.nr_gwar, d.symbol, g.data_wyst  from gwarancje_zakup g, dostawcy d where d.id_dost=g.id_dost order by g.data_wyst desc ";
	$sth1=Query($dbh,$q1);
   while ($row1 =$sth1->fetchRow())
		{
			if ($typ=="sprzedaz")
				$q2="select t.symbol, p.nr_fabr, t.okres_gwar from pozycje_gwars p, towary_sprzedaz t where p.id_tows=t.id_tows and p.nr_gwar='$row1[0]' order by t.nazwa";
			else 
				$q2="select t.symbol, p.nr_fabr, t.okres_gwar from pozycje_gwarz p, towary_zakup t where p.id_towz=t.id_towz  and p.nr_gwar='$row1[0]' order by t.nazwa";
		
			echo "<tr>";
  			echo "<td> <a href=\"index.php?panel=fin&menu=updategwar&typ=$typ&nr=$row1[0]\"> $row1[0] </a> </td>";
	  		echo "<td> $row1[1]</td>";
  			echo "<td> $row1[2]</td>";
  			echo "<td>";
			$sth2=Query($dbh,$q2);
			while ($row2 =$sth2->fetchRow())
				{
					echo " <strong> $row2[0]</strong>   nr fabr. $row2[1]  gwar. $row2[2] <br>";
				}
			echo "</td>";
			echo "<td><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
     echo "</tr>";
       }
}

function ListaPozGwar($typ, $nr)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);


	if ($_GET[typ]=="sprzedaz")
		{
			$q="	select t.symbol, p.nr_fabr, t.okres_gwar 
					from pozycje_gwars p, towary_sprzedaz t 
					where p.id_tows=t.id_tows and p.nr_gwar='$_GEt[nr]";
		}
	else 
		{
			$q="	select t.symbol, p.nr_fabr, t.okres_gwar 
					from pozycje_gwarz p, towary_zakup t 
					where p.id_towz=t.id_towz  and p.nr_gwar='$_GET[nr]'";
		}
	$Lp=0;
	$sth1=Query($dbh,$q);
	while ( $row1=$sth1->fetchRow() )
		{
			++$Lp;
			echo "<tr>";
			echo " <td> $Lp. </td> ";
			echo " <td> $row1[0] </td> ";
			echo " <td> $row1[1] </td> ";
			echo " <td> $row1[2] </td> ";
			echo "</tr>";
		}
}

function UpdateGwar($typ, $nr)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE1="gwarancje_sprzedaz";
			$TABLE2="pozycje_gwars";
			$IDK="id_odb";
			$nazwak="odbiorca";
		}
	else
		{
			$TABLE1="gwarancje_zakup";
			$TABLE2="pozycje_gwarz";
			$IDK="id_dost";
			$nazwak="dostawca";
		}

	$gwar=array
	(
		'nr_gwar'			=> $_POST[nr_gwar],				$IDK			=>FindId2($_POST[$nazwak]), 	'data_wyst'	=>$_POST[data_wyst], 	
	);
	$gwar2=array
	('nr_gwar'	=>$nr);

	$poz1=array('nr_gwar'=>$_POST[nr_gwar]);
	$poz2=array('nr_gwar'=>$nr);

	Update($dbh, $TABLE2, $poz1, $poz2);
	Update($dbh, $TABLE1, $gwar, $gwar2);

}

function AddPozGwar($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE="pozycje_gwars";
			$NT="id_towz";
		}
	else
		{
			$TABLE="pozycje_gwarz";
			$NT="id_towz";
		}

	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
				$id=explode("-",$k);
				$q3="insert into $TABLE values ('$v','$id[0]','$_SESSION[nr_gwar]')";
				echo "$q3 <br>";
				Query($dbh, $q3);
			}
		}

}

function AddNewGwar($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE="gwarancje_sprzedaz";
			$ID="nr_gwar";
			$NK="id_odb";
		}
	else
		{
			$TABLE="gwarancje_zakup";
			$ID="nr_gwar";
			$NK="id_dost";
		}

	$gwar=array (	
						'nr_gwar'=>$_POST[nr_gwar], 	$NK	=>	FindId2($_POST[dostawca]), 'data_wyst'	=>$_POST[data_wyst]
					);
	Insert($dbh, $TABLE, $gwar);
}

function ValidateGwar()
{
	$flag=1;

	if ( empty ($_POST[nr_gwar]))
		{ 
			echo "Błąd pola 'Numer' : pole jest puste <br>";
			$flag=0;
		}	

	if ( !ValidateDate($_POST[data_wyst]) )
		{ 
			echo "Błąd pola 'Data wyatawienia' <br>";
			$flag=0;
		}

	return ($flag);
}

function ValidatePozGwar()
{
	$flag=1;
	foreach($_POST as $k => $v)
		if ( empty ($v))
			{ 
				$flag=0;
			}	
	if ($flag==0)
			echo "Błąd pola 'Numer fabryczny' : pole jest puste <br>";
	return ($flag);
}




/////////////////////////////////////////////////////////////////
///////////// D O K U M E N T Y  K S I E G O W E ///////////////
///////////////////////////////////////////////////////////////

function DeleteFv ()
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);
	
	$_POST2=array_reverse($_POST);
	foreach ($_POST2 as $k => $v)

		{
			if ( $k!="przycisk" )
			{
				$kwota=0;
			
				$d=explode("/", $k);
	
				$q5="select d.nr_ds, d.id_odb, a.pesel_nip from dokumenty_sprzedaz d, abonenci a where d.nr_ds like '%/$d[2]/$d[3]' and d.id_odb=a.id_abon order by nr_ds desc limit 1";	
				$sth=Query($dbh, $q5);
				$row=$sth->fetchRow();
				$ds_ost=$row[0];
				if ( !ValidateNip($row[2]) )
				{
						$q2="select t.cena from pozycje_sprzedaz p, towary_sprzedaz t where p.nr_ds='$k' and p.id_tows=t.id_tows";
						$sth=Query($dbh, $q2);
						while ($row =$sth->fetchRow())						
						$kwota+=$row[0];
			
						$q3="update abonenci set saldo=saldo+$kwota where id_abon=(select id_odb from dokumenty_sprzedaz where nr_ds='$k');
						delete from dokumenty_sprzedaz where nr_ds='$k'; delete from pozycje_sprzedaz where nr_ds='$k'";
						WyswietlSql($q3);	
						Query($dbh, $q3);
						
						if ($ds_ost != $k)
						{
							$q4="update dokumenty_sprzedaz  set nr_ds='$k'  where nr_ds='$ds_ost'; update pozycje_sprzedaz  set nr_ds='$k'  where nr_ds='$ds_ost'";
							WyswietlSql($q4);	
							Query($dbh, $q4);
						}
				}
			else 
				echo "Nie można usunąć faktury VAT, ponieważ ostatnia wystawiona w bieżącym miesiącu to faktura dla firmy.";
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

function InitNrFV($dbh)
{
	$data=date("Y-m");
	$nr=date("/m/Y");
	$q="select nr_ds from dokumenty_sprzedaz where data_wyst like '$data%' order by nr_ds desc limit 1";
	$sth=Query($dbh, $q);
	$row=$sth->fetchRow();
	if ( empty($row) )
		$nr="FV/0000"."$nr";
	else 
		{
			$numer=explode("/",$row[0]);
			if ($numer[0] < 50)
			    $nr=IncNrFV($row[0]);
			else 
				$nr="XXX";
		}
	return($nr);
}


function DodajFAbon()
{
	set_time_limit(1200);
	$fv=$fv1=$_SESSION[fabon];
	$fv[forma_plat]=$fv1[forma_plat]="przelew";
	$fv[stan]=$fv1[stan]="nieuregulowana";

	include "config.php";
	$dbh=DBConnect($DBNAME1);
	$rok=date("Y");
	$mies=date("m");
	if ( $mies=="01" ) 
		$pmies=1;
	else 
		$pmies=$mies-1;
	if ($pmies<10) $pmies="0"."$pmies";
	$dzien=date("d");

	$fv[nr_ds]=$fv1[nr_ds]=InitNrFV($dbh);
	//$fv[nr_ds]=IncNrFV($fv[nr_ds]);
	
	if ( $fv{nr_ds}  != "XXX" )
		{
			if ( $mies!="01" ) 
			{
				$fv1[nr_ds]=FindLastFV("$rok-$pmies-$dzien");
				$fv1[data_wyst]="$rok-$pmies-07";
				$fv1[data_sprzed]="$rok-$pmies-07";
			}
	
			$q="select distinct a.id_abon, a.nazwa, a.saldo, sum(t.cena), um.platnosc,   u.nazwa, b.numer, a.nr_mieszk, um.data_zaw
					from abonenci a,ulice u, budynki b, umowy_abonenckie um, towary_sprzedaz t, komputery k
					where u.id_ul=b.id_ul and a.id_bud=b.id_bud and um.id_abon=a.id_abon and k.id_abon=a.id_abon and
					t.id_tows=k.id_taryfy and um.status in ('Obowiązująca')
					group by u.nazwa, b.numer, a.nr_mieszk, a.id_abon, a.symbol, a.nazwa, u.miasto, u.kod, a.saldo, um.platnosc, um.data_zaw
					order by a.nazwa, u.nazwa, b.numer, a.nr_mieszk";
				
				WyswietlSql($q);
					$sth=Query($dbh,$q);
					while ($row =$sth->fetchRow())
						{
								$fv[id_odb]=$fv1[id_odb]=$row[0];
								//echo "$row[0] $row[1]<br>";
								
								$saldo=$row[2];
								/*suma teoretyczna faktur jaka powinna byc wystawiona do bierzacego miesiaca (w przyslosci trzeba tu 
									uwzglednic ewnetualny czas 		zawieszen poszczegolnych umow) */
								$um_data_zaw=explode('-', $row[8]);
								/* Jezeli abonent został podlaczony w birzacym roku to przy wyliczaniu stwfv musimy uwzglednic date awarcia umowy*/
								if ($um_data_zaw[0]==$rok)
										$stwfv=($mies-$um_data_zaw[1]+1)*$row[3];
								else
										$stwfv=$mies*$row[3];
								//suma praktycznie wystawionych faktur
								$q3="select sum(t.cena*p.ilosc) from dokumenty_sprzedaz d, pozycje_sprzedaz p, towary_sprzedaz t
											where p.id_tows=t.id_tows and d.nr_ds=p.nr_ds and d.data_wyst like '$rok%' and t.pkwiu='64.20.1' and id_odb='$row[0]'"; 
								WyswietlSql($q3);
								$sth3=Query($dbh,$q3);
								$row3 =$sth3->fetchRow();
								
								if ( $saldo<$row[3] && $stwfv>$row3[0] )
								{
									
									$fv[term_plat]= CountDate( $fv[data_wyst], $row[4] );
									
									Insert($dbh, "DOKUMENTY_SPRZEDAZ", $fv);
									$q1="select k.id_taryfy, t.cena from komputery k, towary_sprzedaz t where k.id_taryfy=t.id_tows 
												and k.fv='T' and	k.podlaczony='T' and k.id_abon='$row[0]'"; 
									WyswietlSql($q1);
									$sth1=Query($dbh,$q1);
									while ($row1 =$sth1->fetchRow())
										{
											$q3="insert into POZYCJE_SPRZEDAZ values ('$row1[0]', 1,'$fv[nr_ds]'); 
														update abonenci set saldo=saldo-$row1[1] where id_abon='$row[0]'";
											WyswietlSql($q3);
											Query($dbh, $q3);
										}
									$fv[nr_ds]=IncNrFV($fv[nr_ds]);
								}
								else if ( $saldo >= $row[3] )
								{
									if ( $mies=="01" ) 
										{
											$fv1=$fv;
										//	$fv1[nr_ds]=IncNrFV($fv1[nr_ds]);
											$fv1[term_plat]= CountDate( $fv1[data_wyst], $row[4] );
										}
									else
										$fv1[term_plat]= CountDate( $fv1[data_wyst], $row[4] );
									
									Insert($dbh, "DOKUMENTY_SPRZEDAZ", $fv1);
									$q1="select k.id_taryfy, t.cena from komputery k, towary_sprzedaz t where k.id_taryfy=t.id_tows 
												and k.fv='T' and	k.podlaczony='T' and k.id_abon='$row[0]'"; 
			//						WyswietlSql($q1);

									while ( $saldo >= $row[3] )
										{
											$sth1=Query($dbh,$q1);
											while ($row1 =$sth1->fetchRow())
												{
													$q3="insert into POZYCJE_SPRZEDAZ values ('$row1[0]', 1,'$fv1[nr_ds]')";
													WyswietlSql($q3);
													Query($dbh, $q3);
													$saldo-=$row1[1];
												}
										}
									$q4="update abonenci set saldo=$saldo where id_abon='$row[0]'";
									WyswietlSql($q3);
									Query($dbh, $q4);

									if ( $mies=="01" ) 
											$fv[nr_ds]=IncNrFV($fv[nr_ds]);
									else
											$fv1[nr_ds]=IncNrFV($fv1[nr_ds]);
									
								}
							}
			}
		else 				
				echo "W tym miesiacu wystawiono już jakies Faktury VAT";

}

function ListaDokKs($p)
{
   include "config.php";
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
			$p[order]="d.data_wyst, d.nr_ds";
		}
	else if ($p[order] == "Nazwa odbiorcy")
			$p[order]="k.nazwa, d.data_wyst";


	if ($p[typ]=="sprzedaz")
		{
			$q1="	select  d.nr_ds, k.nazwa, d.data_wyst, d.data_sprzed, d.term_plat 
					from dokumenty_sprzedaz d, abonenci k 
					where d.id_odb=k.id_abon and d.data_wyst >= '$p[data_od]' and d.data_wyst <= '$p[data_do]' and d.stan in ($p[stan])";
					if (!empty($p[abon]) && $p[abon] !=$conf[select])   
						$q1.=" and k.id_abon='$ida' 	order by $p[order]";
					else 
					$q1.=" 	order by $p[order]";
		}
	else 
			$q1="	select  d.nr_dz, k.nazwa, d.data_wyst, d.data_sprzed, d.term_plat 
					from dokumenty_zakup d, dostawcy k 
					where d.id_dost=k.id_dost and d.data_wyst >= '$p[data_od]' and d.data_wyst <= '$p[data_do]' and d.stan in ($p[stan])
					order by d.data_wyst,d.nr_dz";

//	echo "$q1";
	$sth1=Query($dbh,$q1);
	$lp=1;
	$suma=0;
  while ($row1 =$sth1->fetchRow())
		{
			if ($p[typ]=="sprzedaz")
				$q2="select t.nazwa, p.ilosc, t.cena from pozycje_sprzedaz p, towary_sprzedaz t where p.id_tows=t.id_tows and p.nr_ds='$row1[0]' order by 	t.nazwa";
			else 
				$q2="select t.nazwa, p.ilosc, t.cena from pozycje_zakup p, towary_zakup t where p.id_towz=t.id_towz  and p.nr_dz='$row1[0]' order by t.nazwa";

			DrawTable($lp++,$conf[table_color]);				
  		echo "<td class=\"klasa4\"> <a href=\"index.php?panel=fin&menu=updatedokks&typ=$p[typ]&nr=$row1[0]\"> $row1[0] </a> </td>";
	 		echo "<td class=\"klasa4b\"> $row1[1]</td>";
  		echo "<td class=\"klasa4\"> $row1[2]</td>";
  		echo "<td class=\"klasa4\">";
			$sth2=Query($dbh,$q2);
			while ($row2 =$sth2->fetchRow())
				{
					echo "$row2[0]  -- szt. $row2[1] <br>";
					$suma+=$row2[2]*$row2[1];
				}
			echo "</td>";
			if ($p[typ]=="sprzedaz")
			{
  				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('func/pdf.php?dok=fv&typ=ORYGINAŁ&nr=$row1[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
  				
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('func/pdf.php?dok=fv&typ=KOPIA&nr=$row1[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
				
				echo "<td class=\"klasa4\"> <a href=\"javascript&#058;displayWindow('func/pdf.php?dok=fv&typ=DUPLIKAT&nr=$row1[0]',800,800, '38')\"> 
				<img src=\"../graphics/pdf.gif\" width=\"32\" height=\"32\" border=\"0\"/> </a> </td>";
			}
			echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"$row1[0]\"/></td>";
     echo "</tr>";
       }
			 DrawTable($lp++,$conf[table_color]);
			echo "<td> </td>";
			echo "<td> <b> SUMA: </b></td>";
			echo "<td> <b>$suma </b></td>";
			echo "<td> </td>"; 				
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "</tr>";
}

function ListaPozDokks($typ, $nr)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	if ($typ=="sprzedaz")
		{
			$q=" select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_tows
					from pozycje_sprzedaz p, towary_sprzedaz t 
					where p.id_tows=t.id_tows and p.nr_ds='$nr' order by t.nazwa";
		}
	else 
		{
			$q=" select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_towz
					from pozycje_zakup p, towary_zakup t 
					where p.id_towz=t.id_towz  and p.nr_dz='$nr' order by t.nazwa";
		}
	$netto=0;
	$Lp=0;
	$sth1=Query($dbh,$q);
	while ( $row1=$sth1->fetchRow() )
		{
			$netto+=$row1[2]*$row1[3];
			++$Lp;
			echo "<tr>";
			echo " <td> $Lp. </td> ";
			echo " <td> $row1[0] </td> ";
			echo " <td> $row1[1] </td> ";
			echo " <td> $row1[2] </td> ";
			echo " <td> $row1[3] </td> ";
			$cjn=round ($row1[4]/(1+$row1[5]/100), 2);
			echo " <td> $cjn </td> ";
			$brutto=$row1[2]*$row1[4];
			$netto=round ($brutto/(1+$row1[5]/100), 2);
			echo " <td> $netto </td> ";
			echo " <td> $row1[5] </td> ";
			$kwota_vat=round($netto * $row1[5]/100, 2);
			echo " <td> $kwota_vat </td> ";

			echo " <td> $brutto </td> ";
			echo "<td class=\"klasa4\"><input type=\"checkbox\" name=\"$row1[6]-$row1[2]-$nr\"/></td>";		
			echo "</tr>";
			$razem_netto+=$netto;
			$razem_vat+=$kwota_vat;
			$razem_brutto+=$brutto;
		}

	echo "<tr>";
	echo "</tr>";
	echo "<tr>";
	echo " <td colspan=\"6\">  </td>";
	echo " <td> <strong> $razem_netto </strong> </td>";
	echo " <td>  </td>";
	echo " <td> <strong> $razem_vat </strong> </td>";
	echo " <td> <strong> $razem_brutto </strong> </td>";
//	echo " <td>  </td>";
	echo "</tr>";
		
include_once "slownie.php";
$x=new slownie;
$slownie=$x->zwroc($razem_brutto);
	echo "<tr>";
	echo " <td colspan=\"3\"> Słownie: </td>";
	echo " <td colspan=\"7\"> <strong> $slownie </strong> </td>";
	echo "</tr>";


}

function ListaFAbon()
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	$array=array("1","2","3","4","5");

	$query="select distinct a.id_abon, a.symbol, a.nazwa, u.kod, u.miasto, u.nazwa, b.numer, a.nr_mieszk
				from abonenci a,ulice u, budynki b, umowy_abonenckie um, komputery k
				where u.id_ul=b.id_ul and a.id_bud=b.id_bud and um.id_abon=a.id_abon and k.id_abon=a.id_abon and um.status='Obowiązująca' 
				order by u.nazwa, b.numer, a.nr_mieszk";

	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
  		$q1="select count(id_komp) from komputery k, abonenci a where k.id_abon=a.id_abon and a.id_abon='$row[0]'"; 
   					
				 
			$sth1=Query($dbh,$q1);
   		$row1=$sth1->fetchRow();

			DrawTable($lp++,$conf[table_color]);  	
 			echo "<td> <a href=\"index.php?panel=fin&menu=updateabon&abon=$row[0]\"> $row[0] </a> </td>";
			$s=Choose($row[1], $row[2]);
	  		echo "<td> $s </td>";
  			echo "<td> $row[3] $row[4], ul. $row[5] $row[6]/$row[7] </td>";
			echo "<td>";
			$www->SelectFromArray($array, "$row[0]", $row1[0]);
			echo "</td>";
//			echo "<td><input type=\"checkbox\" name=\"$row[0]\" checked=\"true\"/></td>";
         echo "</tr>";
       }
}

function AddNewDokks($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE1="dokumenty_sprzedaz";
			$TABLE2="pozycje_sprzedaz";
			$ID="nr_ds";
			$NK="id_odb";
		}
	else
		{
			$TABLE1="dokumenty_zakup";
			$TABLE2="pozycje_zakup";
			$ID="nr_dz";
			$NK="id_dost";
		}
	$dokks=$_SESSION[dokks];
	$flag=0;
	foreach ($_POST as $k => $v)
		{
			if ( $v!=0 && $k!="przycisk" && $flag==0)
			{
				Insert($dbh, $TABLE1, $dokks);
				$flag=1;
			}
			if ( $v!=0 && $k!="przycisk")
			{
				$q3="insert into $TABLE2 values ('$k','$v','$dokks[$ID]')";
		//		echo "$q3 <br>";
				Query($dbh, $q3);
			if ($typ=="sprzedaz")
				{
					$q4="select vat, cena from towary_sprzedaz where id_tows='$k'";
					$row4=Query2($q4, $dbh);
					$kwota = $v * round($row4[1], 2 );
					$q5="update abonenci set saldo=saldo-$kwota where id_abon='$dokks[id_odb]'";
				//	echo "$q5 <br>";
					Query($dbh, $q5);
				}			
			}
		}
}


function AddNewPozDokks($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE1="dokumenty_sprzedaz";
			$TABLE2="pozycje_sprzedaz";
			$ID="nr_ds";
			$NK="id_odb";
		}
	else
		{
			$TABLE1="dokumenty_zakup";
			$TABLE2="pozycje_zakup";
			$ID="nr_dz";
			$NK="id_dost";
		}
	$dokks=$_SESSION[dokks];
	$flag=0;
	foreach ($_POST as $k => $v)
		{
			if ( $v!=0 && $k!="przycisk")
			{
				$q3="insert into $TABLE2 values ('$k','$v','$dokks[$ID]')";
				WyswietlSql($q3);
				Query($dbh, $q3);
			if ($typ=="sprzedaz")
				{
					$q4="select vat, cena from towary_sprzedaz where id_tows='$k'";
					$row4=Query2($q4, $dbh);
					$kwota = $v * round($row4[1], 2 );
					$q5="update abonenci set saldo=saldo-$kwota where id_abon='$dokks[$NK]'";
				WyswietlSql($q5);
				Query($dbh, $q5);
				}			
			}
		}
}

function UpdateDokks($typ, $nr)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE1="dokumenty_sprzedaz";
			$TABLE2="pozycje_sprzedaz";
			$NR="nr_ds";
			$IDK='id_odb';
			$nazwak="odbiorca";
		}
	else
		{
			$TABLE1="dokumenty_zakup";
			$TABLE2="pozycje_zakup";
			$NR="nr_dz";
			$IDK="id_dost";
			$nazwak="dostawca";
		}

	$dokks=array
	(
		$NR			=> $_POST[nr_d], 						$IDK			=>FindId2($_POST[$nazwak]), 	'data_wyst'	=>$_POST[data_wyst], 	
		'data_sprzed'		=>$_POST[data_sprzed],		'term_plat'	=>	$_POST[term_plat],	'forma_plat'=>$_POST[forma_plat],		'stan'		=>$_POST[stan],		'miejsce_wyst'		=>$_POST[miejsce_wyst]
	);
	$dokks2=array
	($NR	=>$nr);

	$poz1=array($NR=>$_POST[nr_d]);
	$poz2=array($NR=>$nr);
									
	Update($dbh, $TABLE2, $poz1, $poz2);
	Update($dbh, $TABLE1, $dokks, $dokks2);

	
	$id_abon=$_SESSION[dokks][$IDK];
		
	if ( $_SESSION[dokks][$IDK] != $dokks[$IDK] )
	{
	
		if ($typ=="sprzedaz")
			{
				$q=" select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_tows
						from pozycje_sprzedaz p, towary_sprzedaz t 
						where p.id_tows=t.id_tows and p.nr_ds='$nr' order by t.nazwa";
			}
		else 
			{
				$q=" select t.nazwa, t.pkwiu, p.ilosc, t.jm, t.cena, t.vat, t.id_towz
						from pozycje_zakup p, towary_zakup t 
						where p.id_towz=t.id_towz  and p.nr_dz='$nr' order by t.nazwa";
			}
		$netto=0;
		$sth1=Query($dbh,$q);
		while ( $row1=$sth1->fetchRow() )
			{
				$brutto=$row1[2]*$row1[4];
				$razem_brutto+=$brutto;
			}

		$q1="update abonenci set saldo=saldo+$razem_brutto where id_abon='$id_abon'; 
		update abonenci set saldo=saldo-$razem_brutto where id_abon='$dokks[$IDK]'";
	//	echo "$q1";
		
		Query($dbh, $q1);
	}
	
	$kwota=0;
	
	foreach ($_POST as $k => $v)
		{
			if ( $k!="przycisk" )
			{
				$e=explode("-", $k);
				$f=explode("/", $e[2]);
				if ( $f[0]=="FV" )
				{
					$q5="select count(*) from pozycje_sprzedaz where nr_ds='$e[2]'";	
					WyswietlSql($q5);	
					$sth=Query($dbh, $q5);
					$row=$sth->fetchRow();

					if ( $row[0] > 1 )
					{
							$q2="select cena from towary_sprzedaz where id_tows='$e[0]'";
							$sth=Query($dbh, $q2);
							WyswietlSql($q2);	
							$row =$sth->fetchRow();						
							$kwota+=$row[0];
							$q3="delete from pozycje_sprzedaz where ctid in ( select ctid from pozycje_sprzedaz where nr_ds='$e[2]' and id_tows='$e[0]' and ilosc='$e[1]' limit 1 offset 0)";
							WyswietlSql($q3);	
							Query($dbh, $q3);
					}
					else 
						echo "Nie można usunąć pozycji, ponieważ faktura ma tylko jedna pozycję.";
				}
			}
		}

	$q4="update abonenci set saldo=saldo+$kwota where id_abon='$dokks[$IDK]'";
	WyswietlSql($q4);	
	Query($dbh, $q4);
}

function ValidateDokks()
{
	$flag=1;

	if ( !ValidateDate($_POST[data_wyst]) )
		{ 
			echo "Błąd pola 'Data wystawienia' <br>";
			$flag=0;
		}

	if ( !ValidateDate($_POST[data_sprzed]) )
		{ 
			echo "Błąd pola 'Data sprzedaży'  <br>";
			$flag=0;
		}

	return ($flag);
}

function ValidatePozDokks()
{
	$flag=0;
	foreach($_POST as $k => $v)
		if ( !empty ($v))
			{ 
				$flag=1;
			}	
	if ($flag==0)
			echo "Nie wybrano ani jednego towaru / usługi <br>";
	return ($flag);
}

//////////////////////////////////////////////////
//////////////// D O S T A W C Y ////////////////
////////////////////////////////////////////////

function ListaDostawcow()
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	$query="select  id_dost, symbol, nazwa, ulica, nr_bud, nr_mieszk, miasto, kod, nip, regon, aktywny, pl_vat
				from dostawcy order by id_dost";

	$sth1=Query($dbh,$query);
	$lp=1;
   while ($row =$sth1->fetchRow())
		{
			$q2="select telefon, tel_kom from telefony where id_podm='$row[0]'";
  			$sth2=Query($dbh,$q2);
  			$row2=$sth2->fetchRow();
  			$q3="select email from maile where id_podm='$row[0]'";
  			$sth3=Query($dbh,$q3);
  			$row3=$sth3->fetchRow();
			$q5="select nazwa from kontakty where id_podm='$row[0]'";
   		$sth5=Query($dbh,$q5);
	   	$row5=$sth5->fetchRow();
			$q6="select t.telefon, t.tel_kom from telefony t, kontakty k where k.id_kontakt=t.id_podm and k.id_podm='$row[0]'";
   		$sth6=Query($dbh,$q6);
   		$row6=$sth6->fetchRow();
			$q7="select email from maile m, kontakty k where k.id_kontakt=m.id_podm and k.id_podm='$row[0]'";
   		$sth7=Query($dbh,$q7);
   		$row7=$sth7->fetchRow();

			DrawTable($lp++,$conf[table_color]);  	

  			echo "<td> <a href=\"index.php?panel=fin&menu=updatedost&dost=$row[0]\"> $row[0] </a> </td>";
	  		echo "<td> $row[1] </td>";
  			echo "<td> $row[7] $row[6],<br/> ul. $row[3] $row[4]/$row[5] </td>";
  			echo "<td>";
			if ( !empty($row2[0]) )
					echo "tel.:  $row2[0] <br>";
			if ( !empty($row2[1]) )
					echo "tel.kom.:  $row2[1] <br>";
			if ( !empty($row3[0]) )
					echo "e-mail:  $row3[0]";
			echo "</td>";	
  			echo "<td>";
			if ( !empty($row5[0]) )
				echo "$row5[0] <br/>";
			if ( !empty($row6[0]) )
				echo "tel.: $row6[0] <br/>";
			if ( !empty($row6[1]) )
				echo "tel.kom.: $row6[1] <br/>";
			if ( !empty($row7[0]) )
				echo "e-mail: $row7[0] <br/>";
			echo "</td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
     echo "</tr>";
       }
}

function ValidateDost()
{
	$flag=1;

	if (  empty ($_POST["d_nazwa"]) ) 
	{
		echo "Błąd pola 'Nazwa dostawcy' : pole jest puste <br>";
		$flag=0;
	}

	if (  !ValidateKod($_POST["d_kod"]) ) 
	{
		$flag=0;
	}

	if (  !empty($_POST[d_kod]) && !ValidateKod($_POST["d_kod"]) ) 
	{
		$flag=0;
	}
	
	return ($flag);	
}

function UpdateDost($id_dost)
{
	include "config.php";

	$dbh=DBConnect($DBNAME1);	

	$ktk1=$_SESSION[kontakty];
	$teld1=$_SESSION[teld];
	$maild1=$_SESSION[maild];
	$telk1=$_SESSION[telk];
	$mailk1=$_SESSION[mailk];
	$kontod1=$_SESSION[kontod];

	$dost=array (	'id_dost'	=>$id_dost, 	'nazwa'	=>$_POST[d_nazwa],	'ulica'	=>$_POST[d_ulica], 'nr_bud'=>$_POST[d_nrbud],
						'nr_mieszk'	=>IsNull($_POST[d_nrmieszk]),'miasto'	=>$_POST[d_miasto], 	'kod'		=>$_POST[d_kod], 'symbol'=>$_POST[d_symbol],
						'nip'	=>IsNull($_POST[d_nip]), 'regon'	=>IsNull($_POST[d_regon]),
						'aktywny'		=>CheckboxToTable($_POST[d_aktywny]), 'pl_vat'=>CheckboxToTable($_POST[d_pl_vat]));
	Update($dbh, "dostawcy", $dost);

	if ( !empty($_POST[d_telefon]) || !empty($_POST[d_telkom]))
		{
			$teld2=array('id_podm'=> $id_dost, 'kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[d_telefon]), 'tel_kom' => IsNull($_POST[d_telkom]));
			if ( !empty($teld1[telefon]) || !empty($teld1[tel_kom]) )
				Update($dbh, "TELEFONY", $teld2);
			else 
				Insert($dbh, "TELEFONY", $teld2);
		}
	else if ( empty($_POST[d_telefon]) && empty($_POST[d_telkom])  &&   ( !empty($teld1[telefon]) || !empty($teld1[tel_kom]) )  )
 		{
			$Q="delete from TELEFONY where id_podm='$id_dost'";
			echo $Q;
			Query($dbh, $Q);
		}

	if ( !empty($_POST[d_email]) )
			{
				$maild2=array('id_podm'=> $id_dost, 'email'=>$_POST[d_email]);
				if ( !empty($maild1[email]) )
					Update($dbh, "MAILE", $maild2);
				else 
					Insert($dbh, "MAILE", $maild2);
			}
	else if ( empty($_POST[d_email]) && !empty($maild1[email]) )
 		{
			$Q="delete from MAILE where id_podm='$id_dost'";
			echo $Q;
			Query($dbh, $Q);
		}

	
	if ( !empty($_POST[d_konto]) )
			{
				$kontod2=array('id_wlasc'=> $id_dost, 'nr_kb'=>$_POST[d_konto], 'bank'=>IsNull($_POST[d_bank]) );
				if ( !empty($kontod1[nr_kb]) )
					Update($dbh, "KONTA_BANKOWE", $kontod2);
				else 
					Insert($dbh, "KONTA_BANKOWE", $kontod2);
			}
	else if ( empty($_POST[d_konto]) && !empty($kontod1[nr_kb]) )
 		{
			$Q="delete from KONTA_BANKOWE where nr_kb='$kontod1[nr_kb]'";
			echo $Q;
			Query($dbh, $Q);
		}


	if ( !empty($_POST[k_nazwa]) )
		{
			if ( empty($ktk1[nazwa]) )
				{
					$Q="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
					$id_kontakt=IncValue($dbh, $Q, "KTK0000");
					$ktk2=array( 'id_kontakt' => $id_kontakt, 			'nazwa' => $_POST[k_nazwa], 				'kod' => IsNull($_POST[k_kod]),
									'miasto' => IsNull($_POST[k_miasto]), 'ulica' => IsNull($_POST[k_ulica]),	'nr_bud' => IsNull($_POST[k_nrbud]),
									'nr_mieszk' => IsNull($_POST[k_nrlokalu]), 'id_podm' => $id_dost );
					Insert($dbh, "KONTAKTY", $ktk2);
				}
			else if ( !empty($ktk1[nazwa]) )
				{
					$Q="select id_kontakt from KONTAKTY where id_podm='$id_inst'";
		  			$sth=Query($dbh,$Q);
		  			$row=$sth->fetchRow();
		 			$id_kontakt=$row[0];
					$ktk2=array( 'id_kontakt' => $id_kontakt, 'id_podm' => $id_inst , 'nazwa' => $_POST[k_nazwa],		'kod' => IsNull($_POST[k_kod]),
									'miasto' => IsNull($_POST[k_miasto]), 'ulica' => IsNull($_POST[k_ulica]),	'nr_bud' => IsNull($_POST[k_nrbud]),
									'nr_mieszk' => IsNull($_POST[k_nrlokalu]));
					Update($dbh, "KONTAKTY", $ktk2);	
				}

		if ( !empty($_POST[k_telefon]) || !empty($_POST[k_telkom]))
			{
				if ( empty($telk1[telefon]) && empty($telk1[tel_kom]) )
					{
						$telk2=array('kierunkowy'=>'0-32', 'telefon'=>IsNull($_POST[k_telefon]), 'tel_kom'=>IsNull($_POST[k_telkom]), 'id_podm'=>$id_kontakt );
						Insert($dbh, "TELEFONY", $telk2);
					}
				else	if ( !empty($telk1[telefon]) || !empty($telk1[tel_kom]) )
					{
						$telk2=array('id_podm'=>$id_kontakt ,'telefon'=>IsNull($_POST[k_telefon]), 'tel_kom'=>IsNull($_POST[k_telkom]));
						Update($dbh, "TELEFONY", $telk2);
					}
			}
		else if ( empty($_POST[k_telefon]) && empty($_POST[k_telkom]) && (!empty($telk1[telefon]) || !empty($telk1[tel_kom])) )
			{
				$Q="delete from TELEFONY where id_podm='$id_kontakt'";
				echo $Q;
				Query($dbh, $Q);
			}

		if ( !empty($_POST[k_email]) )
			{
				if ( empty($mailk1[email]) )
					{
						$Q11="insert into MAILE values ('$_POST[k_email]', '$id_kontakt')";
						echo $Q11;
						Query($dbh, $Q11);
					}
				else
					{
						$Q11="update MAILE set 'email'='$_POST[k_email]' where 'id_podm'='$id_kontakt";
						echo $Q11;
						Query($dbh, $Q11);
						}
			}
		else if (empty($_POST[k_email])  && !empty($mailk1[email]) )
			{
				$Q="delete from MAILE where id_podm='$id_kontakt'";
				echo $Q;
				Query($dbh, $Q);
			}
	}
	else if ( empty($_POST[k_nazwa]) && !empty($ktk1[nazwa]) )
 		{
			$Q="delete from KONTAKTY where id_podm='$id_inst'";
			echo $Q;
			Query($dbh, $Q);
		}

}

function AddNewDost()
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	
	$Q1="select id_dost from dostawcy order by id_dost desc limit 1";
	$id_dost=IncValue($dbh, $Q1, "DOST000");

	$dost=array (	'id_dost'	=>$id_dost, 	'nazwa'	=>$_POST[d_nazwa],	'ulica'	=>$_POST[d_ulica], 'nr_bud'=>$_POST[d_nrbud],
						'nr_mieszk'	=>IsNull($_POST[d_nrmieszk]),'miasto'	=>$_POST[d_miasto], 	'kod'		=>$_POST[d_kod], 'symbol'=>$_POST[d_symbol],
						'nip'	=>IsNull($_POST[d_nip]), 'regon'	=>IsNull($_POST[d_regon]),
						'aktywny'		=>CheckboxToTable($_POST[d_aktywny]), 'pl_vat'=>CheckboxToTable($_POST[d_pl_vat]));
	Insert($dbh, "dostawcy", $dost);

	if ( !empty($_POST[d_telefon]) || !empty($_POST[d_telkom]))
		{
			$teld=array('kierunkowy'=> "0-32", 'telefon' => IsNull($_POST[d_telefon]), 'tel_kom' => IsNull($_POST[d_telkom]), 'id_podm'=> $id_dost);
			Insert($dbh, "TELEFONY", $teld);
		}

	if ( !empty($_POST[d_email]) )
			{
				$Q20="insert into MAILE values ('$_POST[d_email]', '$id_dost')";
				echo $Q20;
				Query($dbh, $Q20);
			}

	if ( !empty($_POST[d_konto]) )
		{
			$kontod=array('nr_kb'=> $_POST[d_konto], 'bank' => IsNull($_POST[d_bank]), 'id_wlasc'=> $id_dost);
			Insert($dbh, "KONTA_BANKOWE", $kontod);
		}

	
	if ( !empty($_POST[k_nazwa]) )
	{
		$Q="select id_kontakt from KONTAKTY order by id_kontakt desc limit 1";
		$id_kontakt=IncValue($dbh, $Q, "KTK0000");

		$ktk=array( 'id_kontakt' => $id_kontakt, 			'nazwa' => $_POST[k_nazwa], 				'kod' => IsNull($_POST[k_kod]), 'miasto' => IsNull($_POST[k_miasto]),
						'ulica' => IsNull($_POST[k_ulica]),	'nr_bud' => IsNull($_POST[k_nrbud]),	'nr_mieszk' => IsNull($_POST[k_nrlokalu]), 
						'id_podm' => $id_dost );

		Insert($dbh, "KONTAKTY", $ktk);

		if ( !empty($_POST[k_telefon]) || !empty($_POST[k_telkom]))
			{
				$ktk[td]=IsNull($_POST[k_telefon]);
				$ktk[tk]=IsNull($_POST[k_telkom]);
				$Q10="insert into TELEFONY values ('0-32', '$ktk[td]', '$ktk[tk]', '$id_kontakt')";
				echo $Q10;
				Query($dbh, $Q10);
			}
		if ( !empty($_POST[k_email]) )
			{
				$Q11="insert into MAILE values ('$_POST[k_email]', '$id_kontakt')";
				echo $Q11;
				Query($dbh, $Q11);
			}
	}
}


//////////////////////////////////////////////////
//////////////// T O W A R Y ////////////////////
////////////////////////////////////////////////

function AddNewTow($typ)
{
	include "config.php";
	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE="towary_sprzedaz";
			$ID="id_tows";
		}
	else
		{
			$TABLE="towary_zakup";
			$ID="id_towz";
		}

	switch ($_POST[typ])
		{
			case "towar":
				$Q1="select $ID from $TABLE where $ID like 'TOW%' order by $ID desc limit 1";
				$id_tow=IncValue($dbh, $Q1, "TOW0000");
				break;
			case "usluga":
				$Q1="select $ID from $TABLE where $ID like 'USL%' order by $ID desc limit 1";
				$id_tow=IncValue($dbh, $Q1, "USL0000");
				break;
		}

	$tow=array (	
						$ID	=>$id_tow, 	'symbol'	=>	IsNull($_POST[symbol]), 'nazwa'	=>$_POST[nazwa],   'pkwiu'=>IsNull($_POST[pkwiu]),
						'vat'	=>$_POST[vat], 	'cena'		=>$_POST[cena], 'opis'=>IsNull($_POST[opis]), 'okres_gwar' => $_POST[okres_gwar], 'jm'	=> "szt.",
						'aktywny' => 'T'
					);
	Insert($dbh, $TABLE, $tow);
}

function UpdateTow($typ, $id_tow)
{
	include "config.php";

	$dbh=DBConnect($DBNAME1);	

	if ($typ =="sprzedaz")
		{
			$TABLE="towary_sprzedaz";
			$ID="id_tows";
		}
	else
		{
			$TABLE="towary_zakup";
			$ID="id_towz";
		}

	$tow=array (	
						$ID	=>$id_tow, 		'symbol'		=>	IsNull($_POST[symbol]), 'nazwa'	=>$_POST[nazwa],   'pkwiu'=>IsNull($_POST[pkwiu]),
						'vat'	=>$_POST[vat], 	'cena'		=>$_POST[cena], 'opis'=>IsNull($_POST[opis]), 'okres_gwar' => $_POST[okres_gwar],
						'aktywny' => CheckboxToTable($_POST[aktywny])
					);
	Update($dbh, $TABLE, $tow);

}

function ValidateTow()
{
	$flag=1;

	if ( empty ($_POST[nazwa]))
		{ 
			echo "Błąd pola 'Nazwa' : pole jest puste <br>";
			$flag=0;
		}	

	if ( empty($_POST[cena]) )
		{ 
			echo "Błąd pola 'Cena' : pole jest puste <br>";
			$flag=0;
		}

	return ($flag);
}

function ListaTow($typ)
{
   include "config.php";
	$dbh=DBConnect($DBNAME1);

	if ($typ=="sprzedaz")
		$query="	select  id_tows, symbol, nazwa, pkwiu, vat, cena,  opis from towary_sprzedaz order by nazwa";
	else 
		$query="	select  id_towz, symbol, nazwa, pkwiu, vat, cena,  opis from towary_zakup order by nazwa";

	$sth=Query($dbh,$query);
	$lp=1;
   while ($row =$sth->fetchRow())
		{
			DrawTable($lp++,$conf[table_color]);  	
			$netto=round ($row[5] / (1 + $row[4]/100), 2);
	  
 			echo "<td> <a href=\"index.php?panel=fin&menu=updatetow&typ=$typ&id=$row[0]\"> $row[0] </a> </td>";
  		echo "<td> <b> $row[2] </b></td>";
 			echo "<td> $row[3]</td>";
 			echo "<td> $netto </td>";
 			echo "<td> $row[4] % </td>";
			echo "<td> <strong>$row[5]</strong> </td>";
			echo "<td><input type=\"checkbox\" name=\"$row[0]\"/></td>";
     echo "</tr>";
       }
}







?>
